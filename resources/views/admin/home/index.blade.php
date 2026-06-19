@extends('admin.layouts.admin_dashboard', ['title'=>$model, 'enableLoader'=>false])

@section('content')

    <div class="content-wrapper">

        @include('admin.layouts.breadcrumb', ['model'=>$model])

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Events</span>
                                <span class="info-box-number">{{ $counters->events }}</span>
                                <span class="progress-description">{{ $counters->events_active }} active</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bolt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Upcoming Events</span>
                                <span class="info-box-number">{{ $counters->events_upcoming }}</span>
                                <span class="progress-description">On homepage highlights</span>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-images"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Hero Slides</span>
                                <span class="info-box-number">{{ $counters->hero_slides }}</span>
                                <span class="progress-description">Homepage carousel</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-envelope"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Contact Messages</span>
                                <span class="info-box-number">{{ $counters->contact_messages_new }}</span>
                                <span class="progress-description">{{ $counters->contact_messages }} total</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-calendar-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Event Requests</span>
                                <span class="info-box-number">{{ $counters->event_requests_new }}</span>
                                <span class="progress-description">{{ $counters->event_requests }} total</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Upcoming Events</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($upcomingEvents as $event)
                                            <tr>
                                                <td>{{ $event->name }}</td>
                                                <td><img src="{{ $event->getImage() }}" width="40" alt=""></td>
                                                <td>{{ $event->date }}</td>
                                                <td>
                                                    @if($event->country_code)
                                                        {{ config('countries.'.$event->country_code) }}
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $event->is_active ? 'success' : 'secondary' }}">
                                                        {{ $event->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">No upcoming events scheduled.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-secondary float-right">
                                    Manage Events
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box mb-3 bg-warning">
                            <span class="info-box-icon"><i class="fas fa-handshake"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Homepage Partners</span>
                                <span class="info-box-number">{{ $counters->partners }}</span>
                            </div>
                        </div>

                        <div class="info-box mb-3 bg-info">
                            <span class="info-box-icon"><i class="fas fa-question-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Homepage FAQs</span>
                                <span class="info-box-number">{{ $counters->faqs }}</span>
                            </div>
                        </div>

                        <div class="info-box mb-3 bg-dark">
                            <span class="info-box-icon"><i class="fas fa-photo-video"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Media Gallery</span>
                                <span class="info-box-number">{{ $counters->media_items }}</span>
                            </div>
                        </div>

                        <div class="info-box mb-3 bg-secondary">
                            <span class="info-box-icon"><i class="fas fa-archive"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Archived Events</span>
                                <span class="info-box-number">{{ $counters->events_archived }}</span>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Homepage</h3>
                            </div>
                            <div class="card-body p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.nen-landing-settings.edit') }}" class="nav-link">
                                            <i class="fas fa-cog mr-2"></i> Page Settings
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.nen-landing-items.index', 'hero-slides') }}" class="nav-link">
                                            <i class="fas fa-images mr-2"></i> Hero Slides
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.nen-landing-items.index', 'partners') }}" class="nav-link">
                                            <i class="fas fa-handshake mr-2"></i> Partners
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.nen-landing-items.index', 'faqs') }}" class="nav-link">
                                            <i class="fas fa-question-circle mr-2"></i> FAQs
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.nen-landing-items.index', 'media') }}" class="nav-link">
                                            <i class="fas fa-photo-video mr-2"></i> Media Gallery
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/" target="_blank" class="nav-link">
                                            <i class="fas fa-external-link-alt mr-2"></i> View Live Site
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recent Contact Messages</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Received</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($recentMessages as $message)
                                            <tr>
                                                <td>{{ $message->name }}</td>
                                                <td>{{ $message->email }}</td>
                                                <td>{{ $message->phone ?: '—' }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $message->is_done ? 'success' : 'info' }}">
                                                        {{ $message->getStatus() }}
                                                    </span>
                                                </td>
                                                <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">No contact messages yet.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('admin.contact-messages.index') }}">View All Messages</a>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Recent Event Requests</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Received</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($recentEventRequests as $request)
                                            <tr>
                                                <td>{{ $request->event?->name ?? '—' }}</td>
                                                <td>{{ $request->name }}</td>
                                                <td>{{ $request->email }}</td>
                                                <td>{{ $request->phone }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $request->is_done ? 'success' : 'info' }}">
                                                        {{ $request->getStatus() }}
                                                    </span>
                                                </td>
                                                <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">No event requests yet.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('admin.event-requests.index') }}">View All Event Requests</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

@endsection
