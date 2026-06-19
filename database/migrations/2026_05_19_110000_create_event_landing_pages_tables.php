<?php

/**
 * Event landing pages (replaces the removed add_landing_page_fields_to_events migration).
 * Creates event_landing_pages + event_landing_sections. If legacy columns still exist on
 * events, copies hero data into sections then drops those columns.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->unique()->constrained('events')->cascadeOnDelete();
            $table->boolean('is_enabled')->default(false);
            $table->timestamps();
        });

        Schema::create('event_landing_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_landing_page_id')->constrained('event_landing_pages')->cascadeOnDelete();
            $table->string('type', 64);
            $table->json('content')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['event_landing_page_id', 'type']);
        });

        if (Schema::hasColumn('events', 'has_landing_page')) {
            $this->migrateFromEventsTable();
            $this->dropLegacyEventColumns();
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('event_landing_pages')) {
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'has_landing_page')) {
                $table->boolean('has_landing_page')->default(false)->after('is_active');
                $table->string('landing_title')->nullable();
                $table->string('landing_title_highlight')->nullable();
                $table->text('landing_description')->nullable();
                $table->string('landing_date_label')->nullable();
                $table->string('landing_time_label')->nullable();
                $table->string('landing_location_label')->nullable();
                $table->string('landing_hero_image')->nullable();
                $table->string('landing_qr_image')->nullable();
                $table->string('landing_register_label')->nullable();
                $table->string('landing_agenda_label')->nullable();
                $table->string('landing_agenda_url')->nullable();
                $table->dateTime('landing_countdown_at')->nullable();
                $table->string('landing_whatsapp_url')->nullable();
                $table->string('landing_telegram_url')->nullable();
                $table->string('landing_faq_url')->nullable();
            }
        });

        Schema::dropIfExists('event_landing_sections');
        Schema::dropIfExists('event_landing_pages');
    }

    private function migrateFromEventsTable(): void
    {
        $events = DB::table('events')->get();

        foreach ($events as $event) {
            $hasData = (bool) $event->has_landing_page
                || $event->landing_title
                || $event->landing_hero_image;

            if (!$hasData) {
                continue;
            }

            $pageId = DB::table('event_landing_pages')->insertGetId([
                'event_id' => $event->id,
                'is_enabled' => (bool) $event->has_landing_page,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('event_landing_sections')->insert([
                'event_landing_page_id' => $pageId,
                'type' => 'hero',
                'content' => json_encode([
                    'title' => $event->landing_title,
                    'title_highlight' => $event->landing_title_highlight,
                    'description' => $event->landing_description,
                    'date_label' => $event->landing_date_label,
                    'time_label' => $event->landing_time_label,
                    'location_label' => $event->landing_location_label,
                    'hero_image' => $event->landing_hero_image,
                    'qr_image' => $event->landing_qr_image,
                    'register_label' => $event->landing_register_label,
                    'agenda_label' => $event->landing_agenda_label,
                    'agenda_url' => $event->landing_agenda_url,
                    'countdown_at' => $event->landing_countdown_at,
                    'whatsapp_url' => $event->landing_whatsapp_url,
                    'telegram_url' => $event->landing_telegram_url,
                    'faq_url' => $event->landing_faq_url,
                ]),
                'sort_order' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function dropLegacyEventColumns(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'has_landing_page',
                'landing_title',
                'landing_title_highlight',
                'landing_description',
                'landing_date_label',
                'landing_time_label',
                'landing_location_label',
                'landing_hero_image',
                'landing_qr_image',
                'landing_register_label',
                'landing_agenda_label',
                'landing_agenda_url',
                'landing_countdown_at',
                'landing_whatsapp_url',
                'landing_telegram_url',
                'landing_faq_url',
            ]);
        });
    }
};
