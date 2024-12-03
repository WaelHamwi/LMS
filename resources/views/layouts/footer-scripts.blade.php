<!-- Footer Scripts -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/js/feather.min.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/chart-data.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/datatables/datatables.min.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/js/script.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js?v=1.0.0') }}"></script>

<script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales-all.min.js"></script>


<script>
    console.log(typeof ClipboardJS !== 'undefined' ? 'Clipboard.js is loaded' : 'Clipboard.js failed to load');
</script>
<!-- Include the custom.js file -->
<script src="{{ asset('assets/js/custom.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/js/ajax.js?v=1.0.0') }}"></script>

<!-- Additional Scripts with Versioning -->
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/prettify.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/form-wizard.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js?v=1.0.0') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js?v=1.0.0') }}"></script>

<!-- Animation JS -->
<script src="{{ asset('assets/js/animation.js?v=1.0.0') }}"></script>

<script>
    function reloadScripts() {
        const scripts = [
            "{{ asset('assets/js/jquery-3.6.0.min.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js?v=1.0.0') }}",
            "{{ asset('assets/js/feather.min.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/apexchart/apexcharts.min.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/apexchart/chart-data.js?v=1.0.0') }}",
            "{{ asset('assets/js/script.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/datatables/jquery.dataTables.min.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/datatables/datatables.min.js?v=1.0.0') }}",
            "/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js",
            "{{ asset('assets/js/custom.js?v=1.0.0') }}",
            "{{ asset('assets/js/ajax.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/twitter-bootstrap-wizard/prettify.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/twitter-bootstrap-wizard/form-wizard.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/sweetalert/sweetalerts.min.js?v=1.0.0') }}",
            "{{ asset('assets/js/animation.js?v=1.0.0') }}",
            "{{ asset('assets/plugins/clipboard/clipboard.min.js?v=1.0.0') }}"
        ];

        scripts.forEach(function(src) {
            if (!document.querySelector(`script[src="${src}"]`)) {
                const script = document.createElement('script');
                script.src = src;
                script.async = false; // Ensure proper load order
                document.body.appendChild(script);
            }
        });
    }

    document.addEventListener('login-success', function() {
        sessionStorage.setItem('loggedIn', 'true');
        reloadScripts();
    });

    if (sessionStorage.getItem('loggedIn')) {
        reloadScripts();
        sessionStorage.removeItem('loggedIn');
    } else {
        login().then(function() {
            reloadScripts();
        });
    }

    function login() {
        return new Promise(function(resolve) {
            setTimeout(function() {
                resolve();
            }, 1000); // Simulating a login delay
        });
    }

    // Initialize DataTables after scripts are loaded
    $(document).ready(function() {
        $('.datatable').DataTable();
    });
</script>