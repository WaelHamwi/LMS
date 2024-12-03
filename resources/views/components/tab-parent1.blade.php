<div class="tab-pane show active" id="solid-rounded-justified-tab1">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-info">
                        <h4>Profile
                            <span>
                                <a href="javascript:;">
                                    <i class="feather-more-vertical"></i>
                                </a>
                            </span>
                        </h4>
                    </div> @php
                    $image = $parent->images->isNotEmpty() ? $parent->images[0] : null;
                    @endphp

                    <div class="student-profile-head">
                        <div class="profile-bg-img">
                            @php
                            $images = $parent->images;
                            $profileImage = $images->isNotEmpty() ? $images[0] : null;
                            $profileImage = $profileImage && $profileImage->filename ? $profileImage : ($images->count() > 1 ? $images[1] : null);
                            @endphp

                            <img src="{{ $profileImage && $profileImage->filename ? asset('attachments/parents/' . $parent->first_name . '/' . $profileImage->filename) : asset('assets/img/profile-bg.jpg') }}" alt="Profile Image" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">

                            <div class="student-profile-head">
                                <div class="profile-bg-img">


                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="profile-user-box">
                                            <div class="profile-user-img">
                                                <div class="form-group students-up-files mb-0 position-relative">
                                                    <img src="{{ isset($profileImage) && isset($profileImage->filename) 
    ? asset('attachments/parents/' . $parent->first_name . '/' . $profileImage->filename) 
    : asset('assets/img/profile-bg.jpg') }}"
                                                        alt="Profile Image"
                                                        class="img-fluid"
                                                        style="object-fit: cover; width: 100%; height: 100%;">

                                                    <div class="uplod position-absolute bottom-0 start-50 translate-middle">
                                                        <button class="btn btn-primary fas fa-pencil-alt btn-sm edit-image me-2 d-flex align-items-center justify-content-center rounded-circle"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#imageEditModal-target1"
                                                            data-id="{{ $profileImage->id ?? '' }}"
                                                            data-filename="{{ $profileImage->filename ?? '' }}"
                                                            data-imageable-id="{{ $profileImage->imageable_id ?? '' }}"
                                                            data-imageable-type="{{ $profileImage->imageable_type ?? '' }}">
                                                        </button>
                                                    </div>
                                                </div>
                                                @include('components.small-modal-parent', [
                                                'target' => 'target1',
                                                'imageId' => $profileImage->id ?? null,
                                                'filename' => $profileImage->filename ?? null,
                                                'imageableId' => $profileImage->imageable_id ?? null,
                                                'imageableType' => $profileImage->imageable_type ?? null,
                                                ])
                                            </div>
                                            <div class="names-profiles">
                                                <h4>{{ $parent->first_name }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Details Section -->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="student-personals-grp">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>Personal Details :</h4>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-user"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Name</h4>
                                                <h5>{{ $parent->first_name }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-phone-call"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Mobile</h4>
                                                <h5>{{ $parent->phone ?? 'N/A' }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-mail"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Email</h4>
                                                <h5>
                                                    <a href="mailto:{{ $parent->email }}">{{ $parent->email ?? 'N/A' }}</a>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity">
                                            <div class="personal-icons">
                                                <i class="feather-map-pin"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Address</h4>
                                                <h5>{{ $parent->address ?? 'N/A' }}</h5>
                                            </div>
                                        </div>
                                        <div class="personal-activity mb-0">
                                            <div class="personal-icons">
                                                <i class="feather-calendar"></i>
                                            </div>
                                            <div class="views-personal">
                                                <h4>Date of join</h4>
                                                <h5>{{ $parent->join_date ?? 'N/A' }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="student-personals-grp">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="heading-detail">
                                            <h4>About Me</h4>
                                        </div>
                                        <div class="hello-park">
                                            <h5>Hello, I am {{ $parent->first_name }}</h5>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>