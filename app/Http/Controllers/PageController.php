<?php

namespace App\Http\Controllers;

use App\Traits\ITPTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class PageController extends Controller
{
    use ITPTrait;

    public function show($slug, Request $request)
    {
        $view = "site.pages.{$slug}";

        if (!View::exists($view)) {
            abort(404);
        }
        $allowedCountries = [];
        $toeflPath = base_path('database/xls/verification/TOEFL-ITP');
        if (is_dir($toeflPath)) {
            $directories = array_diff(scandir($toeflPath), ['.', '..']);
            foreach ($directories as $dir) {
                if (is_dir($toeflPath . '/' . $dir) && file_exists($toeflPath . '/' . $dir . '/file.xlsx')) {
                    $allowedCountries[] = $dir;
                }
            }
        }

        if ($slug === 'verification') {
            return match ($request->type) {
                'TOEFL-ITP' => $this->handleTITP('TOEFL-ITP', $request, $view, $allowedCountries),
                'Auditor' => $this->handleAuditor('Auditor',$request, $view),
                'Banned-list' => $this->handleSimpleExcel('Banned-list', $view),
                default => view($view),
            };
        }

        if ($slug == 'testing-events') {
            return match ($request->type) {
                'TOFEL-IBT' => $this->handelXLSTestingEvents('TOFEL-IBT', $view),
                'TOEFL-ITP' => $this->handelXLSTestingEvents('TOEFL-ITP', $view),
                default => $this->handelXLSTestingEvents('TOFEL-IBT', $view),
            };
        }

        return view($view);
    }

    protected function handelXLSTestingEvents($path, $view)
    {
        $data = $this->readExcelFile("xls/testing-events/{$path}/file.xlsx");

        abort_if(!$data, 404);

        return view($view, compact('data'));
    }

    protected function handleSimpleExcel(string $folder, string $view, $main = 'verification')
    {
        $data = $this->readExcelFile("xls/verification/{$folder}/file.xlsx");

        abort_if(!$data, 404);

        return view($view, compact('data'));
    }

    protected function readExcelFile(string $relativePath, ?string $id = null): ?Collection
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
