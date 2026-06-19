<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

trait ITPTrait
{

    public function handleTITP(string $mainPath, Request $request, string $view, array $allowedCountries)
    {
        $country = $request->get('country');
        $stName = $request->get('st_name');
        $DOB = $request->get('dob');
        $testDate = $request->get('test_date');

        $errors = [];
        
        if (!$country && $request->has('country')) {
            $errors[] = 'Country is required';
        }
        
        if (!$stName && $request->has('st_name')) {
            $errors[] = 'Student Name is required';
        }

        if(!$DOB && $request->has('dob')) {
            $errors[] = 'Date Of Birth is required';
        }

        if(!$testDate && $request->has('test_date')) {
            $errors[] = 'Test Date is required';
        }
        
        if (!empty($errors)) {
            return view($view, ['data' => null, 'allowedCountries' => $allowedCountries])->withErrors($errors);
        }

        $data = $this->getExcel("xls/verification/{$mainPath}/{$country}/file.xlsx");

        if (!$data || $data->count() < 2) {
            return view($view, ['data' => null, 'allowedCountries' => $allowedCountries]);
        }

        // First row = headers
        $headers = $data[0]->toArray();

        // Remaining rows = data
        $rows = $data->slice(1)->map(function ($row) use ($headers) {
            return collect($headers)->combine($row->toArray());
        });

        $filtered = $rows->filter(function ($row) use ($DOB, $stName, $testDate) {
            $firstName = trim((string)($row['Candidate first name'] ?? ''));
            $lastName = trim((string)($row['Candidate last name'] ?? ''));
            $fullName = $firstName . ' ' . $lastName;

            $nameMatch = strtolower($fullName) === strtolower(trim($stName));

            $convertedDOB = date('d/m/Y', strtotime($DOB));
            $dobMatch = $convertedDOB === $row['Date of birth'];

            $convertedTestDate = date('d/m/Y', strtotime($testDate));
            $testDateMatch = $convertedTestDate === $row['Date of the test'];

            return $nameMatch && $dobMatch && $testDateMatch;
        })->values();

        return view($view, ['data' => $filtered, 'headers' => $headers, 'allowedCountries' => $allowedCountries]);
    }

    public function handleAuditor(string $mainPath, Request $request, string $view)
    {
        $VisitCode = $request->get('visit_code');
        

        $errors = [];
        
        if (!$VisitCode && $request->has('visit_code')) {
            $errors[] = 'Visit Code is required';
        }

        
        if (!empty($errors)) {
            return view($view, ['data' => null])->withErrors($errors);
        }
        
        $data = $this->getExcel("xls/verification/{$mainPath}/file.xlsx");

        if (!$data || $data->count() < 2) {
            return view($view, ['data' => null]);
        }
        // First row = headers
        $headers = $data[0]->toArray();

        // Remaining rows = data
        $rows = $data->slice(1)->map(function ($row) use ($headers) {
            return collect($headers)->combine($row->toArray());
        });

        $filtered = $rows->filter(function ($row) use ($VisitCode) {
            $visitCodeLower = strtolower(trim($VisitCode));
            
            // Check every column in the row for the VisitCode
            foreach ($row as $columnValue) {
                $columnValueLower = strtolower(trim((string)$columnValue));
                
                if ($columnValueLower === $visitCodeLower) {
                    return true;
                }
            }
            
            return false;
        })->values();

        return view($view, ['data' => $filtered, 'headers' => $headers]);
    }

    protected function getExcel(string $relativePath, ?string $id = null): ?Collection
    {
        $filePath = database_path($relativePath);

        if (!file_exists($filePath)) {
            return null;
        }

        $sheet = Excel::toCollection(null, $filePath)->first();

        if ($sheet->isEmpty()) {
            return null;
        }

        // Filter out empty rows
        $filtered = $sheet->filter(function ($row) {
            return $row->filter(fn($cell) => trim((string)$cell) !== '')->isNotEmpty();
        })->values();

        if (is_null($id)) {
            return $filtered;
        }

        return $filtered->firstWhere('id', $id)
            ? collect([$filtered->first()->keys(), $filtered->firstWhere('id', $id)])
            : null;
    }
}
