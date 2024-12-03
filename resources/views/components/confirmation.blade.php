@if($showCard)
<div class="card mt-4">
    <div class="card-header">
        <h4 class="card-title">Confirm Action</h4>
    </div>
    <div class="card-body">
        <p>{{ $confirmMessage }}</p>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-outline-primary" wire:click={{$updateMode ? "updateParents" : "saveParents"}}>Confirm</button>
            <button type="button" class="btn btn-secondary" wire:click="$set('showCard', false)">Cancel</button>
        </div>
    </div>
</div>
@endif