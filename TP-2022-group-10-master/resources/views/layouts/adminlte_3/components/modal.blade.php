@php
if(!isset($btn_class)){
    $btn_class = 'btn cur-p btn-danger';
}
@endphp

<a href="#" data-target="#{{ $modal_name }}" data-toggle="modal" class="{{$btn_class}}">{!! $btn_name !!} </a>

@push('body_end_scripts')
    <div class="modal fade" id="{{ $modal_name }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ $msg_heading }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ $msg_question }}
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-dismiss="modal">
                        {{ $btn_msg_no }}
                    </a>
                    @if($type==="delete")
                        <form></form>
                        <form action="{{ $url }}" method="post">
                            {{method_field('delete')}}
                            {{csrf_field()}}
                            <button class="btn btn-danger" type="submit" style="float: right;">
                                {{ $btn_msg_yes }}
                            </button>
                        </form>
                    @elseif($type==="logout")
                        <form></form>
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST">
                            {{ csrf_field() }}
                            <button class="btn btn-danger" type="submit" style="float: right;">
                                {{ $btn_msg_yes }}
                            </button>
                        </form>
                    @elseif($type==="submit")
                        <button class="btn btn-danger" type="submit" style="float: right;" onclick="{{$btn_onclick_yes}}" data-dismiss="modal">
                            {{ $btn_msg_yes }}
                        </button>
                    @else
                        <a href="{{ $url }}" class="btn btn-danger">
                            {{ $btn_msg_yes }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endpush
