{{-- Panel --}}
<a href="{{ route('eh.employee.create') }}" class="btn btn-primary">{{ __('eh/employee/index_panel.btn_create') }}</a>
<a href="{{ route('eh.personnel_change.index') }}" class="btn btn-primary float-right position-relative">
    {{ __('eh/employee/index_panel.btn_personnel_change') }}
    @if($personnel_change_count!=0)
        <span class="badge bg-danger">
            @if($personnel_change_count<=99)
                {{$personnel_change_count}}
            @else
                {{$personnel_change_count}}+
            @endif
        </span>
    @endif
</a>
