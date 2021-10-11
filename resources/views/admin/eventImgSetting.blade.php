@extends('admin.layout')

@section('css')
<link href="{{{ asset('public/plugins/iCheck/all.css') }}}" rel="stylesheet" type="text/css" />
<link href="{{{ asset('public/plugins/colorpicker/bootstrap-colorpicker.min.css') }}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h4>
            {{ trans('general.admin_event_setting') }}
            <i class="fa fa-angle-right margin-separator"></i>
            {{ trans('general.admin_event_setting') }}
        </h4>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="content">

            <div class="row">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{{ trans('general.default_event_image') }}}</h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form class="form-horizontal" method="post" action="{{{ url('panel/admin/defaultEventImgUpload') }}}" enctype="multipart/form-data">

                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}">

                        @if(session('success_message'))
                        <div class="box-body">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <i class="fa fa-check margin-separator"></i> {{ session('success_message') }}
                            </div>
                        </div>
                        @endif

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.upload_event_image') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/uploads/default-event-image/', $settings->event_default_image)}}" id="blah" class="event-theme">
                                    </div>
                                    
                                    <input type="hidden" name="event_default_crop_image" id="event_default_crop_image">

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="event_default_image" id="uploadEventImg" class="" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer" id="fileContainerLogo">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right">{{{ trans('admin.save') }}}</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div>
                
            
                
            </div><!-- /.row -->
        </div><!-- /.content -->
        
            
                <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Crop Image 300*150</h5>
                        <button type="button" class="close close-inherit" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <div id="upload-demo" class="center-block"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
