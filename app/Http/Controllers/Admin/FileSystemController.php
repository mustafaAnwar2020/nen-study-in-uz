<?php

namespace App\Http\Controllers\Admin;

use App\Models\History;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Html;

class FileSystemController extends Controller
{
    use CommonTrait;

    /**
     * Available directories for file management
     */
    private function getAvailableDirectories()
    {
        return [
            'network/test-sites' => 'Network - Test Sites',
            'network/trainers' => 'Network - Trainers',
            'testing-events/TOEFL-ITP' => 'Testing Events - TOEFL-ITP',
            'testing-events/TOEFL-IBT' => 'Testing Events - TOEFL-IBT',
            'verification/Auditor' => 'Verification - Auditor',
            'verification/Banned-list' => 'Verification - Banned-list',
            'verification/TOEFL-ITP/ae' => 'Verification - TOEFL-ITP - Arab Emirates',
            'verification/TOEFL-ITP/az' => 'Verification - TOEFL-ITP - azerbaijan',
            'verification/TOEFL-ITP/eg' => 'Verification - TOEFL-ITP - Egypt',
            'verification/TOEFL-ITP/kg' => 'Verification - TOEFL-ITP - kyrgyzstan',
            'verification/TOEFL-ITP/om' => 'Verification - TOEFL-ITP - Oman',
            'verification/TOEFL-ITP/sa' => 'Verification - TOEFL-ITP - Saudi Arabia',
            'verification/TOEFL-ITP/uz' => 'Verification - TOEFL-ITP - Uzbekistan',
        ];
    }

    /**
     * Get base path for Excel files
     */
    private function getBasePath()
    {
        return database_path('xls');
    }

    /**
     * Scan directories and get file information
     */
    private function scanDirectories($filterDirectory = null)
    {
        $files = [];
        $directories = $this->getAvailableDirectories();
        $basePath = $this->getBasePath();

        foreach ($directories as $dirKey => $dirName) {
            // Skip if filtering by specific directory
            if ($filterDirectory && $filterDirectory !== $dirKey) {
                continue;
            }

            $fullPath = $basePath . '/' . $dirKey;

            if (File::isDirectory($fullPath)) {
                // Look for file.xlsx in the directory
                $filePath = $fullPath . '/file.xlsx';

                if (File::exists($filePath)) {
                    $fileInfo = [
                        'directory' => $dirKey,
                        'directory_name' => $dirName,
                        'file_name' => 'file.xlsx',
                        'file_path' => $filePath,
                        'relative_path' => $dirKey . '/file.xlsx',
                        'file_size' => File::size($filePath),
                        'formatted_size' => $this->formatFileSize(File::size($filePath)),
                        'last_modified' => File::lastModified($filePath),
                        'last_modified_formatted' => date('Y-m-d H:i:s', File::lastModified($filePath)),
                        'exists' => true
                    ];
                } else {
                    $fileInfo = [
                        'directory' => $dirKey,
                        'directory_name' => $dirName,
                        'file_name' => 'file.xlsx',
                        'file_path' => $filePath,
                        'relative_path' => $dirKey . '/file.xlsx',
                        'file_size' => 0,
                        'formatted_size' => '0 B',
                        'last_modified' => null,
                        'last_modified_formatted' => 'N/A',
                        'exists' => false
                    ];
                }

                $files[] = $fileInfo;
            }
        }

        return collect($files);
    }

    /**
     * Format file size in human readable format
     */
    private function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Display listing of files from filesystem
     */
    public function index(Request $request)
    {
        $filterDirectory = $request->get('directory');
        $files = $this->scanDirectories($filterDirectory);

        // Sort by directory and then by existence
        $files = $files->sortBy([
            ['directory', 'asc'],
            ['exists', 'desc']
        ]);

        $model = 'File System Management';
        $directories = $this->getAvailableDirectories();

        return view('admin.file-system.index', get_defined_vars());
    }

    /**
     * Show upload form for specific directory
     */
    public function create(Request $request)
    {
        $directory = $request->get('directory');
        $directories = $this->getAvailableDirectories();

        if ($directory && !array_key_exists($directory, $directories)) {
            return redirect()->route('admin.file-system.index')
                ->with('error', 'Invalid directory specified.');
        }

        $model = 'Upload File to Directory';
        return view('admin.file-system.create', get_defined_vars());
    }

