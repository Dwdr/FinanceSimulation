<div>

    @include('layouts.adminlte_3.components.alert')

    @hasanyrole(config('constants.ROLE.ADMIN').'|'.config('constants.ROLE.SUPER_ADMIN'))

    <h5 class="mb-2">Company</h5>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-center">
                    Company Information
                </div>
                <div class="card-body text-center">
                    <a class="btn bg-olive w-50" href="{{route('eh.system_settings.company.show',Auth::user()->profile->organization_id)}}">
                        Config
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-center">
                    User Role
                </div>
                <div class="card-body text-center">
                    <button class="btn bg-olive w-50" disabled>
                        TODO
                    </button>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mb-2">Emails</h5>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-center">
                    Email Template
                </div>
                <div class="card-body text-center">
                    <a class="btn bg-olive w-50" href="{{route('eh.system_settings.email_template.index')}}">
                        Config
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-center">
                    Email Notification
                </div>
                <div class="card-body text-center">
                    <a class="btn bg-olive w-50" href="{{route('eh.system_settings.email_notification.show',Auth::user()->profile->organization_id)}}">
                        Config
                    </a>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mb-2">System</h5>

    <div class="row">

        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-center">
                    Queue Processor
                </div>
                <div class="card-body text-center">
                    <a class="btn bg-olive w-50" href="{{route('eh.system_settings.queue.index')}}">
                        View
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <livewire:e-h.system-settings.test-email/>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header text-center">
                    Backups
                </div>
                <div class="card-body text-center">
                    <a class="btn bg-olive w-50" href="{{route('eh.system_settings.backup.index')}}">
                        Config
                    </a>
                </div>
            </div>
        </div>
    </div>

    @endhasanyrole

</div>
