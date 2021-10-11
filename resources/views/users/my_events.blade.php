@extends('layouts.app')

@section('title') {{trans('general.my_events')}} -@endsection



@section('content')


<div class="container">

    <div class="row justify-content-center text-center mb-sm"  style="margin-top: 100px;">
        <div class="col-lg-12 py-5">

            @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>

            @endif

            <h2 class="mb-0 text-break">{{trans('general.my_events')}}</h2>
            <p class="lead text-muted mt-0">

            </p>
            @if(Session::has('success'))
            <span style="color: green; font-size:20px; margin-top:50px;">
                <p>{{ Session::get('success') }}</p>
            </span>
            @endif

        </div>
    </div>

    <div class="row">

        @if (auth()->check())

        @foreach($events as $response)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card card-updates h-100">

                <button style="font-family: poppins;" class="deletebtn btn btn-primary" type="button"
                    data-toggle="modal" value="{{ $response->id}}">{{trans('admin.delete_event_msg')}}</button>

                <a href="{{url('events/')}}/{{$response->id}}" target="_blank">

                    <div class="card-cover"
                        style="background: @if ($response->event_img != '') url({{ Helper::getFile(config('path.event').$response->event_img) }}) @else url({{url('/public/uploads/default-event-image/', $settings->event_default_image)}}) @endif #505050 center center; background-size: cover;">


                        <span class="badge-free px-2 py-1 text-uppercase position-absolute rounded"
                            style="margin-top: 44px;">
                            @if($response->event_cost == 'free')

                            {{$response->event_cost}}

                            @else
                            {{Helper::amountFormatDecimal($response->event_price)}}
                            @endif
                        </span>
                    </div>
                </a>

                <div class="card-body card-body-event" style="height: 310px; word-spacing: 5px;">


                    <?php
                  //      echo date('Y-m-d H:i');
