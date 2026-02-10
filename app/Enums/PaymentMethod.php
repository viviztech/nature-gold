<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Razorpay = 'razorpay';
    case PhonePe = 'phonepe';
    case COD = 'cod';

    public function label(): string
    {
        return match ($this) {
            self::Razorpay => 'Razorpay (UPI/Cards/Netbanking)',
            self::PhonePe => 'PhonePe',
            self::COD => 'Cash on Delivery',
        };
    }
}
