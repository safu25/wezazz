@extends('admin.layout')

@section('css')
<link href="{{ asset('public/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h4>
            {{ trans('admin.admin') }}
            <i class="fa fa-angle-right margin-separator"></i>
            {{ trans('admin.data_connection') }}
        </h4>
    </section>

    <!-- Main content -->
    <section class="content">

        @if (session('success_message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check margin-separator"></i> {{ session('success_message') }}
        </div>
        @endif


        <div class="content">

            <div class="row">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.data_connection') }}</h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form class="form-horizontal" method="POST" action="{{ url('panel/admin/settings/database') }}"
                        enctype="multipart/form-data">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('errors.errors-forms')

                           <!-- url Box Body -->
                           <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('admin.app_url')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ env('APP_URL') }}" name="APP_URL" class="form-control"
                                        placeholder="Enter Project URL">
                                </div>
                            </div>
                        </div><!-- /.box-body -->


                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('admin.app_name')}}</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ env('APP_NAME') }}" name="app_name"
                                        class="form-control" placeholder="Enter App Name">
                                </div>
                            </div>
                        </div><!-- /.box-body -->


                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('admin.app_env')}}</label>
                                <div class="col-sm-10">
                                    <select name="APP_ENV" id="app_env" class="form-control custom-select">
                                        <option @if (env('APP_ENV')=='devlopment' ) selected @endif value="devlopment">
                                            devlopment</option>
                                        <option @if (env('APP_ENV')=='production' ) selected @endif value="production">
                                            production</option>
                                        <option @if (env('APP_ENV')=='local' ) selected @endif value="local">local
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                      
                          <!-- this is pending -->
                        <!-- Start Box Body -->
                        <!-- <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{trans('admin.app_debug')}}</label>
                                <div class="col-sm-10">
                                    <select name="APP_DEGUB" id="app_env" class="form-control custom-select">
                                        <option @if (env('APP_DEBUG')=='true' ) selected @endif value="true">
                                            true</option>
                                        <option @if (env('APP_DEBUG')=='false' ) selected @endif value="false">
                                           false</option>
                                    
                                    </select>
                                </div>
                            </div>
                        </div>/.box-body -->
                        <!-- this is pending -->
                            <div style="padding: 15px;">
                                <button type="submit" class="btn btn-success" >{{ trans('admin.save') }}</button>

                            </div>
                </div><!-- /.box-footer -->
                </form>

            </div>
        </div><!-- /.row -->
</div><!-- /.content -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection