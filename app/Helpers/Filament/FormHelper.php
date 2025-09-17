<?php

namespace App\Helpers\Filament;

class FormHelper
{
    public static function localizedLabel(string $label): \Closure
    {
        $displayLocale ??= app()->getLocale();

        return fn($livewire) => $label . ' (' . locale_get_display_name($livewire->activeLocale, $displayLocale) . ')';
    }
}
