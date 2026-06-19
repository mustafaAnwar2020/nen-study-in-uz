<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function makeNotificationInDb($user, $type, $data): void
    {
        $user->notifications()->create([
            'id' => Str::uuid(),
            'type' => $type,
            'data' => $data,
        ]);
    }

    public function getAdmins()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->get();
    }



    protected function readExcelFile(string $relativePath): ?Collection
    {
        $filePath = database_path($relativePath);

        if (!file_exists($filePath)) {
            return null;
        }

        $sheet = Excel::toCollection(null, $filePath)->first();

        if ($sheet->isEmpty()) {
            return null;
        }

        return $sheet->map(function ($row) {

            
            return $row->filter()->values();
        })->filter(function ($row) {
            return $row->isNotEmpty();
        });

    }

}
