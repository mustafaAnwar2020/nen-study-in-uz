<section class="section mt-5 section-bg dark-background" id="network">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Our Network</h2>
        </div>

        <div class="row mb-4">
            <div class="col-lg-8">
                <ul class="nav nav-tabs custom-tabs" id="networkTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="test-sites-tab" data-bs-toggle="tab" href="#test-sites"
                            role="tab" aria-controls="test-sites" aria-selected="true">Authorized Centers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="teachers-trainers-tab" data-bs-toggle="tab" href="#teachers-trainers"
                            role="tab" aria-controls="teachers-trainers" aria-selected="false">Certified
                            Trainers</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <input id="country" class="form-control" name="country" placeholder="Search...">
                </div>
            </div>
        </div>

        <!-- Tabs Content -->
        <div class="tab-content" id="networkTabsContent">
            <!-- Test Sites Tab -->
            <div class="tab-pane fade show active" id="test-sites" role="tabpanel" aria-labelledby="test-sites-tab">
                <div class="centers-card">
                    @if (isset($testSites) && $testSites->isNotEmpty())
                        <?php
                        $headers = $testSites->first();
                        $rows = $testSites->slice(1);
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        @foreach ($headers as $index => $header)
                                            @if (in_array($index, [0, 1 , 6]))
                                                @continue
                                            @endif
                                            <th style="text-align:center">{{ $header }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr>
                                            @foreach ($row as $colIndex => $cell)
                                                @if (in_array($colIndex, [0, 1 , 6]))
                                                    @continue
                                                @endif

                                                @if ($colIndex === 2)
                                                    @php
                                                        $countryCode = strtolower(trim($row[0] ?? ''));
                                                        $countryName = trim($cell);
                                                    @endphp
                                                    <td>
                                                        @if ($countryCode)
                                                            <span
                                                                class="flag-icon flag-icon-{{ $countryCode }}"></span>
                                                        @endif
                                                        {{ $countryName }}
                                                    </td>
                                                @elseif ($colIndex == 10)
                                                    <td><span
                                                            class="{{ $cell == 'Inactive' ? 'text-danger' : '' }}">{{ $cell }}</span>
                                                    </td>
                                                @else
                                                    <td>{{ $cell }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mt-4">
                            No test sites data available at the moment.
                        </div>
                    @endif
                </div>


                {{--  <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th>Country</th>
                            <th>City</th>
                            <th>ID</th>
                            <th>Test Site</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($networkDetails['test-sites'] ?? [] as $detail)
                            <tr>
                                <td>
                                    <span class="flag-icon flag-icon-{{$detail->country_code}}"></span>
                                    {{ config('countries.'.$detail->country_code) }}
                                </td>
                                <td>{{ $detail->city }}</td>
                                <td>{{ $detail->id }}</td>
                                <td>{{ $detail->name }}</td>
                                <td>{{ $detail->address }}</td>
                                <td>{{ $detail->phone }}</td>
                                <td>{{ $detail->email }}</td>
                                <td>{{ $detail->status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> --}}

                <div class="mt-4">
                    <div class="row gy-3 justify-content-center">
                        <div class="col-auto">
                            <a class="d-flex align-items-center text-decoration-none"
                                href="http://nen-global.org/corapp" target="_blank">
                                <i class="bi bi-building me-2 text-primary"></i>
                                <span class="text-white">To apply as an Authorized Test Center, <span
                                        class="text-danger">Click Here</span> <i
                                        class="bi bi-arrow-right ms-1 text-danger"></i></span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Teachers / Trainers Tab -->
            <div class="tab-pane fade" id="teachers-trainers" role="tabpanel" aria-labelledby="teachers-trainers-tab">
                <div class="centers-card">
                    @if (isset($trainers) && $trainers->isNotEmpty())
                        <?php
                        $headers = $trainers->first();
                        $rows = $trainers->slice(1);
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        @foreach ($headers as $index => $header)
                                            @if (in_array($index, [0,7,9]))
                                                @continue
                                            @endif
                                            <th style="text-align:center">{{ $header }}</th>
                                        @endforeach
                                        <th style="text-align:center">Contact</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $rowIndex => $row)
                                        <tr>
                                            @foreach ($row as $colIndex => $cell)
                                            
                                                @if (in_array($colIndex, [0,7,9]))
                                                    @continue
                                                @endif
                                                @if ($colIndex == 1)
                                                    @php
                                                        $countryCode = strtolower(trim($row[0] ?? ''));
                                                        $countryName = trim($cell);
                                                    @endphp
                                                    <td>
                                                        @if ($countryCode)
                                                            <span
                                                                class="flag-icon flag-icon-{{ $countryCode }}"></span>
                                                        @endif
                                                        {{ $countryName }}
                                                    </td>
                                                @else
                                                    <td>{{ filter_var($cell, FILTER_VALIDATE_EMAIL) ? '-' : $cell }}
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#contactModal"
                                                    data-trainer-index="{{ $rowIndex }}"
                                                    data-trainer-name="{{ $row[1] ?? 'Trainer' }}">
                                                    <i class="bi bi-envelope"></i> Contact
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mt-4">
                            No trainers data available at the moment.
                        </div>
                    @endif
                </div>

                {{--  <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th>Country</th>
                            <th>City</th>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Level</th>
                            <th>Since</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Social Media</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($networkDetails['teachers'] ?? [] as $detail)
                            <tr>
                                <td>
                                    <span class="flag-icon flag-icon-{{$detail->country_code}}"></span>
                                    {{ config('countries.'.$detail->country_code) }}
                                </td>
                                <td>{{ $detail->city }}</td>
                                <td>{{ $detail->name }}</td>
                                <td>{{ $detail->id }}</td>
                                <td>{{ $detail->position }}</td>
                                <td>{{ $detail->since }}</td>
                                <td>{{ $detail->phone }}</td>
                                <td>{{ $detail->email }}</td>
                                <td>{{ $detail->social_media }}</td>
                                <td>{{ $detail->status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> --}}

                <div class="mt-4">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <a class="d-flex align-items-center text-decoration-none"
                                href="http://nen-global.org/tqsapp" target="_blank">
                                <i class="bi bi-person-badge me-2 text-primary"></i>
                                <span class="text-white">To apply as a certified trainer, <span
                                        class="text-danger">Click Here</span> <i
                                        class="bi bi-arrow-right ms-1 text-danger"></i></span>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="d-flex align-items-center text-decoration-none"
                                href="http://etsglobal-26271412.hs-sites-eu1.com/elt-community" target="_blank">
                                <i class="bi bi-people me-2 text-primary"></i>
                                <span class="text-white">Join the Teachers Community</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Contact Trainer Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel" style="color: #000;">Contact Mentor: <span
                            id="trainerNameDisplay"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="contactTrainerForm">
                    <input type="hidden" id="trainerIndex" name="trainer_index">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="contactName" style="color: #000;" class="form-label">Residence Country</label>
                            <select class="form-control" id="contactCountry">
                                <option value="">Select Residence Country</option>
                                @foreach (config('countries') as $code => $country)
                                    <option value="{{ $code }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="contactOrganization" style="color: #000;" class="form-label">Organization</label>
                            <input type="text" class="form-control" placeholder="organization name"
                                id="contactOrganization" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactName" style="color: #000;" class="form-label">Name</label>
                            <input type="text" class="form-control" placeholder="full name"
                                id="contactName" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactPhone" style="color: #000;" class="form-label">Phone</label>
                            <input type="text" class="form-control" placeholder="phone number"
                                id="contactPhone" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactEmail" style="color: #000;" class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="email address"
                                id="contactEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactSubject" style="color: #000;" class="form-label">Subject</label>
                            <input type="text" class="form-control" placeholder="message subject"
                                id="contactSubject" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactMessage" style="color: #000;" class="form-label">Message</label>
                            <textarea class="form-control" placeholder="Type your message here..." id="contactMessage" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactModal = document.getElementById('contactModal');
        const contactForm = document.getElementById('contactTrainerForm');
        const trainerNameDisplay = document.getElementById('trainerNameDisplay');
        const trainerIndexInput = document.getElementById('trainerIndex');
        const nameInput = document.getElementById('contactName');
        const emailInput = document.getElementById('contactEmail');
        const subjectInput = document.getElementById('contactSubject');
        const messageInput = document.getElementById('contactMessage');
        const countrySearchInput = document.getElementById('country');
        const organizationInput = document.getElementById('contactOrganization');
        const countryInput = document.getElementById('contactCountry');
        const phoneInput = document.getElementById('contactPhone');

        // Handle modal opening
        contactModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const trainerName = button.getAttribute('data-trainer-name');
            const trainerIndex = button.getAttribute('data-trainer-index');

            // Set trainer name in the modal header
            trainerNameDisplay.textContent = trainerName;
            trainerIndexInput.value = trainerIndex;

            // Clear previous form data
            nameInput.value = '';
            emailInput.value = '';
            subjectInput.value = '';
            messageInput.value = '';

            // Set focus to name field
            setTimeout(() => {
                nameInput.focus();
            }, 500);
        });

        // Handle form submission
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData();
            formData.append('trainer_index', trainerIndexInput.value);
            formData.append('name', nameInput.value);
            formData.append('email', emailInput.value);
            formData.append('phone', phoneInput.value);
            formData.append('organization', organizationInput.value);
            formData.append('country', countryInput.value);
            formData.append('subject', subjectInput.value);
            formData.append('message', messageInput.value);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute(
                'content'));

            // Disable submit button and show loading state
            const submitButton = contactForm.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';

            // Send AJAX request
            fetch('{{ route('site.contact.trainer') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert(
                            'Message sent successfully! The trainer will receive your message and can reply directly to your email.'
                        );

                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(contactModal);
                        modal.hide();

                        // Reset form
                        contactForm.reset();
                    } else {
                        // Show error message
                        alert('Error: ' + (data.message ||
                            'Failed to send message. Please try again.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while sending the message. Please try again.');
                })
                .finally(() => {
                    // Re-enable submit button
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                });
        });

        // Country search functionality
        if (countrySearchInput) {
            countrySearchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();

                // Filter Test Sites table (search first 5 columns)
                const testSitesTable = document.querySelector('#test-sites .table tbody');
                if (testSitesTable) {
                    const testSitesRows = testSitesTable.querySelectorAll('tr');
                    testSitesRows.forEach(row => {
                        const cells = row.querySelectorAll('td:nth-child(-n+5)');
                        let matches = searchTerm === '';
                        if (!matches && cells.length) {
                            matches = Array.from(cells).some(cell =>
                                cell.textContent.toLowerCase().trim().includes(searchTerm)
                            );
                        }
                        row.style.display = matches ? '' : 'none';
                    });
                }

                // Filter Trainers table (search first 5 columns)
                const trainersTable = document.querySelector('#teachers-trainers .table tbody');
                if (trainersTable) {
                    const trainersRows = trainersTable.querySelectorAll('tr');
                    trainersRows.forEach(row => {
                        const cells = row.querySelectorAll('td:nth-child(-n+5)');
                        let matches = searchTerm === '';
                        if (!matches && cells.length) {
                            matches = Array.from(cells).some(cell =>
                                cell.textContent.toLowerCase().trim().includes(searchTerm)
                            );
                        }
                        row.style.display = matches ? '' : 'none';
                    });
                }
            });
        }
    });
