<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <a href="{{route('ssc.profile.index')}}" class="dropdown-item">
            @if(isset(Auth::user()->employee->avatar_file['file_path']))
                <img src="{{route('files',['s'=>Auth::user()->profile->organization->name_slug,'p'=>Auth::user()->employee->avatar_file['file_path'].Auth::user()->employee->avatar_file['file_name'],'fn'=>Auth::user()->employee->avatar_file['file_source_name'],'dl'=>false])}}" class="img-circle elevation-2" alt="user-avatar" />
            @else
                <img src="{{asset('/images/user.jpg')}}" class="img-circle elevation-2" alt="user-avatar"/>
            @endif
        </a>
    </div>
    <div class="info">
        @switch(Auth::user()->getRoleNames()[0])
            @case(config('constants.ROLE.JOBS-ADMIN'))
            <span class="badge badge-danger navbar-badge">Admin</span>
            @break
            @case(config('constants.ROLE.JOBS-EMPLOYER'))
            <span class="badge badge-info navbar-badge">Employer</span>
            {{ Auth::user()->jobs_employer->company_name }}<br>
            {{ Auth::user()->jobs_employer->uuid }}
            @break
            @case(config('constants.ROLE.JOBS-SEEKER'))
            <span class="badge badge-warning navbar-badge">Student</span>
            {{ Auth::user()->jobs_seeker->name }}
            @break
        @endswitch

        <br>
        <a href="{{route('ssc.profile.index')}}">
            <small>{{ __('View/Update Profile') }}</small>
        </a>
        <br>
        <a href="{{route('ssc.profile.password.index')}}">
            <small>{{ __('common.change-password') }}</small>
        </a>
    </div>
</div>
