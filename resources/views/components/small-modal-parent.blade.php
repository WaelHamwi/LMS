<div class="modal fade" id="imageEditModal-{{ $target }}" tabindex="-1" aria-labelledby="imageEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="imageEditModalLabel">Edit Image</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    @if($image && $image->filename)
                    <img id="modalImage" src="{{ asset('attachments/parents/' . $parent->first_name . '/' . $image->filename) }}" alt="Image preview" class="img-fluid rounded">
                    @else
                    <p class="text-danger">No image available for preview.</p>
                    <p class="text-danger">add image </p>
                    @endif
                </div>

                @if(isset($imageId))
                <form id="editImageForm" enctype="multipart/form-data" action="{{ route('image.updateParentImage', ['id' => $imageId]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="imageId" name="image_id" value="{{ $imageId }}">
                    <input type="text" id="imageFilename" name="filename" class="form-control mb-3"
                        value="{{ $image && $image->filename ? asset('attachments/parents/' . $parent->first_name . '/' . $image->filename) : '' }}"
                        placeholder="No filename available">
                    <input type="hidden" id="newImageFilename" name="new_filename" class="form-control mb-3" value="">
                    <input type="hidden" id="imageableId" name="imageable_id" value="{{ $imageableId ?? '' }}">
                    <input type="hidden" id="imageableType" name="imageable_type" value="{{ $imageableType ?? '' }}">

                    <!-- File input for image selection -->
                    <div class="d-flex justify-content-center align-items-center gap-5">
                        <label for="field-12-student-image-{{ $target }}" class="btn btn-primary feather-edit mt-4">
                            <input type="file" id="field-12-student-image-{{ $target }}" name="image" style="display: none;" onchange="handleImagePreview(event)">
                        </label>
                        <button type="submit" class="btn btn-success mt-3">Submit</button>
                    </div>

                    <!-- Container for image previews -->
                    <div id="image-preview-container-{{$target}}" class="image-preview-container mt-3 justify-content-center align-items-center flex-wrap p-3 border rounded bg-light shadow"></div>
                </form>
                @else
                <p class="text-danger">Unable to update image: missing ID.</p>
                @endif
            </div>
        </div>
    </div>
</div>