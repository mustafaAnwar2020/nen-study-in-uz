<?php

namespace Database\Seeders;

use App\Models\TpiFaq;
use Illuminate\Database\Seeder;

class TpiFaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['question' => 'Is this TOEFL scholarship really free?', 'answer' => 'Yes. Only a refundable security deposit is required.', 'sort_order' => 1],
            ['question' => 'Is the deposit an exam fee?', 'answer' => 'No. It is not an exam or training fee.', 'sort_order' => 2],
            ['question' => 'When will I receive my refund?', 'answer' => 'After completing the required practice activities.', 'sort_order' => 3],
            ['question' => 'Does this guarantee passing TOEFL?', 'answer' => 'No guarantees, but it significantly improves readiness and confidence.', 'sort_order' => 4],
        ];

        foreach ($faqs as $idx => $faq) {
            TpiFaq::query()->firstOrCreate(
                ['id' => $idx + 1],
                array_merge($faq, ['is_active' => true])
            );
        }
    }
}
