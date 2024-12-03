<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-2">{{ $title }}</h5>
        <p class="card-text">
            <code>{{ $description }}</code>
        </p>
    </div>
    @include('components.modal')
    <div class="card-body">
        <div class="table-responsive">
            <table class="datatable table table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        @foreach ($headers as $header)
                        <th>{{ $header }}</th>
                        @endforeach
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                    @php
                    $rowClass = in_array('Active', $row) ? 'table-active' : 'table-inactive';
                    @endphp

                    <tr class="{{ $rowClass }}">
                        <td><input type="checkbox" name="selected[]" value="{{ $row['id'] }}" class="selectRow"></td>

                        @foreach ($row['data'] as $key => $cell)
                        @php
                        $cellClass = ($cell === 'Active') ? 'table-success' : (($cell === 'Inactive') ? 'table-danger' : '');
                        @endphp

                        <td class="{{ $cellClass }}">{{ $cell }}</td>
                        @endforeach

                        <td>
                            {!! $actionButtons($row) !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>


            </table>
            @include('components.staticModal')
            @include('components.danger-alert')
        </div>
        <!-- Bulk delete button -->
        <button id="bulkDeleteBtn" class="btn btn-danger mt-3" data-model="{{ $bulkDelete }}">Bulk delete</button>
    </div>
</div>