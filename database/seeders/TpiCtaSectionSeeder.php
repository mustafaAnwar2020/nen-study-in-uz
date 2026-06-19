<?php

namespace Database\Seeders;

use App\Models\TpiCtaSection;
use Illuminate\Database\Seeder;

class TpiCtaSectionSeeder extends Seeder
{
    public function run(): void
    {
        $paymentOptions = TpiCtaSection::getDefaultPaymentOptions();

        TpiCtaSection::query()->firstOrCreate(
            ['id' => 1],
            [
                'title' => 'Ready to Practice TOEFL',
                'lead' => 'Start Now - Only $10 Refundable Deposit',
                'pay_btn_text' => 'Pay Now',
                'image' => 'site/images/tpi-hero.png',
                'payment_options' => $paymentOptions,
                'is_active' => true,
            ]
        );
    }
}
