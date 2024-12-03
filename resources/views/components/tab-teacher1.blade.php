<div class="tab-pane show active" id="solid-rounded-justified-tab1">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-info">
                        <h4>Profile <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h4>
                    </div>
                    <!-- Edit Button -->
                    @php
                    $image = $teacher->images->isNotEmpty() ? $teacher->images[0] : null;
                    @endphp

                    <div class="student-profile-head">
                        <div class="profile-bg-img">
                            @php
                            $images = $teacher->images;
                            $profileImage = $images->isNotEmpty() ? $images[0] : null;
                            $profileImage = $profileImage && $profileImage->filename ? $profileImage : ($images->count() > 1 ? $images[1] : null);
                            @endphp

                            <img src="{{ $profileImage && $profileImage->filename ? asset('attachments/teachers/' . $teacher->first_name . '/' . $profileImage->filename) : asset('assets/img/profile-bg.jpg') }}" alt="Profile Image" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="profile-user-box">
                                    <div class="profile-user-img ">
                                        @php
                                        $profileImage = $images->isNotEmpty() ? $images[0] : null;
                                        @endphp

                                        <div class="form-group students-up-files mb-0 position-relative">
                                            <img src="{{ $profileImage && $profileImage->filename ? asset('attachments/teachers/' . $teacher->first_name . '/' . $profileImage->filename) : asset('assets/img/profile-user.jpg') }}" alt="Profile Image" class="img-fluid">
                                            <div class="uplod position-absolute bottom-0 start-50 translate-middle">

                                                <button class="btn btn-primary fas fa-pencil-alt btn-sm edit-image me-2 d-flex align-items-center justify-content-center rounded-circle"
                                                    data-bs-toggle="smallModal"
                                                    data-bs-target="#imageEditModal-target1"
                                                    data-id="{{ $image->id ?? '' }}"
                                                    data-filename="{{ $image->filename ?? '' }}"
                                                    data-imageable-id="{{ $image->imageable_id ?? '' }}"
                                                    data-imageable-type="{{ $image->imageable_type ?? '' }}">
                                                </button>

                                            </div>
                                        </div>

                                        @include('components.small-modal-teacher', [
                                        'target' => 'target1',
                                        'imageId' => $image->id ?? null,
                                        'filename' => $image->filename ?? null,
                                        'imageableId' => $image->imageable_id ?? null,
                                        'imageableType' => $image->imageable_type ?? null,
                                        ])
                                    </div>
                                    <div class="names-profiles">
                                        <h4>{{ $teacher->first_name }}</h4>
                                        <h5>
                                            @if ($teacher->sections->isNotEmpty())
                                            {{ $teacher->sections->first()->name }}
                                            @else
                                            No sections assigned
                                            @endif
                                        </h5>
                                    </div>

                                </div>
                            </div>
                            <!-- Other columns, such as followers, follow buttons, etc. -->
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
                                        <h5>{{ $teacher->first_name }}</h5>
                                    </div>
                                </div>
                                <div class="personal-activity">
                                    <div class="personal-icons">
                                        <img src="{{ asset('assets/img/icons/buliding-icon.svg') }}" alt="">
                                    </div>
                                    <div class="views-personal">
                                        <h4>Department </h4>
                                        <h5>
                                            @if ($teacher->sections->isNotEmpty())
                                            @foreach ($teacher->sections as $section)
                                            {{ $section->name }}
                                            @if (!$loop->last)
                                            ,
                                            @endif
                                            @endforeach
                                            @else
                                            No sections assigned
                                            @endif
                                        </h5>

                                    </div>
                                </div>
                                <div class="personal-activity">
                                    <div class="personal-icons">
                                        <i class="feather-phone-call"></i>
                                    </div>
                                    <div class="views-personal">
                                        <h4>Mobile</h4>
                                        <h5>{{ $teacher->phone ? $teacher->phone:'00963968643988' }}</h5>
                                    </div>
                                </div>
                                <div class="personal-activity">
                                    <div class="personal-icons">
                                        <i class="feather-mail"></i>
                                    </div>
                                    <div class="views-personal">
                                        <h4>Email</h4>
                                        <h5><a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a></h5>
                                    </div>
                                </div>
                                <div class="personal-activity">
                                    <div class="personal-icons">
                                        <i class="feather-user"></i>
                                    </div>
                                    <div class="views-personal">
                                        <h4>Gender</h4>
                                        <h5>{{ $teacher->gender->name }}</h5>
                                    </div>
                                </div>
                                <div class="personal-activity">
                                    <div class="personal-icons">
                                        <i class="feather-calendar"></i>
                                    </div>
                                    <div class="views-personal">
                                        <h4>Date of join</h4>
                                        <h5>{{ $teacher->join_date }}</h5>
                                    </div>
                                </div>
                                <div class="personal-activity">
                                    <div class="personal-icons">
                                        <i class="feather-italic"></i>
                                    </div>
                                    <div class="views-personal">
                                        <h4>Language</h4>
                                        <h5>{{ $teacher->language }}</h5>
                                    </div>
                                </div>
                                <div class="personal-activity mb-0">
                                    <div class="personal-icons">
                                        <i class="feather-map-pin"></i>
                                    </div>
                                    <div class="views-personal">
                                        <h4>Address</h4>
                                        <h5>{{ $teacher->address }}</h5>
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
                                    <h5>Hello I am {{$teacher->first_name}}</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur officia deserunt mollit anim id est laborum.</p>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                </div>
                                <div class="hello-park">
                                    <h5>Education</h5>
                                    <div class="educate-year">
                                        <h6>{{$teacher->specialization->name}}</h6>
                                        <p>specialization </p>
                                    </div>
                                    <div class="educate-year">
                                        <h6>2011 - 2012</h6>
                                        <p>Higher Secondary Schooling at xyz school of higher secondary education, Mumbai.</p>
                                    </div>
                                    <div class="educate-year">
                                        <h6>2012 - 2015</h6>
                                        <p>Bachelor of Science at Abc College of Art and Science, Chennai.</p>
                                    </div>
                                    <div class="educate-year">
                                        <h6>2015 - 2017</h6>
                                        <p class="mb-0">Master of Science at Cdm College of Engineering and Technology, Pune.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>