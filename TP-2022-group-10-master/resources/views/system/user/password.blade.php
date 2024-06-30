{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')

@endsection

{{-- Title --}}
@section('html_title', __('auth.passwords.change-password'))
@section('page_title', __('auth.passwords.change-password'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">{{__('profile.profile')}}</a></li>
    <li class="breadcrumb-item active">{{__('auth.passwords.change-password')}}</li>
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <div class="row justify-content-md-center">
        <div class="col-lg-8 col-md-10">
            <form id="v_form" class="block form-horizontal form-label-left"
                  action="{{ route('profile.password.update') }}"
                  method="post">
                @csrf
                {{method_field('put')}}

                <div class="card">
                    <div class="card-body">

                        <x-inputs.text
                            type="password"
                            :label="__('auth.passwords.old-password')"
                            name="old_password"
                            :hints="__('auth.passwords.type-your-old-password-below-for-verification-purpose')"
                            required="true"
                        />

                        <x-inputs.text
                            type="password"
                            :label="__('auth.passwords.new-password')"
                            name="password"
                            :hints="__('auth.passwords.type-the-new-password-and-type-it-again-to-confirm')"
                            required="true"
                            min="8"
                        />

                        <x-inputs.text
                            type="password"
                            :label="__('auth.passwords.confirm-password')"
                            name="password_confirmation"
                            required="true"
                            min="8"
                        />

                    </div>
                    <div class="card-footer">
                        <a href="{{route('profile.index')}}" class="btn btn-secondary">{{__('auth.passwords.cancel')}}</a>
                        <button type="submit" class="btn btn-primary">{{__('auth.passwords.submit')}}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')

@endpush
