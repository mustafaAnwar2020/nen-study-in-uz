<?php

namespace App\Http\Controllers\Admin;

use App\Models\History;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Models\ProtectedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProtectedFileController extends Controller
{
    use CommonTrait;

    private function getAvailableDirectories()
    {
        return [
            'network/test-sites' => 'Network - Test Sites',
            'network/trainers' => 'Network - Trainers',
            'tpi/test-sites' => 'TPI - Test Sites',
            'tpi/trainers' => 'TPI - Trainers',
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

    public function index(Request $request)
    {
        $rows = ProtectedFile::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('is_active') && $request->is_active != 'all') {
            $rows->where('is_active', $request->is_active);
        }

        $rows = $rows->paginate(20);
        $model = 'Protected Files';
        return view('admin.protected-files.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Protected Files';
        $availableDirectories = $this->getAvailableDirectories();
        return view('admin.protected-files.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file_path' => 'required|string|max:500',
            'password' => 'required|string|min:6',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        
        $fullPath = database_path('xls/' . $request->file_path);
        if (!File::exists($fullPath)) {
            return redirect()->back()->withErrors(['file_path' => 'The specified file does not exist.'])->withInput();
        }

        $protectedFile = ProtectedFile::create([
            'name' => $request->name,
            'file_path' => $request->file_path,
            'password' => $request->password, 
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        History::makeHistory(
            auth()->user(),
            'ProtectedFile',
            'create_protected_file',
            $protectedFile->id
        );

        return redirect()->route('admin.protected-files.index')->with('success', 'Protected file created successfully');
    }

    public function edit($id)
    {
        $protectedFile = ProtectedFile::findOrFail($id);
        $model = 'Protected Files';
        $availableDirectories = $this->getAvailableDirectories();
        return view('admin.protected-files.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        $protectedFile = ProtectedFile::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'file_path' => 'required|string|max:500',
            'password' => 'nullable|string|min:6',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        
        $fullPath = database_path('xls/' . $request->file_path);
        if (!File::exists($fullPath)) {
            return redirect()->back()->withErrors(['file_path' => 'The specified file does not exist.'])->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'file_path' => $request->file_path,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        
        if ($request->filled('password')) {
            $updateData['password'] = $request->password; 
        }

        $protectedFile->update($updateData);

        History::makeHistory(
            auth()->user(),
            'ProtectedFile',
            'update_protected_file',
            $protectedFile->id
        );

        return redirect()->route('admin.protected-files.index')->with('success', 'Protected file updated successfully');
    }

    public function destroy($id)
    {
        $protectedFile = ProtectedFile::findOrFail($id);

        History::makeHistory(
            auth()->user(),
            'ProtectedFile',
            'delete_protected_file',
            $protectedFile->id
        );

        $protectedFile->delete();

        return redirect()->route('admin.protected-files.index')->with('success', 'Protected file deleted successfully');
    }

    public function passwords(Request $request)
    {
        $rows = ProtectedFile::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        $rows = $rows->paginate(20);
        $model = 'Protected File Passwords';
        return view('admin.protected-files.passwords', get_defined_vars());
    }

    public function updatePassword(Request $request, $id)
    {
        $protectedFile = ProtectedFile::findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);

        $protectedFile->update([
            'password' => $request->password 
        ]);

        History::makeHistory(
            auth()->user(),
            'ProtectedFile',
            'update_password',
            $protectedFile->id
        );

        return redirect()->back()->with('success', 'Password updated successfully');
    }

    public function toggleStatus($id)
    {
        $protectedFile = ProtectedFile::findOrFail($id);
        $protectedFile->update(['is_active' => !$protectedFile->is_active]);

        History::makeHistory(
            auth()->user(),
            'ProtectedFile',
            'toggle_status',
            $protectedFile->id
        );

        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
