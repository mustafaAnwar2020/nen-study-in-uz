<?php

namespace App\Imports;

use App\Models\Network;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class NetworkImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection)
    {
        foreach ($collection as $idx => $row) {

            if ((isset($row['type']) && $row['type'] != null) && (isset($row['country_code']) && $row['country_code'] != null)) {
                DB::beginTransaction();
                try {
                    Network::query()->create([
                        'slug' => Network::generateSlug(),
                        'type' => $row['type'],
                        'name' => $row['name'],
                        'country_code' => $row['country_code'],
                        'center_name' => $row['center_name'],
                        'position' => $row['position'],
                        'city' => $row['city'],
                        'id_text' => $row['id'],
                        'email' => $row['email'],
                        'address' => $row['address'],
                        'phone' => $row['phone'],
                        'description' => $row['description'],
                        'is_active' => true,
                    ]);
                    DB::commit();
                } catch (\Exception $e) {
                    Log::error('ImportClassError:' . $e->getMessage());
                    DB::rollBack();
                }
            }
        }
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1'
        ];
    }

}
