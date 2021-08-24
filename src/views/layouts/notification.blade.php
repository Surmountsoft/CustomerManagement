<script src="{{asset('assets/admin/assets/js/toaster.min.js')}}"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<script>
    @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
    @endif

    @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
    @endif

    @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
    @endif
</script>
