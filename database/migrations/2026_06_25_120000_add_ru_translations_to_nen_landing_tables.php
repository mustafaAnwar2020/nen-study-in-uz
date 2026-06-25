<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
    foreach ($this->settingsTextColumns as $column) {
      if (! Schema::hasColumn('nen_landing_settings', $column)) {
        continue;
      }
      if (Schema::hasColumn('nen_landing_settings', $column . '_ru')) {
        continue;
      }

      Schema::table('nen_landing_settings', function (Blueprint $table) use ($column) {
        $after = Schema::hasColumn('nen_landing_settings', $column . '_ar')
          ? $column . '_ar'
          : $column;

        if (in_array($column, ['about_description', 'milestones_description', 'contact_description'], true)) {
          $table->longText($column . '_ru')->nullable()->after($after);
        } else {
          $table->text($column . '_ru')->nullable()->after($after);
        }
      });
    }

    $this->addRuColumns('nen_landing_partner_items', ['name', 'description']);
    $this->addRuColumns('nen_landing_faq_items', ['question', 'answer']);
    $this->addRuColumns('nen_landing_feature_cards', ['stat_label', 'title', 'description']);
    $this->addRuColumns('nen_landing_how_it_works_steps', ['title', 'description']);
    $this->addRuColumns('nen_landing_agencies', ['name', 'service_description', 'location']);
    $this->addRuColumns('nen_landing_documents', ['title', 'description']);

    if (Schema::hasTable('nen_landing_hero_slides')) {
      $this->addRuColumns('nen_landing_hero_slides', ['title', 'subtitle', 'btn_text']);
    }
  }

  public function down(): void
  {
    if (Schema::hasTable('nen_landing_settings')) {
      $drops = array_filter(
        array_map(fn ($c) => $c . '_ru', $this->settingsTextColumns),
        fn ($col) => Schema::hasColumn('nen_landing_settings', $col)
      );
      if ($drops !== []) {
        Schema::table('nen_landing_settings', function (Blueprint $table) use ($drops) {
          $table->dropColumn($drops);
        });
      }
    }

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
      $drops = array_filter(
        array_map(fn ($c) => $c . '_ru', $columns),
        fn ($col) => Schema::hasColumn($tableName, $col)
      );
      if ($drops === []) {
        continue;
      }
      Schema::table($tableName, function (Blueprint $table) use ($drops) {
        $table->dropColumn($drops);
      });
    }
  }

  private function addRuColumns(string $tableName, array $columns): void
  {
    if (! Schema::hasTable($tableName)) {
      return;
    }

    foreach ($columns as $column) {
      if (! Schema::hasColumn($tableName, $column)) {
        continue;
      }
      if (Schema::hasColumn($tableName, $column . '_ru')) {
        continue;
      }

      Schema::table($tableName, function (Blueprint $table) use ($tableName, $column) {
        $after = Schema::hasColumn($tableName, $column . '_ar')
          ? $column . '_ar'
          : $column;
        $table->text($column . '_ru')->nullable()->after($after);
      });
    }
  }
};
