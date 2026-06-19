<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Faq;
use App\Models\Library;
use App\Models\Network;
use App\Models\Offer;
use App\Models\Partner;
use App\Models\Slider;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {

        $this->call(LocationSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SectionSeeder::class);

        for ($i = 1; $i < 16; $i++) {
            Network::query()->create([
                'slug' => Network::generateSlug(),
                'id_text' => '23134',
                'name' => 'Network number - ' . $i,
                'country_code' => ['eg', 'us', 'ae'][rand(0, 2)],
                'city' => "City name" . $i,
                'phone' => "2132132123",
                'address' => "Address name" . $i,
                'email' => "email@m.com",
                'center_name' => "Center name" . $i,
                'position' => "Position" . $i,
                'type' => ['test-sites', 'teachers', 'tca'][rand(0, 2)],
                'is_active' => true,
            ]);
        }

        for ($i = 1; $i < 8; $i++) {
            Partner::query()->create([
                'slug' => Partner::generateSlug(),
                'product_id' => rand(1, 4),
                'name' => 'Partner number - ' . $i,
                'country_code' => ['eg', 'us', 'ae'][rand(0, 2)],
                'pdf' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'url' => 'google.com',
                'logo' => '/site/images/partners/client-' . $i . '.png',
                'website' => 'https://google.com',
                'description' => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation' . $i,
                'is_active' => true,
            ]);
        }

        for ($i = 7; $i < 20; $i++) {
            Event::query()->create([
                'slug' => Event::generateSlug(),
                'name' => 'Event number - ' . $i,
                'description' => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation' . $i,
                'date' => now()->addDays($i + 2),
                'time' => '10 hours',
                'location' => 'Online',
                'address' => 'Online',
                'excel_file' => 'https://google.com',
                'country_code' => ['eg', 'us'][rand(0, 1)],
                'is_online' => true,
                'is_active' => true,
                'book_now_url' => 'https://google.com',
            ]);
        }

        for ($i = 5; $i < 10; $i++) {
            Offer::query()->create([
                'slug' => Offer::generateSlug(),
                'name' => 'Offer number - ' . $i,
                'country_code' => ['eg', 'us', 'ae'][rand(0, 2)],
                'description' => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation' . $i,
                'image' => '/assets/offer.jpg',
                'book_now_url' => 'https://google.com',
                'date' => now()->addDays($i),
            ]);
        }

        Slider::query()->create([
            'slug' => Slider::generateSlug(),
            'name' => 'Welcome to NeN',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut
                                labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                ullamco
                                laboris nisi ut aliquip ex ea commodo consequat.',
            'image' => '/site/hero-carousel-1.jpg',
            'url' => 'https://google.com',
            'btn_text' => 'Book now',
            'btn_url' => 'https://google.com',
        ]);

        Slider::query()->create([
            'slug' => Slider::generateSlug(),
            'name' => 'Second Slider',
            'description' => '2222222222222222 ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut
                                labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                ullamco
                                laboris nisi ut aliquip ex ea commodo consequat.',
            'image' => '/site/hero-carousel-3.jpg',
            'url' => 'https://fb.com',
            'btn_text' => 'Learn More',
            'btn_url' => 'https://dd.com',
            'btn2_text' => 'Contact Us',
            'btn2_url' => 'https://sd.com',
        ]);

        for ($i = 0; $i < 5; $i++) {
            Faq::query()->create([
                'slug' => Faq::generateSlug(),
                'product_id' => rand(1, 3),
                'name' => 'What is the ETS? --- ' . $i,
                'answer' => $i . ' - The Educational Testing Service (ETS) is a U.S.-based non-profit organization that develops and administers standardized tests used to measure educational readiness and skill development. ETS is best known for its administration of the GRE (Graduate Record Examination) and TOEFL (Test of English as a Foreign Language) exams, but it also offers a wide range of other assessments, including the Praxis Series for teacher certification, the SAT and AP exams for college admissions, and the HiSET for high school equivalency.',
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Library::query()->create([
                'slug' => Library::generateSlug(),
                'name' => 'Some title here about the link ' . $i,
                'description' => 'Library Description ' . $i,
                'url' => 'https://www.ets.org/',
                'type' => ['resource', 'news', 'useful-links'][rand(0, 2)],
            ]);
        }


    }
}