//                        echo '<br>';
//                        echo $parsed_date->diffInMinutes(); 
                        ?>

                    <!-- changes for edit -->
                   
                    <h6 class="text-right" >
                                 <button href="" style="width: 50px; padding: 10px;" type="button" value="{{ $response->id}}"
                                class="editbtn btn btn-primary " data-toggle="modal" data-target="#editeventForm">
                               {{trans('general.edit')}}
                            </button></h6>
                        
                            <h6 class="m-0 pb-1 text-muted card-text">
                                <i class="fa fa-calendar-alt mr-1" aria-hidden="true"></i> {{ $response->start_date
                                }}
                            </h6>
                    

                    <h6 class="m-0 pb-1 text-muted card-text">
                        <i class="fa fa-clock mr-1" aria-hidden="true"></i> {{ $response->end_date }} hours
                    </h6>


                    <h6 class="m-0 pb-1 text-muted card-text">
                        <i class="far fa-calendar-alt mr-1" aria-hidden="true"></i> {{ $response->event_name }}
                    </h6>
                    <h6 class="m-0 pb-1 text-muted card-text">
                        <i class="fa fa-globe mr-1" aria-hidden="true"></i> {{ $response->event_type }}
                    </h6>


                    <h6 class="m-0 py-1 text-muted card-text">
                        <i class="fa fa-map-marker-alt mr-1" aria-hidden="true"></i> {{ $response->event_place }}
                    </h6>


                    <h6 class="m-0 py-1 text-muted card-text">
                        <i class="fas fa-info-circle mr-1" aria-hidden="true"></i> {{ $response->event_details }}
                    </h6>


                    <div id="showCountedInterest_{{$response->id}}" style="line-height: 30px; margin: 2px;">
                        @foreach (DB::table('event_interest')->select('interest', DB::raw('count(interest) as
                        count'))->where('event_id', $response->id)->where('event_user_id',
                        $response->user_id)->groupBy('interest')->get() as $event_interest)
                        <small class="m-0  pb-3 text-muted card-text">
                            @if($event_interest->interest == 'interested')
                            <i class="fa fa-circle pb-3" aria-hidden="true" style="font-size: 4px;"></i>
                            {{$event_interest->count}} {{trans('general.interested')}} @endif



                            @if($event_interest->interest == 'going')
                            <i class="fa fa-circle pb-3" aria-hidden="true" style="font-size: 4px;"></i>
                            {{ $event_interest->count }} {{trans('general.going')}} @endif

                        </small>
                        @endforeach
                    </div>



                    @php
                    $parsed_date = \Carbon\Carbon::parse($response->start_date);
                    if ($parsed_date->diffInMinutes() <= 15 || ($response->start_date <= date('Y-m-d H:i') &&
                            $response->duration >= date('Y-m-d H:i'))) {
                            $display = '';
                            }else {

                            $display = 'disabled';
                            }

                            if($response->duration >= date("Y-m-d H:i")){
                            $show = '';
                            }else {
                            $show = 'none';
                            }

                            @endphp


                            <a href="{{url('/eventLiveStreaming/'.$response->id)}}" style="float:left;display:{{$show}}"
                                class="card-event">
                                <button id="start-event-btn" class="btn btn-primary mt-2" {{$display}}> START Event
                                </button>
                            </a>

                            @php

                            if($response->duration >= date("Y-m-d H:i")){
                            $show = '';
                            }else {
                            $show = 'none';
                            }
                            @endphp

                            @if (auth()->user()->verified_id == 'yes')
                            <!--                        <button class="btn btn-google mt-1" title="{{trans('general.share')}}" id="dropdownUserShare" role="button" data-toggle="modal" data-target=".share-modal" style="float:right;display:{{$show}}">-->
                            <button class="btn btn-google mt-1 card-btn" id="dropdownUserShare" role="button"
                                onclick="shareEvent('{{$response->id}}','{{ e( auth()->user()->hide_name == 'yes' ? auth()->user()->username : auth()->user()->name ) }}')"
                                style="float:right;display:{{$show}}">
                                <i class="far fa-share-square mr-1 mr-lg-0"></i>
                                <!--                            <span class="d-lg-none">{{trans('general.share')}}</span>-->
                            </button>

                            @endif



                </div>
            </div><!-- End Card -->

        </div><!-- end col-md-4 -->
        @endforeach

        <!-- Share modal -->

        <div class="modal fade share-modal" id="share-event-modal" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mySmallModalLabel">{{trans('general.share')}}</h5>
                        <button type="button" class="close close-inherit" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 col-6 mb-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{url('events/1')}}"
                                        id="facebook_href" title="Facebook" target="_blank"
                                        class="social-share text-muted d-block text-center h6">
                                        <i class="fab fa-facebook-square facebook-btn"></i>
                                        <span class="btn-block mt-3">Facebook</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-6 mb-3">
                                    <a href="https://twitter.com/intent/tweet?url={{url('events/1')}}&text={{ e( auth()->user()->hide_name == 'yes' ? auth()->user()->username : auth()->user()->name ) }}"
                                        data-url="{{url('events/1')}}" id="twitter_href"
                                        class="social-share text-muted d-block text-center h6" target="_blank"
                                        title="Twitter">
                                        <i class="fab fa-twitter twitter-btn"></i> <span
                                            class="btn-block mt-3">Twitter</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-6 mb-3">
                                    <a href="whatsapp://send?text={{url('events/1')}}"
                                        data-action="share/whatsapp/share" id="whatsapp_href"
                                        class="social-share text-muted d-block text-center h6" title="WhatsApp">
                                        <i class="fab fa-whatsapp btn-whatsapp"></i> <span
                                            class="btn-block mt-3">WhatsApp</span>
                                    </a>
                                </div>

                                <div class="col-md-4 col-6 mb-3">
                                    <a href="mailto:?subject={{ e( auth()->user()->hide_name == 'yes' ? auth()->user()->username : auth()->user()->name ) }}&amp;body={{url('events/1')}}"
                                        id="mail_href" class="social-share text-muted d-block text-center h6"
                                        title="{{trans('auth.email')}}">
                                        <i class="far fa-envelope"></i> <span
                                            class="btn-block mt-3">{{trans('auth.email')}}</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-6 mb-3">
                                    <a href="sms://?body={{ trans('general.check_this') }} {{url('events/1')}}"
                                        id="sms_href" class="social-share text-muted d-block text-center h6"
                                        title="{{ trans('general.sms') }}">
                                        <i class="fa fa-sms"></i> <span class="btn-block mt-3">{{
                                            trans('general.sms') }}</span>
                                    </a>
                                </div>
                                <div class="col-md-4 col-6 mb-3">
                                    <a href="javascript:void(0);" id="btn_copy_url"
                                        class="social-share text-muted d-block text-center h6 link-share"
                                        title="{{trans('general.copy_link')}}">
                                        <i class="fas fa-link"></i> <span
                                            class="btn-block mt-3">{{trans('general.copy_link')}}</span>
                                    </a>
                                    <input type="hidden" readonly="readonly" id="copy_link" class="form-control"
                                        value="{{url('events/1')}}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Share modal end -->

        @endif


    </div>
