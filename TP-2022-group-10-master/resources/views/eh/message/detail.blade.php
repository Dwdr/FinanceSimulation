{{-- Parent Layout --}}
@extends('layouts.adminlte_3.panel_eh')

@section('html_head_style')
@endsection

{{-- Title --}}
@section('html_title', __('eh/message/detail.title_html'))
@section('page_title', __('eh/message/detail.title_page'))

@section('body_page_breadcrumb')
    <li class="breadcrumb-item active">{{ __('eh/message/detail.breadcrumb_level_1') }}</li>
    <li class="breadcrumb-item active"><a href="{{ route('eh.message.index') }}">{{ __('eh/message/detail.breadcrumb_level_2') }}</a></li>

    @if($mode['isModeCreate'])
        <li class="breadcrumb-item active">{{ __('eh/message/detail.breadcrumb_create') }}</li>
    @else
        @if($mode['isModeEdit'])
            <li class="breadcrumb-item active">{{ $b->id }} {{ $b->id }}</li>
            <li class="breadcrumb-item active">{{ __('eh/message/detail.breadcrumb_edit') }}</li>
        @else
            <li class="breadcrumb-item active">Demo</li>
        @endif
    @endif
@endsection

{{-- Body Main Content --}}
@section('body_main_content')

    <div class="row">
        <div class="col-md-3">
            <a href="{{route('eh.message.index')}}" class="btn btn-primary btn-block mb-3">Back to Inbox</a>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Folders</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a href="#" class="nav-link">
                                <i class="fas fa-inbox"></i> Inbox
                                <span class="badge bg-primary float-right">12</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-envelope"></i> Sent
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-file-alt"></i> Drafts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-filter"></i> Junk
                                <span class="badge bg-warning float-right">65</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-trash-alt"></i> Trash
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Labels</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="far fa-circle text-danger"></i> Important</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="far fa-circle text-warning"></i> Promotions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="far fa-circle text-primary"></i> Social</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <form id="v_form" enctype="multipart/form-data" class="block form-horizontal form-label-left"
                  action="@if(!$mode['isModeEdit']){{route('eh.message.store')}}@elseif($mode['isModeEdit']){{route('eh.message.update', $b->id)}}@endif"
                  method="post">
                @csrf
                @if($mode['isModeEdit'])
                    {{method_field('put')}}
                @endif
                <div class="card card-primary card-outline">
                    <div class="card-header">

                        @if($mode['isModeCreate'])
                            <h3 class="card-title">Compose New Message</h3>
                        @else
                            <h3 class="card-title">Read Mail</h3>

                            <div class="card-tools">
                                <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                                <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                            </div>
                        @endif

                    </div>
                    <!-- /.card-header -->
                    @if($mode['isModeCreate'])
                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control" placeholder="To:" name="to">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Subject:" name="subject">
                            </div>
                            <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" style="height: 300px" name="body">
                      <h1><u>Heading Of Message</u></h1>
                      <h4>Subheading</h4>
                      <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain
                        was born and I will give you a complete account of the system, and expound the actual teachings
                        of the great explorer of the truth, the master-builder of human happiness. No one rejects,
                        dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know
                        how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again
                        is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain,
                        but because occasionally circumstances occur in which toil and pain can procure him some great
                        pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise,
                        except to obtain some advantage from it? But who has any right to find fault with a man who
                        chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that
                        produces no resultant pleasure? On the other hand, we denounce with righteous indignation and
                        dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so
                        blinded by desire, that they cannot foresee</p>
                      <ul>
                        <li>List item one</li>
                        <li>List item two</li>
                        <li>List item three</li>
                        <li>List item four</li>
                      </ul>
                      <p>Thank you,</p>
                      <p>John Doe</p>
                    </textarea>
                            </div>
                            <div class="form-group">
                                <div class="btn btn-default btn-file">
                                    <i class="fas fa-paperclip"></i> Attachment
                                    <input type="file" name="attachment">
                                </div>
                                <p class="help-block">Max. 32MB</p>
                            </div>
                        </div>
                    @else
                        <div class="card-body p-0">
                            <div class="mailbox-read-info">
                                <h5>Message Subject Is Placed Here</h5>
                                <h6>From: support@adminlte.io
                                    <span class="mailbox-read-time float-right">15 Feb. 2015 11:03 PM</span></h6>
                            </div>
                            <!-- /.mailbox-read-info -->
                            <div class="mailbox-controls with-border text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                                        <i class="fas fa-share"></i>
                                    </button>
                                </div>
                                <!-- /.btn-group -->
                                <button type="button" class="btn btn-default btn-sm" title="Print">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-message">
                                <p>Hello John,</p>

                                <p>Keffiyeh blog actually fashion axe vegan, irony biodiesel. Cold-pressed hoodie chillwave put a bird
                                    on it aesthetic, bitters brunch meggings vegan iPhone. Dreamcatcher vegan scenester mlkshk. Ethical
                                    master cleanse Bushwick, occupy Thundercats banjo cliche ennui farm-to-table mlkshk fanny pack
                                    gluten-free. Marfa butcher vegan quinoa, bicycle rights disrupt tofu scenester chillwave 3 wolf moon
                                    asymmetrical taxidermy pour-over. Quinoa tote bag fashion axe, Godard disrupt migas church-key tofu
                                    blog locavore. Thundercats cronut polaroid Neutra tousled, meh food truck selfies narwhal American
                                    Apparel.</p>

                                <p>Raw denim McSweeney's bicycle rights, iPhone trust fund quinoa Neutra VHS kale chips vegan PBR&amp;B
                                    literally Thundercats +1. Forage tilde four dollar toast, banjo health goth paleo butcher. Four dollar
                                    toast Brooklyn pour-over American Apparel sustainable, lumbersexual listicle gluten-free health goth
                                    umami hoodie. Synth Echo Park bicycle rights DIY farm-to-table, retro kogi sriracha dreamcatcher PBR&amp;B
                                    flannel hashtag irony Wes Anderson. Lumbersexual Williamsburg Helvetica next level. Cold-pressed
                                    slow-carb pop-up normcore Thundercats Portland, cardigan literally meditation lumbersexual crucifix.
                                    Wayfarers raw denim paleo Bushwick, keytar Helvetica scenester keffiyeh 8-bit irony mumblecore
                                    whatever viral Truffaut.</p>

                                <p>Post-ironic shabby chic VHS, Marfa keytar flannel lomo try-hard keffiyeh cray. Actually fap fanny
                                    pack yr artisan trust fund. High Life dreamcatcher church-key gentrify. Tumblr stumptown four dollar
                                    toast vinyl, cold-pressed try-hard blog authentic keffiyeh Helvetica lo-fi tilde Intelligentsia. Lomo
                                    locavore salvia bespoke, twee fixie paleo cliche brunch Schlitz blog McSweeney's messenger bag swag
                                    slow-carb. Odd Future photo booth pork belly, you probably haven't heard of them actually tofu ennui
                                    keffiyeh lo-fi Truffaut health goth. Narwhal sustainable retro disrupt.</p>

                                <p>Skateboard artisan letterpress before they sold out High Life messenger bag. Bitters chambray
                                    leggings listicle, drinking vinegar chillwave synth. Fanny pack hoodie American Apparel twee. American
                                    Apparel PBR listicle, salvia aesthetic occupy sustainable Neutra kogi. Organic synth Tumblr viral
                                    plaid, shabby chic single-origin coffee Etsy 3 wolf moon slow-carb Schlitz roof party tousled squid
                                    vinyl. Readymade next level literally trust fund. Distillery master cleanse migas, Vice sriracha
                                    flannel chambray chia cronut.</p>

                                <p>Thanks,<br>Jane</p>
                            </div>
                            <!-- /.mailbox-read-message -->
                        </div>
                    @endif
                    <!-- /.card-body -->
                    @if($mode['isModeCreate'])
                    <div class="card-footer">
                        <div class="float-right">
                            <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Draft</button>
                            <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                        </div>
                        <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                    </div>
                    @else
                        <div class="card-footer bg-white">
                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Sep2014-report.pdf</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                          <span>1,245 KB</span>
                          <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                        </span>
                                    </div>
                                </li>
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> App Description.docx</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                          <span>1,245 KB</span>
                          <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                        </span>
                                    </div>
                                </li>
                                <li>
                                    <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i> photo1.png</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                          <span>2.67 MB</span>
                          <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                        </span>
                                    </div>
                                </li>
                                <li>
                                    <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i> photo2.png</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                          <span>1.9 MB</span>
                          <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                                <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
                            </div>
                            <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
                            <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                        </div>
                    @endif
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </form>
        </div>
        <!-- /.col -->
    </div>
@endsection

{{-- Body End Scripts --}}
@push('body_end_scripts')
    <script>
        $(function () {
            //Add text editor
            $('#compose-textarea').summernote()
        })
    </script>
@endpush
