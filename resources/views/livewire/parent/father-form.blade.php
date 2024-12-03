@props(['nationalities' => [], 'bloods' => [], 'religions' => [], 'handleErrors' => [],
'father_name' => '', 'father_national_id' => '', 'father_passport_id' => '',
'father_phone' => '', 'father_job' => '', 'father_nationality_id' => '',
'father_blood_id' => '', 'father_religion_id' => '', 'updateMode' => $updateMode])

<form wire:submit.prevent="{{ $updateMode ? 'updateFatherDetails' : 'saveFatherDetails' }}">
    <div class="row">
        <!-- Email -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="email-input">Email</label>
                <input type="email" class="form-control" id="email-input"
                    wire:model.defer="email" wire:keydown="clearErrors"
                    value="{{ $updateMode ? $email : '' }}">
                @if(isset($handleErrors['email']))
                <span class="text-danger">{{ $handleErrors['email'] }}</span>
                @endif
            </div>
        </div>

        <!-- Password -->
        <div class="col-lg-3">
            <div class="mb-3">
                <label for="password-input">Password</label>
                <input type="password" class="form-control" id="password-input"
                    wire:model.defer="password" wire:keydown="clearErrors"
                    value="">
                @if(isset($handleErrors['password']))
                <span class="text-danger">{{ $handleErrors['password'] }}</span>
                @endif
            </div>
        </div>

        <!-- Password Confirmation -->
        <div class="col-lg-3">
            <div class="mb-3">
                <label for="password-confirmation-input">Confirm Password</label>
                <input type="password" class="form-control" id="password-confirmation-input"
                    wire:model.defer="password_confirmation" wire:keydown="clearErrors"
                    value="">
                @if(isset($handleErrors['password_confirmation']))
                <span class="text-danger">{{ $handleErrors['password_confirmation'] }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Father's Name -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="father-name-input">Father's Name</label>
                <input type="text" class="form-control" id="father-name-input"
                    wire:model.defer="father_name" wire:keydown="clearErrors"
                    value="{{ $updateMode ? $father_name : '' }}">
                @if(isset($handleErrors['father_name']))
                <span class="text-danger">{{ $handleErrors['father_name'] }}</span>
                @endif
            </div>
        </div>

        <!-- Father's National ID -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="father-national-id-input">Father's National ID</label>
                <input type="text" class="form-control" id="father-national-id-input"
                    wire:model.defer="father_national_id" wire:keydown="clearErrors"
                    value="{{ $updateMode ? $father_national_id : '' }}">
                @if(isset($handleErrors['father_national_id']))
                <span class="text-danger">{{ $handleErrors['father_national_id'] }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Father's Passport ID -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="father-passport-id-input">Father's Passport ID</label>
                <input type="text" class="form-control" id="father-passport-id-input"
                    wire:model.defer="father_passport_id" wire:keydown="clearErrors"
                    value="{{ $updateMode ? $father_passport_id : '' }}">
                @if(isset($handleErrors['father_passport_id']))
                <span class="text-danger">{{ $handleErrors['father_passport_id'] }}</span>
                @endif
            </div>
        </div>

        <!-- Father's Phone -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="father-phone-input">Father's Phone</label>
                <input type="text" class="form-control" id="father-phone-input"
                    wire:model.defer="father_phone" wire:keydown="clearErrors"
                    value="{{ $updateMode ? $father_phone : '' }}">
                @if(isset($handleErrors['father_phone']))
                <span class="text-danger">{{ $handleErrors['father_phone'] }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Father's Job -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="father-job-input">Father's Job</label>
                <input type="text" class="form-control" id="father-job-input"
                    wire:model.defer="father_job" wire:keydown="clearErrors"
                    value="{{ $updateMode ? $father_job : '' }}">
                @if(isset($handleErrors['father_job']))
                <span class="text-danger">{{ $handleErrors['father_job'] }}</span>
                @endif
            </div>
        </div>

        <!-- Father's Nationality -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="father-nationality-input">Father's Nationality</label>
                <select class="form-control" id="father-nationality-input"
                    wire:model.defer="father_nationality_id" wire:keydown="clearErrors">
                    <option value="">Select Nationality</option>
                    @foreach ($nationalities as $nationality)
                    <option value="{{ $nationality->id }}" @if($updateMode && $father_nationality_id==$nationality->id) selected @endif>
                        {{ $nationality->name }}
                    </option>
                    @endforeach
                </select>
                @if(isset($handleErrors['father_nationality_id']))
                <span class="text-danger">{{ $handleErrors['father_nationality_id'] }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Father's Blood Type -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="father-blood-type-input">Father's Blood Type</label>
                <select class="form-control" id="father-blood-type-input"
                    wire:model.defer="father_blood_id" wire:keydown="clearErrors">
                    <option value="">Select Blood Type</option>
                    @foreach ($bloods as $blood)
                    <option value="{{ $blood->id }}" @if($updateMode && $father_blood_id==$blood->id) selected @endif>
                        {{ $blood->type }}
                    </option>
                    @endforeach
                </select>
                @if(isset($handleErrors['father_blood_id']))
                <span class="text-danger">{{ $handleErrors['father_blood_id'] }}</span>
                @endif
            </div>
        </div>

        <!-- Father's Religion -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="father-religion-input">Father's Religion</label>
                <select class="form-control" id="father-religion-input"
                    wire:model.defer="father_religion_id" wire:keydown="clearErrors">
                    <option value="">Select Religion</option>
                    @foreach ($religions as $religion)
                    <option value="{{ $religion->id }}" @if($updateMode && $father_religion_id==$religion->id) selected @endif>
                        {{ $religion->name }}
                    </option>
                    @endforeach
                </select>
                @if(isset($handleErrors['father_religion_id']))
                <span class="text-danger">{{ $handleErrors['father_religion_id'] }}</span>
                @endif
            </div>
        </div>
    </div>

    <ul class="pager wizard twitter-bs-wizard-pager-link">
        <li class="next">
            <a href="javascript: void(0);" class="btn btn-primary"
                wire:click.prevent='nextTab'
                @if($this->getErrorBag()->isNotEmpty()) disabled @endif>
                {{ $updateMode ? 'Next Update' : 'Next' }} <i class="bx bx-chevron-right ms-1"></i>
            </a>
        </li>
    </ul>
</form>