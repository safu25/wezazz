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
            {{{ trans('admin.admin') }}}
            <i class="fa fa-angle-right margin-separator"></i>
            {{{ trans('admin.theme') }}}
        </h4>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="content">

            <div class="row">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{{ trans('admin.theme') }}}</h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form class="form-horizontal" method="post" action="{{{ url('panel/admin/theme') }}}" enctype="multipart/form-data">

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

                        @if(session('error_max_upload_size'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <i class="fa fa-warning margin-separator"></i>  {{trans('general.max_upload_files', ['post_size' => ini_get("post_max_size")."B"] )}}
                        </div>
                        @endif

                        @include('errors.errors-forms')

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.home_style') }}</label>
                                <div class="col-sm-10">
                                    <div class="radio">
                                        <label class="padding-zero">
                                            <input type="radio" value="0" name="home_style" @if ($settings->home_style == 0) checked="checked" @endif checked>
                                            <img src="{{url('/public/img/homepage-1.jpg')}}">
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label class="padding-zero">
                                            <input type="radio" value="1" name="home_style" @if ($settings->home_style == 1) checked="checked" @endif>
                                            <img src="{{url('/public/img/homepage-2.jpg')}}">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->


                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.logo') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->logo)}}" class="logo-theme">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="logo" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.note_logo_white') }}</p>
                                    <p class="help-block">{{ trans('general.recommended_size') }} 487x144 px (PNG)</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer" id="fileContainerLogo">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.logo_blue') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->logo_2)}}" class="w-150">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="logo_2" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 487x144 px (PNG)</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer" id="fileContainerLogo">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Favicon</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->favicon)}}">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="favicon" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 48x48 px (PNG)</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.index_image_top') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->home_index)}}" class="w-200">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="index_image_top" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 884x592 px</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>

                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
