<?php

namespace App\Traits;



trait ReportsTrait
{

    /*
     * This fun is used in general export and export per group
     * */
    public function loopThroughTestResults($data): array
    {
        $beforeType = [];
        $afterType = [];
        $nullData = [];

        foreach ($data as $row) {
            if ($row->type == 'before') {
                $beforeType[] = [
                    'name' => $row->name,
                    'value' => $row->value,
                    'id_number' => $row->id_number,
                    'phone' => $row->phone,
                    'test_name' => $row->test_name,
                ];
            } elseif ($row->type == 'after') {
                $afterType[] = [
                    'name' => $row->name,
                    'value' => $row->value,
                    'id_number' => $row->id_number,
                    'phone' => $row->phone,
                    'test_name' => $row->test_name,
                ];
            }else{
                $nullData[] = [
                    'name' => $row->name,
                    'value' => $row->value,
                    'id_number' => $row->id_number,
                    'phone' => $row->phone,
                    'test_name' => $row->test_name,
                ];
            }
        }

        return [
            'beforeType' => $beforeType,
            'afterType' => $afterType,
            'nullData' => $nullData,
        ];
    }


}
