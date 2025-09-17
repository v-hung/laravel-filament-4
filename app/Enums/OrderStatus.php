<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasColor, HasLabel, HasDescription
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Pending => 'Order has been placed but not yet paid.',
            self::Paid => 'Payment has been received for the order.',
            self::Shipped => 'Order has been shipped to the customer.',
            self::Completed => 'Order has been delivered and finalized.',
            self::Canceled => 'Order has been canceled and will not be processed.',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Paid => 'primary',
            self::Shipped => 'info',
            self::Completed => 'success',
            self::Canceled => 'danger',
        };
    }
}
