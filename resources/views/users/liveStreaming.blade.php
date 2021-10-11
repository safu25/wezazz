@extends('layouts.app')

@section('title') {{trans('Live Streaming')}} -@endsection

<!-- <link href="index.css" rel="stylesheet"> -->


<style>
    header {
        display: none !important;
    }

    footer {
        display: none !important;
    }

    #removeFooterLive {
        display: none !important;
    }

    #full-screen-video-user:first-child:nth-last-child(3) .player {
        height: 100vh;
    }

    #full-screen-video-user:first-child:nth-last-child(4) .player,
    #full-screen-video-user:first-child:nth-last-child(4)~#full-screen-video-user .player {
        height: 50vh;
    }

    @media only screen and (max-device-width: 768px) {

        .chating-wrp {
            bottom: 50;
            padding: 10px 10px 0px 10px;
            position: fixed;

        }

        #comment-wrp {

            display: table;
            width: 87% !important;
            align-items: center;
        }

    }
</style>


@section('javascript')
<script type="text/javascript">

    window.onload = function () {
        $("#host-join").click();
        // $('#login').click();
    }


    $(document).ready(function () {

        setTimeout(function () {
            $('#login').click();
        }, 5000);

        setTimeout(function () {
            $('#join').trigger('click');
        }, 10000);
        setTimeout(function () {
            $('#join').trigger('click');
        }, 25000);
        setInterval(function () {
            $("#activeusr").load(window.location.href + " #activeusr");
            //    console.log('check');
        }, 4000);
    });

    //    $("#leave").click(function (e) {
    //        var retVal = confirm("Are you sure you want to end your live video ?");
    //        if (retVal == true) {
    //            leave();
    //            location.href = " {{ url('/') }}";
    //            return true;
    //        } else {
    //            return false;
    //        }
    //
    //
    //    });

    $("#cohost-name").click(function (e) {
        var name = $(this).text();
        $(".cohost-remove").css("display", "inline-block");
        $(".cohost-remove").attr('data-cohostname', name);
    });

    $("#cohost-names").click(function (e) {
        var name = $(this).text();
        $(".cohost-remove").css("display", "inline-block");
        $(".cohost-remove").attr('data-cohostname', name);
    });


    function coRemove(name) {
        // var name = $(this).text();
        $(".cohost-remove").css("display", "inline-block");
        $(".cohost-remove").attr('data-cohostname', name);
        //  console.log('hello');
    }


    $(".cohost-remove").click(function (e) {
        $(".cohost-remove").css("display", "none");

        var cohostName = $(this).attr("data-cohostname");


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "post",
            url: "{{route('hostleaveCohost')}}",
            datatype: "json",
            data: { status: 0, cohostName: cohostName, _token: _token },
            success: function (response) {
                console.log(response.message);
                $("#full-screen-video-user").removeClass("twoHostJoin");
                audienceRemove();
                //                $("#full-screen-video").removeClass('col-md-6');
                //                $("#full-screen-video").addClass('col-md-12');
                //                $("#videobtn").removeClass('cohost-video-btn');
                //                $("#videobtn").css("display", "none");

                //                var CheckDivSize = $("#full-screen-video-user div.mainPlayer").length;
                //                if (CheckDivSize == 1) {
                //                    $(".audienceSide").html("");
                //                    $(".twoHostJoin").removeClass('audienceSide');
                //                    $(".audienceSide").html("");
                //                } else {
                //                    $(".audienceSide").html("");
                //                }


                //  hostleaveCohost();
            }
        });
    });

    function requestCoHost(hostId, appid, token, channel) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: 'requestCoHost',
            datatype: "json",
            data: { requestCoHostId: hostId, appid: appid, token: token, channel: channel, _token: _token },
            success: function (response) {
                if (response.result == 'success') {
                    toastr.success(response.message);
                    console.log(response.message);
                } else {
                    toastr.error(response.message);
                    console.log(response.message);
                }

            }
        });
    }


    function acceptreq() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        var streamerid = $('#streamerid').val();
        var streamername = $('#streamername').val();
        $.ajax({
            type: "POST",
            url: "{{route('acceptreq')}}",
            datatype: "json",
            data: { streamerid: streamerid, _token: _token },
            success: function (response) {
                //  console.log(response.result);
                if (response.result == 'success') {

                    var names = response.cohostname;
                    var nameArr = names.toString().split(',');
                    //                    $.each(response.cohostname, function (key, value) {
                    //                        $("#cohost-name").text(value);
                    //                    });
                    if (nameArr.length == 1) {

                        $("#cohost-name").text(nameArr[0]);
                        $("#cohost-names").text('');
                        $("#seperate-cohost").css('display', 'none');

                        $("#full-screen-video").removeClass('col-md-12');
                        $("#full-screen-video").addClass('col-md-6');
                        $("#full-screen-video-user").addClass('col-md-6');
                        $("#full-screen-video-user").removeClass('twoHostJoin');
                        $("#full-screen-video-user").removeClass('threeJoin');

                        $("#streamer-name-mobile").css('display', 'none');


                        $("#slct").css('display', 'inline-block');

                        $("#streamer-name-mobile1").text(streamername);
                        var xyz = " '" + nameArr[0] + "' ";


                        $("#co-menu").html('<a href="javascript:void(0);" onclick="coRemove(' + xyz + ')" id="cohost-name-mobile1" class="dropdown-item"> Co-Host - ' + nameArr[0] + '</a>');
                        //                        $('#slct').html('<option id="streamer-name-mobile1" value="' + streamername + '">' + streamername + '</option>\n\
                        //                                            <option id="cohost-name-mobile1" value="' + nameArr[0] + '">' + nameArr[0] + '</option>')

                    }

                    if (nameArr.length == 2) {
                        $("#cohost-name").text(nameArr[0]);
                        $("#cohost-names").text(nameArr[1]);
                        $("#seperate-cohost").css('display', 'inline-block');

                        $("#full-screen-video").removeClass('col-md-12');
                        $("#full-screen-video").addClass('col-md-6');
                        $("#full-screen-video-user").addClass('col-md-6');
                        $("#full-screen-video-user").addClass('twoHostJoin');
                        $("#full-screen-video-user").addClass('threeJoin');


                        $("#streamer-name-mobile").css('display', 'none');

                        $("#slct").css('display', 'inline-block');

                        $("#streamer-name-mobile1").text(streamername);

                        var xyz = " '" + nameArr[0] + "' ";
                        var abc = " '" + nameArr[1] + "' ";

                        $("#co-menu").html('<a href="javascript:void(0);" onclick="coRemove(' + xyz + ')" id="cohost-name-mobile1" class="dropdown-item"> Co-Host - ' + nameArr[0] + '</a>\n\
                                            <a href="javascript:void(0);" onclick="coRemove(' + abc + ')" id="cohost-name-mobile2" class="dropdown-item"> Co-Host - ' + nameArr[1] + '</a>')


                        //                        $('#slct').html('<option id="streamer-name-mobile1" value="' + streamername + '">' + streamername + '</option>\n\
                        //                                            <option id="cohost-name-mobile1" value="' + nameArr[0] + '">' + nameArr[0] + '</option>\n\
                        //                                            <option id="cohost-name-mobile2" value="' + nameArr[1] + '">' + nameArr[1] + '</option>')
                        //                       
                    }

                    //   $("#cohost-screen-controlls").css('display', 'inline-block');
                    //  $(".full-screen-controlls").css('display', 'none');

                    //  console.log(response.result);
                    //  console.log(response.cohostname);

                    if ('{{ auth()->check()}}' && '{{auth()->user()->dark_mode}}' == 'on') {
                        $('.dropdown-item').attr('style', 'color: #ffffff !important');
                    } else {
                        $('.dropdown-item').attr('style', 'color: #212529 !important');
                    }

                } else if (response.result == 'notanycohost') {

                    //                    $('.audienceSide').remove();
                    $("#full-screen-video").addClass('col-md-12');
                    $("#full-screen-video").addClass('host-live-full-screen');
                    $("#full-screen-video").removeClass('col-md-6');
                    $("#videobtn").removeClass('cohost-video-btn');
                    $("#full-screen-video-user").removeClass('threeJoin');
                    $("#videobtn").css("display", "none");

                    $("#cohost-name").text(response.cohostname);
                    $("#cohost-names").text(response.cohostname);

                    $("#streamer-name-mobile").css('display', 'inline-block');
                    $('#slct').css("display", "none");
                    $('#co-menu').html('');
                    // $('#slct').html('');

                    //    console.log(response.result);

                    //  $(".full-screen-controlls").css('display', 'block');
                    //  $("#cohost-screen-controlls").css('display', 'none');
                }


            }
        });
    }


    function checkNotification() {

        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right"
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        var streamerid = $('#streamerid').val();
        $.ajax({
            type: "POST",
            url: "{{route('checkNotification')}}",
            datatype: "json",
            data: { streamerid: streamerid, _token: _token },
            success: function (response) {
                //  console.log(response.result);
                if (response.result == 'success') {
                    toastr.success(response.data);
                    console.log(response.data);

                    //  $('#tip_notification').append(response.data);

                    console.log(response.result);
                } else {
                    //     console.log(response.result);
                }
            }
        });
    }


    function checkCohost() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "{{route('checkCohost')}}",
            datatype: "json",
            data: { _token: _token },
            success: function (response) {

                if (response.result == 'hide') {

                    // console.log('hide');
                    $('.co-host').css('display', 'none');
                } else {

                    // console.log('show');
                    $('.co-host').css('display', 'inline-block');
                }
            }
        });
    }


    //    function checkvideo() {
    //    var CheckVideo = $("video").length;
    //    console.log('total video'+CheckVideo);
    //            if (CheckVideo == '3') {
    //                
    //                $("#full-screen-video-user").addClass("threeJoin");
    //               
    //            } else {
    //                $("#full-screen-video-user").removeClass("threeJoin");
    //            }
    //
    //}

    $(document).ready(function () {
        setInterval(function () {
            acceptreq();
        }, 3000);
        //        setInterval(function () {
        //            checkvideo();
        //        }, 3000);
        setInterval(function () {
            audienceRemove();
        }, 3000);

        setInterval(function () {
            checkCohost();
        }, 3000);
        setInterval(function () {
            checkNotification();
        }, 1000);
    });</script>

