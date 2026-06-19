<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProtectedFile;
use Illuminate\Support\Facades\Hash;

class ProtectedFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Network directories
        ProtectedFile::create([
            'name' => 'Network Test Sites Data',
            'file_path' => 'network/test-sites/file.xlsx',
            'password' => 'network123',
            'description' => 'Protected Excel file containing network test sites information.',
            'is_active' => true,
        ]);

        ProtectedFile::create([
            'name' => 'Network Trainers Database',
            'file_path' => 'network/trainers/file.xlsx',
            'password' => 'trainers456',
            'description' => 'Database of certified trainers in the network.',
            'is_active' => true,
        ]);

        // Testing Events directories
        ProtectedFile::create([
            'name' => 'TOEFL-ITP Testing Events',
            'file_path' => 'testing-events/TOEFL-ITP/file.xlsx',
            'password' => 'toefl_itp789',
            'description' => 'TOEFL-ITP testing events schedule and data.',
            'is_active' => true,
        ]);

        ProtectedFile::create([
            'name' => 'TOEFL-IBT Testing Events',
            'file_path' => 'testing-events/TOEFL-IBT/file.xlsx',
            'password' => 'toefl_ibt012',
            'description' => 'TOEFL-IBT testing events schedule and data.',
            'is_active' => true,
        ]);

        // Verification directories
        ProtectedFile::create([
            'name' => 'Auditor Verification Data',
            'file_path' => 'verification/Auditor/file.xlsx',
            'password' => 'auditor345',
            'description' => 'Auditor verification and certification data.',
            'is_active' => true,
        ]);

        ProtectedFile::create([
            'name' => 'Banned List Database',
            'file_path' => 'verification/Banned-list/file.xlsx',
            'password' => 'banned678',
            'description' => 'Database of banned individuals and institutions.',
            'is_active' => true,
        ]);

        // TOEFL-ITP Verification by Country
        ProtectedFile::create([
            'name' => 'TOEFL-ITP UAE Verification',
            'file_path' => 'verification/TOEFL-ITP/ae/file.xlsx',
            'password' => 'uae901',
            'description' => 'TOEFL-ITP verification data for United Arab Emirates.',
            'is_active' => true,
        ]);

        ProtectedFile::create([
            'name' => 'TOEFL-ITP Azerbaijan Verification',
            'file_path' => 'verification/TOEFL-ITP/az/file.xlsx',
            'password' => 'azerbaijan234',
            'description' => 'TOEFL-ITP verification data for Azerbaijan.',
            'is_active' => true,
        ]);

        ProtectedFile::create([
            'name' => 'TOEFL-ITP Egypt Verification',
            'file_path' => 'verification/TOEFL-ITP/eg/file.xlsx',
            'password' => 'egypt567',
            'description' => 'TOEFL-ITP verification data for Egypt.',
            'is_active' => true,
        ]);

        ProtectedFile::create([
            'name' => 'TOEFL-ITP Kyrgyzstan Verification',
            'file_path' => 'verification/TOEFL-ITP/kg/file.xlsx',
            'password' => 'kyrgyzstan890',
            'description' => 'TOEFL-ITP verification data for Kyrgyzstan.',
            'is_active' => true,
        ]);

        ProtectedFile::create([
            'name' => 'TOEFL-ITP Oman Verification',
            'file_path' => 'verification/TOEFL-ITP/om/file.xlsx',
            'password' => 'oman123',
            'description' => 'TOEFL-ITP verification data for Oman.',
            'is_active' => true,
        ]);

        ProtectedFile::create([
            'name' => 'TOEFL-ITP Saudi Arabia Verification',
            'file_path' => 'verification/TOEFL-ITP/sa/file.xlsx',
            'password' => 'saudi456',
            'description' => 'TOEFL-ITP verification data for Saudi Arabia.',
            'is_active' => true,
        ]);

        ProtectedFile::create([
            'name' => 'TOEFL-ITP Uzbekistan Verification',
            'file_path' => 'verification/TOEFL-ITP/uz/file.xlsx',
            'password' => 'uzbekistan789',
            'description' => 'TOEFL-ITP verification data for Uzbekistan.',
            'is_active' => true,
        ]);
    }
}
