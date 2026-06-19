<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\User;
use App\Traits\CommonTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckCarRegistrationExpiry extends Command
{
    use CommonTrait;

    protected $signature = 'cars:check-registration';
    protected $description = 'Check for cars with registration expiring in 5 days';

    public function handle()
    {
        $targetDate = Carbon::now()->addDays(5)->startOfDay();

        $cars = Car::query()
            ->whereDate('registration_expiry_date', $targetDate)
            ->get();

        if ($cars->count() > 0) {
            $admin = User::query()->where('is_admin', true)->first();
            foreach ($cars as $car) {
                $this->sendGeneralNotification($admin, [
                        'message' => 'تاريخ انتهاء التسجيل للسيارو :' . $car->license_plate . ' شارف علي الإنتهاء بعد 5 ايام'
                    ]
                );
            }
            $this->info('Found ' . $cars->count() . ' cars with expiring registration. Notifications sent.');
        } else {
            $this->info('No cars found with registration expiring in 5 days.');
        }
    }
}
