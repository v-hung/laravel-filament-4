<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum CategoryStatus: string implements HasColor, HasLabel, HasDescription
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Archived = 'archived';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Active => 'Visible and available to users.',
            self::Inactive => 'Hidden from users. Not currently in use.',
            self::Archived => 'No longer used, kept for historical reference.',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
            self::Archived => 'warning',
        };
    }
}
