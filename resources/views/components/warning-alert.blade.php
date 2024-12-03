<div id="warning-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-warning h1 text-warning"></i>
                    <h4 class="mt-2" id="modal-title">{{ $title }}</h4>
                    <p class="mt-3" id="modal-message">{{ $message }}</p>
                    <form id="warn-form" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="return_data" value="1">
                        <button type="submit" class="btn btn-warning my-2">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
