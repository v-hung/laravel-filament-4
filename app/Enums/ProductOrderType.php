<?php

namespace App\Enums;

enum ProductOrderType: string
{
    case FEATURED = 'featured';
    case BEST_SELLING = 'best_selling';
    case LATEST = 'latest';
}
