<div class="tab-pane fade show active" id="contact-details">
    <div class="row g-2 mt-2">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center p-3 rounded-4"
                style="background: linear-gradient(90deg, rgba(2, 35, 77, 1) 0%, rgba(0, 0, 0, 1) 94%); border: 1px solid rgba(255,255,255,0.08);">

                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-lg"
                        style="width: 56px; height: 56px; font-size: 1.4rem; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); letter-spacing: -1px;">
                        {{ substr($user->name, 0, 1) }}
                    </div>

                    <div class="ms-3">
                        <h4 class="fw-bold m-0 text-white" style="letter-spacing: -0.8px; font-size: 1.5rem;">
                            {{ $user->name }}
                        </h4>
                        <div class="d-flex align-items-center mt-1">
                            <span class="badge rounded-pill border-0 px-2 py-1"
                                style="background: rgba(255, 255, 255, 0.08); color: #a1a1a6; font-size: 0.65rem; font-weight: 600; text-uppercase; letter-spacing: 0.5px;">
                                <i
                                    class="mdi mdi-gender-{{ strtolower($user->gender) == 'male' ? 'male' : 'female' }} me-1"></i>
                                {{ $user->gender }}
                            </span>

                        </div>
                    </div>
                </div>

                <a href="{{ route('superadmin.customers.edit', $user->id) }}"
                    class="btn btn-sm px-3 py-2 rounded-pill fw-semibold transition-all"
                    style="background: #ffffff; color: #000000; border: none; font-size: 0.8rem; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row g-2 mt-2">
        <div class="col-md-6">
            <div class="p-3 rounded-4 d-flex align-items-center justify-content-between"
                style="background: linear-gradient(90deg, rgba(2, 35, 77, 1) 0%, rgba(0, 0, 0, 1) 94%); border: 1px solid rgba(255,255,255,0.05);">

                <div>
                    <label class="text-uppercase text-muted fw-bold mb-2 d-block"
                        style="font-size: 0.65rem; letter-spacing: 1px;">Email & Security</label>
                    <div class="text-white fw-medium mb-1">
                        {{ $user->email }}
                        @if ($user->email_verified_at)
                            <i class="mdi mdi-check-decagram text-primary ms-1" title="Verified Account"></i>
                        @endif
                    </div>
                    <div class="text-muted small">Password: <span class="opacity-50">••••••••</span>
                    </div>
                </div>

                <a href="mailto:{{ $user->email }}"
                    class="btn rounded-circle d-flex align-items-center justify-content-center shadow-sm action-icon-hover"
                    style="width: 45px; height: 45px; background: linear-gradient(135deg, #0071e3 0%, #00c6fb 100%); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.1); transition: all 0.3s ease;">
                    <i class="mdi mdi-email-outline text-white fs-4"></i>
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 rounded-4 d-flex align-items-center justify-content-between"
                style="background: linear-gradient(90deg, rgba(2, 35, 77, 1) 0%, rgba(0, 0, 0, 1) 94%); border: 1px solid rgba(255,255,255,0.05);">

                <div>
                    <label class="text-uppercase text-muted fw-bold mb-2 d-block"
                        style="font-size: 0.65rem; letter-spacing: 1px;">Phone Number</label>
                    <div class="mb-1">
                        <span class="text-white fw-normal">{{ $user->dialcode }}</span>
                        <span class="text-white fw-medium">{{ $user->phone }}</span>
                    </div>
                    <div class="text-muted small">Primary Mobile</div>
                </div>

                <a href="tel:{{ $user->dialcode }}{{ $user->phone }}"
                    class="btn rounded-circle d-flex align-items-center justify-content-center shadow-sm action-icon-hover"
                    style="width: 45px; height: 45px; background: linear-gradient(135deg, #0071e3 0%, #00c6fb 100%); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.1); transition: all 0.3s ease;">
                    <i class="mdi mdi-phone-outline text-white fs-4"></i>
                </a>
            </div>
        </div>

        <div class="col-md-12 mt-2">
            <div class="p-3 rounded-4 d-flex align-items-center justify-content-between h-100"
                style="background: linear-gradient(90deg, rgba(2, 35, 77, 1) 0%, rgba(0, 0, 0, 1) 94%); border: 1px solid rgba(255,255,255,0.05);">

                <div class="pe-2">
                    <label class="text-uppercase text-muted fw-bold mb-2 d-block"
                        style="font-size: 0.65rem; letter-spacing: 1px;">Customer Address</label>
                    <div class="mb-0">
                        <div class="text-white fw-medium" style="font-size: 0.95rem; line-height: 1.4;">
                            {{ $user->address }}
                        </div>
                        <div class="text-muted small">
                            {{ $user->city }}, {{ $user->state }} {{ $user->zipcode }}
                        </div>
                    </div>
                </div>

                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($user->address . ' ' . $user->city . ' ' . $user->state) }}"
                    target="_blank"
                    class="btn rounded-circle d-flex align-items-center justify-content-center shadow-sm action-icon-hover flex-shrink-0 p-0"
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15); transition: all 0.3s ease; overflow: hidden;">

                    <img src="{{ asset('assets/images/flags/' . strtolower($user->iso2) . '.svg') }}"
                        alt="{{ $user->iso2 }}" class="rounded-circle img-fluid"
                        style="width: 100%; height: 100%; object-fit: cover; transform: scale(1.1);">
                </a>
            </div>
        </div>

    </div>

    <div class="row g-2 mt-2">
        <div class="col-md-6">
            <div class="p-3 rounded-4 d-flex align-items-center"
                style="background: linear-gradient(90deg, rgba(2, 35, 77, 1) 0%, rgba(0, 0, 0, 1) 94%); border: 1px solid rgba(255,255,255,0.05);">

                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 42px; height: 42px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(5px);">
                    <i class="mdi mdi-calendar-check text-white fs-5"></i>
                </div>

                <div>
                    <label class="text-uppercase fw-bold mb-1 d-block"
                        style="font-size: 0.6rem; letter-spacing: 1.2px; color: #a1a1a6;">Customer Since</label>
                    <div class="text-white fw-medium">
                        {{ date('F d, Y', strtotime($user->created_at)) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 rounded-4 d-flex align-items-center"
                style="background: linear-gradient(90deg, rgba(2, 35, 77, 1) 0%, rgba(0, 0, 0, 1) 94%); border: 1px solid rgba(255,255,255,0.05);">

                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 42px; height: 42px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(5px);">
                    <i class="mdi mdi-history text-white fs-5"></i>
                </div>

                <div>
                    <label class="text-uppercase fw-bold mb-1 d-block"
                        style="font-size: 0.6rem; letter-spacing: 1.2px; color: #a1a1a6;">Last Profile
                        Update</label>
                    <div class="text-white fw-medium">
                        {{ $user->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <div class="p-3 rounded-4 d-flex align-items-center"
                style="background: linear-gradient(90deg, rgba(2, 35, 77, 1) 0%, rgba(0, 0, 0, 1) 94%); border: 1px solid rgba(255,255,255,0.05);">

                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 42px; height: 42px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(5px);">
                    <i class="bi bi-car-front text-white fs-5"></i>
                </div>

                <div>
                    <label class="text-uppercase fw-bold mb-1 d-block"
                        style="font-size: 0.6rem; letter-spacing: 1.2px; color: #a1a1a6;">Linked Vehciles</label>
                    <div class="text-white fw-medium">
                        {{ count($user->linkedVehicles) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-2">
            <div class="p-3 rounded-4 d-flex align-items-center"
                style="background: linear-gradient(90deg, rgba(2, 35, 77, 1) 0%, rgba(0, 0, 0, 1) 94%); border: 1px solid rgba(255,255,255,0.05);">

                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                    style="width: 42px; height: 42px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(5px);">
                    <i class="uil-chart text-white fs-5"></i>
                </div>

                <div>
                    <label class="text-uppercase fw-bold mb-1 d-block"
                        style="font-size: 0.6rem; letter-spacing: 1.2px; color: #a1a1a6;">Linked Sales</label>
                    <div class="text-white fw-medium">
                        0
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
