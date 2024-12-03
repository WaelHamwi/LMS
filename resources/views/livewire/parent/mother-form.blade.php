@props(['nationalities', 'bloods', 'religions', 'handleErrors'])

<div class="mb-4">
    <h5>Mother's Details</h5>
</div>

<form wire:submit.prevent="saveMotherDetails">
    <div class="row">
        <!-- Mother's Name -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="mother-name-input">Mother's Name</label>
                <input type="text" class="form-control" id="mother-name-input" 
                       wire:model.defer="mother_name" wire:keydown="clearErrors">
                @if(isset($handleErrors['mother_name'])) 
                    <span class="text-danger">{{ $handleErrors['mother_name'] }}</span> 
                @endif
            </div>
        </div>

        <!-- Mother's National ID -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="mother-national-id-input">Mother's National ID</label>
                <input type="text" class="form-control" id="mother-national-id-input" 
                       wire:model.defer="mother_national_id" wire:keydown="clearErrors">
                @if(isset($handleErrors['mother_national_id'])) 
                    <span class="text-danger">{{ $handleErrors['mother_national_id'] }}</span> 
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Mother's Passport ID -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="mother-passport-id-input">Mother's Passport ID</label>
                <input type="text" class="form-control" id="mother-passport-id-input" 
                       wire:model.defer="mother_passport_id" wire:keydown="clearErrors">
                @if(isset($handleErrors['mother_passport_id'])) 
                    <span class="text-danger">{{ $handleErrors['mother_passport_id'] }}</span> 
                @endif
            </div>
        </div>

        <!-- Mother's Phone -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="mother-phone-input">Mother's Phone</label>
                <input type="text" class="form-control" id="mother-phone-input" 
                       wire:model.defer="mother_phone" wire:keydown="clearErrors">
                @if(isset($handleErrors['mother_phone'])) 
                    <span class="text-danger">{{ $handleErrors['mother_phone'] }}</span> 
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Mother's Job -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="mother-job-input">Mother's Job</label>
                <input type="text" class="form-control" id="mother-job-input" 
                       wire:model.defer="mother_job" wire:keydown="clearErrors">
                @if(isset($handleErrors['mother_job'])) 
                    <span class="text-danger">{{ $handleErrors['mother_job'] }}</span> 
                @endif
            </div>
        </div>

        <!-- Mother's Nationality -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="mother-nationality-input">Mother's Nationality</label>
                <select class="form-control" id="mother-nationality-input" 
                        wire:model.defer="mother_nationality_id" wire:keydown="clearErrors">
                    <option value="">Select Nationality</option>
                    @foreach ($nationalities as $nationality)
                        <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                    @endforeach
                </select>
                @if(isset($handleErrors['mother_nationality_id'])) 
                    <span class="text-danger">{{ $handleErrors['mother_nationality_id'] }}</span> 
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Mother's Blood Type -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="mother-blood-input">Mother's Blood Type</label>
                <select class="form-control" id="mother-blood-input" 
                        wire:model.defer="mother_blood_id" wire:keydown="clearErrors">
                    <option value="">Select Blood Type</option>
                    @foreach ($bloods as $blood)
                        <option value="{{ $blood->id }}">{{ $blood->type }}</option>
                    @endforeach
                </select>
                @if(isset($handleErrors['mother_blood_id'])) 
                    <span class="text-danger">{{ $handleErrors['mother_blood_id'] }}</span> 
                @endif
            </div>
        </div>

        <!-- Mother's Religion -->
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="mother-religion-input">Mother's Religion</label>
                <select class="form-control" id="mother-religion-input" 
                        wire:model.defer="mother_religion_id" wire:keydown="clearErrors">
                    <option value="">Select Religion</option>
                    @foreach ($religions as $religion)
                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                    @endforeach
                </select>
                @if(isset($handleErrors['mother_religion_id'])) 
                    <span class="text-danger">{{ $handleErrors['mother_religion_id'] }}</span> 
                @endif
            </div>
        </div>
    </div>

    <ul class="pager wizard twitter-bs-wizard-pager-link">
        <li class="previous">
            <a href="javascript: void(0);" class="btn btn-primary"
                wire:click="previousTab"
                @if($this->getErrorBag()->isNotEmpty()) disabled @endif>
                Previous <i class="bx bx-chevron-right ms-1"></i>
            </a>
        </li>
        <li class="next">
            <a href="javascript: void(0);" class="btn btn-primary"
                wire:click="nextTab"
                @if($this->getErrorBag()->isNotEmpty()) disabled @endif>
                Next <i class="bx bx-chevron-right ms-1"></i>
            </a>
        </li>
    </ul>
</form>
