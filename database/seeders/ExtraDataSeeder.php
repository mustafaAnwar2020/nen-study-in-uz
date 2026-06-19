<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class ExtraDataSeeder extends Seeder
{
    public function run()
    {

        Section::query()->where('page', 'verification')->delete();


        Section::query()->create([
            'slug'        => Section::generateSlug(),
            'key'         => 'TOFEL-IBT',
            'title'       => 'TOFEL IBT',
            'description' => 'Some Steps here',
            'iframe_url'  => 'https://blog.getbootstrap.com/',
            'page'        => 'verification',
        ]);

        Section::query()->create([
            'slug'        => Section::generateSlug(),
            'key'         => 'TOEFL-ITP',
            'title'       => 'TOEFL ITP',
            'description' => 'Another Some Steps here',
            'iframe_url'  => 'https://blog.getbootstrap.com/',
            'page'        => 'verification',
        ]);

        Section::query()->create([
            'slug'        => Section::generateSlug(),
            'key'         => 'Banned-list',
            'title'       => 'Banned list',
            'description' => 'Banned list description here',
            'iframe_url'  => 'https://blog.getbootstrap.com/',
            'page'        => 'verification',
        ]);

        Section::query()->create([
            'slug'        => Section::generateSlug(),
            'key'         => 'Auditor',
            'title'       => 'Auditor',
            'description' => 'Auditor description here',
            'iframe_url'  => 'https://blog.getbootstrap.com/',
            'page'        => 'verification',
        ]);

        ///Testing events
        Section::query()->create([
            'slug'        => Section::generateSlug(),
            'key'         => 'testing-events',
            'title'       => 'Testing events',
            'description' => 'Testing events description here  description here  description here  description here  description here description here description here  description here ',
            'iframe_url'  => 'https://blog.getbootstrap.com/',
            'page'        => 'testing-events',
        ]);


    }

}