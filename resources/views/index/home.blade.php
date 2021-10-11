@extends('layouts.app')


@section('content')

      
    <!-- <div class="container container_l">
         <div class="row h-100">
            <div class="col-6">
               <div class="head_left d-flex justify-content-start align-items-center h-100">
                  <a href="https://webmobdemo.xyz/sponzydev/sponzy">
                     <img src="images/logo-land.png" class="img-fluid" alt="WeZazz">
                  </a>
                  <div class="search_box ml-lg-5 ml-md-2 d-md-block d-none">
                     <form class="search_form">
                        <input class="form-control mr-sm-2 bd-10" type="search" placeholder="Find a Creator" aria-label="Search">
                     </form>
                  </div>
               </div>
            </div>
            <div class="col-6">
               <div class="head_right d-flex justify-content-end align-items-center h-100">
                  <button type="button" class="btn btn-outline-primary bd-10 mr-3 w-122" onclick="location.href='https://webmobdemo.xyz/sponzydev/sponzy/login';">Log In</button>
                  <button class="btn btn-primary bd-10 w-122" type="submit">Sign Up</button>
               </div>
              
            </div>
         </div>   
      </div>  --> 

<!-- {{config('app.locale')}}
 -->   <section class="earn_profits pt-5">
      
      <div class="container container_l">
         <div class="row mb-md-5 mb-sm-2">
            <div class="col-md-6">
               <div class="letter d-flex flex-column justify-content-center align-items-md-start align-items-center h-100">
                  <h1>{{ (config('app.locale') == 'en') ? $settings->home_image_box : $settings->home_image_box_spanish }} </h1>
                  <p>{{ (config('app.locale') == 'en') ? $settings->home_image_desc_box : $settings->home_image_desc_box_spanish }}</p>
                  <a class="btn btn-primary bd-10 pr-3 pl-3 w-122 d-flex justify-content-center align-items-center" href="{{url('creators')}}"> 
                     <span>{{trans('general.explore')}}</span> 
                     <small> <i class="fa fa-arrow-right ml-2"></i> </small></a>
               </div>
            </div>
            <div class="col-md-6">
               <div class="h_position">
                  <img src="{{url('public/img', $settings->home_index)}}" class="img-fluid">
                  <img src="{{url('public/img', $settings->home_index_s)}}" class="img-fluid h_second money-white">
                  <img src="{{url('public/img', $settings->home_index_t)}}" class="img-fluid h_third money-red">
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="title mt-5 mb-md-5 mb-2 d-flex flex-column justify-content-center align-items-center">
                  <h1>{{ (config('app.locale') == 'en') ? $settings->home_image_box_2 : $settings->home_image_box_2_spanish }}</h1>
                  <div class="bottomline"></div>
                  <p>{{ (config('app.locale') == 'en') ? $settings->home_image_desc_box_2  : $settings->home_image_box_2_spanish }}</p>
               </div>
            </div>
         </div>
      </div>

   </section>