<script>
    document.getElementById('channelMessage').addEventListener('keypress', function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            document.getElementById('send_channel_message').click();
        }
    });
    $(window).on("beforeunload", function () {
        //return confirm("Do you really want to close?"); 

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: 'startStreaming',
            datatype: "json",
            data: { status: 0, _token: _token },
            success: function (response) {
                console.log(response.message);
            }
        });
        console.log("client leaves channel success");
    })

    function trim(string) {
        return string.replace(/^\s+/g, '').replace(/\s+$/g, '')
    }

    $(function () {

        $('#searchCreators').on('keyup', function (e) {
            e.preventDefault();
            var $string = $(this).val();
            var appId = $("#appid").val();
            var token = $("#token").val();
            var channelName = $("#channel").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var _token = $('input[name="_token"]').val();
            $('#searchSpinner').show();
            $('#creatorsContainer').html('');
            $(this).waiting(500).done(function () {


                $.ajax({
                    type: "post",
                    url: '{{ route("searchCoHost") }}',
                    data: { 'user': trim($string), 'appId': appId, 'token': token, 'channelName': channelName, _token: _token },
                    success: function (response) {
                        if (response) {

                            $('#creatorsContainer').html(response);
                            $('#searchSpinner').hide();
                        } else {
                            $('#creatorsContainer').html('<span class="p-2 text-center w-100 d-block">' + no_results + '</span>');
                            $('#searchSpinner').hide();
                        }
                    }
                });
            });
        });
    });</script>

