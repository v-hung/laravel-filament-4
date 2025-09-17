<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    public function getAll()
    {
        $locale = app()->getLocale();

        $settings = cache()->remember("settings", now()->addMinutes(60), function () use ($locale) {
            return Setting::get()
                ->mapWithKeys(function ($setting) use ($locale) {
                    $key = strtolower($setting->group . '.' . $setting->key);
                    $value = $setting->getTranslation('value', $locale)
                        ?: collect(optional($setting)->getTranslations('value'))->first()
                        ?: null;
                    return [$key => $value];
                })
                ->toArray();
        });

        return $settings;
    }
}
