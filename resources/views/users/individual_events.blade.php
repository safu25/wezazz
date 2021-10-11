@extends('layouts.app')

@section('title'){{ $events->event_name }} -@endsection
@section('css')


<meta property="og:type" content="website" />
<meta property="og:image:width" content="350" />
<meta property="og:image:height" content="200" />

<!-- Current locale and alternate locales -->
<meta property="og:locale" content="en_US" />
<meta property="og:locale:alternate" content="es_ES" />

<!-- Og Meta Tags -->
<link rel="canonical" href="{{url('/events/'.$events->id)}}" />
<meta property="og:site_name" content="{{$settings->title}}" />
<meta property="og:url" content="{{url('/events/'.$events->id)}}" />
<!--  <meta property="og:image" content="https://webmobdemo.xyz/sponzydev/sponzy/public/uploads/event/12304f66-141627459960btlv6kpyv6.png"/>-->
<meta property="og:image"
    content="@if($events->event_img != ''){{Helper::getFile(config('path.event').$events->event_img)}}@else{{url('/public/uploads/default-event-image', $settings->event_default_image)}}@endif" />

<meta property="og:title" content="{{ $events->event_name }}" />
<meta property="og:description" content="Show this Event" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image"
    content="@if($events->event_img != ''){{Helper::getFile(config('path.event').$events->event_img)}}@else{{url('/public/uploads/default-event-image', $settings->event_default_image)}}@endif" />
<meta name="twitter:title" content="{{ $events->event_name }}" />
<meta name="twitter:description" content="Show this Event" />

@endsection