<script>

    function liveLeaveBtn() {

        swal({
            title: "Confirm Leave",
            text: "Are you sure you want to end your live video ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, End it!",
            closeOnConfirm: true
        },
            function (isConfirm) {

                if (isConfirm) {

                    leave();
                    location.href = " {{ url('/') }}";
                    return true;
                } else {
                    return false;
                }
            });

    }

//    var deleter = {
//
//        linkSelector: "#leave",
//
//        init: function () {
//            $(this.linkSelector).on('click', {self: this}, this.handleClick);
//        },
//
//        handleClick: function (event) {
//            event.preventDefault();
//
//            var self = event.data.self;
//            var link = $(this);
//
//            swal({
//                title: "Confirm Leave",
//                text: "Are you sure you want to end your live video ?",
//                type: "warning",
//                showCancelButton: true,
//                confirmButtonColor: "#DD6B55",
//                confirmButtonText: "Yes, End it!",
//                closeOnConfirm: true
//            },
//                    function (isConfirm) {
//
//                        if (isConfirm) {
//
//                            leave();
//                            location.href = " {{ url('/') }}";
//                            return true;
//                        } else {
//                            return false;
//                        }
//                    });
//
//        },
//    };
//
//    deleter.init();
</script>


@endsection

@section('content')

<center>
    <div id="loading" style="margin:80px auto;">
        <img id="loading-image" src="{{ asset('public/img/loader1.gif') }}" />
        <p></p>
    </div>
</center>


