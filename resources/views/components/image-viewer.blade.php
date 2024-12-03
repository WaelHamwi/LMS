<!-- Image Viewer Modal -->
<div class="modal fade" id="imageViewerModal" tabindex="-1" aria-labelledby="imageViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageViewerModalLabel">Image Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="imageViewer" src="{{ $imageUrl ?? '' }}" alt="Image" class="img-fluid" />
            </div>
        </div>
    </div>
</div>
