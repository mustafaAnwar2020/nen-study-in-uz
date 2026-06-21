<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** User-facing text columns on nen_landing_settings that receive an _ar counterpart. */
    private array $settingsTextColumns = [
        'hero_product_title', 'hero_subtitle', 'hero_btn_text', 'hero_official_label',
        'about_label', 'about_title', 'about_description', 'about_stat_label',
        'about_metric1_label', 'about_metric2_label',
        'highlights_title', 'highlights_subtitle', 'archive_title', 'archive_subtitle', 'archive_btn_text',
        'partners_title', 'faq_title', 'media_title', 'contact_title', 'contact_description',
        'footer_copyright', 'footer_collaboration_text', 'footer_tagline',
        'header_register_text',
        'features_title', 'features_subtitle',
        'how_it_works_title', 'how_it_works_subtitle', 'how_it_works_btn_text',
        'milestones_title', 'milestones_subtitle', 'milestones_description', 'milestones_cta_text',
        'agencies_title', 'agencies_subtitle',
        'documents_title', 'documents_subtitle',
        'trusted_agencies_title', 'trusted_agencies_subtitle',
        'university_logos_title',
    ];

    public function up(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('nen_landing_settings', 'footer_tagline')) {
                $table->string('footer_tagline', 500)->nullable()->after('footer_collaboration_text');
            }
        });

        foreach ($this->settingsTextColumns as $column) {
            if (! Schema::hasColumn('nen_landing_settings', $column)) {
                continue;
            }
            if (Schema::hasColumn('nen_landing_settings', $column . '_ar')) {
                continue;
            }

            Schema::table('nen_landing_settings', function (Blueprint $table) use ($column) {
                if ($column === 'about_description' || $column === 'milestones_description' || $column === 'contact_description') {
                    $table->longText($column . '_ar')->nullable()->after($column);
                } else {
                    $table->text($column . '_ar')->nullable()->after($column);
                }
            });
        }

        $this->addArColumns('nen_landing_partner_items', [
            'name' => 'string',
            'description' => 'text',
        ]);

        $this->addArColumns('nen_landing_faq_items', [
            'question' => 'string',
            'answer' => 'text',
        ]);

        $this->addArColumns('nen_landing_feature_cards', [
            'stat_label' => 'string:255',
            'title' => 'string:255',
            'description' => 'text',
        ]);

        $this->addArColumns('nen_landing_how_it_works_steps', [
            'title' => 'string:255',
            'description' => 'text',
        ]);

        $this->addArColumns('nen_landing_agencies', [
            'name' => 'string:255',
            'service_description' => 'string:500',
            'location' => 'string:255',
        ]);

        $this->addArColumns('nen_landing_documents', [
            'title' => 'string:255',
            'description' => 'text',
        ]);

        if (Schema::hasTable('nen_landing_hero_slides')) {
            $this->addArColumns('nen_landing_hero_slides', [
                'title' => 'string:255',
                'subtitle' => 'string:500',
                'btn_text' => 'string:100',
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $drops = array_map(fn ($c) => $c . '_ar', $this->settingsTextColumns);
            $table->dropColumn($drops);
        });

        foreach ([
            'nen_landing_partner_items' => ['name', 'description'],
            'nen_landing_faq_items' => ['question', 'answer'],
            'nen_landing_feature_cards' => ['stat_label', 'title', 'description'],
            'nen_landing_how_it_works_steps' => ['title', 'description'],
            'nen_landing_agencies' => ['name', 'service_description', 'location'],
            'nen_landing_documents' => ['title', 'description'],
            'nen_landing_hero_slides' => ['title', 'subtitle', 'btn_text'],
        ] as $tableName => $columns) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }
            Schema::table($tableName, function (Blueprint $table) use ($columns) {
                $table->dropColumn(array_map(fn ($c) => $c . '_ar', $columns));
            });
        }
    }

    private function addArColumns(string $tableName, array $columns): void
    {
        if (! Schema::hasTable($tableName)) {
            return;
        }

        foreach ($columns as $column => $type) {
            if (! Schema::hasColumn($tableName, $column)) {
                continue;
            }
            if (Schema::hasColumn($tableName, $column . '_ar')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($column, $type) {
                if (str_starts_with($type, 'text') || str_starts_with($type, 'string')) {
                    $table->text($column . '_ar')->nullable()->after($column);
                } else {
                    $table->text($column . '_ar')->nullable()->after($column);
                }
            });
        }
    }
};