</script>


@push('styles')
    <style>
        :root {
            --primary-color: #384f4b;
            --secondary-color: #7c3aed;
            --success-color: #10b981;
            --info-color: #06b6d4;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        /* Authorized Centers Section Styles */
        .centers-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid #e2e8f0;
        }

        .custom-tabs {
            border-bottom: 2px solid #e2e8f0 !important;
        }

        .custom-tabs .nav-link {
            color: #64748b !important;
            font-weight: 500;
            padding: 12px 24px;
            border: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            background: transparent !important;
        }

        .custom-tabs .nav-link:hover {
            color: var(--primary-color) !important;
            border-bottom-color: var(--primary-color) !important;
        }

        .custom-tabs .nav-link.active {
            color: var(--primary-color) !important;
            border-bottom-color: #ff0000 !important;
            ;
            background: transparent !important;
        }

        .centers-card .table {
            margin-bottom: 0;
        }

        .centers-card .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        .centers-card .table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: #1e293b;
            font-weight: 600;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .centers-card .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }

        .centers-card .table tbody tr:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .centers-card .table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #475569;
        }

        .centers-card .form-control {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .centers-card .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        @media (max-width: 768px) {
            .centers-card {
                padding: 20px;
            }

            .custom-tabs .nav-link {
                padding: 10px 16px;
                font-size: 0.9rem;
            }
        }
    </style>
@endpush
