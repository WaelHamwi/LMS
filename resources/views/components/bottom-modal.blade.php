<div id="bottom-modal" class="modal " tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-bottom">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="bottomModalLabel">Delete {{$selectedModel}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to delete this {{$selectedModel}}?</h5>
                <p>Email: {{ $selectedEmail }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" 
                    wire:click="destroy({{ $selectedId }})">Delete</button>
            </div>
        </div>
    </div>
</div>
