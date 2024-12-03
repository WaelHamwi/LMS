{{-- resources/views/components/student-form.blade.php --}}
@props([
'formId' => 'student-form',
'formAction',
'formTitle',
'fields' => [],
'multiple'=>'multiple',
])

<div class="row">
    <div class="col-sm-12">
        <div class="card comman-shadow">
            <div class="card-body">
                <form id="{{ $formId }}" action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title student-info">Student Information <span><a href="javascript:;"></a></span></h5>
                        </div>

                        @foreach ($fields as $field)
                        <div class="col-12 col-sm-4">
                            <div class="form-group local-forms">
                                <label for="{{ $field['id'] }}">{{ $field['label'] }} @if($field['required'])<span class="login-danger">*</span>@endif</label>
                                @if ($field['type'] === 'select')
                                <select name="{{ $field['name'] }}" id="{{ $field['id'] }}" class="form-control select" {{ $field['required'] ? 'required' : '' }}>
                                    <option value="" disabled selected>{{ $field['placeholder'] ?? 'Please Select' }}</option>
                                    @foreach ($field['options'] as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @elseif ($field['type'] === 'file')
                                <input type="file" name="{{ $field['name'] }}" class="form-control" id="{{ $field['id'] }}"
                                    {{ $field['required'] ? 'required' : '' }}
                                    accept="{{ $field['accept'] ?? '' }}"
                                    {{ $field['multiple'] ? 'multiple' : '' }}>
                                @else
                                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control" id="{{ $field['id'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" {{ $field['required'] ? 'required' : '' }}>
                                @endif
                            </div>
                        </div>
                        @endforeach


                        <div class="col-12">
                            <div class="student-submit">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div id="image-preview-container" class="image-preview-container">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>