@section('content')
<section class="section section-sm">
    <div class="container">

        <div class="row justify-content-center text-center mb-sm">
            <div class="col-lg-12  pt-5 pb-3">

                @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>

                @endif

                <h2 class="mb-0 text-break text-uppercase ">{{$events->event_name}}</h2>
                <p class="lead text-muted mt-0">

                </p>
                @if(Session::has('success'))
               <span style="color: green;"> <p>{{ Session::get('success') }}</p></span>
                @endif

            </div>
        </div>



        @php
        $user = DB::table('users')->where('id', '=', $events->user_id)->where('status', 'active')->first();
        @endphp


        <div class="row">



            <div class="col-lg-7" style="margin:0px auto;">
                <div class="card card-updates">
                    <div class="card-cover"
                        style="background: @if ($events->event_img != '') url({{ Helper::getFile(config('path.event').$events->event_img) }}) @else url({{url('/public/uploads/default-event-image', $settings->event_default_image)}}) @endif #505050 center center; background-size: cover; height:300px;">
                      
                     <!-- condition for user create or not event change by saifali -->
                     @if(auth()->user() && $events->user_id == auth()->user()->id)

                        <button   class="deletebtn btn btn-primary" type="button" data-toggle="modal" 
                       value="{{ $events->id}}" >{{trans('admin.delete_event_msg')}}</button>   
                    
                    @endif

                        <span class="badge-free px-2 py-1 text-uppercase position-absolute rounded">
                            @if($events->event_cost == 'free')

                            {{$events->event_cost}}

                            @else
                            {{Helper::amountFormatDecimal($events->event_price)}}
                            @endif

                        </span>
                    </div>

                    <div class="card-body card-body-event2">

                        <img src="@if ($events->event_img != ''){{ Helper::getFile(config('path.event').$events->event_img) }} @else {{url('/public/uploads/default-event-image', $settings->event_default_image)}} @endif"
                            width="300" height="150" style='display:none;'>

                        <div style="padding: 10px;">
                            <div class="row">
                                <div class="pr-5 pl-3">
                                    <h5> {{ date('M', strtotime($events->start_date)) }} </h5>
                                    <!-- class="text-muted" -->
                                    <h4>{{ date('d', strtotime($events->start_date)) }} </h4>
                                </div>
                                
                           <div>
                            <div class="" style="width: 500px; display: flex; column-gap: 300px;">
                                <h5  value="{{$events->event_name}}">
                                    {{ $events->event_name }} <br>
                                    <small>Host By
                                        <a href="{{url($user->username)}}">
                                            {{ e( $user->hide_name == 'yes' ? $user->username : $user->name ) }}
                                        </a>
                                    </small>
                                </h5>

                                <!-- condition for user create or not event change by saifali -->
                             @if(auth()->user() && $events->user_id == auth()->user()->id)

                                <div>
                                    <button  type="button" style="width: 60px; padding: 10px;"  class="edittbtn btn btn-primary "
                                    data-toggle="modal"  data-target="#editeventForm" value="{{ $events->id}}">
                                      {{trans('general.edit')}}
                                    </button>
                                </div>

                            @endif
                     
                            </div>
                            
                           </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-calendar-alt mr-1" aria-hidden="true"></i>

                                    <span> {{ date('d', strtotime($events->start_date)) }} {{ date('M',
                                        strtotime($events->start_date)) }}, {{ date('h:i a',
                                        strtotime($events->start_date)) }}</span>

                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-clock mr-1" aria-hidden="true"></i> {{ $events->end_date }} hours
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-globe mr-1" aria-hidden="true"></i> {{ $events->event_type }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fa fa-map-marker-alt mr-1" aria-hidden="true"></i> {{ $events->event_place
                                    }}
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <i class="fas fa-info-circle mr-1" aria-hidden="true"></i> {{ $events->event_details
                                    }}
                                </div>
                            </div>
                            <hr>

                        </div>

                        <?php // echo date('Y-m-d H:i'); ?>

                        <div id="showCountedInterest_{{$events->id}}" style=>
                            @foreach (DB::table('event_interest')->select('interest', DB::raw('count(interest) as
                            count'))->where('event_id', $events->id)->where('event_user_id',
                            $events->user_id)->groupBy('interest')->get() as $event_interest)
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

                        <!--        <a href="javascript:void(0);" class="btn btn-1 btn-sm btn-outline-primary">{{trans('general.interested')}}</a>-->
                        @php
                        if (auth()->check()){
                        $checkPayPerEvent = auth()->user()->payPerViewEvent()->where('events_id', $events->id)->first();
                        if ($checkPayPerEvent) {
                        $display = 'none';
                        }else {

                        $display = 'inline-block';
                        }
                        } else {
                        $display = 'inline-block';
                        }
                        @endphp


                        @if($events->event_cost == 'paid' && auth()->check())
                        <div id="overlay-for-event" class="card-event" style="display:{{$display}}">
                            <button class="btn btn-primary mt-2" id='event-overlay-btn' data-toggle="modal"
                                data-target="#payPerEventForm" data-mediaid="{{$events->id}}"
                                data-price="{{Helper::amountFormatDecimal($events->event_price)}}"
                                data-pricegross="{{$events->event_price}}">
                                <i class="feather icon-unlock mr-1"></i>{{ trans('general.unlock_event_for') }}
                                {{Helper::amountFormatDecimal($events->event_price)}}
                            </button>
                        </div>
                        @elseif($events->event_cost == 'paid')

                        <div id="overlay-for-event" class="card-event" style="display:{{$display}}">
                            <a href="{{url('individual_event/'.$events->id)}}" id='event-overlay-btn'
                                class="btn btn-primary mt-2" id='event-overlay-btn'>
                                <i class="feather icon-unlock mr-1"></i>{{ trans('general.unlock_event_for') }}
                                {{Helper::amountFormatDecimal($events->event_price)}}
                            </a>
                        </div>

                        @endif

                        @if(auth()->check())
                        <div class="dropdown card-event" style="float:left;">
                            @php
                            $eventsInterest = DB::table('event_interest')->where('event_id',
                            $events->id)->where('event_user_id', $events->user_id)->where('user_id',
                            auth()->user()->id)->get();
                            @endphp

                            @if(isset($eventsInterest))
                            @forelse($eventsInterest As $key => $value)

                            <button class="btn btn-secondary dropdown-toggle dropdownMenuButton_{{$events->id}} mt-2"
                                type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" @if($value->event_id == $events->id && $value->user_id ==
                                auth()->user()->id && $value->event_user_id == $events->user_id) style="color:#c56cf0"
                                @endif>

                                @if($value->interest == 'interested')
                                <i class="fa fa-star" aria-hidden="true"></i>
                                {{trans('general.interested')}}
                                @elseif($value->interest == 'going')
                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                {{trans('general.going')}}
                                @elseif($value->interest == 'not_interested')
                                <i class="fas fa-times-circle" aria-hidden="true"></i>
                                {{trans('general.not_interested')}}
                                @endif
                            </button>
                            @empty
                            <button class="btn btn-secondary dropdown-toggle dropdownMenuButton_{{$events->id}} mt-2"
                                type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="far fa-star" aria-hidden="true"></i>
                                {{trans('general.interested')}}

                            </button>
                            @endforelse

                            @endif

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <div id="activeusr" style="width: 200px;">


                                    <a class="dropdown-item dropdown-navbar dropdown-lang " href="javascript:;"
                                        onclick="checkInterest('interested','{{ $events->user_id }}','{{ $events->id }}')">
                                        <i class="far fa-star" aria-hidden="true"></i> {{trans('general.interested')}}
                                        <!--                        <input type="radio" value="interested" name="interest" id="interested">-->
                                    </a>

                                    <a class="dropdown-item dropdown-navbar dropdown-lang " href="javascript:;"
                                        onclick="checkInterest('going','{{ $events->user_id }}','{{ $events->id }}')">
                                        <i class="fa fa-check-circle" aria-hidden="true"></i> {{trans('general.going')}}
                                        <!--                        <input type="radio" value="going" name="interest" id="going">-->
                                    </a>

                                    <a class="dropdown-item dropdown-navbar dropdown-lang " href="javascript:;"
                                        onclick="checkInterest('not_interested','{{ $events->user_id }}','{{ $events->id }}')">
                                        <i class="fas fa-times-circle" aria-hidden="true"></i>
                                        {{trans('general.not_interested')}}
                                        <!--                        <input type="radio" value="not_interested" name="interest" id="not_interested">-->
                                    </a>


                                </div>

                            </div>
                        </div>

                        @else

                        <div class="card-event" style="float:left;">

                            <a href="{{url('individual_event/'.$events->id)}}"
                                class="btn btn-secondary dropdownMenuButton_{{$events->id}} mt-2">
                                <i class="far fa-star" aria-hidden="true"></i>
                                {{trans('general.interested')}}

                            </a>

                        </div>

                        @endif


                        <button class="btn btn-google mt-1 card-btn" title="{{trans('general.share')}}"
                            id="dropdownUserShare" role="button" data-toggle="modal" data-target=".share-modal"
                            style="float:right;">
                            <i class="far fa-share-square mr-1 mr-lg-0"></i>
                            <!--                            <span class="d-lg-none">{{trans('general.share')}}</span>-->
                        </button>


                        <!-- Share modal -->
                        <div class="modal fade share-modal" tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="mySmallModalLabel">{{trans('general.share')}}</h5>
                                        <button type="button" class="close close-inherit" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-4 col-6 mb-3">
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}"
                                                        title="Facebook" target="_blank"
                                                        class="social-share text-muted d-block text-center h6">
                                                        <i class="fab fa-facebook-square facebook-btn"></i>
                                                        <span class="btn-block mt-3">Facebook</span>
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-6 mb-3">
                                                    <a href="https://twitter.com/intent/tweet?url={{url()->current()}}&text={{ e( $user->hide_name == 'yes' ? $user->username : $user->name ) }}"
                                                        data-url="{{url()->current()}}"
                                                        class="social-share text-muted d-block text-center h6"
                                                        target="_blank" title="Twitter">
                                                        <i class="fab fa-twitter twitter-btn"></i> <span
                                                            class="btn-block mt-3">Twitter</span>
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-6 mb-3">
                                                    <a href="whatsapp://send?text={{url()->current()}}"
                                                        data-action="share/whatsapp/share"
                                                        class="social-share text-muted d-block text-center h6"
                                                        title="WhatsApp">
                                                        <i class="fab fa-whatsapp btn-whatsapp"></i> <span
                                                            class="btn-block mt-3">WhatsApp</span>
                                                    </a>
                                                </div>

                                                <div class="col-md-4 col-6 mb-3">
                                                    <a href="mailto:?subject={{ e( $user->hide_name == 'yes' ? $user->username : $user->name ) }}&amp;body={{url()->current()}}"
                                                        class="social-share text-muted d-block text-center h6"
                                                        title="{{trans('auth.email')}}">
                                                        <i class="far fa-envelope"></i> <span
                                                            class="btn-block mt-3">{{trans('auth.email')}}</span>
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-6 mb-3">
                                                    <a href="sms://?body={{ trans('general.check_this') }} {{url()->current()}}"
                                                        class="social-share text-muted d-block text-center h6"
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
                                                    <input type="hidden" readonly="readonly" id="copy_link"
                                                        class="form-control" value="{{url()->current()}}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div><!-- End Card -->
            </div><!-- end col-md-4 -->


        </div>

        <!--        <br>
                <div class="row">
        
                    <div class="col-lg-7" style="margin:0px auto;">
                        <div class="card card-updates">
        
                            <div class="card-body">
                                <h5 class="text-muted">   Event Host  </h5><hr>
        
                                <div class="media">
                                    <span class="rounded-circle mr-3">
                                        <a href="{{url($user->username)}}">
                                            <img src="{{ Helper::getFile(config('path.avatar').$user->avatar) }}" alt="devloper1" class="rounded-circle avatarUser" width="60" height="60">
                                        </a>
                                    </span>
                                    <div class="media-body">
                                        <h5 class="mb-0 font-montserrat mt-3">
                                            <a href="{{url($user->username)}}">
                                                {{ e( $user->hide_name == 'yes' ? $user->username : $user->name ) }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
        
        
                            </div>
                        </div>
                    </div>
                </div>-->

        <!--        <br>
                <div class="row">
        
                    <div class="col-lg-7" style="margin:0px auto;">
                        <div class="card card-updates">
        
                            <div class="card-body">
                                <div class="media">
        
                                    <div class="media-body">
                                        <h5 class="mb-0 font-montserrat">
        
                                            <div id="showCountedInterest_{{$events->id}}">
                                                @foreach (DB::table('event_interest')->select('interest', DB::raw('count(interest) as count'))->where('event_id', $events->id)->where('event_user_id', $events->user_id)->groupBy('interest')->get() as $event_interest)
                                                <small class="m-0  pb-3 text-muted card-text">
                                                    @if($event_interest->interest == 'interested')
                                                    <i class="fa fa-circle pb-3" aria-hidden="true" style="font-size: 4px;"></i>
                                                    {{$event_interest->count}} {{trans('general.interested')}} @endif
        
        
        
                                                    @if($event_interest->interest == 'going')
                                                    <i class="fa fa-circle pb-3" aria-hidden="true" style="font-size: 4px;"></i>
                                                    {{ $event_interest->count }} {{trans('general.going')}}  @endif 
        
                                                </small>
                                                @endforeach
                                            </div>
        
                                        </h5>
                                    </div>
                                </div>
        
        
                            </div>
                        </div>
                    </div>
                </div>-->

    </div>
    <!-- Modal -->
                    
<!-- MODEL FOR UPDATE EVENTS -->
@include('includes.update_event')
<!-- END EVENT UPDATE -->

<!-- MODEL FOR DELETE MODEL -->
@include('includes.delete_event')
<!-- END DELETE MODEL -->
</section>
@endsection


@section('javascript')

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

    $('#cost').on('change', function () {
            if (this.value == 'paid') {
                $("#cost-price").show();
            }
            else {
                $("#cost-price").hide();
            }
        });
// script for datepicker and hide show price input field
    $(document).on('click', '.edittbtn', function (e)
        {
           // alert("kkkkkk");
            e.preventDefault();
            
            var event_id = $(this).val();
             //alert(event_id);
            $('#editeventForm').modal('show');

            $.ajax({
                type: "GET",
                url: "{{ env('APP_URL') }}" + "/showevent/" + event_id,

                success: function (response) {
                   
                    console.log(response.events.event_name);
                    if(response.status == 404)
                    {
                        alert(response.msg);
                        $('#editeventForm').modal('hide');

                    }
                    else
                    {
                    
                        if(response.events.event_img){

                            $('#store_event').html("<img src={{asset('public/uploads/event')}}/" +response.events.event_img +"  width='498px' height='200px' />");
                        }
                        else{

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


        // DELETE EVENT
        $(document).on('click', '.deletebtn ', function () {

        var event_id = $(this).val();

         // alert(event_id);
         $('#deleteEvent').modal('show');
        $('#deleting_id').val(event_id);

        });

   }); 
</script>
@endsection