<?php

namespace App\Services;

class InvoiceCalculationService 
{
    public static function calculateAmounts(float $quantity, float $priceRupiah, float $priceDollar): array 
    {
        return [
            'amount_rupiah' => $priceRupiah * $quantity,
            'amount_dollar' => $priceDollar * $quantity
        ];
    }

    public static function convertCurrency(float $price, float $currentDollar, string $type): array
    {
        if ($price <= 0 || $currentDollar <= 0) {
            return [];
        }

        if ($type === 'rupiah') {
            $priceDollar = round($price / $currentDollar, 2);
            return [
                'price_rupiah' => $price,
                'price_dollar' => $priceDollar
            ];
        }

        $priceRupiah = round($price * $currentDollar);
        return [
            'price_rupiah' => $priceRupiah, 
            'price_dollar' => $price
        ];
    }
}