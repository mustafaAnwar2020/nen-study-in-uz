<?php

namespace App\Http\Controllers;

// Removed SendGrid library dependencies - using cURL instead
use App\Models\Blog;
use App\Models\Cefr;
use App\Models\ContactMessage;
use App\Models\EventRequest;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Library;
use App\Models\Location;
use App\Models\Newsletter;
use App\Models\Offer;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Section;
use App\Models\Slider;
use App\Models\TpiContactSection;
use App\Models\TpiCtaSection;
use App\Models\TpiFaq;
use App\Models\TpiHeroSection;
use App\Models\TpiJoinPartnerSection;
use App\Models\TpiKeyBenefitsSection;
use App\Models\TpiOverviewSection;
use App\Models\TpiSection;
use App\Models\NenLandingAgency;
use App\Models\NenLandingDocument;
use App\Models\NenLandingFaqItem;
use App\Models\NenLandingFeatureCard;
use App\Models\NenLandingHeroSlide;
use App\Models\NenLandingHowItWorksStep;
use App\Models\NenLandingMediaItem;
use App\Models\NenLandingPartnerItem;
use App\Models\NenLandingSetting;
use App\Models\NenLandingUniversityLogo;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $landing = NenLandingSetting::getInstance()
            ->loadMissing('featuredEvent.landingPage.heroSection');

        $featuredEvent = $landing->featuredEvent;
        if ($featuredEvent && (!$featuredEvent->is_active || $featuredEvent->archived)) {
            $featuredEvent = null;
        }

        $pageTitle = 'Home';

        $heroSlides = NenLandingHeroSlide::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($heroSlides->isEmpty()) {
            $heroSlides = collect([(object) [
                'title' => $landing->hero_product_title,
                'subtitle' => $landing->hero_subtitle,
                'image' => $landing->hero_image,
                'btn_text' => $landing->hero_btn_text,
                'btn_url' => $landing->hero_btn_url,
            ]]);
        }

        $partners = NenLandingPartnerItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $highlightEvents = Event::query()
            ->active()
            ->notArchived()
            ->with('landingPage.heroSection')
            ->whereNotNull('date')
            ->where('date', '>=', Carbon::today()->toDateString())
            ->orderBy('date')
            ->orderBy('id')
            ->get();

        if ($highlightEvents->isEmpty()) {
            $highlightEvents = Event::query()
                ->active()
                ->notArchived()
                ->with('landingPage.heroSection')
                ->orderByDesc('date')
                ->orderByDesc('id')
                ->limit(6)
                ->get();
        }

        $highlightEvents = $highlightEvents->values();

        $calendarEvents = Event::query()
            ->active()
            ->notArchived()
            ->whereNotNull('date')
            ->orderBy('date')
            ->orderBy('id')
            ->get()
            ->map(function (Event $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $event->date,
                    'country_code' => $event->country_code,
                    'location' => $event->getLandingLocationLabel(),
                    'url' => $event->hasLandingPage() ? $event->getLandingPageUrl() : '',
                ];
            })
            ->values()
            ->all();

        $archiveEvents = Event::query()
            ->active()
            ->archived()
            ->with('landingPage.heroSection')
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        $faqs = NenLandingFaqItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $mediaItems = NenLandingMediaItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $mediaGallery = array_fill_keys(array_keys(NenLandingMediaItem::layoutSlots()), null);
        $slotFallback = array_keys(NenLandingMediaItem::layoutSlots());

        foreach ($mediaItems as $mediaItem) {
            if ($mediaItem->layout_slot && array_key_exists($mediaItem->layout_slot, $mediaGallery)) {
                $mediaGallery[$mediaItem->layout_slot] = $mediaItem;
            }
        }

        $fallbackIndex = 0;
        foreach ($mediaItems as $mediaItem) {
            if ($mediaItem->layout_slot) {
                continue;
            }
            while ($fallbackIndex < count($slotFallback) && $mediaGallery[$slotFallback[$fallbackIndex]] !== null) {
                $fallbackIndex++;
            }
            if ($fallbackIndex < count($slotFallback)) {
                $mediaGallery[$slotFallback[$fallbackIndex]] = $mediaItem;
                $fallbackIndex++;
            }
        }

        $mediaTotalCount = $mediaItems->count();

        // New dynamic sections
        $featureCards = NenLandingFeatureCard::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $howItWorksSteps = NenLandingHowItWorksStep::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('step_number')
            ->orderBy('id')
            ->get();

        $translationAgencies = NenLandingAgency::query()
            ->where('is_active', true)
            ->where('type', NenLandingAgency::TYPE_TRANSLATION)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $trustedAgencies = NenLandingAgency::query()
            ->where('is_active', true)
            ->where('type', NenLandingAgency::TYPE_TRUSTED)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $applicationDocuments = NenLandingDocument::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $universityLogos = NenLandingUniversityLogo::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $collectionPoints = Location::collectionPoints();
        $collectionPointsJson = $collectionPoints->mapWithKeys(function ($location) {
            return [
                $location->slug => [
                    'slug'        => $location->slug,
                    'name'        => $location->name,
                    'address'     => $location->address,
                    'landLine'    => $location->land_line,
                    'callCenter'  => $location->call_center,
                    'email'       => $location->email,
                    'schedule'    => $location->schedule,
                    'coords'      => [(float) $location->latitude, (float) $location->longitude],
                    'mapUrl'      => $location->mapsShareUrl(),
                    'cityLabel'   => __('landing.collection_points.cities.' . $location->slug),
                ],
            ];
        })->toArray();

        return view('site.index', get_defined_vars());
    }

    public function offers(Request $request)
    {
        $pageTitle = 'Offers';

        $applyFilters = function ($query) use ($request) {
            if ($request->filled('country_code')) {
                $query->where('country_code', $request->country_code);
            }

            if ($request->filled('valid_from')) {
                $query->whereDate('date', '>=', $request->valid_from);
            }

            if ($request->filled('valid_to')) {
                $query->whereDate('date', '<=', $request->valid_to);
            }

            if ($request->filled('is_online')) {
                $query->where('is_online', $request->is_online === 'yes');
            }

            return $query;
        };

        $specialOffers = $applyFilters(Offer::query()->active())
            ->where('is_special', 1)
            ->orderByDesc('date')
            ->get();

        $rows = $applyFilters(Offer::query()->active())
            ->where(function ($q) {
                $q->whereNull('is_special')->orWhere('is_special', 0);
            })
            ->latest('date')
            ->get();

        $offerCountries = Offer::distinct()->pluck('country_code');
        $offerCountries = $offerCountries->map(function($country){
            return [
                'code' => $country,
                'name' => @config('countries')[$country],
            ];
        });

        $specialOfferDeepLink = (string)$request->query('special', '');
        $specialOffersInitialSlide = 0;
        if ($specialOfferDeepLink !== '' && $specialOffers->isNotEmpty()) {
            $matchIndex = $specialOffers->search(function ($o) use ($specialOfferDeepLink) {
                return $o->slug === $specialOfferDeepLink;
            });
            if ($matchIndex !== false) {
                $specialOffersInitialSlide = (int)$matchIndex;
            }
        }

        return view('site.offers', compact(
            'pageTitle',
            'rows',
            'offerCountries',
            'specialOffers',
            'specialOffersInitialSlide',
            'specialOfferDeepLink'
        ));
    }


    public function products(Request $request)
    {
        $pageTitle = 'Products';

        $rows = Product::query()->where('type', '!=', 'general')->active();

        if ($request->type && $request->type != '') {
            $rows->where('type', $request->type);
        }

        $rows = $rows->get();

        return view('site.products', get_defined_vars());
    }

    public function events(Request $request)
    {
        $pageTitle = 'Events';
        $rows      = Event::query()->active()->with('landingPage');

        if ($request->filled('country_code')) {
            $rows->where('country_code', $request->country_code);
        }

        if ($request->filled('date')) {
            $rows->where('date', $request->date);
        }

        if ($request->filled('is_online')) {
            $rows->where('is_online', $request->is_online === 'yes');
        }

        $rows = $rows->get();

        $eventsCalender = $rows->map(function ($e) {
            return [
                'id'           => $e->id,
                'title'        => $e->name,
                'start'        => $e->date,
                'country_code' => $e->country_code,
            ];
        })->values()->all();

        return view('site.events', get_defined_vars());
    }

    public function eventShow(string $slug)
    {
        $event = Event::query()->active()->with([
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

        if (!$event->hasLandingPage()) {
            abort(404);
        }

        $pageTitle = $event->getLandingTitle();
        $mapLocationIds = $event->usesAllOrganizersMapLocations()
            ? null
            : $event->getOrganizersMapLocationIds();
        extract($this->mapLocationsData($mapLocationIds));

        return view('site.event-landing', compact('event', 'pageTitle', 'locations', 'locationsJson', 'locationFlags'));
    }

    public function postContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string',
            'email'   => 'required|string|email',
            'phone'   => 'required|string|min:3',
            'message' => 'required|string|min:3|max:180',
        ]);

        ContactMessage::query()->create([
            'name'    => strip_tags($request->name),
            'email'   => strip_tags($request->email),
            'phone'   => strip_tags($request->phone),
            'message' => strip_tags($request->message),
        ]);

        return redirect()->back()->with('success', 'Message has been sent successfully');
    }

    public function postEventRequest(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|min:3|max:50',
            'notes' => 'nullable|string|max:2000',
        ]);

        $event = Event::query()
            ->active()
            ->archived()
            ->where('id', $validated['event_id'])
            ->first();

        if (!$event) {
            return redirect()->to(url('/') . '#archive')
                ->withErrors(['event_id' => 'Please select a valid archived event.'])
                ->withInput($request->merge(['_form' => 'event_request'])->only([
                    'event_id', 'event_title', 'name', 'email', 'phone', 'notes', '_form',
                ]));
        }

        EventRequest::query()->create([
            'event_id' => $event->id,
            'name' => strip_tags($validated['name']),
            'email' => strip_tags($validated['email']),
            'phone' => strip_tags($validated['phone']),
            'notes' => isset($validated['notes']) ? strip_tags($validated['notes']) : null,
        ]);

        return redirect()->to(url('/') . '#archive')
            ->with('event_request_success', 'Your request for "' . $event->name . '" has been submitted. We will contact you soon.');
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:newsletters,email',
        ]);

        Newsletter::create([
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Email has been added to our newsletter successfully.');
    }


    public function faqs(Request $request)
    {
        $rows = Faq::query()->active();

        if ($request->filled('product_id')) {
            $rows->where('product_type', $request->product_id);
        }

        $rows = $rows->get();

        $pageTitle = 'Faq';
        return view('site.faqs', get_defined_vars());
    }

    public function blogs()
    {
        $pageTitle = 'Blogs';
        $rows = Blog::query()
            ->published()
            ->active()
            ->latest()
            ->paginate(12);

        return view('site.blogs', get_defined_vars());
    }

    public function blogShow(string $slug)
    {
        $row = Blog::query()
        ->published()
        ->active()
        ->where('slug', $slug)
        ->firstOrFail();
        
        $pageTitle = $row->title;
        $recentBlogs = Blog::query()->published()->active()
            ->where('id', '!=', $row->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('site.blog-detail', get_defined_vars());
    }

    public function tpi()
    {
        $pageTitle = 'TOEFL Preparation Initiative';

        $testSites = $this->readExcelFile("xls/tpi/test-sites/file.xlsx");
        $trainers = $this->readExcelFile("xls/tpi/trainers/file.xlsx");

        $tpiCtaSection = TpiCtaSection::getContent();
        $tpiFaqs = TpiFaq::getActiveList();
        $tpiHeroSection = TpiHeroSection::getContent();
        $tpiOverviewSection = TpiOverviewSection::getContent();
        $tpiKeyBenefitsSection = TpiKeyBenefitsSection::getContent();
        $tpiJoinPartnerSection = TpiJoinPartnerSection::getContent();
        $tpiContactSection = TpiContactSection::getContent();

        return view('site.tpi', compact('pageTitle', 'testSites', 'trainers', 'tpiCtaSection', 'tpiFaqs', 'tpiHeroSection', 'tpiOverviewSection', 'tpiKeyBenefitsSection', 'tpiJoinPartnerSection', 'tpiContactSection'));
    }

    public function contactTrainer(Request $request)
    {
        // Validate the form data
        $request->validate([
            'trainer_index' => 'required|integer',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'organization' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        try {
            // Read trainers data from Excel file
            $trainers = $this->readExcelFile("xls/network/trainers/file.xlsx");
            
            if (!$trainers || $trainers->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trainers data not available.'
                ], 400);
            }

            // Get headers and rows
            $headers = $trainers->first();
            $rows = $trainers->slice(1);
            
            // Find the trainer by index
            $trainerIndex = $request->trainer_index;
            $trainerRow = $rows->get($trainerIndex);
            
            if (!$trainerRow) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trainer not found.'
                ], 404);
            }

            // Find trainer's email from the row data
            $trainerEmail = null;
            foreach ($trainerRow as $cell) {
                if (filter_var($cell, FILTER_VALIDATE_EMAIL)) {
                    $trainerEmail = $cell;
                    break;
                }
            }

            if (!$trainerEmail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trainer email not found.'
                ], 404);
            }

            // Get trainer name (assuming it's in the second column)
            $trainerName = $trainerRow[1] ?? 'Trainer';

            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'organization' => $request->organization,
                'country' => $request->country,
            ]);
            $subject = 'nen-ets-contact- ' . $request->subject . ' - ' . $contactMessage->id;
            // Send email using SendGrid
            $this->sendTrainerEmail(
                $trainerEmail,
                $trainerName,
                $contactMessage->name,
                $contactMessage->email,
                $subject,
                $contactMessage->message
            );

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully to the trainer.'
            ]);

        } catch (\Exception $e) {
            dd($e);
            Log::error('Error sending trainer contact email: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again later.'
            ], 500);
        }
    }

    private function sendTrainerEmail($trainerEmail, $trainerName, $senderName, $senderEmail, $subject, $message)
    {
        $sendgridApiKey = env('SENDGRID_API_KEY');
        
        if (!$sendgridApiKey) {
            throw new \Exception('SendGrid API key not configured');
        }

        // Create email content
        $htmlContent = view('emails.trainer-contact', [
            'trainerName' => $trainerName,
            'senderName' => $senderName,
            'senderEmail' => $senderEmail,
            'subject' => $subject,
            'messageContent' => $message
        ])->render();

        // Prepare SendGrid API payload
        $data = [
            'personalizations' => [
                [
                    'to' => [
                        [
                            'email' => $trainerEmail,
                            'name' => $trainerName
                        ]
                    ],
                    'cc' => [
                        [
                            'email' => $trainerEmail,
                            'name' => $trainerName
                        ]
                    ],
                    'subject' => $subject
                ]
            ],
            'from' => [
                'email' => env('MAIL_FROM_ADDRESS', 'noreply@nen-global.org'),
                'name' => env('MAIL_FROM_NAME', 'NEN Global')
            ],
            'reply_to' => [
                'email' => $senderEmail,
                'name' => $senderName
            ],
            'content' => [
                [
                    'type' => 'text/html',
                    'value' => $htmlContent
                ]
            ]
        ];

        // Send email using cURL
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $sendgridApiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            throw new \Exception('cURL error: ' . $error);
        }
        
        if ($httpCode >= 400) {
            throw new \Exception('SendGrid API error (HTTP ' . $httpCode . '): ' . $response);
        }
    }

    /**
     * @param  array<int>|null  $onlyIds  null = all active; [] = none
     * @return array{locations: \Illuminate\Support\Collection, locationsJson: array, locationFlags: \Illuminate\Support\Collection}
     */
    private function mapLocationsData(?array $onlyIds = null): array
    {
        if ($onlyIds !== null && count($onlyIds) === 0) {
            return [
                'locations' => collect(),
                'locationsJson' => [],
                'locationFlags' => collect(),
            ];
        }

        $locations = Location::sortedActive();

        if ($onlyIds !== null) {
            $locations = $locations->whereIn('id', array_map('intval', $onlyIds))->values();
        }

        $locationsJson = $locations->mapWithKeys(function ($location) {
            return [
                $location->country_code.'_'.$location->id => [
                    'id' => $location->id,
                    'country_code' => $location->country_code,
                    'name' => $location->name,
                    'location_type' => $location->location_type,
                    'coords' => [$location->latitude, $location->longitude],
                    'address' => $location->address,
                    'landLine' => $location->land_line,
                    'callCenter' => $location->call_center,
                    'email' => $location->email,
                    'schedule' => $location->schedule,
                ],
            ];
        })->toArray();

        $locationFlags = $locations
            ->where('location_type', Location::TYPE_MAIN)
            ->unique('country_code');

        return compact('locations', 'locationsJson', 'locationFlags');
    }

}
