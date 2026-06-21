<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NenLandingAgency;
use App\Models\NenLandingDocument;
use App\Models\NenLandingEventItem;
use App\Models\NenLandingFaqItem;
use App\Models\NenLandingFeatureCard;
use App\Models\NenLandingHeroSlide;
use App\Models\NenLandingHowItWorksStep;
use App\Models\NenLandingMediaItem;
use App\Models\NenLandingPartnerItem;
use App\Models\NenLandingUniversityLogo;
use App\Traits\CommonTrait;
use App\Traits\LocalizesValidationRules;
use Illuminate\Http\Request;

class NenLandingItemController extends Controller
{
    use CommonTrait, LocalizesValidationRules;

    protected array $resources = [
        'hero-slides' => [
            'model' => NenLandingHeroSlide::class,
            'label' => 'Hero Slides',
            'fields' => ['title', 'subtitle', 'image', 'btn_text', 'btn_url'],
        ],
        'partners' => [
            'model' => NenLandingPartnerItem::class,
            'label' => 'NEN Landing Partners',
            'fields' => ['name', 'description', 'image', 'url'],
        ],
        'events' => [
            'model' => NenLandingEventItem::class,
            'label' => 'NEN Landing Events',
            'fields' => ['type', 'title', 'description', 'image', 'event_date', 'url'],
        ],
        'faqs' => [
            'model' => NenLandingFaqItem::class,
            'label' => 'NEN Landing FAQs',
            'fields' => ['question', 'answer'],
        ],
        'media' => [
            'model' => NenLandingMediaItem::class,
            'label' => 'NEN Landing Media',
            'fields' => ['image', 'caption'],
        ],
        'feature-cards' => [
            'model' => NenLandingFeatureCard::class,
            'label' => 'Feature Cards (Why Uzbekistan)',
            'fields' => ['stat_value', 'stat_label', 'title', 'description', 'image'],
        ],
        'how-it-works' => [
            'model' => NenLandingHowItWorksStep::class,
            'label' => 'How It Works Steps',
            'fields' => ['title', 'description', 'image', 'step_number'],
        ],
        'translation-agencies' => [
            'model' => NenLandingAgency::class,
            'label' => 'Certified Translation Agencies',
            'fields' => ['name', 'service_description', 'image', 'location', 'phone', 'website'],
        ],
        'trusted-agencies' => [
            'model' => NenLandingAgency::class,
            'label' => 'Trusted Study Abroad Agencies',
            'fields' => ['name', 'service_description', 'image', 'location', 'phone', 'whatsapp_url'],
        ],
        'documents' => [
            'model' => NenLandingDocument::class,
            'label' => 'Application Documents',
            'fields' => ['title', 'description', 'image'],
        ],
        'university-logos' => [
            'model' => NenLandingUniversityLogo::class,
            'label' => 'University Logos (Success Partners)',
            'fields' => ['name', 'image', 'url'],
        ],
    ];

    protected function config(string $resource): array
    {
        abort_unless(isset($this->resources[$resource]), 404);
        return $this->resources[$resource];
    }

    protected function model(string $resource)
    {
        $class = $this->config($resource)['model'];
        return new $class();
    }

    public function index(string $resource)
    {
        $cfg = $this->config($resource);
        $class = $cfg['model'];

        $query = $class::query()->orderBy('sort_order')->orderBy('id');

        if (in_array($resource, ['translation-agencies', 'trusted-agencies'])) {
            $type = $resource === 'translation-agencies'
                ? NenLandingAgency::TYPE_TRANSLATION
                : NenLandingAgency::TYPE_TRUSTED;
            $query->where('type', $type);
        }

        $rows = $query->paginate(20);
        $model = $cfg['label'];
        return view('admin.nen-landing-items.index', get_defined_vars());
    }

    public function create(string $resource)
    {
        $cfg = $this->config($resource);
        $model = 'Create ' . $cfg['label'];
        return view('admin.nen-landing-items.manage', get_defined_vars());
    }

    public function edit(string $resource, $id)
    {
        $cfg = $this->config($resource);
        $class = $cfg['model'];
        $row = $class::query()->findOrFail($id);
        $model = 'Edit ' . $cfg['label'];
        return view('admin.nen-landing-items.manage', get_defined_vars());
    }

