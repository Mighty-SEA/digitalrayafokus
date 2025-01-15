<?php

namespace App\Enums;

enum InvoiceStatus: string 
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';

    public function getColor(): string 
    {
        return match($this) {
            self::PAID => 'success',
            self::CANCELLED => 'danger',
            default => 'warning'
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::PAID => 'heroicon-o-check-circle',
            self::CANCELLED => 'heroicon-o-x-circle',
            default => 'heroicon-o-clock'
        };
    }
} 