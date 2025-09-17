<?php

namespace App\Filament\Core\Pages;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

/**
 * @property-read static $GROUP_KEY
 */
trait HasPageTranslatable
{
    public ?array $data = [];

    public string $activeLocale;
    public array $otherLocaleData = [];
    protected ?string $oldActiveLocale = null;

    public array $translatableAttributes = [];

    public function getGroupKey(): string
    {
        return strtolower(static::$GROUP_KEY);
    }

    public function getTranslatableLocales(): array
    {
        return [];
    }

    public function updatingActiveLocale(): void
    {
        $this->oldActiveLocale = $this->activeLocale;
    }

    public function updatedActiveLocale(): void
    {
        if (blank($this->oldActiveLocale)) {
            return;
        }

        $this->resetValidation();

        $this->otherLocaleData[$this->oldActiveLocale] = Arr::only($this->data, $this->translatableAttributes);

        $this->data = [
            ...Arr::except($this->data, $this->translatableAttributes),
            ...$this->otherLocaleData[$this->activeLocale] ?? [],
        ];

        unset($this->otherLocaleData[$this->activeLocale]);
    }

    public function setActiveLocale(string $locale): void
    {
        $this->updatingActiveLocale();
        $this->activeLocale = $locale;
        $this->updatedActiveLocale();
    }

    public function mount(): void
    {
        $this->activeLocale ??= app()->getLocale();
        $settings = Setting::where('group', $this->getGroupKey())->get()->keyBy('key');

        $attributes = [];

        $fields = collect($this->form->getComponents());

        foreach ($fields as $field) {
            $fieldName = $field->getName();
            $setting = $settings->get($fieldName);


            $attributes[$fieldName] = optional($setting)->getTranslation('value', $this->activeLocale)
                ?: collect(optional($setting)->getTranslations('value'))->first()
                ?: null;
        }

        $this->form->fill($attributes);
    }

    public function save()
    {
        $this->validate();

        $locales = $this->getTranslatableLocales();
        $formData = $this->form->getState();

        $existingSettings = Setting::where('group', $this->getGroupKey())->get()->keyBy('key');

        foreach ($formData as $key => $value) {
            $setting = $existingSettings->get($key);
            $translations = $this->getAllLocaleTranslationsForKey($key, $locales, $setting?->value ?? []);

            if ($setting) {

                $setting->updated_at = now();
                $setting->value = $translations;
                $setting->save();
            } else {

                Setting::create([
                    'group' => $this->getGroupKey(),
                    'key' => $key,
                    'value' => $translations,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Cache::forget("settings");

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }

    protected function getAllLocaleTranslationsForKey(string $key, array $locales, array $translations): array
    {
        $translations ??= [];

        foreach ($locales as $locale) {
            $localeValue = $this->getLocaleValue($key, $locale);

            if (!is_null($localeValue)) {
                $translations[$locale] = $localeValue;
            }
        }

        return $translations;
    }

    protected function getLocaleValue(string $key, string $locale): ?string
    {
        if ($locale === $this->activeLocale) {
            return $this->data[$key] ?? null;
        }

        return $this->otherLocaleData[$locale][$key] ?? null;
    }
}
