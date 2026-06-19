<?php

namespace App\Http\Controllers;

use App\Models\ProtectedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ProtectedFileAccessController extends Controller
{
    public function index()
    {
        $protectedFiles = ProtectedFile::active()->get();

        return view('protected-files.index', compact('protectedFiles'));
    }

    public function showPasswordForm($id)
    {
        $protectedFile = ProtectedFile::active()->findOrFail($id);

        return view('protected-files.password', compact('protectedFile'));
    }

    public function verifyPassword(Request $request, $id)
    {
        $protectedFile = ProtectedFile::active()->findOrFail($id);

        $request->validate([
            'password' => 'required|string'
        ]);

        if (!$protectedFile->checkPassword($request->password)) {
            return redirect()->back()->withErrors(['password' => 'Invalid password'])->withInput();
        }
        
        Session::put("protected_file_access_{$id}", true);
                
        $protectedFile->updateLastAccessed();

        return redirect()->route('protected-files.edit', $id);
    }

    public function edit($id)
    {
        $protectedFile = ProtectedFile::active()->findOrFail($id);
        
        if (!Session::has("protected_file_access_{$id}")) {
            return redirect()->route('protected-files.password', $id)
                ->withErrors(['access' => 'Please enter the password to access this file']);
        }
        
        if (!$protectedFile->fileExists()) {
            return redirect()->route('protected-files.index')
                ->withErrors(['file' => 'File not found']);
        }
        
        $fileContent = $protectedFile->getFileContent();
        $fileExtension = pathinfo($protectedFile->file_path, PATHINFO_EXTENSION);

        return view('protected-files.edit', compact('protectedFile', 'fileContent', 'fileExtension'));
    }

    public function update(Request $request, $id)
    {
        $protectedFile = ProtectedFile::active()->findOrFail($id);
        
        if (!Session::has("protected_file_access_{$id}")) {
            return redirect()->route('protected-files.password', $id)
                ->withErrors(['access' => 'Please enter the password to access this file']);
        }

        $request->validate([
            'content' => 'required|string'
        ]);

        try {            
            $protectedFile->saveFileContent($request->content);


            return redirect()->back()->with('success', 'File updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['save' => 'Failed to save file: ' . $e->getMessage()]);
        }
    }

    public function upload(Request $request, $id)
    {
        $protectedFile = ProtectedFile::active()->findOrFail($id);
        
        if (!Session::has("protected_file_access_{$id}")) {
            return redirect()->route('protected-files.password', $id)
                ->withErrors(['access' => 'Please enter the password to access this file']);
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240' 
        ]);

        try {
            $uploadedFile = $request->file('file');
            
            if ($request->has('create_backup') && $protectedFile->fileExists()) {
                $backupPath = $protectedFile->full_path . '.backup.' . date('Y-m-d_H-i-s');
                File::copy($protectedFile->full_path, $backupPath);
            }
                        
            $directory = dirname($protectedFile->full_path);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
                        
            $uploadedFile->move($directory, basename($protectedFile->file_path));
                        
            $protectedFile->updateLastAccessed();

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download($id)
    {
        $protectedFile = ProtectedFile::active()->findOrFail($id);
        
        if (!Session::has("protected_file_access_{$id}")) {
            return redirect()->route('protected-files.password', $id)
                ->withErrors(['access' => 'Please enter the password to access this file']);
        }
        
        if (!$protectedFile->fileExists()) {
            return redirect()->back()->withErrors(['file' => 'File not found']);
        }


        return response()->download($protectedFile->full_path, basename($protectedFile->file_path));
    }

    public function logout($id)
    {
        Session::forget("protected_file_access_{$id}");
        
        return redirect()->route('protected-files.index')->with('success', 'Logged out successfully');
    }

    public function checkAccess($id)
    {
        $hasAccess = Session::has("protected_file_access_{$id}");

        return response()->json(['has_access' => $hasAccess]);
    }
}
