<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\History;
use App\Models\Location;
use App\Services\EventLandingPageService;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    use CommonTrait;

    public function __construct(
        private readonly EventLandingPageService $landingPageService
    ) {
    }

    public function index(Request $request)
    {
        $rows = Event::query()->latest();

        // Non-super_admin users only see their assigned events
        if (!auth()->user()->hasRole('super_admin')) {
            $rows->whereHas('assignedUsers', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->date && $request->date != '') {
            $rows->where('date', $request->date);
        }

        if ($request->country_code && $request->country_code != '') {
            $rows->where('country_code', $request->country_code);
        }

        $rows = $rows->paginate(20);
        $model = 'Events';
        return view('admin.events.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Event';
        $hero = [];
        $aboutReasons = [];
        $stats = [];
        $detailsMap = [];
        $speakers = [];
        $agenda = [];
        $partners = [];
        $organizers = [];
        $mapLocations = Location::sortedActive();
        $landingMedia = [];
        $landingFaq = [];
        return view('admin.events.manage', get_defined_vars());
    }

    public function edit($slug)
    {
        // Non-super_admin users can only edit assigned events
        $row = Event::query()->with([
            'landingPage.heroSection',
            'landingPage.aboutReasonsSection',
            'landingPage.statsSection',
            'landingPage.detailsMapSection',
            'landingPage.speakersSection',
            'landingPage.agendaSection',
            'landingPage.organizersSection',
            'landingPage.partnersSection',
            'landingPage.mediaSection',
            'landingPage.landingFaqSection',
        ])->where('slug', $slug)->firstOrFail();

        // Non-super_admin users can only edit assigned events
        if (!auth()->user()->hasRole('super_admin') && !$row->assignedUsers->contains(auth()->id())) {
            abort(403, 'You do not have permission to edit this event.');
        }

        $model = 'Edit event - ' . $row->name;
        $hero = $row->heroSectionContent();
        $aboutReasons = $row->aboutReasonsSectionContent();
        $stats = $row->statsSectionContent();
        $detailsMap = $row->detailsMapSectionContent();
        $speakers = $row->speakersSectionContent();
        $agenda = $row->agendaSectionContent();
        $organizers = $row->organizersSectionContent();
        $mapLocations = Location::sortedActive();
        $partners = $row->partnersSectionContent();
        $landingMedia = $row->mediaSectionContent();
        $landingFaq = $row->landingFaqSectionContent();
        return view('admin.events.manage', get_defined_vars());
    }

    public function store(Request $request)
    {
        $isUpdate = (bool) $request->row_id;

        // Only super_admin or users with events.create can create new events
        if (!$isUpdate && !auth()->user()->hasRole('super_admin') && !auth()->user()->hasPermissionTo('events.create')) {
            abort(403, 'You do not have permission to create events.');
        }

        $request->merge([
            'slug' => Str::slug((string) $request->input('slug', '')),
        ]);

        $data = $request->validate(array_merge([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('events', 'slug')->ignore($request->row_id),
            ],
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'pdf' => 'nullable|string|max:2048',
            'excel_file' => 'nullable|string',
            'country_code' => 'nullable|string',
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'time' => 'nullable|string',
            'book_now_url' => 'nullable|string',
            'date' => 'nullable|date',
            'is_online' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'show_full_address' => 'nullable|boolean',
            'has_landing_page' => 'nullable|boolean',
            'landing_title' => 'nullable|string|max:255',
            'landing_title_highlight' => 'nullable|string|max:255',
            'landing_description' => 'nullable|string',
            'landing_date_label' => 'nullable|string|max:255',
            'landing_time_label' => 'nullable|string|max:255',
            'landing_location_label' => 'nullable|string|max:500',
            'landing_hero_image' => 'nullable|string|max:2048',
            'landing_qr_image' => 'nullable|string|max:2048',
            'landing_register_label' => 'nullable|string|max:255',
            'landing_agenda_label' => 'nullable|string|max:255',
            'landing_agenda_url' => 'nullable|string|max:2048',
            'landing_countdown_at' => 'nullable|date',
            'landing_countdown_end_at' => 'nullable|date',
            'landing_whatsapp_url' => 'nullable|string|max:2048',
            'landing_telegram_url' => 'nullable|string|max:2048',
            'landing_faq_url' => 'nullable|string|max:2048',
            'landing_about_label' => 'nullable|string|max:255',
            'landing_about_title' => 'nullable|string|max:255',
            'landing_about_description' => 'nullable|string',
            'landing_reasons_label' => 'nullable|string|max:255',
            'landing_reason_1_icon' => 'nullable|string|max:64',
            'landing_reason_1_title' => 'nullable|string|max:255',
            'landing_reason_1_description' => 'nullable|string',
            'landing_reason_2_icon' => 'nullable|string|max:64',
            'landing_reason_2_title' => 'nullable|string|max:255',
            'landing_reason_2_description' => 'nullable|string',
            'landing_reason_3_icon' => 'nullable|string|max:64',
            'landing_reason_3_title' => 'nullable|string|max:255',
            'landing_reason_3_description' => 'nullable|string',
            'landing_stat_1_icon' => 'nullable|string|max:64',
            'landing_stat_1_value' => 'nullable|string|max:64',
            'landing_stat_1_label' => 'nullable|string|max:255',
            'landing_stat_2_icon' => 'nullable|string|max:64',
            'landing_stat_2_value' => 'nullable|string|max:64',
            'landing_stat_2_label' => 'nullable|string|max:255',
            'landing_stat_3_icon' => 'nullable|string|max:64',
            'landing_stat_3_value' => 'nullable|string|max:64',
            'landing_stat_3_label' => 'nullable|string|max:255',
            'landing_stat_4_icon' => 'nullable|string|max:64',
            'landing_stat_4_value' => 'nullable|string|max:64',
            'landing_stat_4_label' => 'nullable|string|max:255',
            'landing_details_label' => 'nullable|string|max:255',
            'landing_details_title' => 'nullable|string|max:255',
            'landing_details_description' => 'nullable|string',
            'landing_details_date' => 'nullable|string|max:255',
            'landing_details_time' => 'nullable|string|max:255',
            'landing_details_venue' => 'nullable|string|max:500',
            'landing_details_address' => 'nullable|string|max:500',
            'landing_details_map_embed_url' => 'nullable|string|max:5000',
        ], EventLandingPageService::extraValidationRules()));

        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $oldRow = null;
        $image = null;
        $pdf = null;

        if ($isUpdate) {
            $oldRow = Event::findOrFail($request->row_id);

            // Non-super_admin users can only update assigned events
            if (!auth()->user()->hasRole('super_admin') && !$oldRow->assignedUsers->contains(auth()->id())) {
                abort(403, 'You do not have permission to edit this event.');
            }

            $image = $oldRow->image;
            $pdf = $oldRow->pdf;

            if ($request->filled('image')) {
                $this->deleteOldFile($oldRow->image);
            }

        }

        if ($request->filled('image')) {
            $image = $request->image;
        }

        if ($request->boolean('remove_pdf')) {
            if ($oldRow && $oldRow->pdf) {
                $this->deleteOldFile($oldRow->pdf);
            }
            $pdf = null;
        } elseif ($request->filled('pdf')) {
            if ($oldRow && $oldRow->pdf && $oldRow->pdf !== $request->pdf) {
                $this->deleteOldFile($oldRow->pdf);
            }
            $pdf = $request->pdf;
        }

        $data['image'] = $image;
        $data['pdf'] = $pdf;
        $data['is_active'] = $request->boolean('is_active');
        $data['is_online'] = $request->boolean('is_online');
        $data['show_full_address'] = $request->boolean('show_full_address');

        foreach (array_merge(['has_landing_page'], array_keys(EventLandingPageService::extraValidationRules()), [
            'landing_title', 'landing_title_highlight', 'landing_description',
            'landing_date_label', 'landing_time_label', 'landing_location_label',
            'landing_hero_image', 'landing_qr_image', 'landing_register_label',
            'landing_agenda_label', 'landing_agenda_url', 'landing_countdown_at', 'landing_countdown_end_at',
            'landing_whatsapp_url', 'landing_telegram_url', 'landing_faq_url',
            'landing_about_label', 'landing_about_title', 'landing_about_description', 'landing_reasons_label',
            'landing_reason_1_icon', 'landing_reason_1_title', 'landing_reason_1_description',
            'landing_reason_2_icon', 'landing_reason_2_title', 'landing_reason_2_description',
            'landing_reason_3_icon', 'landing_reason_3_title', 'landing_reason_3_description',
            'landing_stat_1_icon', 'landing_stat_1_value', 'landing_stat_1_label',
            'landing_stat_2_icon', 'landing_stat_2_value', 'landing_stat_2_label',
            'landing_stat_3_icon', 'landing_stat_3_value', 'landing_stat_3_label',
            'landing_stat_4_icon', 'landing_stat_4_value', 'landing_stat_4_label',
            'landing_details_label', 'landing_details_title', 'landing_details_description',
            'landing_details_date', 'landing_details_time', 'landing_details_venue',
            'landing_details_address', 'landing_details_map_embed_url',
        ]) as $landingField) {
            unset($data[$landingField]);
        }

        $event = Event::query()->updateOrCreate(['id' => $request->row_id], $data);

        $this->landingPageService->sync($event, $request);

        History::makeHistory(auth()->user(),
            'Event',
            'create',
            $event->id
        );

        return redirect()->route('admin.events.index')->with('success', $status);
    }
}
