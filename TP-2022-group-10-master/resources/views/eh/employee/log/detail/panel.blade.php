{{-- Panel --}}
@if($mode['isModeShow'])
    <a href="{{ route('eh.employee.show',['employee'=>$log->employee_uuid,'tab'=>'timeline']) }}" class="btn cur-p btn-secondary">{{ __('eh/employee/detail_panel.btn_back') }}</a>
@endif
{{csrf_field()}}
