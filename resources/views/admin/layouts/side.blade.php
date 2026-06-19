<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="/" class="brand-link" style="text-align: center;background: #fff;">
        <img src="{{asset('/assets/logo.png')}}" alt="Logo" width="80">
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('/assets/user-placeholder.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{currentUser()->name}}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @if(auth()->user()->hasPermissionTo('dashboard.view'))
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}"
                       class="nav-link {{(in_array('dashboard', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @endif

                {{-- User Management Section --}}
                {{-- @if(auth()->user()->hasPermissionTo('users.index') || auth()->user()->hasPermissionTo('roles.index') || auth()->user()->hasPermissionTo('permissions.index') || auth()->user()->hasPermissionTo('roles.edit') || auth()->user()->hasPermissionTo('users.edit') || auth()->user()->hasPermissionTo('permissions.edit'))
                <li class="nav-item has-treeview {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/permissions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/permissions*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-users-cog"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(auth()->user()->hasPermissionTo('users.index') || auth()->user()->hasPermissionTo('users.edit'))
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                               class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-user"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->hasPermissionTo('roles.index') || auth()->user()->hasPermissionTo('roles.edit'))
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                               class="nav-link {{ request()->is('admin/roles*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-user-tag"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->hasPermissionTo('permissions.index') || auth()->user()->hasPermissionTo('permissions.edit'))
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}"
                               class="nav-link {{ request()->is('admin/permissions*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-shield-alt"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif --}}

                @if(auth()->user()->hasPermissionTo('sections.edit') || auth()->user()->hasPermissionTo('sections.index'))


                @if(auth()->user()->hasPermissionTo('sections.edit'))
                <li class="nav-item">
                    <a href="{{ route('admin.nen-landing-settings.edit') }}"
                       class="nav-link {{ request()->is('admin/nen-landing-settings*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>Page Settings</p>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasPermissionTo('sections.index'))
                {{-- Content Items --}}
                <li class="nav-item has-treeview {{ request()->is('admin/nen-landing-items*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/nen-landing-items*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-layer-group"></i>
                        <p>Page Sections <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'hero-slides') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/hero-slides*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-images"></i>
                                <p>Hero Slides</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'feature-cards') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/feature-cards*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-th-large"></i>
                                <p>Why Uzbekistan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'how-it-works') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/how-it-works*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-list-ol"></i>
                                <p>How It Works</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'partners') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/partners*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-handshake"></i>
                                <p>Partners</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'translation-agencies') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/translation-agencies*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-language"></i>
                                <p>Translation Agencies</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'documents') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/documents*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-file-alt"></i>
                                <p>App. Documents</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'trusted-agencies') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/trusted-agencies*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-user-check"></i>
                                <p>Study Abroad Agencies</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'university-logos') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/university-logos*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-university"></i>
                                <p>University Logos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'faqs') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/faqs*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-question-circle"></i>
                                <p>FAQs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.nen-landing-items.index', 'media') }}"
                               class="nav-link {{ request()->is('admin/nen-landing-items/media*') ? 'active' : '' }}">
                                <i class="nav-icon fa fa-photo-video"></i>
                                <p>Media Gallery</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @endif

                {{-- @if(auth()->user()->hasPermissionTo('locations.index'))
                <li class="nav-item">
                    <a href="{{route('admin.locations.index')}}"
                       class="nav-link {{(in_array('locations', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-landmark"></i>
                        <p>
                            Locations
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('blogs.index'))
                <li class="nav-item">
                    <a href="{{route('admin.blogs.index')}}"
                       class="nav-link {{(in_array('blogs', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-newspaper"></i>
                        <p>
                            Blogs
                        </p>
                    </a>
                </li>
                @endif --}}

                {{-- @if(auth()->user()->hasPermissionTo('offers.index'))
                <li class="nav-item">
                    <a href="{{route('admin.offers.index')}}"
                       class="nav-link {{(in_array('offers', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-handshake"></i>
                        <p>
                            Offers
                        </p>
                    </a>
                </li>
                @endif --}}
{{-- 
                @if(auth()->user()->hasPermissionTo('events.index') || auth()->user()->assignedEvents()->count() > 0)
                <li class="nav-item">
                    <a href="{{route('admin.events.index')}}"
                       class="nav-link {{(in_array('events', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-magic"></i>
                        <p>
                            Events
                        </p>
                    </a>
                </li>
                @endif --}}

                {{-- @if(auth()->user()->hasPermissionTo('products.index'))
                <li class="nav-item">
                    <a href="{{route('admin.products.index')}}"
                       class="nav-link {{(in_array('products', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-folder"></i>
                        <p>
                            Products
                        </p>
                    </a>
                </li>
                @endif --}}

                {{-- Legacy homepage: Partners --}}
                {{-- @if(auth()->user()->hasPermissionTo('partners.index'))
                <li class="nav-item">
                    <a href="{{route('admin.partners.index')}}"
                       class="nav-link {{(in_array('partners', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-book"></i>
                        <p>Partners</p>
                    </a>
                </li>
                @endif --}}

                {{-- Legacy homepage: Network --}}
                {{-- @if(auth()->user()->hasPermissionTo('network.index'))
                <li class="nav-item">
                    <a href="{{route('admin.network.index')}}"
                       class="nav-link {{(in_array('network', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-network-wired"></i>
                        <p>Network</p>
                    </a>
                </li>
                @endif --}}

                {{-- Legacy homepage: CEFR --}}
                {{-- @if(auth()->user()->hasPermissionTo('cefr.index'))
                <li class="nav-item">
                    <a href="{{route('admin.cefr.index')}}"
                       class="nav-link {{(in_array('cefr', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-language"></i>
                        <p>CEFR</p>
                    </a>
                </li>
                @endif --}}

                {{-- @if(auth()->user()->hasPermissionTo('countries.index'))
                <li class="nav-item">
                    <a href="{{route('admin.countries.index')}}"
                       class="nav-link {{(in_array('countries', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-language"></i>
                        <p>
                            Countries
                        </p>
                    </a>
                </li>
                @endif --}}

                {{-- @if(auth()->user()->hasPermissionTo('file-system.index'))
                <li class="nav-item">
                    <a href="{{route('admin.file-system.index')}}"
                       class="nav-link {{(in_array('file-system', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-language"></i>
                        <p>
                            File Management
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('protected-files.index'))
                <li class="nav-item">
                    <a href="{{route('admin.protected-files.index')}}"
                       class="nav-link {{(in_array('protected-files', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-lock"></i>
                        <p>
                            Protected Files
                        </p>
                    </a>
                </li>
                @endif --}}

                {{-- Legacy homepage: Sliders --}}
                {{-- @if(auth()->user()->hasPermissionTo('sliders.index'))
                <li class="nav-item">
                    <a href="{{route('admin.sliders.index')}}"
                       class="nav-link {{(in_array('sliders', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-image"></i>
                        <p>Sliders</p>
                    </a>
                </li>
                @endif --}}

                {{-- Legacy homepage: Sections --}}
                {{-- @if(auth()->user()->hasPermissionTo('sections.index'))
                <li class="nav-item">
                    <a href="{{route('admin.sections.index')}}"
                       class="nav-link {{(in_array('sections', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>Sections</p>
                    </a>
                </li>
                @endif --}}

                {{-- @if(auth()->user()->hasPermissionTo('tpi-section.edit'))
                <li class="nav-item">
                    <a href="{{route('admin.tpi-section.edit')}}"
                       class="nav-link {{(in_array('tpi-section', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-book"></i>
                        <p>
                            TPI Section
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('tpi-hero-section.edit'))
                <li class="nav-item">
                    <a href="{{route('admin.tpi-hero-section.edit')}}"
                       class="nav-link {{(in_array('tpi-hero-section', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-image"></i>
                        <p>
                            TPI Hero Section
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('tpi-overview-section.edit'))
                <li class="nav-item">
                    <a href="{{route('admin.tpi-overview-section.edit')}}"
                       class="nav-link {{(in_array('tpi-overview-section', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-list"></i>
                        <p>
                            TPI Overview Section
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('tpi-key-benefits-section.edit'))
                <li class="nav-item">
                    <a href="{{route('admin.tpi-key-benefits-section.edit')}}"
                       class="nav-link {{(in_array('tpi-key-benefits-section', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-star"></i>
                        <p>
                            TPI Key Benefits
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('tpi-join-partner-section.edit'))
                <li class="nav-item">
                    <a href="{{route('admin.tpi-join-partner-section.edit')}}"
                       class="nav-link {{(in_array('tpi-join-partner-section', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-handshake"></i>
                        <p>
                            TPI Join Partner
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('tpi-contact-section.edit'))
                <li class="nav-item">
                    <a href="{{route('admin.tpi-contact-section.edit')}}"
                       class="nav-link {{(in_array('tpi-contact-section', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-phone-alt"></i>
                        <p>
                            TPI Contact Us
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('tpi-cta-section.edit'))
                <li class="nav-item">
                    <a href="{{route('admin.tpi-cta-section.edit')}}"
                       class="nav-link {{(in_array('tpi-cta-section', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-credit-card"></i>
                        <p>
                            TPI CTA Section
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('tpi-faqs.index'))
                <li class="nav-item">
                    <a href="{{route('admin.tpi-faqs.index')}}"
                       class="nav-link {{(in_array('tpi-faqs', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-question-circle"></i>
                        <p>
                            TPI FAQs
                        </p>
                    </a>
                </li>
                @endif --}}

                {{-- Legacy homepage: Library --}}
                {{-- @if(auth()->user()->hasPermissionTo('library.index'))
                <li class="nav-item">
                    <a href="{{route('admin.library.index')}}"
                       class="nav-link {{(in_array('library', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-book"></i>
                        <p>Library</p>
                    </a>
                </li>
                @endif --}}

                {{-- Legacy homepage: FAQs (site-wide) --}}
                {{-- @if(auth()->user()->hasPermissionTo('faqs.index'))
                <li class="nav-item">
                    <a href="{{route('admin.faqs.index')}}"
                       class="nav-link {{(in_array('faqs', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-question"></i>
                        <p>Faqs</p>
                    </a>
                </li>
                @endif --}}


                {{-- @if(auth()->user()->hasPermissionTo('contact-messages.index'))
                <li class="nav-item">
                    <a href="{{route('admin.contact-messages.index')}}"
                       class="nav-link {{(in_array('contact-messages', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-envelope-open"></i>
                        <p>
                            Contact Messages
                        </p>
                    </a>
                </li>
                @endif --}}

                {{-- @if(auth()->user()->hasPermissionTo('event-requests.index'))
                <li class="nav-item">
                    <a href="{{ route('admin.event-requests.index') }}"
                       class="nav-link {{ request()->is('admin/event-requests*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-calendar-plus"></i>
                        <p>Event Requests</p>
                    </a>
                </li>
                @endif --}}


                {{-- @if(auth()->user()->hasPermissionTo('newsletter.index'))
                <li class="nav-item">
                    <a href="{{route('admin.newsletter.index')}}"
                       class="nav-link {{(in_array('newsletter', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-paper-plane"></i>
                        <p>
                            Newsletter Subscribers
                        </p>
                    </a>
                </li>
                @endif --}}


                @if(auth()->user()->hasPermissionTo('settings.view'))
                <li class="nav-item">
                    <a href="{{route('admin.settings.index')}}"
                       class="nav-link {{(in_array('settings', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasPermissionTo('user_settings.view'))
                <li class="nav-item">
                    <a href="{{route('admin.user_settings.index')}}"
                       class="nav-link {{(in_array('user_settings', request()->segments())) ? 'active' : ''}}">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            User Settings
                        </p>
                    </a>
                </li>
                @endif


                <li class="nav-item">
                    <a href="{{route('admin.logout')}}" class="nav-link">
                        <i class="nav-icon fa fa-sign-out-alt"></i>
                        <p> Logout </p>
                    </a>
                </li>

                <li class="nav-item" style="text-align: center;color: #7d7b7b;margin-top: 19px;">
                    V.1.4
                </li>

            </ul>
        </nav>
    </div>
</aside>
