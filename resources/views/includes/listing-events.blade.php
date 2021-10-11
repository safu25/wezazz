<div class="card card-updates h-100">
    
    <!--<div class="card-cover" style="background: @if ($response->event_img != '') url({{asset('public/uploads/event')}}/{{$response->event_img}}) @else url({{url('/public/uploads/default-event-image/', $settings->event_default_image)}}) @endif #505050 center center; background-size: cover;"> -->
   
    <a href="{{url('events/')}}/{{$response->id}}" target="_blank">
    <div class="card-cover" style="background: @if ($response->event_img != '') url({{ Helper::getFile(config('path.event').$response->event_img) }}) @else url({{url('/public/uploads/default-event-image/', $settings->event_default_image)}}) @endif #505050 center center; background-size: cover;">
        <span class="badge-free px-2 py-1 text-uppercase position-absolute rounded">
            
            @if($response->event_cost == 'free')
            
            {{$response->event_cost}}
        
            @else
             {{Helper::amountFormatDecimal($response->event_price)}}
            @endif
        </span>
    </div>
</a>

    <div class="card-body card-body-event">

        <?php // echo date('Y-m-d H:i'); ?>

      
        <h6 class="m-0 pb-1 text-muted card-text">
            <i class="fa fa-calendar-alt mr-1" aria-hidden="true"></i>  {{ $response->start_date }}
        </h6>

        <h6 class="m-0 pb-1 text-muted card-text">
            <i class="fa fa-clock mr-1" aria-hidden="true"></i> {{ $response->end_date }} hours
        </h6>


        <h6 class="m-0 pb-1 text-muted card-text">
            <i class="fa fa-user mr-1" aria-hidden="true"></i>  {{ $response->event_name }}
        </h6> 
        <h6 class="m-0 pb-1 text-muted card-text">
            <i class="fa fa-globe mr-1" aria-hidden="true"></i>  {{ $response->event_type }}
        </h6>


        <h6 class="m-0 py-1 text-muted card-text">
            <i class="fa fa-map-marker-alt mr-1" aria-hidden="true"></i>  {{ $response->event_place }}
        </h6>

        <h6 class="m-0 py-1 text-muted card-text">
            <i class="fas fa-info-circle mr-1" aria-hidden="true"></i>  {{ $response->event_details }}
        </h6>
       

        <div id="showCountedInterest_{{$response->id}}">
            @foreach (DB::table('event_interest')->select('interest', DB::raw('count(interest) as count'))->where('event_id', $response->id)->where('event_user_id', $response->user_id)->groupBy('interest')->get() as $event_interest)
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

        <!--        <a href="javascript:void(0);" class="btn btn-1 btn-sm btn-outline-primary">{{trans('general.interested')}}</a>-->

        @php
        $checkPayPerEvent = auth()->user()->payPerViewEvent()->where('events_id', $response->id)->first();
        if ($checkPayPerEvent) {
        $display = 'none';
        }else {

        $display = 'inline-block';
        }
        @endphp



        @if($response->event_cost == 'paid')
        <div id="overlay-for-event" class="card-event" style="display:{{$display}}">
            <button class="btn btn-primary mt-2" id='event-overlay-btn' data-toggle="modal" data-target="#payPerEventForm" data-mediaid="{{$response->id}}" data-price="{{Helper::amountFormatDecimal($response->event_price)}}" data-pricegross="{{$response->event_price}}">
                <i class="feather icon-unlock mr-1"></i>{{ trans('general.unlock_event_for') }} {{Helper::amountFormatDecimal($response->event_price)}}
            </button>
        </div>
        @endif

        <div class="dropdown card-event"  style="float:left;">
            @php
            $eventsInterest = DB::table('event_interest')->where('event_id', $response->id)->where('event_user_id', $response->user_id)->where('user_id', auth()->user()->id)->get();
            @endphp

            @if(isset($eventsInterest))
            @forelse($eventsInterest As $key => $value)

            <button class="btn btn-secondary dropdown-toggle dropdownMenuButton_{{$response->id}} mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @if($value->event_id == $response->id && $value->user_id == auth()->user()->id && $value->event_user_id == $response->user_id) style="color:#c56cf0" @endif>

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
            <button class="btn btn-secondary dropdown-toggle dropdownMenuButton_{{$response->id}} mt-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-star" aria-hidden="true"></i>
                {{trans('general.interested')}}

            </button>
            @endforelse

            @endif

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                <div id="activeusr" style="width: 200px;">


                    <a class="dropdown-item dropdown-navbar dropdown-lang " href="javascript:;" onclick="checkInterest('interested','{{ $response->user_id }}','{{ $response->id }}')">
                        <i class="far fa-star" aria-hidden="true"></i> {{trans('general.interested')}}
<!--                        <input type="radio" value="interested" name="interest" id="interested">-->
                    </a>

                    <a class="dropdown-item dropdown-navbar dropdown-lang " href="javascript:;" onclick="checkInterest('going','{{ $response->user_id }}','{{ $response->id }}')">
                        <i class="fa fa-check-circle" aria-hidden="true"></i> {{trans('general.going')}}
<!--                        <input type="radio" value="going" name="interest" id="going">-->
                    </a>

                    <a class="dropdown-item dropdown-navbar dropdown-lang " href="javascript:;" onclick="checkInterest('not_interested','{{ $response->user_id }}','{{ $response->id }}')">
                        <i class="fas fa-times-circle" aria-hidden="true"></i> {{trans('general.not_interested')}}
<!--                        <input type="radio" value="not_interested" name="interest" id="not_interested">-->
                    </a>


                </div>

            </div>
        </div>


        <button class="btn btn-google mt-1 card-btn" title="{{trans('general.share')}}" id="dropdownUserShare" role="button" onclick="shareEvent('{{$response->id}}','{{ e( $user->hide_name == 'yes' ? $user->username : $user->name ) }}')" style="float:right;">
            <i class="far fa-share-square mr-1 mr-lg-0"></i> 
<!--            <span class="d-lg-none">{{trans('general.share')}}</span>-->
        </button>

        


    </div>
</div><!-- End Card -->