    /**
     * Store uploaded file
     */
    public function store(Request $request)
    {
        $request->validate([
            'directory' => 'required|string',
            'file' => 'required|file|mimes:xlsx,xls|max:10240', // 10MB max
        ]);

        try {
            $directory = $request->directory;
            $directories = $this->getAvailableDirectories();

            if (!array_key_exists($directory, $directories)) {
                return redirect()->back()->with('error', 'Invalid directory specified.');
            }

            $uploadedFile = $request->file('file');

            // Create target directory if it doesn't exist
            $targetPath = $this->getBasePath() . '/' . $directory;
            if (!File::isDirectory($targetPath)) {
                File::makeDirectory($targetPath, 0755, true);
            }

            // Always save as file.xlsx
            $fileName = 'file.xlsx';
            $filePath = $targetPath . '/' . $fileName;

            // Backup existing file if it exists
            if (File::exists($filePath)) {
                $backupPath = $targetPath . '/backup_' . date('Y_m_d_H_i_s') . '_file.xlsx';
                File::move($filePath, $backupPath);
            }

            // Move uploaded file
            $uploadedFile->move($targetPath, $fileName);

            // Log the action
                History::makeHistory(
                    auth()->user(),
                    'FileSystem',
                    'update',
                    null
                );

            return redirect()->route('admin.file-system.index')
                ->with('success', 'File uploaded successfully to ' . $directories[$directory] . '!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error uploading file: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Preview Excel file content
     */
    public function preview(Request $request)
    {
        $directory = $request->get('directory');
        $directories = $this->getAvailableDirectories();

        if (!$directory || !array_key_exists($directory, $directories)) {
            return response()->json(['error' => 'Invalid directory specified'], 400);
        }

        $filePath = $this->getBasePath() . '/' . $directory . '/file.xlsx';

        if (!File::exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        try {
            $spreadsheet = IOFactory::load($filePath);
            $writer = new Html($spreadsheet);
            $htmlContent = $writer->generateHTMLAll();

            return response()->json([
                'success' => true,
                'html' => $htmlContent,
                'file_info' => [
                    'name' => 'file.xlsx',
                    'directory' => $directories[$directory],
                    'size' => $this->formatFileSize(File::size($filePath)),
                    'last_modified' => date('Y-m-d H:i:s', File::lastModified($filePath))
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error reading file: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Download file
     */
    public function download(Request $request)
    {
        $directory = $request->get('directory');
        $directories = $this->getAvailableDirectories();

        if (!$directory || !array_key_exists($directory, $directories)) {
            return redirect()->back()->with('error', 'Invalid directory specified.');
        }

        $filePath = $this->getBasePath() . '/' . $directory . '/file.xlsx';

        if (!File::exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $downloadName = str_replace(['/', ' '], '_', $directories[$directory]) . '_file.xlsx';

        return response()->download($filePath, $downloadName);
    }

    /**
     * Delete file
     */
    public function destroy(Request $request)
    {
        $directory = $request->get('directory');
        $directories = $this->getAvailableDirectories();

        if (!$directory || !array_key_exists($directory, $directories)) {
            return redirect()->back()->with('error', 'Invalid directory specified.');
        }

        try {
            $filePath = $this->getBasePath() . '/' . $directory . '/file.xlsx';

            if (File::exists($filePath)) {
                File::delete($filePath);

                History::makeHistory(
                    auth()->user(),
                    'FileSystem',
                    'delete',
                    null
                );

                return redirect()->route('admin.file-system.index')
                    ->with('success', 'File deleted successfully from ' . $directories[$directory] . '!');
            } else {
                return redirect()->back()->with('error', 'File not found.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting file: ' . $e->getMessage());
        }
    }

    /**
     * Get directory information as JSON
     */
    public function getDirectoryInfo(Request $request)
    {
        $directory = $request->get('directory');
        $files = $this->scanDirectories($directory);

        return response()->json([
            'success' => true,
            'files' => $files->values()->all()
        ]);
    }

    /**
     * Refresh directory scan
     */
    public function refresh()
    {
        try {
            $files = $this->scanDirectories();
            $existingCount = $files->where('exists', true)->count();
            $missingCount = $files->where('exists', false)->count();

            return redirect()->route('admin.file-system.index')
                ->with('success', "Directory scan completed. Found {$existingCount} existing files, {$missingCount} missing files.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error scanning directories: ' . $e->getMessage());
        }
    }
}
