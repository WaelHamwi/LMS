<div class="tab-pane" id="solid-rounded-justified-tab2">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Copy Image URL</h5>
        </div>
        <div class="card-body">
            <form class="form-horizontal">
                @if ($parent->images && count($parent->images) > 0)
                @foreach ($parent->images as $image)
                <input type="text" class="form-control mb-4" id="input-copy-{{ $parent->id }}-{{ $loop->index }}"
                    value="{{ asset('attachments/parents/' . $parent->first_name . '/' . $image->filename) }}">
                <a class="mb-1 btn clip-btn btn-primary" href="javascript:;" data-clipboard-action="copy"
                    data-clipboard-target="#input-copy-{{ $parent->id }}-{{ $loop->index }}">
                    <i class="far fa-copy"></i> Copy
                </a>

                <a class="mb-1 btn clip-btn btn-dark" href="javascript:;" data-clipboard-action="cut"
                    data-clipboard-target="#input-copy-{{ $parent->id }}-{{ $loop->index }}">
                    <i class="fas fa-cut"></i> Cut
                </a>
                @endforeach
                @else
                <p class="text-danger">No images available for this parent. Please attach images.</p>
                @endif
            </form>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">parent attachements</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Image Filename</th>
                                        <th>Imageable ID</th>
                                        <th>Imageable Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <div class="mb-3 col-4">
                                        <label for="image" class="form-label">Select Image</label>
                                        <form action="{{ route('images.storeParentImage') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="images[]" id="image" class="form-control" multiple required>
                                            <input type="hidden" name="imageable_id" value="{{ $parent->id }}">
                                            <input type="hidden" name="imageable_type" value="App\Models\StudentParent">
                                            <button type="submit" class="btn btn-primary mb-4 mt-4"><i class="fas fa-plus"></i> Add Images</button>
                                        </form>
                                    </div>


                                    @if($parent->images && count($parent->images) > 0)
                                    @foreach ($parent->images as $image)
                                    <tr>
                                        <td>{{ $parent->first_name }}</td>
                                        <td>
                                            <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="93f9fcfbfdd3f6ebf2fee3fff6bdf0fcfe">
                                                [&#160;{{ $parent->email }}]
                                            </a>
                                        </td>
                                        <td>{{ $image->filename }}</td>
                                        <td>{{ $image->imageable_id }}</td>
                                        <td>{{ $image->imageable_type }}</td>
                                        <td>
                                            <!-- Download Button -->
                                            <a href="{{ route('image.downloadParentImage', $image->id) }}" class="btn btn-outline-primary me-2">
                                                <i class="fas fa-arrow-down"></i> Download
                                            </a>

                                            <!-- View Button -->
                                            <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#imageViewerModal"
                                                data-image-url="{{ asset('attachments/parents/' . $parent->first_name . '/' . $image->filename) }}"
                                                onclick="setImageUrl(this)">
                                                <i class="fas fa-eye"></i> View
                                            </button>

                                            <!-- Edit Button -->
                                            <button class="btn btn-warning btn-rounded edit-image me-2"
                                                data-bs-toggle="smallModal"
                                                data-bs-target="#imageEditModal-target2"
                                                data-id="{{ $image->id }}"
                                                data-filename="{{ $image->filename }}"
                                                data-imageable-id="{{ $image->imageable_id }}"
                                                data-imageable-type="{{ $image->imageable_type }}">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </button>

                                            @include('components.small-modal-parent', [
                                            'target' => 'target2',
                                            'imageId' => $image->id ?? null,
                                            'filename' => $image->filename ?? null,
                                            'imageableId' => $image->imageable_id ?? null,
                                            'imageableType' => $image->imageable_type ?? null,
                                            ])
                                            <!-- Delete Button -->
                                            <form action="{{ route('image.delete', $image->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                                    data-title="Delete Image"
                                                    data-body="Are you sure you want to delete this image?"
                                                    data-action="delete"
                                                    data-url="{{ route('image.delete', $image->id) }}">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('components.modal')
                                    @include('components.image-viewer', ['imageUrl' => asset('attachments/parents/' . $parent->first_name . '/' . $image->filename)])
                                    @endforeach
                                    @else
                                    <tr class="table-danger">
                                        <td colspan="6" class="text-center">
                                            There is no data to show. Please attach images.
                                        </td>
                                    </tr>
                                    @endif
                                    @include('components.staticModal')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>