@props([
    'modalId' => 'default-modal',
    'modalTitle' => 'Default Title',
    'formId' => 'default-form',
    'formAction' => '#',
    'fields' => [],
    'label' => 'label',
    'saveBtn' => 'Save',
    'readOnly'=>'readOnly',
])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $label }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="{{ $label }}">
                    {{ $modalTitle }}
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ $formAction }}" method="POST" id="{{ $formId }}">
                    @csrf
                    @foreach($fields as $field)
                    <div class="mb-3">
                        <label for="{{ $field['id'] }}" class="form-label">{{ $field['label'] }}</label>
                        @if($field['type'] === 'select')
                        <select id="{{ $field['id'] }}" name="{{ $field['name'] }}" class="form-select" {{ $field['readonly'] ? 'disabled' : '' }} required>
                            <option value="" selected>{{ $field['placeholder'] }}</option>
                            <!-- Add options here if needed -->
                        </select>
                        @elseif($field['type'] === 'textarea')
                        <textarea id="{{ $field['id'] }}" name="{{ $field['name'] }}" class="form-control" placeholder="{{ $field['placeholder'] }}" {{ $field['readonly'] ? 'readonly' : '' }}></textarea>
                        @else
                        <input 
                            type="{{ $field['type'] }}" 
                            id="{{ $field['id'] }}" 
                            name="{{ $field['name'] }}" 
                            class="form-control" 
                            placeholder="{{ $field['placeholder'] }}" 
                            {{ $field['readonly'] ? 'readonly' : '' }} 
                            {{ $field['required'] ? 'required' : '' }} 
                            step="{{ $field['step'] ?? '' }}"
                        >
                        @endif
                    </div>
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ $saveBtn }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
