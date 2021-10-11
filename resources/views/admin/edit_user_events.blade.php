@extends('admin.layout')

@section('content')


!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h4>
            {{ trans('admin.admin') }}
            <i class="fa fa-angle-right margin-separator"></i>
            {{ trans('admin.edit') }}

            <i class="fa fa-angle-right margin-separator"></i>
            {{ $data->name }}
        </h4>
    </section>


    <!-- Main content -->
    <section class="content">

        <div class="content">

            <div class="row ">
                <div class="col-md-11">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h2 class="box-title">{{ trans('admin.edit') }}</h>
                        </div><!-- /.box-header -->

                        <!-- form start -->
                        <form class="form-horizontal" method="POST" action="{{route('update_event')}}"
                            enctype="multipart/form-data">
                            @csrf


                            @include('errors.errors-forms')

                            <input type="hidden" name="id" value="{{$data->id}}" id="id">
                            <!-- Start Box Body -->
                            <div class="box-body ">
                                <div class="form-group ">

                                    <div class="col-sm-10">

                                        @if($data->event_img != '')
                                        <img src="{{Helper::getFile(config('path.event').$data->event_img)}}"
                                            width="400" height="200" id="blah" style="margin-left: 180px;" />
                                        @else
                                        <img src="{{url('/public/uploads/default-event-image/', $settings->event_default_image)}}"
                                            width="400" height="200" style="margin-left: 180px;" id="blah"/>
                                        @endif
                                        <div style="margin-top: 15px; text-align: center;">

                                            <i class="fas fa-camera fa-2x"> <input type="file" name="event_img"
                                                    class="form-control" id="imgInp"><span></i></span>
                                        </div>


                                    </div>
                                </div>
                            </div><!-- /.box-body -->


                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{trans('general.event_cost')}} :</label>
                                    <div class="col-sm-6">
                                        <select name="event_cost" class="form-control browser-default mb-3"
                                            id="price_show">
                                            <option @if ($data->event_cost=='free') selected @endif  value="free">Free</option>
                                            <option @if($data->event_cost=='paid') selected @endif  value="paid">Paid</option>
                                        </select>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body" @if($data->event_cost=='free') style="display:none" @endif id="event-price">
                                <div class="col-sm-4" style="margin-left: 145px;" id="event-price">
                                    <input class="form-control isNumber" autocomplete="off" name="event_price"
                                        type="text" value="{{$data->event_price}}">
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.event_name') }} :</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="event_name" id="" class="form-control"
                                            value="{{$data->event_name}}">
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.start_date') }} :</label>
                                    <div class="col-sm-6">
                                        <input type="text"  name="start_date"
                                            id="date_input" class="form-control datepicker" value="{{$data->start_date}}"
                                            placeholder="{{trans('general.start_time')}}">
                                           
                                    </div>

                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.duration') }} :</label>
                                    <div class="col-sm-6">
                                        <select id="end-date" value="{{$data->end_date}}" name="end_date"
                                            class="form-control browser-default mb-3">
                                
                                            <option @if($data->end_date=='0.5') selected @endif value="0.5">0.5 hr</option>
                                            <option @if($data->end_date=='1') selected @endif value="1">1 hr</option>
                                            <option @if($data->end_date=='1.5') selected @endif value="1.5">1.5 hr</option>
                                            <option @if($data->end_date=='2') selected @endif value="2">2 hr</option>
                                            <option @if($data->end_date=='2.5') selected @endif value="2.5">2.5 hr</option>
                                            <option @if($data->end_date=='3') selected @endif value="3">3 hr</option>
                                            <option @if($data->end_date=='3.5') selected @endif value="3.5">3.5 hr</option>
                                            <option @if($data->end_date=='4') selected @endif value="4">4 hr</option>
                                            <option @if($data->end_date=='4.5') selected @endif value="4.5">4.5 hr</option>
                                            <option @if($data->end_date=='5') selected @endif value="5">5 hr</option>
                                            <option @if($data->end_date=='5.5') selected @endif value="5.5">5.5 hr</option>
                                            <option @if($data->end_date=='6') selected @endif value="6">6 hr</option>
                                        </select>

                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.end_date') }} :</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="duration" 
                                            class="form-control datepicker" value="{{$data->duration}}">
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.event_place') }} :</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="event_place" id="" class="form-control"
                                            value="{{$data->event_place}}">
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.event_type') }} :</label>
                                    <div class="col-sm-6">

                                        <select id="event-type" name="event_type"
                                            class="form-control browser-default mb-3">
                                            <option value="{{$data->event_type}}">{{$data->event_type}}</option>
                                            @foreach (Categories::where('mode','on')->orderBy('name')->get() as
                                            $category)
                                            <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <!-- Start Box Body -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin.event_details') }} :</label>
                                    <div class="col-sm-6">
                                        <textarea name="event_details" id="" cols="5" rows="5"
                                            class="form-control">{{$data->event_details}}</textarea>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->



                            <div style=" margin-left: 225px; padding-bottom: 100px; padding: 20px;">
                                <a href="{{ url('panel/admin/users_events') }}" class="btn btn-default">{{
                                    trans('admin.cancel') }}</a> &nbsp;
                                <button type="submit" class="btn btn-success form-control" style="width: 170px;">{{
                                    trans('admin.save') }}</button>

                            </div>

                        </form>
                    </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('javascript')
<script src="{{ asset('public/datetime/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('public/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>


<script>
    $(document).ready(function () {

        $(function () {
        $('.datepicker').datetimepicker({
            format: "yyyy-mm-dd ",
            autoclose: true,
            startDate: new Date(),
            onShow: function (ct) {
                this.setOptions({
                    maxDate: $('#end').val() ? $('#end').val() : false
                })
            },
        });

    });

    //end 
    
        $('#price_show').on('change', function () {
            if (this.value == 'paid') {
                $("#event-price").show();
            }
            else {
                $("#event-price").hide();
            }
        });


        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }

     
    });
   

</script>

@endsection