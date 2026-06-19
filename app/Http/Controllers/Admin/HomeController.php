<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventRequest;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\NenLandingFaqItem;
use App\Models\NenLandingHeroSlide;
use App\Models\NenLandingMediaItem;
use App\Models\NenLandingPartnerItem;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $model = 'Dashboard';
        $counters = $this->getCounters();
        $upcomingEvents = Event::query()
            ->active()
            ->notArchived()
            ->whereNotNull('date')
            ->where('date', '>=', Carbon::today()->toDateString())
            ->orderBy('date')
            ->orderBy('id')
            ->limit(6)
            ->get();
        $recentMessages = ContactMessage::query()
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        $recentEventRequests = EventRequest::query()
            ->with('event')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('admin.home.index', get_defined_vars());
    }

    public function getCounters(): object
    {
        return (object) [
            'events' => Event::count(),
            'events_active' => Event::active()->count(),
            'events_upcoming' => Event::active()
                ->notArchived()
                ->whereNotNull('date')
                ->where('date', '>=', Carbon::today()->toDateString())
                ->count(),
            'events_archived' => Event::archived()->count(),
            'hero_slides' => NenLandingHeroSlide::count(),
            'partners' => NenLandingPartnerItem::count(),
            'faqs' => NenLandingFaqItem::count(),
            'media_items' => NenLandingMediaItem::count(),
            'contact_messages' => ContactMessage::count(),
            'contact_messages_new' => ContactMessage::where('is_done', 0)->count(),
            'event_requests' => EventRequest::count(),
            'event_requests_new' => EventRequest::where('is_done', false)->count(),
        ];
    }
}
