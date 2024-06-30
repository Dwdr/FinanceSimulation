<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <a href="{{ route('ssc.profile.index') }}" class="dropdown-item">
            @if (isset(Auth::user()->employee->avatar_file['file_path']))
                <img src="{{ route('files', ['s' => Auth::user()->profile->organization->name_slug, 'p' => Auth::user()->employee->avatar_file['file_path'] . Auth::user()->employee->avatar_file['file_name'], 'fn' => Auth::user()->employee->avatar_file['file_source_name'], 'dl' => false]) }}"
                    class="img-circle elevation-2" alt="user-avatar" />
            @else
                <img src="{{ asset('/images/user.jpg') }}" class="img-circle elevation-2" alt="user-avatar" />
            @endif
        </a>
    </div>
    <div class="info">
        {{ App::getLocale() != 'en-GB' ? Auth::user()->employee->chinese_name ?? Auth::user()->employee->first_name . ' ' . Auth::user()->employee->last_name : Auth::user()->employee->first_name . ' ' . Auth::user()->employee->last_name }}
        {{-- <br>
        <a href="{{ route('ssc.profile.index') }}">
            <small>{{ __('View/Update Profile') }}</small>
        </a> --}}
        {{-- <br> --}}
        {{-- <a href="{{route('ssc.profile.password.index')}}">
            <small>{{ __('common.change-password') }}</small>
        </a> --}}
    </div>
</div>