<!--                                 {{ trans('general.index_image_top') }}
 -->                            </label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->home_index_s)}}" class="w-200">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="index_image_top_s" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block"></p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                               
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
<!--                                 {{ trans('general.index_image_top') }}
 -->                            </label>
                               
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->home_index_t)}}" class="w-200">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="index_image_top_t" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block"></p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.home_image_box') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="home_image_box" value="{{$settings->home_image_box}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>

                                <div class="col-sm-5">
                                    <input type="text" name="home_image_box_spanish" value="{{$settings->home_image_box_spanish}}" class="form-control">
                                    <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->                        
                        
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.home_image_desc_box') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="home_image_desc_box" value="{{$settings->home_image_desc_box}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>

                                <div class="col-sm-5">
                                    <input type="text" name="home_image_desc_box_spanish" value="{{$settings->home_image_desc_box_spanish}}" class="form-control">
                                    <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->

                        
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.home_image_box_2') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="home_image_box_2" value="{{$settings->home_image_box_2}}" class="form-control">
                                     <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="home_image_box_2_spanish" value="{{$settings->home_image_box_2_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                        
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.home_image_desc_box_2') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="home_image_desc_box_2" value="{{$settings->home_image_desc_box_2}}" class="form-control">
                                     <p class="help-block">For English lang</p>
                                </div>
                                 <div class="col-sm-5">
                                    <input type="text" name="home_image_desc_box_2_spanish" value="{{$settings->home_image_desc_box_2_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('admin.background') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->bg_gradient)}}" class="w-400">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="background" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 1441x480 px</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('admin.image_index_1') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->img_1)}}" class="w-120">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="image_index_1" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 120x120 px</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        
                         <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.index_1_card_1') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="index_1_card_1" value="{{$settings->index_1_card_1}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="index_1_card_1_spanish" value="{{$settings->index_1_card_1_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                         <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.index_1_desc_card_1') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="index_1_desc_card_1" value="{{$settings->index_1_desc_card_1}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="index_1_desc_card_1_spanish" value="{{$settings->index_1_desc_card_1_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('admin.image_index_2') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->img_2)}}" class="w-120">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="image_index_2" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 120x120 px</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                         <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.index_2_card_2') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="index_2_card_2" value="{{$settings->index_2_card_2}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="index_2_card_2_spanish" value="{{$settings->index_2_card_2_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                         <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.index_2_desc_card_2') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="index_2_desc_card_2" value="{{$settings->index_2_desc_card_2}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="index_2_desc_card_2_spanish" value="{{$settings->index_2_desc_card_2_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('admin.image_index_3') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->img_3)}}" class="w-120">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="image_index_3" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 120x120 px</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                          <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.index_3_card_3') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="index_3_card_3" value="{{$settings->index_3_card_3}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="index_3_card_3_spanish" value="{{$settings->index_3_card_3_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                         <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.index_3_desc_card_3') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="index_3_desc_card_3" value="{{$settings->index_3_desc_card_3}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="index_3_desc_card_3_spanish" value="{{$settings->index_3_desc_card_3_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                        
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('admin.image_index_4') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{url('/public/img', $settings->img_4)}}" class="w-120">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="image_index_4" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 362x433 px</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        
                          <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.index_4_card_4') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="index_4_card_4" value="{{$settings->index_4_card_4}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="index_4_card_4_spanish" value="{{$settings->index_4_card_4_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                         <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.index_4_desc_card_4') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="index_4_desc_card_4" value="{{$settings->index_4_desc_card_4}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="index_4_desc_card_4_spanish" value="{{$settings->index_4_desc_card_4_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                        @if ($settings->earnings_simulator == 'on')
                          <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.earnings_simulator_title') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="earnings_simulator_title" value="{{$settings->earnings_simulator_title}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="earnings_simulator_title_spanish" value="{{$settings->earnings_simulator_title_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                         <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.earnings_simulator_desc') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="earnings_simulator_desc" value="{{$settings->earnings_simulator_desc}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="earnings_simulator_desc_spanish" value="{{$settings->earnings_simulator_desc_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        @endif
                        

                           <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.home_box_title_last') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="home_box_title_last" value="{{$settings->home_box_title_last}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="home_box_title_last_spanish" value="{{$settings->home_box_title_last_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                         <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.home_desc_box_last') }}</label>

                                <div class="col-sm-5">
                                    <input type="text" name="home_desc_box_last" value="{{$settings->home_desc_box_last}}" class="form-control">
                                    <p class="help-block">For English lang</p>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" name="home_desc_box_last_spanish" value="{{$settings->home_desc_box_last_spanish}}" class="form-control">
                                     <p class="help-block">For Spanish lang</p>
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->
                        
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.avatar_default') }}</label>
                                <div class="col-sm-10">

                                    <div class="btn-block margin-bottom-10">
                                        <img src="{{ Helper::getFile(config('path.avatar').$settings->avatar) }}" class="w-200">
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="avatar" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 250x250 px</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.cover_default') }}</label>
                                <div class="col-sm-10">
                                    <div class="btn-block margin-bottom-10">
                                        <div style="max-width: 400px; height: 150px; display: block; border-radius: 6px; background: #505050 @if ($settings->cover_default) url('{{ Helper::getFile(config('path.cover').$settings->cover_default) }}') no-repeat center center; background-size: cover; @endif ;">
                                        </div>
                                    </div>

                                    <div class="btn btn-info box-file">
                                        <input type="file" accept="image/*" name="cover_default" class="filePhoto" />
                                        <i class="glyphicon glyphicon-cloud-upload myicon-right"></i>
                                        <span class="text-file">{{ trans('general.choose_image') }}</span>
                                    </div>

                                    <p class="help-block">{{ trans('general.recommended_size') }} 1500x800 px</p>

                                    <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
                                        <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                                        <small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle far fa-times-circle delete-image btn pull-right" title="{{ trans('general.delete') }}"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

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

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">@lang('admin.default_color'):</label>

                                <div class="col-sm-2">
                                    <div class="input-group my-colorpicker2">
                                        <div class="input-group-addon">
                                            <i></i>
                                        </div>
                                        <input type="text" name="color" value="{{$settings->color_default}}" class="form-control">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">@lang('general.navbar_background_color'):</label>

                                <div class="col-sm-2">
                                    <div class="input-group my-colorpicker2">
                                        <div class="input-group-addon">
                                            <i></i>
                                        </div>
                                        <input type="text" name="navbar_background_color" value="{{$settings->navbar_background_color}}" class="form-control">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">@lang('general.navbar_text_color'):</label>

                                <div class="col-sm-2">
                                    <div class="input-group my-colorpicker2">
                                        <div class="input-group-addon">
                                            <i></i>
                                        </div>
                                        <input type="text" name="navbar_text_color" value="{{$settings->navbar_text_color}}" class="form-control">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">@lang('general.footer_background_color'):</label>

                                <div class="col-sm-2">
                                    <div class="input-group my-colorpicker2">
                                        <div class="input-group-addon">
                                            <i></i>
                                        </div>
                                        <input type="text" name="footer_background_color" value="{{$settings->footer_background_color}}" class="form-control">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <!-- Color Picker -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">@lang('general.footer_text_color'):</label>

                                <div class="col-sm-2">
                                    <div class="input-group my-colorpicker2">
                                        <div class="input-group-addon">
                                            <i></i>
                                        </div>
                                        <input type="text" name="footer_text_color" value="{{$settings->footer_text_color}}" class="form-control">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('general.button_style') }}</label>
                                <div class="col-sm-10">
                                    <div class="radio">
                                        <label class="padding-zero">
                                            <input type="radio" value="rounded" name="button_style" @if ($settings->button_style == 'rounded') checked="checked" @endif checked>
                                            {{ trans('general.button_style_rounded') }}
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label class="padding-zero">
                                            <input type="radio" value="normal" name="button_style" @if ($settings->button_style == 'normal') checked="checked" @endif>
                                            {{ trans('admin.normal') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <hr>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right">{{{ trans('admin.save') }}}</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div>
            </div><!-- /.row -->

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

        </div><!-- /.content -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
