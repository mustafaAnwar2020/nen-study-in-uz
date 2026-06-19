<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="youtubeVideo" src="" title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let videoModal = document.getElementById('videoModal');
            let youtubeVideo = document.getElementById('youtubeVideo');
            let videoSrc = "https://www.youtube.com/embed/1R2douCnpUk?autoplay=1&rel=0&playlist=1R2douCnpUk";

            videoModal.addEventListener('show.bs.modal', function() {
                youtubeVideo.src = videoSrc;
            });

            videoModal.addEventListener('hide.bs.modal', function() {
                youtubeVideo.src = "";
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var eventDeepLink = @json(request()->query('event'));
            if (eventDeepLink && document.getElementById('events') && typeof showEventDetails === 'function') {
                showEventDetails(null, String(eventDeepLink));
            }
        });

        // calendar
        document.addEventListener('DOMContentLoaded', function() {
            var events =
                @if (isset($eventsCalender))
                    @json($eventsCalender)
                @else
                    []
                @endif ;
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: events,
                locale: 'en',
                eventRender: function(event, element) {
                    if (event.country_code) {
                        var flagIcon = '<span id="flag-icon" class="flag-icon flag-icon-' + event
                            .country_code.toLowerCase() + '"></span>';
                        element.find('.fc-title').prepend(flagIcon + ' ');
                    }
                },
                eventClick: function(calEvent, jsEvent) {
                    if (jsEvent && typeof jsEvent.preventDefault === 'function') {
                        jsEvent.preventDefault();
                    }
                    if (calEvent && calEvent.id && typeof showEventDetails === 'function') {
                        showEventDetails(null, String(calEvent.id));
                    }
                    return false;
                }
            });
        });

        // map
        const fullMap = L.map('fullMap').setView([30.0444, 31.2357], 3);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18
        }).addTo(fullMap);

        const locations =
            @if (isset($locationsJson))
                @json($locationsJson)
            @else
                []
            @endif ;

        for (const key in locations) {
            const location = locations[key];

            // Create custom marker icon based on location type
            let markerIcon;
            if (location.location_type === 'Main Offices') {
                // Red marker for Main Offices
                markerIcon = L.divIcon({
                    html: '<i class="fa fa-map-marker" style="color: #dc3545; font-size: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"></i>',
                    className: 'custom-red-marker',
                    iconSize: [30, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });
            } else {
                // Default blue marker for Main Offices (using Leaflet's default)
                markerIcon = new L.Icon.Default();
            }

            L.marker(location.coords, {
                icon: markerIcon
            }).addTo(fullMap).bindPopup(showDetails(location));
        }


        function showDetails(location) {
            const tooltipContent = `
                    ${location.name ? `<strong>${location.name}</strong><br>` : ''}
                    ${location.address ? `<strong>Address:</strong> ${location.address}<br>` : ''}
                    ${location.landLine ? `<strong>Landline:</strong> ${location.landLine}<br>` : ''}
                    ${location.callCenter ? `<strong>Call Center:</strong> ${location.callCenter}<br>` : ''}
                    ${location.email ? `<strong>Email:</strong> ${location.email}<br>` : ''}
                    ${location.schedule ? `<strong>Schedule:</strong> ${location.schedule}<br>` : ''}
                `;

            return tooltipContent;
        }


        $('.flag_map').click(function() {
            const country_code = $(this).attr('data-code');
            const location = locations[country_code];

            if (location) {
                fullMap.setView(location.coords, 5);

                // Create marker with appropriate color based on location_type
                let marker;
                if (location.location_type === 'Main Offices') {
                    // Create red marker for Main Offices
                    const redIcon = L.divIcon({
                        className: 'custom-red-marker',
                        html: '<i class="fa fa-map-marker" style="color: #dc3545; font-size: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"></i>',
                        iconSize: [30, 30],
                        iconAnchor: [15, 30],
                        popupAnchor: [0, -30]
                    });
                    marker = L.marker(location.coords, {
                        icon: redIcon
                    }).addTo(fullMap);
                } else {
                    // Create default blue marker for Authorized Offices
                    marker = L.marker(location.coords).addTo(fullMap);
                }
                marker.bindPopup(showDetails(location)).openPopup();

                document.getElementById('flag-icon').classList.add('flag-icon-' + location.country_code);
            } else {
                console.error(`Location not found for country code: ${country_code}`);
            }
        });

        // Offers Swiper
        new Swiper('.offers-swiper', {
            loop: false,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 3,
                },
            },
        });


        // Offers Swiper
        new Swiper('.events-swiper', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });

        //
        new Swiper('.partners-swiper', {
            loop: true,
            slidesPerView: 5,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });

        // TPI Swiper
        const tpiSwiper = document.querySelector('.tpi-swiper');
        if (tpiSwiper) {
            const slides = tpiSwiper.querySelectorAll('.swiper-slide');
            const hasMultipleSlides = slides.length > 1;

            new Swiper('.tpi-swiper', {
                loop: hasMultipleSlides,
                slidesPerView: 1,
                spaceBetween: 30,
                allowTouchMove: hasMultipleSlides,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: hasMultipleSlides ? {
                    delay: 5000,
                    disableOnInteraction: false,
                } : false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }


        $(document).ready(function() {
            // Hide all cefr-content initially except the one with cefr-active class
            $('.cefr-content').not($('.cefr-active').find('.cefr-content')).hide();

            // Rotate the toggle icon for the initially active item
            $('.cefr-active .cefr-toggle').css('transform', 'translateY(-50%) rotate(90deg)');


            // Add click event listener to the header (h3) of each cefr-item
            $('.cefr-item h3').on('click', function() {
                var $parentItem = $(this).closest('.cefr-item');
                var $content = $parentItem.find('.cefr-content');
                var $toggleIcon = $parentItem.find('.cefr-toggle');

                // Check if the clicked item is already active
                if ($parentItem.hasClass('cefr-active')) {
                    // If active, collapse it
                    $content.slideUp(300, function() {
                        $parentItem.removeClass('cefr-active');
                    });
                    $toggleIcon.css('transform', 'translateY(-50%) rotate(0deg)');
                } else {
                    // If not active, close all other open items
                    $('.cefr-item.cefr-active .cefr-content').slideUp(300, function() {
                        $(this).closest('.cefr-item').removeClass('cefr-active');
                        $(this).closest('.cefr-item').find('.cefr-toggle').css('transform',
                            'translateY(-50%) rotate(0deg)');
                    });

                    // Open the clicked item
                    $content.slideDown(300, function() {
                        $parentItem.addClass('cefr-active');
                    });
                    $toggleIcon.css('transform', 'translateY(-50%) rotate(90deg)');
                }
            });
        });


        $(document).ready(function() {
            var $readMore = $('.product-read-more');
            if (!$readMore.length) {
                return;
            }
            var href = $readMore.attr('href');
            var baseHref = href ? href.split('?')[0] : '';

            $('.portfolio-filters li').on('click', function() {
                $('.portfolio-filters li').removeClass('filter-active');
                $(this).addClass('filter-active');

                const filterClass = $(this).data('filter');
                let type = filterClass.replace('.filter-', '');

                if (filterClass === '*') {
                    $readMore.attr('href', baseHref);
                } else {
                    $readMore.attr('href', baseHref + '?type=' + type);
                }
            });
        });
    </script>
@endpush