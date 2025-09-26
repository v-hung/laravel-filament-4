<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Forms\Components\HasProductOptionVariant;
use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateProduct extends CreateRecord
{
    use Translatable, HasProductOptionVariant;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        $switchLocaleActions = array_map(function (string $locale) {
            /** @var SpatieTranslatablePlugin $plugin */
            $plugin = filament('spatie-translatable');

            $localeTranlate = $plugin->getLocaleLabel($locale) ?? $locale;
            $isActive = $locale === $this->activeLocale;

            return Action::make("switch_locale_{$locale}")
                ->label($isActive ? "✅ $localeTranlate" : $localeTranlate)
                ->color($isActive ? 'success' : 'gray')
                ->action(function () use ($locale) {
                    $oldLocale = $this->getActiveFormsLocale();

                    /** @var SpatieLaravelTranslatablePlugin $plugin */
                    $plugin = filament('spatie-laravel-translatable');
                    $localeLabel = $plugin->getLocaleLabel($oldLocale) ?? $oldLocale;

                    $this->form->saveRelationships();
                    $this->save(shouldRedirect: false, shouldSendSavedNotification: false);

                    $this->setActiveLocale($locale);

                    Notification::make("saved_{$locale}")
                        ->title(trans('filament-actions::edit.single.notifications.saved.title') . ' ' . $localeLabel)
                        ->success()
                        ->send();
                });
        }, self::$resource::getTranslatableLocales());

        return [
            ActionGroup::make($switchLocaleActions)
                ->button()
                ->icon('heroicon-o-language')
                ->label('Save and Switch Language'),
        ];
    }
}
