@extends('layouts.app')

@section('title') {{trans('general.obs_stream')}} -@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('public/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<section class="section section-sm">
    <div class="container">
        <div class="row justify-content-center text-center mb-sm">
            <div class="col-lg-8 py-5">
                <h2 class="mb-0 font-montserrat"><i class="feather icon-info mr-2"></i> {{trans('general.obs_stream')}}</h2>
                <p class="lead text-muted mt-0"></p>
            </div>
        </div>
        <div class="row">

            @include('includes.cards-settings')

            <div class="col-md-6 col-lg-9 mb-5 mb-lg-0" style="word-wrap: break-word;">

                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label class="mb-3" for="live_app_id" style=" padding: .625rem .75rem;">
                            {{trans('general.live_app_id')}} : 
                        </label>
                    </div>
                    <div class="col-md-8 col-sm-8">   
                        {{$appID}}
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label class="mb-3" for="live_token" style=" padding: .625rem .75rem;">
                            {{trans('general.live_token')}} : 
                        </label>
                    </div> 
                    <div class="col-md-8 col-sm-8">   
                        {{$token}}
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label class="mb-3" for="live_channel_name" style=" padding: .625rem .75rem;">
                            {{trans('general.live_channel_name')}} : 
                        </label>
                    </div> 
                    <div class="col-md-8 col-sm-8">   
                        {{ $channelName }}
                    </div>
                </div>

            </div><!-- end col-md-6 -->
        </div>
    </div>
</section>
@endsection

