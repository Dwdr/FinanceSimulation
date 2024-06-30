<a href="#" class="brand-link navbar-white">
    {{-- TODO fix org id later --}}

    {{--    @php $o = Auth::user()->profile->organization @endphp --}}

    {{--    <img src="@if (!is_null($o->logo_id)){{asset($o->logo->path.$o->logo->name)}}@else{{asset('vendor/adminlte-3.1.0/img/staymgt_logistics_logo.png')}}@endif" alt="" class="brand-image img-circle elevation-3"> --}}

    <img src="{{ asset('vendor/adminlte-3.1.0/dist/img/staymgt_logo.png') }}" alt=""
        class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-light">Financial Simulator</span>
</a>
