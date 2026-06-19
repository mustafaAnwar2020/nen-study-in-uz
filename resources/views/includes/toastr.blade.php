<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/toastr/toastr.css')}}">
<script>

    @if(session()->has('message'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.success("{{ session('message') }}");
    @endif

        @if(session()->has('success'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.success("{{ session('success') }}");
    @endif

        @if(session()->has('error'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.error("{{ session('error') }}");
    @endif

        @if(session()->has('info'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.info("{{ session('info') }}");
    @endif

        @if(session()->has('warning'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.warning("{{ session('warning') }}");
    @endif


        @if($errors->any())
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }

    @foreach($errors->all() as $error)
    toastr.warning("{{ $error }}");
    @endforeach
    @endif

</script>