</div>
</section>



<!-- Modal -->
<!-- MODEL FOR UPDATE EVENTS -->

@include('includes.update_event')
<!-- END UPDATE MODEL  ---- -->


<!-- MODEL FOR DELETE MODEL -->
@include('includes.delete_event')
<!-- END DELETE MODEL -->

@endsection

@section('javascript')

<!-- <script>
    function previewFile(input)
    {
       var file=$("input[type=file]").get(0).files[0];
       if(file)
       {
           var reader = new  FileReader();
           reader.onload = function(){
               $('#previewimage').attr("src",reader.result);
           }
           reader.readAsDataURL(file);
       }
    }
</script> -->

<script>

    // UPDATE SCRIPT ----->
    $(document).ready(function () {

       

        $(function () {
            $('#start').datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                autoclose: true,
                startDate: new Date(),
                onShow: function (ct) {
                    this.setOptions({
                        maxDate: $('#end').val() ? $('#end').val() : false
                    })
                },
            });

        });

      
      

        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();

            var event_id = $(this).val();

            // alert(event_id);
            $('#editeventForm').modal('show');

            $.ajax({
                type: "GET",
                url: "showevent/" + event_id,

                success: function (response) {
                    //console.log(response.events.event_name);
                    if (response.status == 404) {
                        alert(response.msg);
                        $('#editeventForm').modal('hide');

                    }
                    else {
                        if (response.events.event_img) {

                            $('#store_event').html("<img src={{asset('public/uploads/event')}}/" + response.events.event_img + " width='498px' height='200px' />");
                        }
                        else {

                            $('#store_event').html("<img src={{asset('public/uploads/default-event-image/2b9d0f5d-31628081920pnhy3lxusq.png')}}  width='498px' height='200px' />");
                        }

                        $('#cost').val(response.events.event_cost);
                        $('#price').val(response.events.event_price);
                        $('#name').val(response.events.event_name);
                        $('#start').val(response.events.start_date);
                        $('#end-date').val(response.events.end_date);
                        $('#event-place').val(response.events.event_place);
                        $('#event-type').val(response.events.event_type);
                        $('#event_detail').val(response.events.event_details);
                        $('#event_id').val(event_id);
						
						
						  if(response.events.event_cost == 'free')
                        {
                            $("#cost-price").hide();
                            
                        }
                        else{

                            $('#cost').on('change', function () {
                            if (this.value == 'paid') {
                                $("#cost-price").show();
                            }
                            else {
                                $("#cost-price").hide();
                            }
                        });


                    }
					
				}

                }

            });

        });
        // END UPDATE --------->

        //DELETE EVENT ------>
        $(document).on('click', '.deletebtn ', function () {

            var event_id = $(this).val();
            //   alert(event_id);
            $('#deleteEvent').modal('show');
            $('#deleting_id').val(event_id);

        });
        //end delete event


    });
</script>


<!--<script type="text/javascript">
   
window.onload = function () {
    
    @if(Session::has('success'))
        var message = Session::get('success');
        toastr.success(message);
     @endif
    }
    
</script>-->

<!-- <script>
    $(document).ready(function(){

       $('#editeventForm').on('show.bs.modal', function (event) {

//  console.log("i m so happy");

var button = $(event.relatedTarget)

var id = button.data('id') 
var cost = button.data('cost') 
var name = button.data('name') 
var startdate = button.data('startdate') 
var enddate = button.data('enddate')
var event_place = button.data('event_place') 
var event_type = button.data('event_type')

var modal = $(this)

modal.find('.modal-body #event_id').val(id);
modal.find('.modal-body #cost').val(cost);
modal.find('.modal-body #name').val(name);
modal.find('.modal-body #start_date').val(startdate);
modal.find('.modal-body #end-date').val(enddate);
modal.find('.modal-body #event-place').val(event_place);
modal.find('.modal-body #event-type').val(event_type);

})
})
</script> -->




@endsection