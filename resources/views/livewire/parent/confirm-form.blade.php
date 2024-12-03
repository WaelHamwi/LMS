<div class="mb-4">
    <h5>parent Details</h5>
</div>

<form wire:submit.prevent="showConfirmationCard">
    <div class="form-group row mb-4">
        <label class="col-form-label col-md-2">File Input</label>
        <div class="col-md-10">
            <input class="form-control" type="file" wire:model="files" multiple>
            @error('files.*') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="d-flex justify-content-between">


        <a href="javascript:void(0);" class="btn btn-primary"
            wire:click="previousTab"
            @if($errors->isNotEmpty()) disabled @endif>
            Previous <i class="bx bx-chevron-right ms-1"></i>
        </a>
        <button type="submit" class="btn btn-primary">Save Parent's Details</button>
    </div>

</form>

@if($showCard)
@include('components.confirmation', [
'confirmMessage' => $confirmMessage,
'showCard' => $showCard,
])
@endif