<section class="section ">

    <div class="container" id="hide-full-screen" style="display:none;">
        <div class="row">
            <div class="col-md-8 mb-lg-0 py-5 wrap-post">

                <form id="join-form" action="">
                    <!-- method="post"  -->
                    @csrf

                    <div class="row join-info-group">
                        <div class="col-sm">
                            <input id="appid" type="hidden" value="{{ $appID }}" required>
                        </div>
                        <div class="col-sm">
                            <input id="token" name="token" type="hidden" value="{{ $token }}">
                        </div>
                        <div class="col-sm">
                            <input id="channel" type="hidden" value="{{ $channelName }}" required>
                            <input id="status" name="status" type="hidden" value="1">
                            <input id="streamername" name="streamername" type="hidden"
                                value="{{ auth()->user()->name }}">
                            <input id="streamerid" name="streamerid" type="hidden" value="{{ auth()->user()->id }}">
                        </div>
                    </div>

                    <div class="button-group">
                        <button id="host-join" type="submit" class="btn btn-primary btn-sm"
                            style="display:none">{{trans('general.start_streaming')}}</button>
                    </div>
                </form>


            </div>

            <div class="col-md-4 pb-4 py-lg-5 chat" style="display:none;">


            </div>

        </div>
    </div>

    <div class="row video-screen-card">

        <div id="full-screen-video" class="col-md-12 host-live-full-screen">

            <div id="overlay-for-screen" style="display:none;">
                <button id="blur-screen-btn" disabled>
                    <i class="fa fa-desktop" style="font-size: 1.2rem;"></i>
                </button>
                <h5>Sharing Your Entire Screen</h5>
            </div>

            <div class="comment-dropdown">
                <div class="row video-group livesreaming-popup">
                    <div class="col">
                        <input type="hidden" id="muteAudio" value="{{ asset('public/img/mute.png') }}">
                        <input type="hidden" id="unmuteAudio" value="{{ asset('public/img/unmute.png') }}">
                        <input type="hidden" id="muteVideo" value="{{ asset('public/img/play.png') }}">
                        <input type="hidden" id="unmuteVideo" value="{{ asset('public/img/pause.png') }}">

                        <div class="full-screen-controlls" style="display:none;" id="local-player">


                        </div>
                        <div id="local-stats" class="stream-stats stats"></div>

                    </div>
                    <!-- <div class="w-100"></div>
                <div class="col">
                    <div id="remote-playerlist"></div>
                </div> -->
                </div>



                <div class="chating-wrp chat" style="z-index: 9;">
                    <div class="chating-box" id="log">

                    </div>
                    <!--                <button id="comment-hide"><i class="fa fa-arrow-up"></i></button>
                <button id="comment-show" style="display: none;"><i class="fa fa-arrow-up"></i></button>-->

                    <div class="comment-dropdown">
                        <div class="comment-wrp" id="comment-wrp">

                            <form id="loginForm" action="">
                                <!-- method="post"  -->
                                @csrf

                                <input id="appId" name="appId" type="hidden" value="{{ $appID }}" required>
                                <input id="accountName" name="accountName" type="hidden" value="{{ $username }}">
                                <input id="usrtoken" name="token" type="hidden" value="{{ $chattoken }}">
                                <input id="channelName" name="channelName" type="hidden" value="{{ $channelName }}"
                                    required>
                                <!--                        <input id="countUser" name="countUser" type="text" value="0" >-->

                                <div class="form-group">
                                    <button id="login" type="submit" style="display:none;">LOGIN</button>
                                    <button id="logout" style="display:none;">LOGOUT</button>
                                    <button id="join" style="display:none">JOIN</button>
                                </div>


                                <div class="form-group">
                                    <input type="text" placeholder="Add a Comment..." class="form-control m-0"
                                        name="channelMessage" id="channelMessage">
                                    <input class="m-0" type="hidden" name="usrAvatar" id="usrAvatar"
                                        value="{{ Helper::getFile(config('path.avatar').auth()->user()->avatar) }}">
                                    <button id="send_channel_message"><img
                                            src="https://webmobdemo.xyz/sponzydev/sponzy/public/uploads/avatar/send.svg"></button>
                                </div>


                            </form>


                        </div>

                        <div id="cohost-screen-controlls" style="width: 45px;height: 40px;margin-left: auto;">
                            <ul id="menu" class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
                                <li class="mfb-component__wrap">
                                    <a href="#" class="mfb-component__button--main">
                                        <!-- <i class="mfb-component__main-icon--resting ion-plus-round"> -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                            viewBox="0 0 64 64">
                                            <path fill="#fff"
                                                d="M58.18 25.98H38.03V5.83c0-7.77-12.05-7.77-12.05 0v20.15H5.83c-7.768 0-7.768 12.05 0 12.05h20.15v20.15c0 7.77 12.05 7.77 12.05 0V38.03h20.15c7.769 0 7.769-12.05 0-12.05" />
                                        </svg>
                                        <!-- </i> -->

                                    </a>
                                    <ul class="mfb-component__list">

                                        <li class="mfb-component__wrap">
                                            <a href="javascript:;" onclick="liveCommentOffBtn();" id="hideComment"
                                                data-mfb-label="Comments Allowed" class="mfb-component__button--child">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 20 20">
                                                    <g>
                                                        <path fill="#fff"
                                                            d="M6.5 2a2.5 2.5 0 0 0-2.458 2.042A2.5 2.5 0 0 0 2 6.5v7A2.5 2.5 0 0 0 4.5 16H5v1.028a1 1 0 0 0 1.581.814L9.161 16h.046a5.48 5.48 0 0 1-.185-1H8.84L6 17.028V15H4.5A1.5 1.5 0 0 1 3 13.5v-7A1.5 1.5 0 0 1 4.5 5h9A1.5 1.5 0 0 1 15 6.5v2.522c.343.031.678.094 1 .185V6.5A2.5 2.5 0 0 0 13.5 4H5.085A1.5 1.5 0 0 1 6.5 3h8A2.5 2.5 0 0 1 17 5.5v4.1c.358.183.693.404 1 .657V5.5A3.5 3.5 0 0 0 14.5 2h-8zM19 14.5a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0zm-2.146-1.854a.5.5 0 0 0-.708 0L13.5 15.293l-.646-.647a.5.5 0 0 0-.708.708l1 1a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0 0-.708z" />
                                                    </g>
                                                </svg>

                                                <!-- <img src="{{ asset('public/img/comment.png') }}" style="width: 23px;"> -->
                                            </a>

                                            <a href="javascript:;" onclick="liveCommentOnBtn();" id="showComment"
                                                data-mfb-label="Comments Blocked" class="mfb-component__button--child"
                                                style="display: none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <g>
                                                        <path fill="#fff"
                                                            d="M8.25 2a3.25 3.25 0 0 0-3.241 3.007c.08-.005.16-.007.241-.007h9.5A4.25 4.25 0 0 1 19 9.25v6.5c0 .08-.002.161-.007.241A3.25 3.25 0 0 0 22 12.75v-6A4.75 4.75 0 0 0 17.25 2h-9z" />
                                                        <path fill="#fff"
                                                            d="M17.99 16a3.25 3.25 0 0 1-3.24 3h-4.083L7 21.75c-.824.618-2 .03-2-1v-1.76a3.25 3.25 0 0 1-3-3.24v-6.5A3.25 3.25 0 0 1 5.25 6h9.5A3.25 3.25 0 0 1 18 9.25v6.5c0 .084-.003.168-.01.25z" />
                                                    </g>
                                                </svg>
                                                <!-- <img src="{{ asset('public/img/comment-hide.png') }}" style="width: 23px;"/> -->
                                            </a>
                                        </li>

                                        <li class="mfb-component__wrap">
                                            <a href="javascript:;" onclick="liveCommentBoxHide();" id="hideCommentBox"
                                                data-mfb-label="Comments Visible" class="mfb-component__button--child">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 512 512">
                                                    <path fill="#fff"
                                                        d="M144 208c-17.7 0-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32s-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32s-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32s-14.3-32-32-32zM256 32C114.6 32 0 125.1 0 240c0 47.6 19.9 91.2 52.9 126.3C38 405.7 7 439.1 6.5 439.5c-6.6 7-8.4 17.2-4.6 26S14.4 480 24 480c61.5 0 110-25.7 139.1-46.3C192 442.8 223.2 448 256 448c141.4 0 256-93.1 256-208S397.4 32 256 32zm0 368c-26.7 0-53.1-4.1-78.4-12.1l-22.7-7.2l-19.5 13.8c-14.3 10.1-33.9 21.4-57.5 29c7.3-12.1 14.4-25.7 19.9-40.2l10.6-28.1l-20.6-21.8C69.7 314.1 48 282.2 48 240c0-88.2 93.3-160 208-160s208 71.8 208 160s-93.3 160-208 160z" />
                                                </svg>
                                                <!-- <i class="fas fa-comments"></i> -->
                                            </a>

                                            <a href="javascript:;" onclick="liveCommentBoxShow();" id="showCommentBox"
                                                data-mfb-label="Comments Hidden" class="mfb-component__button--child"
                                                style="display: none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 512 512">
                                                    <path fill="#fff"
                                                        d="M256 32C114.6 32 0 125.1 0 240c0 49.6 21.4 95 57 130.7C44.5 421.1 2.7 466 2.2 466.5c-2.2 2.3-2.8 5.7-1.5 8.7S4.8 480 8 480c66.3 0 116-31.8 140.6-51.4c32.7 12.3 69 19.4 107.4 19.4c141.4 0 256-93.1 256-208S397.4 32 256 32z" />
                                                </svg>
                                                <!-- <i class="far fa-comments"></i> -->
                                            </a>

                                        </li>

                                        <li class="mfb-component__wrap">
                                            <a href="javascript:;" onclick="liveAudioBtn();" id="liveAudioBtn"
                                                data-mfb-label="Audio" class="mfb-component__button--child">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 1024 1024">
                                                    <path fill="#fff"
                                                        d="M842 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 140.3-113.7 254-254 254S258 594.3 258 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 168.7 126.6 307.9 290 327.6V884H326.7c-13.7 0-24.7 14.3-24.7 32v36c0 4.4 2.8 8 6.2 8h407.6c3.4 0 6.2-3.6 6.2-8v-36c0-17.7-11-32-24.7-32H548V782.1c165.3-18 294-158 294-328.1zM512 624c93.9 0 170-75.2 170-168V232c0-92.8-76.1-168-170-168s-170 75.2-170 168v224c0 92.8 76.1 168 170 168zm-94-392c0-50.6 41.9-92 94-92s94 41.4 94 92v224c0 50.6-41.9 92-94 92s-94-41.4-94-92V232z" />
                                                </svg>
                                                <!-- <img src="{{ asset('public/img/unmute.png') }}" style="width: 23px;" /> -->
                                            </a>
                                        </li>

                                        <li class="mfb-component__wrap">
                                            <a href="javascript:;" onclick="liveVideoBtn();" id="liveVideoBtn"
                                                data-mfb-label="Video" class="mfb-component__button--child">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <g class="icon-tabler" fill="none" stroke="#fff" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path fill="none"
                                                            d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14v-4z" />
                                                        <rect x="3" y="6" width="12" height="12" rx="2" />
                                                    </g>
                                                </svg>
                                                <!-- <img src="{{ asset('public/img/pause.png') }}" style="width: 23px;"/> -->
                                            </a>
                                        </li>

                                        <li class="mfb-component__wrap share-screen-control">
                                            <a href="javascript:;" onclick="screenShare();" id="liveScreenShareBtn"
                                                data-mfb-label="Start Sharing Screen"
                                                class="mfb-component__button--child">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <g class="icon-tabler" fill="none" stroke="#fff" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <rect x="7" y="3" width="14" height="14" rx="2" />
                                                        <path
                                                            d="M17 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2" />
                                                    </g>
                                                </svg>
                                                <!-- <i class="fa fa-desktop"></i> -->
                                            </a>

                                            <a href="javascript:;" onclick="screenShareHide();"
                                                id="liveScreenShareHideBtn" data-mfb-label="Stop Sharing Screen"
                                                style="display:none;" class="mfb-component__button--child">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <g class="icon-tabler" fill="#fff" stroke="#fff" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <rect x="7" y="3" width="14" height="14" rx="2" />
                                                        <path
                                                            d="M17 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2" />
                                                    </g>
                                                </svg>
                                                <!-- <i class="fa fa-desktop"></i> -->
                                            </a>
                                        </li>

                                        <li class="mfb-component__wrap switch-camera-control">
                                            <a href="javascript:;"
                                                onclick="liveFrontCameraBtn(this.getAttribute('data-camid'), this.getAttribute('data-camlabel'));"
                                                id="liveFrontCameraBtn" data-mfb-label=" Rear Camera"
                                                style="display:none;" data-camid="" data-camlabel=""
                                                class="mfb-component__button--child">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 512 512">
                                                    <path
                                                        d="M432 144h-59c-3 0-6.72-1.94-9.62-5l-25.94-40.94a15.52 15.52 0 0 0-1.37-1.85C327.11 85.76 315 80 302 80h-92c-13 0-25.11 5.76-34.07 16.21a15.52 15.52 0 0 0-1.37 1.85l-25.94 41c-2.22 2.42-5.34 5-8.62 5v-8a16 16 0 0 0-16-16h-24a16 16 0 0 0-16 16v8h-4a48.05 48.05 0 0 0-48 48V384a48.05 48.05 0 0 0 48 48h352a48.05 48.05 0 0 0 48-48V192a48.05 48.05 0 0 0-48-48zM316.84 346.3a96.06 96.06 0 0 1-155.66-59.18a16 16 0 0 1-16.49-26.43l20-20a16 16 0 0 1 22.62 0l20 20A16 16 0 0 1 196 288a17.31 17.31 0 0 1-2-.14a64.07 64.07 0 0 0 102.66 33.63a16 16 0 1 1 20.21 24.81zm50.47-63l-20 20a16 16 0 0 1-22.62 0l-20-20a16 16 0 0 1 13.09-27.2A64 64 0 0 0 215 222.64A16 16 0 1 1 194.61 198a96 96 0 0 1 156 59a16 16 0 0 1 16.72 26.35z"
                                                        fill="#fff"></path>
                                                </svg>
                                                <!-- <img src="{{ asset('public/img/camera.png') }}" style="width: 23px;"/> -->
                                            </a>
                                            <a href="javascript:;"
                                                onclick="liveBackCameraBtn(this.getAttribute('data-camid'), this.getAttribute('data-camlabel'));"
                                                id="liveBackCameraBtn" data-mfb-label=" Front Camera" data-camid=""
                                                data-camlabel="" class="mfb-component__button--child">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 512 512">
                                                    <path
                                                        d="M350.54 148.68l-26.62-42.06C318.31 100.08 310.62 96 302 96h-92c-8.62 0-16.31 4.08-21.92 10.62l-26.62 42.06C155.85 155.23 148.62 160 140 160H80a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h352a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32h-59c-8.65 0-16.85-4.77-22.46-11.32z"
                                                        fill="none" stroke="#fff" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="32"></path>
                                                    <path fill="none" stroke="#fff" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="32"
                                                        d="M124 158v-22h-24v22"></path>
                                                    <path
                                                        d="M335.76 285.22v-13.31a80 80 0 0 0-131-61.6M176 258.78v13.31a80 80 0 0 0 130.73 61.8"
                                                        fill="none" stroke="#fff" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="32"></path>
                                                    <path fill="none" stroke="#fff" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="32"
                                                        d="M196 272l-20-20l-20 20"></path>
                                                    <path fill="none" stroke="#fff" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="32"
                                                        d="M356 272l-20 20l-20-20"></path>
                                                </svg>
                                                <!-- <img src="{{ asset('public/img/camera.png') }}" style="width: 23px;"/> -->
                                            </a>
                                        </li>

                                        <li class="mfb-component__wrap">
                                            <a href="javascript:;" onclick="liveLeaveBtn();" id="leaveHost"
                                                data-mfb-label="Leave" class="mfb-component__button--child"
                                                style="background-color: #f00;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <g>
                                                        <path fill="#fff"
                                                            d="M7.772 2.439l1.076-.344c1.01-.322 2.087.199 2.52 1.217l.859 2.028c.374.883.167 1.922-.514 2.568L9.819 9.706c.116 1.076.478 2.135 1.084 3.177a8.678 8.678 0 0 0 2.271 2.595l2.275-.76c.863-.287 1.802.044 2.33.821l1.233 1.81c.615.904.505 2.15-.258 2.916l-.818.821c-.814.817-1.977 1.114-3.052.778c-2.539-.792-4.873-3.143-7.003-7.053c-2.133-3.916-2.886-7.24-2.258-9.968c.264-1.148 1.081-2.063 2.149-2.404z" />
                                                    </g>
                                                </svg>
                                                <!-- <img src="{{ asset('public/img/leave-call.png') }}" style="width: 23px;" /> -->
                                            </a>
                                        </li>



                                    </ul>
                                </li>
                            </ul>
                        </div>


                        <!-- old code here -->

                    </div>

                </div>
            </div>
        </div>
        <div id="full-screen-video-user" class="col-md-6 cohost">

            <div class="top-left-part">
                <ul>
                    <li>
                        <a href="javascript:;">
                            <div class="user for_remove_btn">
                                <!--                        <img src="https://webmobdemo.xyz/sponzydev/sponzy/public/uploads/avatar/5da8273e-41616952448bwjv1ivj8q.png">-->
                                <h4 id="cohost-name" class="d-none d-sm-block"></h4>
                                <h4 id="seperate-cohost" class="" style="display:none;"> , </h4>
                                <h4 id="cohost-names" class="d-none d-sm-block"></h4>
                                <button id="cohost-remove" type="button" class="btn btn-primary btn-sm cohost-remove"
                                    data-cohostname="" style="display:none;">
                                    <h4>Remove</h4>
                                </button>
                                <!-- id="leave" -->
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

            <!--            <div class="row video-group livesreaming-popup">
                <div class="col">

                    <div class="" id="local-player">
                        <div class="videButton" id="videobtn" style="display:none">

                            <div class="popup-btn">
                                <button id="mute-audio-host" type="button" class="btn btn-primary btn-sm mute-audio-cohost" disabled>
                                    <img src="{{ asset('public/img/unmute.png') }}" />
                                </button>
                                <p>Mute</p>
                            </div>
                            <div class="popup-btn">
                                <button id="mute-video-host" type="button" class="btn btn-primary btn-sm mute-video-cohost" disabled>
                                    <img src="{{ asset('public/img/pause.png') }}" />
                                </button>
                                <p>Video</p>
                            </div>

                        </div>
                    </div>

                </div>

            </div>-->

        </div>

    </div>

    <div class="top-left-part">
        <ul>
            <li>
                <!--                <a href="{{url(auth()->user()->username)}}">-->
                <a href="javascript:;">
                    <div class="user">
                        <img src="{{Helper::getFile(config('path.avatar').auth()->user()->avatar)}}"
                            class="img-user-small">
                        <h4 id="streamer-name" class="d-none d-sm-block"></h4>

                        <div class="d-block d-sm-none">
                            <h4 id="streamer-name-mobile"></h4>

                            <div class="dropdown" id="slct" style="display:none;">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    style="background: transparent;">
                                    <h4 id="streamer-name-mobile1" style="float:left;"></h4>
                                    <i class="feather icon-chevron-down" style="color:white;"></i>

                                </button>
                                <div class="dropdown-menu" id="co-menu" aria-labelledby="dropdownMenuButton" style="">


                                </div>
                            </div>

                            <!--                            <a class="p-2 btn-mobile navbar-toggler-mobile" id="slct" href="#" id="nav-inner-success_dropdown_1" role="button" data-toggle="dropdown">
                                                            <h4 id="streamer-name-mobile1"></h4>
                                                            <span class="d-lg-none"></span>
                                                            <i class="feather icon-chevron-down m-0 align-middle"></i>
                                                        </a>
                                                        <div class="dropdown-menu mb-1 dropdown-menu-right dd-menu-user" id="co-menu" aria-labelledby="nav-inner-success_dropdown_1">
                            
                                                            <a href="javascript:void(0);" data-toggle="modal" title="{{trans('general.create_event')}}" data-target="#eventForm" class="dropdown-item dropdown-navbar">
                                                                {{trans('general.create_event')}}
                                                            </a>
                                                            <div class="dropdown-divider dropdown-navbar"></div>
                            
                                                            <a class="dropdown-item dropdown-navbar" href="{{url('events')}}" title="{{trans('general.our_events')}}">
                                                                {{trans('general.our_events')}}
                                                            </a>
                                                        </div>-->

                            <!--                            <select name="slct" id="slct" style="display:none;" class='browser-default'>


    </select>-->
                        </div>
                    </div>
                </a>
            </li>

            <li>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Cams</button>
                        <div class="cam-list dropdown-menu"></div>
                    </div>
                    <input type="text" class="cam-input form-control" aria-label="Text input with dropdown button"
                        readonly>
                </div>
            </li>
            <!--            <li>
                            <a href="javascript:;">
                                <div class="user">
                                    <img src="https://webmobdemo.xyz/sponzydev/sponzy/public/uploads/avatar/5da8273e-41616952448bwjv1ivj8q.png">
                                    <h4 id="cohost-name"></h4>
                                    <button id="leave" type="button" class="btn btn-primary btn-sm cohost-remove" style="display:none;"><img src="{{ asset('public/img/leave-call.png') }}" /></button>
            
                                </div>
                            </a>
                        </li>-->
        </ul>
    </div>

    <div class="top-right-part">
        <ul>
            <!--            <li>
                            <div class="dropdown" id="cohost-screen-controlls" style="display:none">  style="display:none" 
                                <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenusButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Controls
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenusButton">
                                    <a href="javascript:;" onclick="liveCommentBoxHide();" id="hideCommentBox">
                                        <i class="fas fa-comments"></i>
                                    </a> 
            
                                    <a href="javascript:;" onclick="liveCommentBoxShow();" id="showCommentBox" style="display: none;">
                                        <i class="fas fa-comments"></i>
                                    </a>  <hr>
            
                                    <a href="javascript:;" onclick="liveCommentOffBtn();" id="hideComment">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M7 7h10v2H7zm0 4h7v2H7z" fill="#626262"/><path d="M20 2H4c-1.103 0-2 .897-2 2v18l5.333-4H20c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zm0 14H6.667L4 18V4h16v12z" fill="#626262"/></svg>
                                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M9.707 13.707L12 11.414l2.293 2.293l1.414-1.414L13.414 10l2.293-2.293l-1.414-1.414L12 8.586L9.707 6.293L8.293 7.707L10.586 10l-2.293 2.293z" fill="#626262"/><path d="M20 2H4c-1.103 0-2 .897-2 2v18l5.333-4H20c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zm0 14H6.667L4 18V4h16v12z" fill="#626262"/></svg> 
                                         <img src="{{ asset('public/img/comment.png') }}" style="width: 23px;"> 
                                    </a>  
            
                                    <a href="javascript:;" onclick="liveCommentOnBtn();" id="showComment" style="display: none;">
                                        <img src="{{ asset('public/img/comment-hide.png') }}" style="width: 23px;"/>
                                    </a>
                                    <hr>
            
                                    <a href="javascript:;" onclick="liveAudioBtn();" id="liveAudioBtn"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M842 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 140.3-113.7 254-254 254S258 594.3 258 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 168.7 126.6 307.9 290 327.6V884H326.7c-13.7 0-24.7 14.3-24.7 32v36c0 4.4 2.8 8 6.2 8h407.6c3.4 0 6.2-3.6 6.2-8v-36c0-17.7-11-32-24.7-32H548V782.1c165.3-18 294-158 294-328.1zM512 624c93.9 0 170-75.2 170-168V232c0-92.8-76.1-168-170-168s-170 75.2-170 168v224c0 92.8 76.1 168 170 168zm-94-392c0-50.6 41.9-92 94-92s94 41.4 94 92v224c0 50.6-41.9 92-94 92s-94-41.4-94-92V232z" fill="#626262"/></svg>
                                         <img src="{{ asset('public/img/unmute.png') }}" style="width: 23px;" /> 
                                    </a>  <hr>
            
                                    <a href="javascript:;" onclick="liveVideoBtn();" id="liveVideoBtn"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g class="icon-tabler" fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14v-4z"/><rect x="3" y="6" width="12" height="12" rx="2"/></g></svg>
                                         <img src="{{ asset('public/img/pause.png') }}" style="width: 23px;"/> 
                                    </a>  <hr>
            
                                    <a href="javascript:;" onclick="screenShare();" id="liveScreenShareBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g class="icon-tabler" fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="3" width="14" height="14" rx="2"/><path d="M17 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2"/></g></svg>
                                         <i class="fa fa-desktop"></i> 
                                    </a>
                                    <a href="javascript:;" onclick="screenShareHide();" id="liveScreenShareHideBtn" style="display:none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g class="icon-tabler" fill="none" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="3" width="14" height="14" rx="2"/><path d="M17 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2"/></g></svg>
                                         <i class="fa fa-desktop"></i> 
                                    </a>  <hr>
            
                                    <a href="javascript:;" onclick="liveFrontCameraBtn(this.getAttribute('data-camid'), this.getAttribute('data-camlabel'));" id="liveFrontCameraBtn" style="display:none;" data-camid="" data-camlabel="">
                                        <img src="{{ asset('public/img/camera.png') }}" style="width: 23px;"/>
                                    </a> 
                                    <a href="javascript:;" onclick="liveBackCameraBtn(this.getAttribute('data-camid'), this.getAttribute('data-camlabel'));" id="liveBackCameraBtn" data-camid="" data-camlabel="">
                                        <img src="{{ asset('public/img/camera.png') }}" style="width: 23px;"/>
                                    </a>  <hr>
            
                                    <a href="javascript:;" onclick="liveLeaveBtn();" id="leaveHost"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none"><path d="M7.772 2.439l1.076-.344c1.01-.322 2.087.199 2.52 1.217l.859 2.028c.374.883.167 1.922-.514 2.568L9.819 9.706c.116 1.076.478 2.135 1.084 3.177a8.678 8.678 0 0 0 2.271 2.595l2.275-.76c.863-.287 1.802.044 2.33.821l1.233 1.81c.615.904.505 2.15-.258 2.916l-.818.821c-.814.817-1.977 1.114-3.052.778c-2.539-.792-4.873-3.143-7.003-7.053c-2.133-3.916-2.886-7.24-2.258-9.968c.264-1.148 1.081-2.063 2.149-2.404z" fill="#626262"/></g></svg>
                                         <img src="{{ asset('public/img/leave-call.png') }}" style="width: 23px;" /> 
                                    </a>  
            
                                </div>
                            </div>
            
            
                        </li>-->
            <li class="live"><span class="blink">Live</span></li>
            <!--            <li class="co-host">
            
                            <div class="dropdown ">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="https://webmobdemo.xyz/sponzydev/sponzy/public/uploads/avatar/join.png" style="width:20px;">
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            
                                    <div id="activeusr">
            
                                        @foreach ($cohostusr as $user)
                                        @if ( Cache::has('is-online-' . $user->user()->id) && $user->user()->status == 'active' && $user->user()->verified_id == 'yes')
            
                                        <a class="dropdown-item dropdown-navbar dropdown-lang " href="javascript:;" onclick="requestCoHost('{{$user->user()->id}}','{{$appID}}','{{$token}}','{{$channelName}}');">
                                            {{ $user->user()->name }}
                                        </a>
            
                                        @endif
                                        @endforeach
            
                                    </div>
            
                                </div>
                            </div>
            
                        </li>-->
            <li class="co-host">

                <div class="dropdown ">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://webmobdemo.xyz/sponzydev/sponzy/public/uploads/avatar/join.png"
                            style="width:20px;">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                        <input id="searchCreators" name="searchCreators"
                            placeholder="{{ trans('general.find_cohost') }}" type="text" autocomplete="off">
                        <button class="button-search" style="top:10px;">
                            <i class="fa fa-search"></i>
                        </button>

                        <div class="w-100 text-center display-none py-2" id="searchSpinner">
                            <span class="spinner-border spinner-border-sm align-middle text-primary"></span>
                        </div>

                        @php
                        if (auth()->check() && auth()->user()->dark_mode == 'on' ){
                        $color = '#fff !important';
                        }else {
                        $color = '#495057 !important';
                        }

                        @endphp
                        <div id="creatorsContainer"></div>
                        <!-- style="color: {{$color}}" -->

                    </div>
                </div>

            </li>
            <li class="user"><input id="countUser" class="countUser" name="countUser" type="text" value="0" readonly>
            </li>

        </ul>
    </div>

    <div id="tip_notification"></div>




</section>
@endsection