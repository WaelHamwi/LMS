@props([ 
    'modalId' => 'default-modal',
    'modalTitle' => 'Default Title',
    'formId' => 'default-form',
    'formAction' => '#',
    'fields' => [],
    'saveBtn' => 'saveBtn',
])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">{{ $modalTitle }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="{{ $formId }}" action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="repeater">
                        <div class="form-group row form-0">
                            @foreach ($fields as $index => $field)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="{{ $field['id'] }}" class="form-label">{{ $field['label'] }}</label>
                                        
                                        @if ($field['type'] === 'select')
                                            <div class="mb-3">
                                                <select name="{{ $field['name'] }}[]" id="{{ $field['id'] }}" class="form-select" {{ $field['required'] ? 'required' : '' }} {{ isset($field['multiple']) && $field['multiple'] ? 'multiple' : '' }} aria-label="{{ $field['label'] }}">
                                                    <option value="" disabled selected>{{ $field['placeholder'] }}</option>
                                                    @foreach ($field['options'] as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                @if (isset($field['help_text']))
                                                    <small id="{{ $field['id'] }}Help" class="form-text text-muted">{{ $field['help_text'] }}</small>
                                                @endif
                                            </div>

                                        @elseif ($field['type'] === 'textarea')
                                            <textarea name="{{ $field['name'] }}[]" id="{{ $field['id'] }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}" {{ $field['required'] ? 'required' : '' }}>{{ old($field['name']) }}</textarea>
                                            @if (isset($field['help_text']))
                                                <small id="{{ $field['id'] }}Help" class="form-text text-muted">{{ $field['help_text'] }}</small>
                                            @endif

                                        @else
                                            <input type="{{ $field['type'] ?? 'text' }}" name="{{ $field['name'] }}[]" class="form-control" id="{{ $field['id'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" {{ $field['required'] ? 'required' : '' }}>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" hidden class="btn btn-success" id="add-repeater-form"> {{$modalTitle}}</button>
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light" id="{{ $saveBtn }}">Save changes</button>
                    </div>
                </form>
                @include('components.spinners')
            </div>
        </div>
    </div>
</div>
