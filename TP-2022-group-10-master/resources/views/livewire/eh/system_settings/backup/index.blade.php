<div>

    @include('layouts.adminlte_3.components.alert')

    <livewire:e-h.system-settings.backup.index-panel/>

    <div class="card">
        <div class="card-body">

            <div class="overlay-wrapper loading" wire:loading wire:target="restore">
                <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                    <div class="text-bold pt-2"> {{__('common.loading')}}</div>
                </div>
            </div>

            <table class="table table-hover mb-4">
                <thead>
                <tr>
                    <th scope="col">{{__('eh/settings/backup/index.th_datetime')}}</th>
                    <th scope="col">{{__('eh/settings/backup/index.th_action')}}</th>
                </tr>
                </thead>
                <tbody>
                @if(sizeof($backup)>0)
                    @foreach($backup as $b)
                        <tr>
                            <th scope="row">{{$b->created_at}}</th>
                            <td>
                                <a class="btn btn-warning" href="{{route('files',['s'=>Auth::user()->profile->organization->name_slug,'p'=>$b->file['file_path'].$b->file['file_name'],'fn'=>$b->file['file_source_name'],'dl'=>true])}}">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <button class="btn btn-info" data-toggle="modal" data-target="#restoreModal_{{$loop->index}}"><i class="fas fa-history"></i> Restore</button>

                                <!-- Modal -->
                                <div class="modal fade" id="restoreModal_{{$loop->index}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="restoreModalLabel">Restore</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Warning: this is an unrecoverable action, please make sure the schema version match to your current system design.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary" wire:click.prevent="restore('{{$b->uuid}}')" data-dismiss="modal">Understand, restore now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">No any backup</td>
                    </tr>
                @endif
                </tbody>
            </table>

            <div class="d-flex">
                <div class="m-auto">
                    {{$backup->links()}}
                </div>
            </div>

        </div>
    </div>
</div>