<!-- three_boxes -->

   <section class="three_boxes">
      <div class="container">
         <div class="row justify-content-center">    
            <div class="col-lg-4 col-md-12 mb-5">
               <div class="boxes p-2 d-flex justify-content-center align-items-between">
                  <div class="box d-flex flex-column justify-content-between align-items-between">
                     <div class="box_img_d hvr-float-shadow">
                        <img src="{{url('public/img', $settings->img_1)}}" class="img-fluid">
                     </div>
                     <h3>{{ (config('app.locale') == 'en') ? $settings->index_1_card_1 : $settings->index_1_card_1_spanish }}</h3>
                     <p>{{ (config('app.locale') == 'en') ? $settings->index_1_desc_card_1 : $settings->index_1_desc_card_1_spanish }}</p>
                  </div>
               </div>
            </div>
             <div class="col-lg-4 col-md-12 mb-5">
               <div class="boxes p-2 d-flex justify-content-center align-items-between">
                  <div class="box d-flex flex-column justify-content-between align-items-between">
                     <div class="box_img_d hvr-float-shadow">
                        <img src="{{url('public/img', $settings->img_2)}}" class="img-fluid">
                     </div>
                     <h3>{{ (config('app.locale') == 'en') ? $settings->index_2_card_2 : $settings->index_2_card_2_spanish }}</h3>
                     <p>{{ (config('app.locale') == 'en') ? $settings->index_2_desc_card_2 : $settings->index_2_desc_card_2_spanish }}</p>
                  </div>
               </div>
            </div>
             <div class="col-lg-4 col-md-12 mb-5">
               <div class="boxes p-2 d-flex justify-content-center align-items-between">
                  <div class="box d-flex flex-column justify-content-between align-items-between">
                     <div class="box_img_d hvr-float-shadow">
                        <img src="{{url('public/img', $settings->img_3)}}" class="img-fluid">
                     </div>
                     <h3>{{ (config('app.locale') == 'en') ? $settings->index_3_card_3 : $settings->index_3_card_3_spanish }} </h3>
                     <p>{{ (config('app.locale') == 'en') ? $settings->index_3_desc_card_3 : $settings->index_3_desc_card_3_spanish }}</p>
                  </div>
               </div>
            </div>

         </div>

         <div class="row row_2nd mb-4">
            <div class="col-md-5">
               <div class="for_sm">
                  <img src="{{ asset('public/img/home-img/Status update-cuate.png') }}" class="img-fluid">
               </div>
            </div>
            <div class="col-md-7">
               <div class="title d-flex flex-column justify-content-center h-100">
                  <h1 class="text-md-left">{{ (config('app.locale') == 'en') ? $settings->index_4_card_4 : $settings->index_4_card_4_spanish }}</h1>
                  <p class="text-md-left">{{ (config('app.locale') == 'en') ? $settings->index_4_desc_card_4 : $settings->index_4_desc_card_4_spanish }}</p>
               </div>
            </div>
         </div>

         @if ($settings->earnings_simulator == 'on')
         <div class="row">
            <div class="col-12">
               <div class="title mt-5 mb-5 d-flex flex-column justify-content-center align-items-center">
                  <h1>{{ (config('app.locale') == 'en') ? $settings->earnings_simulator_title : $settings->earnings_simulator_title_spanish }}</h1>
                  <div class="bottomline"></div>
                  <p>{{ (config('app.locale') == 'en') ? $settings->earnings_simulator_desc : $settings->earnings_simulator_desc_spanish }}</p>

               </div>
            </div>
         </div>

         <div class="row row_4th">
            <div class="col-12">
               <div class="">
                  <div class="d-flex justify-content-between">
                     <ul class="social d-flex align-items-center p-0">
                        <li class="title"><p class="m-0">{{ __('general.number_followers') }}</p></li>
                        @if ($settings->twitter != '')
                        <li>
                           <a href="{{$settings->twitter}}" target="_blank" class="ico-social">
                              <img src="{{ asset('public/img/home-img/twitter.svg') }}" class="img-fluid">
                           </a>
                        </li>
                         @endif

                           @if ($settings->facebook != '')
                           <li>
                           <a href="{{$settings->facebook}}" target="_blank" class="ico-social">
                              <img src="{{ asset('public/img/home-img/facebook.svg') }}" class="img-fluid">
                           </a>
                        </li>
                         @endif

                      @if ($settings->instagram != '')
                        <li>
                           <a href="{{$settings->instagram}}" target="_blank" class="ico-social">
                              <img src="{{ asset('public/img/home-img/insta.svg') }}" class="img-fluid">
                           </a>
                        </li>
                        @endif
                     </ul>
                     <div>
                        <img src="{{ asset('public/img/home-img/users.svg') }}" class="img-fluid mr-2 before_output">
                        <output id="rangevalue">
                           <span id="numberFollowers">1000</span>
                        </output>
                     </div>
                  </div>
                  <div class="ranger mb-5">
                     <input type="range" value="0" min="1000" max="1000000" id="rangeNumberFollowers" onInput="$('#numberFollowers').html($(this).val())"/>
                  </div>

                  <div class="d-flex justify-content-between">
                     <ul class="social d-flex align-items-center p-0">
                        <li class="title"><p class="m-0">{{ __('general.monthly_subscription_price') }}</p></li>
                     </ul>
                     <div>
                     <span class="font-weight-bold" style="font-size: 30px;"> {{ $settings->currency_position == 'left' ? $settings->currency_symbol : null }} </span>

