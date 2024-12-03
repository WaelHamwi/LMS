@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show mt-4 custom-alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Wizard with Progressbar</h4>
                @if($updateMode)
                <h4>Edit Parent</h4>
                @else
                <h4>Add Parent</h4>
                @endif

                <!-- Normal Button (hidden while loading) -->
                <button type="button" class="btn btn-primary" wire:click="showTable" wire:loading.remove wire:target="showTable">
                    {{ $showingTable ? 'Add Parent' : 'Show Table' }}
                </button>

                <!-- Button with Spinner (visible when loading) -->
                <button type="button" class="btn btn-primary" wire:loading wire:target="showTable" disabled>
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...
                </button>
            </div>

            @if(!$showingTable)
            <div class="card-body">
                <div id="progrss-wizard" class="twitter-bs-wizard">
                    <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a href="#progress-seller-details" class="nav-link @if($step === 1) active @endif" data-toggle="tab">
                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Father Details">
                                    <i class="far fa-user"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#progress-company-document" class="nav-link @if($step === 2) active @endif" data-toggle="tab">
                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Mother Details">
                                    <i class="fas fa-user"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#progress-bank-detail" class="nav-link @if($step === 3) active @endif" data-toggle="tab">
                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirm Details">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content twitter-bs-wizard-tab-content">
                        <!-- Father Details Form -->
                        <div class="tab-pane @if($step === 1) active @endif" id="progress-seller-details">
                            @if($step === 1)
                            @if($updateMode)
                            @include('livewire.parent.father-form', [
                            'nationalities' => $nationalities,
                            'bloods' => $bloods,
                            'religions' => $religions,
                            'handleErrors' => $handleErrors,
                            'father_name' => $father_name,
                            'father_national_id' => $father_national_id,
                            'father_passport_id' => $father_passport_id,
                            'father_phone' => $father_phone,
                            'father_job' => $father_job,
                            'father_nationality_id' => $father_nationality_id,
                            'father_blood_id' => $father_blood_id,
                            'father_religion_id' => $father_religion_id,
                            'updateMode' => $updateMode
                            ])
                            @else
                            @include('livewire.parent.father-form', [
                            'nationalities' => $nationalities,
                            'bloods' => $bloods,
                            'religions' => $religions,
                            'handleErrors' => $handleErrors
                            ])
                            @endif
                            @endif
                        </div>

                        <!-- Mother Details Form -->
                        <div class="tab-pane @if($step === 2) active @endif" id="progress-company-document">
                            @if($step === 2)
                            @include('livewire.parent.mother-form')
                            @endif
                        </div>

                        <!-- Confirm Details Form -->
                        <div class="tab-pane @if($step === 3) active @endif" id="progress-bank-detail">
                            @if($step === 3)
                            @include('livewire.parent.confirm-form')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @elseif($showingTable)
            @php
            $headers = ['ID', 'Email', 'FatherName', 'PassportId', 'Phone', 'Nationality'];
            $modelName = 'StudentParent';
            $routeDestroy = 'StudentParent.destroy';

            $rows = $studentParents->map(function ($studentParent) {
            return [
            'id' => $studentParent->id,
            'data' => [
            $studentParent->id,
            $studentParent->email,
            $studentParent->father_name,
            $studentParent->father_passport_id,
            $studentParent->phone,
            $studentParent->father_nationality_id,
            ],
            ];
            })->toArray();

            $actionButtons = function ($row) {
            return '
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <button class="dropdown-item edit-studentParent"
                            wire:click="edit(' . $row['data'][0] . ')"
                            data-bs-toggle="modal"
                            data-bs-target="#studentParent-modal">
                            <i class="fas fa-edit me-2"></i> Edit
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item text-danger"
                            wire:click="selectStudentParent(' . $row['data'][0] . ', \'' . $row['data'][1] . '\')"
                            data-bs-toggle="modal"
                            data-bs-target="#bottom-modal">
                            <i class="fas fa-trash-alt me-2"></i> Delete
                        </button>
                    </li>
                </ul>
            </div>
            ';
            };

            @endphp

            @include('components.data-table', [
            'title' => 'Student Parents',
            'description' => 'Manage student parents in the table',
            'headers' => $headers,
            'rows' => $rows,
            'modelName' => $modelName,
            'routeDestroy' => $routeDestroy,
            'actionButtons' => $actionButtons,
            'bulkDelete' => 'studentParent'
            ])
            @endif
        </div>
    </div>
    @if( $showDeleteConfirmationModal)
    @include('components.bottom-modal', [
    'title' => 'Delete Student Parent',
    'body' => 'Are you sure you want to delete this student parent?',
    'action' => 'destroy',
    'selectedModel'=>'student parent',
    ])
    @endif
</div>