    public function store(Request $request, string $resource)
    {
        $cfg = $this->config($resource);
        $class = $cfg['model'];

        $rules = [
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ];

        if ($resource === 'hero-slides') {
            $rules += [
                'title'    => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:500',
                'image'    => 'nullable|string',
                'btn_text' => 'nullable|string|max:100',
                'btn_url'  => 'nullable|string|max:500',
            ];
        } elseif ($resource === 'partners') {
            $rules += [
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'image'       => 'nullable|string',
                'url'         => 'nullable|string|max:500',
            ];
        } elseif ($resource === 'events') {
            $rules += [
                'type'        => 'required|string|in:highlight,archive',
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'image'       => 'nullable|string',
                'event_date'  => 'nullable|date',
                'url'         => 'nullable|string|max:500',
            ];
        } elseif ($resource === 'faqs') {
            $rules += [
                'question' => 'required|string|max:500',
                'answer'   => 'nullable|string',
            ];
        } elseif ($resource === 'media') {
            $rules += [
                'image'       => 'nullable|string',
                'caption'     => 'nullable|string|max:255',
                'layout_slot' => 'nullable|string|in:left_top,left_bottom,center,right_top,right_bottom',
            ];
        } elseif ($resource === 'feature-cards') {
            $rules += [
                'stat_value'  => 'nullable|string|max:50',
                'stat_label'  => 'nullable|string|max:255',
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'image'       => 'nullable|string',
            ];
        } elseif ($resource === 'how-it-works') {
            $rules += [
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'image'       => 'nullable|string',
                'step_number' => 'nullable|integer|min:0|max:99',
            ];
        } elseif ($resource === 'translation-agencies') {
            $rules += [
                'name'                => 'required|string|max:255',
                'service_description' => 'nullable|string|max:500',
                'image'               => 'nullable|string',
                'location'            => 'nullable|string|max:255',
                'phone'               => 'nullable|string|max:50',
                'website'             => 'nullable|string|max:500',
            ];
        } elseif ($resource === 'trusted-agencies') {
            $rules += [
                'name'                => 'required|string|max:255',
                'service_description' => 'nullable|string|max:500',
                'image'               => 'nullable|string',
                'location'            => 'nullable|string|max:255',
                'phone'               => 'nullable|string|max:50',
                'whatsapp_url'        => 'nullable|string|max:500',
            ];
        } elseif ($resource === 'documents') {
            $rules += [
                'title'       => 'required|string|max:255',
                'description' => 'nullable|string',
                'image'       => 'nullable|string',
            ];
        } elseif ($resource === 'university-logos') {
            $rules += [
                'name'  => 'required|string|max:255',
                'image' => 'nullable|string',
                'url'   => 'nullable|string|max:500',
            ];
        } else {
            $rules += ['image' => 'nullable|string', 'caption' => 'nullable|string|max:255'];
        }

        $data = $request->validate($this->localizeRules($rules, $this->translatableFields($resource)));
        $data['is_active']   = $request->boolean('is_active');
        $data['sort_order']  = (int) ($request->sort_order ?? 0);

        if (in_array($resource, ['translation-agencies', 'trusted-agencies'])) {
            $data['type'] = $resource === 'translation-agencies'
                ? NenLandingAgency::TYPE_TRANSLATION
                : NenLandingAgency::TYPE_TRUSTED;
        }

        if ($request->row_id) {
            $row = $class::query()->findOrFail($request->row_id);
            if ($request->image && $row->image && $request->image !== $row->image) {
                $this->deleteOldFile($row->image);
            }
            $row->update($data);
            return redirect()->route('admin.nen-landing-items.index', $resource)
                ->with('success', __('messages.updated'));
        }

        $class::query()->create($data);
        return redirect()->route('admin.nen-landing-items.index', $resource)
            ->with('success', __('messages.created'));
    }

    public function destroy(string $resource, $id)
    {
        $cfg   = $this->config($resource);
        $class = $cfg['model'];
        $row   = $class::query()->findOrFail($id);
        if ($row->image ?? null) {
            $this->deleteOldFile($row->image);
        }
        $row->delete();
        return redirect()->route('admin.nen-landing-items.index', $resource)
            ->with('success', __('messages.deleted'));
    }

    /** @return list<string> */
    protected function translatableFields(string $resource): array
    {
        return match ($resource) {
            'hero-slides'          => ['title', 'subtitle', 'btn_text'],
            'partners'             => ['name', 'description'],
            'events'               => ['title', 'description'],
            'faqs'                 => ['question', 'answer'],
            'media'                => ['caption'],
            'feature-cards'        => ['stat_label', 'title', 'description'],
            'how-it-works'         => ['title', 'description'],
            'translation-agencies' => ['name', 'service_description', 'location'],
            'trusted-agencies'     => ['name', 'service_description', 'location'],
            'documents'            => ['title', 'description'],
            'university-logos'     => ['name'],
            default                => [],
        };
    }
}