<!--                         <img src="{{ asset('public/img/home-img/dollar-sign.svg') }}" class="img-fluid mr-2 before_output">
 -->                        <output id="rangevalue2"  style="font-size: 20px;">
                          <span id="monthlySubscription">{{ $settings->min_subscription_amount }}</span>
                        </output>
                                   <span class="font-weight-bold" style="font-size: 30px;"> {{ $settings->currency_position == 'right' ? $settings->currency_symbol : null }} </span>

                     </div>
                  </div>
                  <div class="ranger">
                     <input type="range" value="0" onInput="$('#monthlySubscription').html($(this).val())" min="{{ $settings->min_subscription_amount }}" max="{{ $settings->max_subscription_amount }}" id="rangeMonthlySubscription"/>
                  </div>
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12">
               <div class="title mt-5 mb-5 d-flex flex-column justify-content-center align-items-center">
                  <h4>{{trans('general.earnings_simulator_subtitle_2')}} <span id="estimatedEarn"></span> <small>{{$settings->currency_code}}</small> {{ __('general.per_month') }}*</h4>
                  <p> * {{trans('general.earnings_simulator_subtitle_3')}}</p>
                   <p>* {{trans('general.include_platform_fee', ['percentage' => $settings->fee_commission])}}</p>
               </div>
            </div>
         </div>

      @endif

         <div class="row">
            <div class="col-12">
               <div class="title mt-5 mb-5 d-flex flex-column justify-content-center align-items-center">
                  <h1>{{ (config('app.locale') == 'en') ? $settings->home_box_title_last : $settings->home_box_title_last_spanish }}</h1>
                  <div class="bottomline"></div>
                  <p>{{(config('app.locale') == 'en') ? $settings->home_desc_box_last : $settings->home_desc_box_last_spanish }}</p>

               </div>
            </div>
         </div>

      </div>
   </section>

   
@endsection

@section('javascript')

@section('javascript')

  @if ($settings->earnings_simulator == 'on')
  <script type="text/javascript">

  function decimalFormat(nStr)
  {
    @if ($settings->decimal_format == 'dot')
     var $decimalDot = '.';
     var $decimalComma = ',';
     @else
     var $decimalDot = ',';
     var $decimalComma = '.';
     @endif

     @if ($settings->currency_position == 'left')
     var currency_symbol_left = '{{$settings->currency_symbol}}';
     var currency_symbol_right = '';
     @else
     var currency_symbol_right = '{{$settings->currency_symbol}}';
     var currency_symbol_left = '';
     @endif

      nStr += '';
      var x = nStr.split('.');
      var x1 = x[0];
      var x2 = x.length > 1 ? $decimalDot + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          var x1 = x1.replace(rgx, '$1' + $decimalComma + '$2');
      }
      return currency_symbol_left + x1 + x2 + currency_symbol_right;
    }

    function earnAvg() {
      var fee = {{ $settings->fee_commission }};
      @if($settings->currency_code == 'JPY')
       $decimal = 0;
      @else
       $decimal = 2;
      @endif

      var monthlySubscription = parseFloat($('#rangeMonthlySubscription').val());
      var numberFollowers = parseFloat($('#rangeNumberFollowers').val());

      var estimatedFollowers = (numberFollowers * 5 / 100)
      var followersAndPrice = (estimatedFollowers * monthlySubscription);
      var percentageAvgFollowers = (followersAndPrice * fee / 100);
      var earnAvg = followersAndPrice - percentageAvgFollowers;

      var target0 = $('#rangeMonthlySubscription');

       const min0 = target0.attr('min');
        const max0 = target0.attr('max');
        const val0 = target0.val();

        var target = $('#rangeNumberFollowers');

       const min = target.attr('min');
        const max = target.attr('max');
        const val = target.val();


      $('#rangeMonthlySubscription').attr('style', 'background-size: '+ (val0 - min0) * 100 / (max0 - min0) +'% 100%');
       $('#rangeNumberFollowers').attr('style', 'background-size: '+ (val - min) * 100 / (max - min) + '% 100%');


      return decimalFormat(earnAvg.toFixed($decimal));
    }
   $('#estimatedEarn').html(earnAvg());

   $("#rangeNumberFollowers, #rangeMonthlySubscription").on('change', function() {

     $('#estimatedEarn').html(earnAvg());

   });
  </script>
@endif

@if (session('success_verify'))
  <script type="text/javascript">

   swal({
      title: "{{ trans('general.welcome') }}",
      text: "{{ trans('users.account_validated') }}",
      type: "success",
      confirmButtonText: "{{ trans('users.ok') }}"
      });
    </script>
    @endif

    @if (session('error_verify'))
   <script type="text/javascript">
   swal({
      title: "{{ trans('general.error_oops') }}",
      text: "{{ trans('users.code_not_valid') }}",
      type: "error",
      confirmButtonText: "{{ trans('users.ok') }}"
      });
    </script>
    @endif

   <!-- <script type="text/javascript">
      const rangeInputs = document.querySelectorAll('input[type="range"]')
      const numberInput = document.querySelector('input[type="number"]')

      function handleInputChange(e) {
        let target = e.target
        if (e.target.type !== 'range') {
          target = document.getElementById('range')
        } 
        const min = target.min
        const max = target.max
        const val = target.value
        
        target.style.backgroundSize = (val - min) * 100 / (max - min) + '% 100%'
      }

      rangeInputs.forEach(input => {
        input.addEventListener('input', handleInputChange)
      })

      numberInput.addEventListener('input', handleInputChange)
   </script> -->

@endsection
