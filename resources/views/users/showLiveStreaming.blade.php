@extends('layouts.app')

@section('title') {{trans('Join Live Streaming')}} -@endsection


<style>
    header {
        display:none !important;
    }
    footer {
        display:none !important;
    }
    #removeFooterLive{
        display:none !important;
    }

 
</style>

@section('javascript')
<script type="text/javascript">

    window.onload = function () {
        $("#audience-join").click();
      //  $("#login").click();

    }

    $(document).ready(function () {

        setTimeout(function () {
            $('#login').click();
        }, 5000);
        
        setTimeout(function () {
            $('#join').trigger('click');
        }, 5000);

        setTimeout(function () {
            $('#join').trigger('click');
        }, 25000);

    });


    $(".leave_stream").click(function (e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "post",
            url: "{{route('startStreaming')}}",
            datatype: "json",
            data: {status: 0, _token: _token},
            success: function (response) {
                console.log(response.message);
            }
        });
        leave();

        console.log("client leaves channel success");
        location.href = " {{ url('/') }}";
    });


//    $(".coHostLeave").click(function (e) {
//
//        var retVal = confirm("Are you sure you want to end your live video ?");
//        if (retVal == true) {
//
//            leaveCohost();
//
//
//            $.ajaxSetup({
//                headers: {
//                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                }
//            });
//            var _token = $('input[name="_token"]').val();
//            var streamerid = $('#streamerid').val();
//            $.ajax({
//                type: "post",
//                url: "{{route('leaveCoHost')}}",
//                datatype: "json",
//                data: {status: 0, streamerid: streamerid, _token: _token},
//                success: function (response) {
//                    console.log(response.message);
//                    $('#videobutton').css('display', 'none');
//                }
//            });
//
//            return true;
//        } else {
//            return false;
//        }
//    });



    function CheckCohostRemove() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        var streamerid = $('#streamerid').val();
        $.ajax({
            type: "POST",
            url: "{{route('CheckCohostRemove')}}",
            datatype: "json",
            data: {streamerid: streamerid, _token: _token},
            success: function (response) {
                //  console.log(response.result);
                if (response.result == 'success') {
                    // console.log(response.result);
                } else if (response.result == 'leave') {
                    // $(".coHostLeave").click(); 
                    //  console.log(response.result);
                    leaveCohost();
                    $('#videobutton').css('display', 'none');
                    $("#comment-full-screen").css('display', 'inline-block');
                    var CheckAvailPlayer = $(".checkhost div.mainPlayer").length;
                    console.log('CheckAvailPlayer' + CheckAvailPlayer);
                    if (CheckAvailPlayer == 2) {
                        $(".checkhost").addClass("twoCoHostJoin");
                    } else if (CheckAvailPlayer == 1) {
                        $(".checkhost").removeClass("twoCoHostJoin");
                        $(".checkhost").removeClass("twoHostJoin");
                    }
                    clearInterval(interval);

                    commentInterval = setInterval(function () {
                        checkComment();
                    }, 2000);
                }
            }
        });
    }
    
    
    function audienceJoinThreeHost() {
         var CheckAvailPlayer = $(".checkhost div.mainPlayer").length;
                    console.log('CheckAvailableStreamer: ' + CheckAvailPlayer);
                    
                    if (CheckAvailPlayer == 3) {
                        $(".checkhost").addClass("threeHost");
                         $("#co-host-video").addClass('allHostName');
                        $(".checkhost .audienceSide:first-child > .mainPlayer > .player").addClass('firstHost');
                       
                    } else {
                        $(".checkhost").removeClass("threeHost");
                        $("#co-host-video").removeClass('allHostName');
                        $(".checkhost .audienceSide:first-child > .mainPlayer > .player").removeClass('firstHost');
                         
                    }
    }

    function leavePage() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        var streamerName = $('#streamerName').val();
        $.ajax({
            type: "POST",
            url: "{{route('leavePage')}}",
            datatype: "json",
            data: {streamerName: streamerName, _token: _token},
            success: function (response) {
                //  console.log(response.result);
                if (response.result == 'success') {
                    // console.log(response.result);
                } else if (response.result == 'leave') {
                    location.href = " {{ url('/') }}";
                    //console.log(response.result);
                }
            }
        });
    }

    function checkCoRequest() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        var streamerid = $('#streamerid').val();
        $.ajax({
            type: "POST",
            url: "{{route('checkCoRequest')}}",
            datatype: "json",
            data: {streamerid: streamerid, _token: _token},
            success: function (response) {
                //  console.log(response.result);
                if (response.result == 'refresh') {
                    $("#app_Id").val(response.value.appid);
                    $("#hosttoken").val(response.value.token);
                    $("#hostchannel").val(response.value.channel);
                    $("#streamer_id").val(response.value.streamer_id);
                    $("#accept_join").css("display", "inline-block");


                    // $("#checkreq").load(window.location.href + " #checkreq" )
                    //    console.log(response.result);
                } else if (response.result == 'notrefresh') {
                    //  location.href = " {{ url('/') }}";
                    $("#accept_join").css("display", "none");
                    // console.log(response.result);
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
        var cohostnames = $('#coname').val();

        $.ajax({
            type: "POST",
            url: "{{route('acceptreq')}}",
            datatype: "json",
            data: {streamerid: streamerid, _token: _token},
            success: function (response) {
                //  console.log(response.result);
                if (response.result == 'success') {

                    var names = response.cohostname;
                    var nameArr = names.toString().split(',');
                    var coname = "{{ auth()->user()->name }}";

                    if (nameArr.length == 1) {

                        if (nameArr[0] == coname) {

                            $("#cohost-name").text(nameArr[0]);
                            $("#cohost-names").text('');
                            $("#seperate-cohost").css('display', 'none');

                            $("#full-screen-video-user").removeClass("twoHostJoin");
                            $(".checkhost").removeClass("twoCoHostJoin");
                            $(".checkhost").removeClass("threeJoin");



                        } else {
                            $("#cohost-name").text('');
                            $("#cohost-names").text(nameArr[0]);
                            $("#seperate-cohost").css('display', 'inline-block');

                            $(".checkhost").addClass("twoCoHostJoin");
                            $("#full-screen-video-user").removeClass("twoHostJoin");
                            $(".checkhost").removeClass("threeJoin");
                        }

                        // $("#comment-wrp").addClass('comment-wrp');

                        $("#streamer-name-mobile1").css('display', 'none');
                        $("#slct").css('display', 'inline-block');

                        $("#cohost-name-mobile1").text(nameArr[0]);

//                        $('#slct').html('<option id="cohost-name-mobile1">' + nameArr[0] + '</option>\n\
//                                            <option id="streamer-name-mobile2">' + cohostnames + '</option>')

                        $("#co-menu").html('<a href="javascript:void(0);" id="streamer-name-mobile2" class="dropdown-item"> Host - ' + cohostnames + '</a>');

                    }

                    if (nameArr.length == 2) {
                        if (nameArr[0] == coname) {

                            $("#cohost-name").text(nameArr[0]);
                            $("#cohost-names").text(nameArr[1]);
                            $("#seperate-cohost").css('display', 'inline-block');

                            $("#cohost-name-mobile1").text(nameArr[0]);

                            $("#co-menu").html('<a href="javascript:void(0);" id="streamer-name-mobile2" class="dropdown-item"> Host - ' + cohostnames + '</a>\n\
                                            <a href="javascript:void(0);" id="cohost-name-mobile2" class="dropdown-item"> Co-Host - ' + nameArr[1] + '</a>')


//                            $('#slct').html('<option id="cohost-name-mobile1">' + nameArr[0] + '</option>\n\
//                                            <option id="streamer-name-mobile2">' + cohostnames + '</option>\n\
//                                            <option id="cohost-name-mobile2">' + nameArr[1] + '</option>')
                        } else {
                            $("#cohost-names").text(nameArr[0]);
                            $("#cohost-name").text(nameArr[1]);
                            $("#seperate-cohost").css('display', 'inline-block');

                            $("#cohost-name-mobile1").text(nameArr[1]);

                            $("#co-menu").html('<a href="javascript:void(0);" id="streamer-name-mobile2" class="dropdown-item"> Host - ' + cohostnames + '</a>\n\
                                            <a href="javascript:void(0);" id="cohost-name-mobile2" class="dropdown-item"> Co-Host - ' + nameArr[0] + '</a>')

//
//                            $('#slct').html('<option id="cohost-name-mobile1">' + nameArr[1] + '</option>\n\
//                                            <option id="streamer-name-mobile2">' + cohostnames + '</option>\n\
//                                            <option id="cohost-name-mobile2">' + nameArr[0] + '</option>')
                        }
                        $(".checkhost").removeClass("twoCoHostJoin");
                        $("#full-screen-video-user").addClass("twoHostJoin");
                        $(".checkhost").addClass("threeJoin");

                        // $("#comment-wrp").addClass('comment-wrp');

                        $("#streamer-name-mobile1").css('display', 'none');
                        $("#slct").css('display', 'inline-block');



                        //    $("#cohost-name-mobile1").text(nameArr[0]);
                        //    $("#cohost-name-mobile2").text(nameArr[1]);


                    }

                   // $("#comment-full-screen").css('display', 'none');

                    if ('{{ auth()->check()}}' && '{{auth()->user()->dark_mode}}' == 'on') {
                        $('.dropdown-item').attr('style', 'color: #ffffff !important');
                    } else {
                        $('.dropdown-item').attr('style', 'color: #212529 !important');
                    }

//                     var coname = "{{ auth()->user()->name }}";
//                     console.log('hello' +coname);
//                    $("#cohost-name").text(response.cohostname);
//                    console.log(response.result);
                } else if (response.result == 'notanycohost') {

                    $("#full-screen-video-user").removeClass('col-md-6');
                    $("#full-screen-video-user").removeClass('twoHostJoin');
                    $("#full-screen-video-user").removeClass('twoCoHostJoin');
                    $(".checkhost").removeClass("threeJoin");
                    $("#full-screen-video-user").addClass('col-md-12');
                    $("#full-screen-video-user").addClass('host-live-full-screen');
                    //  $("#comment-wrp").removeClass('comment-wrp');

                    $("#comment-wrp").addClass('comment-wrap');

                    $("#cohost-name").text(response.cohostname);
                    $("#seperate-cohost").css('display', 'none');
                    $("#cohost-names").text(response.cohostname);
                    //   console.log(response.result);

                    $("#streamer-name-mobile1").css('display', 'inline-block');
                    $('#slct').css("display", "none");
                    $('#co-menu').html('');
                    // $('#slct').html('');

                    $("#comment-full-screen").css('display', 'inline-block');

                }
            }
        });
    }

//    $("#tipBtn").click(function (e) {
//    
//    toastr.options = {
//          "closeButton": true,
//          "newestOnTop": true,
//          "positionClass": "toast-top-right"
//        };
//        
//    var sender_name = $("#cardholder-name").val();
//    var amount = $("#onlyNumber").val();
//
//
//    var view = '<p>' + sender_name + ' send you a tip amount $' + amount + '.</p>';
// 
//                toastr.success(view);
//                console.log(view);
//        
//     // $('#tip_notification').append(view);
//    
//});

//    $("#tipBtn").click(function (e) {
//
//        setTimeout(function () {
//            checkNotification();
//        }, 5000);
//    //    checkNotification()
//
//    });
//
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
            data: {streamerid: streamerid, _token: _token},
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

    function checkCountUser() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        var streamerid = $('#streamerid').val();
        $.ajax({
            type: "POST",
            url: "{{route('checkCountUser')}}",
            datatype: "json",
            data: {streamerid: streamerid, _token: _token},
            success: function (response) {
                if (response.message == 'success') {

                    $("#totalUser").val(response.totalCntUser);
                    //  console.log("total user in livestream is " + response.totalCntUser);
                    //    console.log(response.cohostname);
                }
            }
        });
    }

    function checkComment() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        var streamerid = $('#streamerid').val();
        $.ajax({
            type: "POST",
            url: "{{route('checkComment')}}",
            datatype: "json",
            data: {streamerid: streamerid, _token: _token},
            success: function (response) {
                if (response.message == 'success') {

                    if (response.comment_status == 0) {
                        $('.comment-wrp').css('display', 'inline-block');
                        //   $("#comment-full-screen").css('display', 'inline-block');
                        $('#log').css('display', 'inline-block');
                        $('#comment-hide').removeAttr('disabled');
                        $('#comment-show').removeAttr('disabled');
                    } else {
                        $('.comment-wrp').css('display', 'none');
                        $('#log').css('display', 'none');
                        $('#comment-hide').attr('disabled', 'disabled');
                        $('#comment-show').attr('disabled', 'disabled');
                        //   $("#comment-full-screen").css('display', 'none');
                    }

                    //   console.log('comment status:' + response.comment_status);

                }
            }
        });
    }


    function checkScreenShare() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        var streamerid = $('#streamerid').val();
        $.ajax({
            type: "POST",
            url: "{{route('checkScreenShare')}}",
            datatype: "json",
            data: {streamerid: streamerid, _token: _token},
            success: function (response) {
                if (response.message == 'success') {

                    if (response.screen_share_status == 0) {
                        $('.agora_video_player').removeClass('screen-share-video');
                    } else {
                        $('.agora_video_player').addClass('screen-share-video');
                    }

                    //   console.log('Screen status:' + response.screen_share_status);

                }
            }
        });

    }


//    function checkvideo() {
//        var CheckVideo = $("video").length;
//        console.log('total video' + CheckVideo);
//        if (CheckVideo == '3') {
//            $(".checkhost").removeClass("twoCoHostJoin");
//            $(".checkhost").addClass("threeJoin");
//        } else {
//            $(".checkhost").removeClass("threeJoin");
//        }
//
//    }



    var interval;

    $(document).ready(function () {


        $('#accept_join').click(function (e) {

            var CheckPlayer = $(".checkhost div.mainPlayer").length;
            if (CheckPlayer == 1) {
                $(".checkhost").removeClass("twoCoHostJoin");
            }

//    options.role = "host";


            var streamer_id = $("#streamer_id").val();

            $("#accept_join").hide();
            $("#comment-full-screen").css('display', 'none');




            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var _token = $('input[name="_token"]').val();


            $.ajax({
                type: "POST",
                url: "{{route('acceptCoHost')}}",
                datatype: "json",
                data: {streamer_id: streamer_id, _token: _token},
                success: function (response) {
                    console.log(response.message);
                    $("#full-screen-video-user").removeClass('col-md-12');
                    $("#full-screen-video-user").removeClass('host-live-full-screen');
                    $("#full-screen-video-user").addClass('col-md-6');
                    $("#full-screen-video-user").addClass('host-live');
                    $("#co-host-video").addClass('Cohost-live');
                    $("#comment-wrp").removeClass('comment-wrap');

                    $('#comment-wrp').css('display', 'inline-block');
                     $('#log').css('display', 'inline-block');

                    CoHost();

                    clearInterval(commentInterval);

                    interval = setInterval(function () {
                        CheckCohostRemove();
                    }, 3000);

                }

            });

            //  CoHost();


        });
    });

    var commentInterval;

    $(document).ready(function () {

//                setInterval(function(){
//              $("#checkreq").load(window.location.href + " #checkreq" );
//          //    console.log('check');
//        }, 4000);

        setInterval(function () {
            leavePage();
        }, 3000);


        setInterval(function () {
            checkCoRequest();
        }, 3000);

//        setInterval(function () {
//            checkvideo();
//        }, 3000);

        setInterval(function () {
            acceptreq();
        }, 3000);

        setInterval(function () {
            checkCountUser();
        }, 2000);

        setInterval(function () {
            checkScreenShare();
        }, 3000);

        setInterval(function () {
            audienceJoinThreeHost();
        }, 3000);

        commentInterval = setInterval(function () {
            checkComment();
        }, 2000);

//        setInterval(function () {
//            checkNotification();
//        }, 1000);


    });


  var deleter = {

        linkSelector: ".coHostLeave",

        init: function () {
            $(this.linkSelector).on('click', {self: this}, this.handleClick);
        },

        handleClick: function (event) {
            event.preventDefault();

            var self = event.data.self;
            var link = $(this);

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
                            leaveCohost();


                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            var _token = $('input[name="_token"]').val();
                            var streamerid = $('#streamerid').val();
                            $.ajax({
                                type: "post",
                                url: "{{route('leaveCoHost')}}",
                                datatype: "json",
                                data: {status: 0, streamerid: streamerid, _token: _token},
                                success: function (response) {
                                    console.log(response.message);
                                    $('#videobutton').css('display', 'none');
                                    $("#comment-wrp").addClass('comment-wrap');
                                    $("#comment-full-screen").css('display', 'inline-block');

//                                    commentInterval = setInterval(function () {
//                                        checkComment();
//                                    }, 2000);
                                }
                            });

                            return true;
                        } else {
                            return false;
                        }
                    });

        },
    };

    deleter.init();

    $("#comment-hide").click(function (e) {

        clearInterval(commentInterval);

        $('#log').css('display', 'none');
        $('#comment-wrp').css('display', 'none');
        $('#comment-hide').css('display', 'none');
        $('#comment-show').css('display', 'inline-block');
        $('#showCommentBox').css('display', 'inline-block');
        $('#hideCommentBox').css('display', 'none');


    });
    $("#comment-show").click(function (e) {
        commentInterval = setInterval(function () {
            checkComment();
        }, 2000);

        $('#log').css('display', 'inline-block');
        $('#comment-wrp').css('display', 'inline-block');
        $('#comment-hide').css('display', 'inline-block');
        $('#comment-show').css('display', 'none');
        $('#hideCommentBox').css('display', 'none');
        $('#showCommentBox').css('display', 'inline-block');



    });
    
</script>


<script>
    document.getElementById('channelMessage').addEventListener('keypress', function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();

            document.getElementById('send_channel_message').click();
        }
    });
</script>

@endsection


@section('content')

@if(isset($notification))

<center>
    <div id="loader" style="margin:80px auto;">
        <img id="loading-image" src="{{ asset('public/img/loader1.gif') }}" /><p></p>
    </div>
</center>    

<section class="section">

    <div class="container" id="hide-full-screen" style="display:none;">
        <div class="row">
            <div class="col-md-8 mb-lg-0 py-5 wrap-post">

                <form id="join-form" action="">       <!-- method="post"  -->

                    <input id="streamerName" type="hidden" value="{{ $streamerName }}">

                    @csrf

                    <div class="row join-info-group">
                        <div class="col-sm">
                            <input id="appid" type="hidden" value="{{ $appID }}" required>
                        </div>
                        <div class="col-sm">
                            <input id="token" type="hidden" value="{{ $token }}">
                        </div>
                        <div class="col-sm">
                            <input id="channel" type="hidden" value="{{ $channelName }}" required>
                            <input id="streamerid" type="hidden" value="{{ $user->id }}" required>
                        </div>
                    </div>

                    <div class="button-group">
                        <button id="audience-join" type="submit" class="btn btn-primary btn-sm" style="display:none">{{trans('general.join_streaming')}}</button>

                        <button id="full-video" type="button" class="btn btn-primary btn-sm" style="display:none">full screen</button>


                    </div>
                </form>


                <div class="row video-group">
                    <div class="w-100"></div>
                    <div class="col">
                        <div id="remote-playerlist"></div>
                    </div>
                </div>


            </div>

            <div class="col-md-4 pb-4 py-lg-5 chatbox" style="display:none;" >



            </div>

        </div>
    </div>

    <div class="row video-screen-card">

        <input type="hidden" value="{{ auth()->user()->name }}" id="hosterName">
        <div id="co-host-video" class="col-md-6">
            <div class="top-left-part">
                <ul> 
                    <li>
                        <a href="#">
                            <div class="user">
                                <h4 id="cohost-name" class="d-none d-sm-block"></h4>
                                <img src="{{Helper::getFile(config('path.avatar').$user->avatar)}}" alt="" class="img-user-small d-block d-sm-none">
                                <div class="d-block d-sm-none">
                                    <input type="hidden" value="{{ $user->name }}" id="coname">
                                    <h4 id="streamer-name-mobile1">{{ $user->name }}</h4>

                                    <div class="dropdown"  id="slct" style="display:none;">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: transparent;">
                                            <h4 id="cohost-name-mobile1" style="float:left;"></h4>
                                            <i class="feather icon-chevron-down" style="color:white;"></i>

                                        </button>
                                        <div class="dropdown-menu" id="co-menu" aria-labelledby="dropdownMenuButton" style="">


                                        </div>
                                    </div>

<!--                                    <select name="slct" id="slct" style="display:none;" class='browser-default'>

</select>-->
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

            <h1 id="local-player-name" style="display: none;"></h1>

            <div class="row video-group livesreaming-popup">
                <div class="col">
                    <input type="hidden" id="muteAudio" value="{{ asset('public/img/mute.png') }}">
                    <input type="hidden" id="unmuteAudio" value="{{ asset('public/img/unmute.png') }}">
                    <input type="hidden" id="muteVideo" value="{{ asset('public/img/play.png') }}">
                    <input type="hidden" id="unmuteVideo" value="{{ asset('public/img/pause.png') }}">


                </div>

            </div>

        </div>
        <div id="full-screen-video-user" class="livesreaming-popup checkhost col-md-12 host-live-full-screen"> 

            <div class="top-right-part">
                <ul>
                    <li class="" id="checkreq">

                        <!--        <div id="checkreq">-->


                        <form id="join-host-form" action="">         <!-- method="post"  -->


                            @csrf

                            <input id="app_Id" type="hidden" value="" required>
                            <input id="hosttoken" type="hidden" value="">
                            <input id="hostchannel" type="hidden" value="" required>
                            <input id="streamer_id" type="hidden" name="streamer_id" value="" >
                            <input id="streamername" name="streamername" type="hidden" value="{{ auth()->user()->name }}" >

                            <button class="btn btn-primary btn-sm please_accept" type="button" id="accept_join" style="display: none;">Accept</button>

                        </form>



                        <!--        </div>-->
                    </li>

                    <li class="">
                        @if (auth()->check() && auth()->user()->id != $user->id && $user->updates()->count() <> 0)
                        <a href="javascript:void(0);" data-toggle="modal" title="{{trans('general.tip')}}" data-target="#tipForm" class="btn btn-google btn-profile mr-1 give_gift" data-cover="{{Helper::getFile(config('path.cover').$user->cover)}}" data-avatar="{{Helper::getFile(config('path.avatar').$user->avatar)}}" data-name="{{$user->hide_name == 'yes' ? $user->username : $user->name}}" data-userid="{{$user->id}}">
                            <i class="fa fa-donate mr-1 mr-lg-0"></i> {{trans('general.tip')}}
                        </a>
                        @elseif (auth()->guest() && $user->updates()->count() <> 0)
                        <a href="{{url('login')}}" data-toggle="modal" style="color:#fff;padding: 6px 10px !important;margin-bottom: 0 !important;" data-target="#loginFormModal" class="btn btn-google btn-profile mr-1" title="{{trans('general.tip')}}">
                            <i class="fa fa-donate mr-1 mr-lg-0"></i> {{trans('general.tip')}}
                        </a>
                        @endif
                    </li>

<!--                    <li class="user"><input id="countUser" name="countUser" type="text" value="0" readonly></li>-->
                    <li class="user"><input id="totalUser" class="countUser" name="totalUser" type="text" readonly></li>

                    <li class="close-wrp">
                        <button id="leave" type="button" class="btn btn-primary btn-sm leave_stream " style="background-color: #f00 !important;padding: 7px 10px !important;border: 1px solid #f00 !important;">
                            <!--                            <h6 class="d-lg-block d-none">Leave</h6>
                            
                                                        <i class="fa fa-times d-lg-none"> </i> -->
                            <h6 class="d-none d-sm-block">Leave</h6>

                            <i class="fa fa-times d-block d-sm-none"> </i> 

                        </button>

                    </li>

                </ul>
            </div>
            <!--        onclick="acceptJoin('')"-->

            <div class="top-left-part">
                <ul>
                    <li>
                        <!--                        <a href="{{url($user->username)}}">-->
                        <a href="javascript:;">
                            <div class="user">
                                <img src="{{Helper::getFile(config('path.avatar').$user->avatar)}}" alt="" class="img-user-small d-none d-sm-block">
                                <h4 class="d-none d-sm-block">{{ $user->name }}</h4>
                                <h4 id="seperate-cohost" class="" style="display:none;"> , </h4>
                                <h4 id="cohost-names" class="d-none d-sm-block"></h4>
                            </div>
                        </a>
                    </li>
                    <!--                    <li>
                                            <a href="#">
                                                <div class="user">
                                                    <h4 id="cohost-name"></h4>
                                                </div>
                                            </a>
                                        </li>-->
                </ul>
            </div>

            <!--            <div id="tip_notification"></div>-->



            <div class="row video-group livesreaming-popup">
                <div class="col">

                    <div class="" id="local-player">
                        <div class="videButton host-video-btn" style="display:none">

                            <!--                            <div class="popup-btn">
                                                            <button id="mute-audio-host" type="button" class="btn btn-primary btn-sm mute-audio-host" style="display:none" disabled>
                                                                <img src="{{ asset('public/img/unmute.png') }}" />
                                                            </button>
                                                            <p>Mute</p>
                                                        </div>
                                                        <div class="popup-btn">
                                                            <button id="mute-video-host" type="button" class="btn btn-primary btn-sm mute-video-host" style="display:none" disabled><img src="{{ asset('public/img/pause.png') }}" /></button>
                                                            <p>Video</p>
                                                        </div>-->
                        </div>
                    </div>

                </div>

            </div>

            <div class="chating-wrp chat" style="z-index: 9;">
                <div class="chating-box" id="log">

                    @if(isset($liveChat))

                    @foreach($liveChat AS $key => $value)

                    <div class="user-block">

                        <div class="user-img">
                            <img src="{{ $value->user_img }}">
                        </div>

                        <div class="user-dt">
                            <h3> {{ $value->user_name }} </h3>
                            <p> {{ $value->message }} </p> 
                        </div> 

                    </div>

                    @endforeach

                    @endif                 

                </div>

                <div class="d-flex flex-row-reverse comment-HS align-items-center">
                    <div id="comment-full-screen">
                        <button id="comment-hide" class="btn btn-primary btn-sm"><i class="fas fa-comments"></i></button>
                        <button id="comment-show" style="display: none;" class="btn btn-primary btn-sm"><i class="far fa-comments"></i></button>
                    </div>
                    <div class="" id="local-player">
                        <div class="videButton" id="videobutton" style="display:none">

                            <!--      <div class="popup-btn">
                                      <button id="mute-audio" type="button" class="btn btn-primary btn-sm">
                                          <img src="{{ asset('public/img/unmute.png') }}" />
                                      </button>
                                      <p>Mute</p>
                                  </div>
                                  <div class="popup-btn">
                                      <button id="mute-video" type="button" class="btn btn-primary btn-sm"><img src="{{ asset('public/img/pause.png') }}" /></button>
                                      <p>Video</p>
                                  </div>
      
                                  <div class="popup-btn switch-camera">
                                      <button id="switchBtn1" type="button" class="btn btn-primary btn-sm" style="display:none" data-camid="" data-camlabel="">
                                          <img src="{{ asset('public/img/camera.png') }}" />
                                      </button>
                                      <button id="switchBtn2" type="button" class="btn btn-primary btn-sm" data-camid="" data-camlabel="">
                                          <img src="{{ asset('public/img/camera.png') }}" />
                                      </button>
                                      <p>camera</p>
                                  </div>
      
                                  <div class="popup-btn leave-btn">
                                      <button id="leave" type="button" class="btn btn-primary btn-sm coHostLeave"><img src="{{ asset('public/img/leave-call.png') }}" /></button>
                                      <p>Leave</p>
                                  </div>-->

                            <div id="cohost-screen-controlls" style="width: 45px;height: 40px;margin-left: auto;">
                                <ul id="menu" class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
                                    <li class="mfb-component__wrap">
                                        <a href="#" class="mfb-component__button--main">
                                          <!-- <i class="mfb-component__main-icon--resting ion-plus-round"> -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 64 64"><path fill="#fff" d="M58.18 25.98H38.03V5.83c0-7.77-12.05-7.77-12.05 0v20.15H5.83c-7.768 0-7.768 12.05 0 12.05h20.15v20.15c0 7.77 12.05 7.77 12.05 0V38.03h20.15c7.769 0 7.769-12.05 0-12.05"/></svg>
                                            <!-- </i> -->

                                        </a>
                                        <ul class="mfb-component__list">

                                            <li class="mfb-component__wrap">
                                                <a href="javascript:;" onclick="liveCommentBoxHide();" id="hideCommentBox" data-mfb-label="Comments Visible" class="mfb-component__button--child">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="#fff" d="M144 208c-17.7 0-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32s-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32s-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32s-14.3-32-32-32zM256 32C114.6 32 0 125.1 0 240c0 47.6 19.9 91.2 52.9 126.3C38 405.7 7 439.1 6.5 439.5c-6.6 7-8.4 17.2-4.6 26S14.4 480 24 480c61.5 0 110-25.7 139.1-46.3C192 442.8 223.2 448 256 448c141.4 0 256-93.1 256-208S397.4 32 256 32zm0 368c-26.7 0-53.1-4.1-78.4-12.1l-22.7-7.2l-19.5 13.8c-14.3 10.1-33.9 21.4-57.5 29c7.3-12.1 14.4-25.7 19.9-40.2l10.6-28.1l-20.6-21.8C69.7 314.1 48 282.2 48 240c0-88.2 93.3-160 208-160s208 71.8 208 160s-93.3 160-208 160z" /></svg>                                
                                                    <!-- <i class="fas fa-comments"></i> -->
                                                </a>

                                                <a href="javascript:;" onclick="liveCommentBoxShow();" id="showCommentBox" data-mfb-label="Comments Hidden"  class="mfb-component__button--child" style="display: none;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="#fff" d="M256 32C114.6 32 0 125.1 0 240c0 49.6 21.4 95 57 130.7C44.5 421.1 2.7 466 2.2 466.5c-2.2 2.3-2.8 5.7-1.5 8.7S4.8 480 8 480c66.3 0 116-31.8 140.6-51.4c32.7 12.3 69 19.4 107.4 19.4c141.4 0 256-93.1 256-208S397.4 32 256 32z" /></svg>
                                                    <!-- <i class="far fa-comments"></i> -->
                                                </a>

                                            </li>

                                            <li class="mfb-component__wrap">
                                                <a href="javascript:;" onclick="liveAudioBtn();" id="liveAudioBtn" class="mfb-component__button--child" data-mfb-label="Audio"> 
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024"><path fill="#fff" d="M842 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 140.3-113.7 254-254 254S258 594.3 258 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 168.7 126.6 307.9 290 327.6V884H326.7c-13.7 0-24.7 14.3-24.7 32v36c0 4.4 2.8 8 6.2 8h407.6c3.4 0 6.2-3.6 6.2-8v-36c0-17.7-11-32-24.7-32H548V782.1c165.3-18 294-158 294-328.1zM512 624c93.9 0 170-75.2 170-168V232c0-92.8-76.1-168-170-168s-170 75.2-170 168v224c0 92.8 76.1 168 170 168zm-94-392c0-50.6 41.9-92 94-92s94 41.4 94 92v224c0 50.6-41.9 92-94 92s-94-41.4-94-92V232z" /></svg>
                                                    <!-- <img src="{{ asset('public/img/unmute.png') }}" style="width: 23px;" /> -->
                                                </a>  
                                            </li>

                                            <li class="mfb-component__wrap">
                                                <a href="javascript:;" onclick="liveVideoBtn();" id="liveVideoBtn" data-mfb-label="Video" class="mfb-component__button--child"> 
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g class="icon-tabler" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14v-4z" fill="none"></path><rect x="3" y="6" width="12" height="12" rx="2"></rect></g></svg>
                                                    <!-- <img src="{{ asset('public/img/pause.png') }}" style="width: 23px;"/> -->
                                                </a>  
                                            </li>

                                            <li class="mfb-component__wrap switch-camera-control">
                                                <a href="javascript:;" onclick="liveFrontCameraBtn(this.getAttribute('data-camid'), this.getAttribute('data-camlabel'));" id="liveFrontCameraBtn" style="display:none;" data-camid="" data-camlabel="" data-mfb-label="Back Camera"  class="mfb-component__button--child">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                                    <path d="M350.54 148.68l-26.62-42.06C318.31 100.08 310.62 96 302 96h-92c-8.62 0-16.31 4.08-21.92 10.62l-26.62 42.06C155.85 155.23 148.62 160 140 160H80a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h352a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32h-59c-8.65 0-16.85-4.77-22.46-11.32z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                                    <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M124 158v-22h-24v22"/>
                                                    <path d="M335.76 285.22v-13.31a80 80 0 0 0-131-61.6M176 258.78v13.31a80 80 0 0 0 130.73 61.8" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                                    <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M196 272l-20-20l-20 20"/>
                                                    <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M356 272l-20 20l-20-20"/>
                                                    </svg>
                                                    <!-- <img src="{{ asset('public/img/camera.png') }}" style="width: 23px;"/> -->
                                                </a> 
                                                <a href="javascript:;" onclick="liveBackCameraBtn(this.getAttribute('data-camid'), this.getAttribute('data-camlabel'));" id="liveBackCameraBtn" data-camid="" data-camlabel="" data-mfb-label="Front Camera" class="mfb-component__button--child">
                                                    <svg xmlns="http://www.w3.org/2000/svg"width="1em" height="1em" viewBox="0 0 512 512">
                                                    <path d="M432 144h-59c-3 0-6.72-1.94-9.62-5l-25.94-40.94a15.52 15.52 0 0 0-1.37-1.85C327.11 85.76 315 80 302 80h-92c-13 0-25.11 5.76-34.07 16.21a15.52 15.52 0 0 0-1.37 1.85l-25.94 41c-2.22 2.42-5.34 5-8.62 5v-8a16 16 0 0 0-16-16h-24a16 16 0 0 0-16 16v8h-4a48.05 48.05 0 0 0-48 48V384a48.05 48.05 0 0 0 48 48h352a48.05 48.05 0 0 0 48-48V192a48.05 48.05 0 0 0-48-48zM316.84 346.3a96.06 96.06 0 0 1-155.66-59.18a16 16 0 0 1-16.49-26.43l20-20a16 16 0 0 1 22.62 0l20 20A16 16 0 0 1 196 288a17.31 17.31 0 0 1-2-.14a64.07 64.07 0 0 0 102.66 33.63a16 16 0 1 1 20.21 24.81zm50.47-63l-20 20a16 16 0 0 1-22.62 0l-20-20a16 16 0 0 1 13.09-27.2A64 64 0 0 0 215 222.64A16 16 0 1 1 194.61 198a96 96 0 0 1 156 59a16 16 0 0 1 16.72 26.35z" fill="#fff"/>
                                                    </svg>
                                                    <!-- <img src="{{ asset('public/img/camera.png') }}" style="width: 23px;"/> -->
                                                </a>
                                            </li>

                                            <li class="mfb-component__wrap">
                                                <a href="javascript:;" class="mfb-component__button--child coHostLeave" data-mfb-label="Leave" style="background-color: #f00;"> 
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g><path fill="#fff" d="M7.772 2.439l1.076-.344c1.01-.322 2.087.199 2.52 1.217l.859 2.028c.374.883.167 1.922-.514 2.568L9.819 9.706c.116 1.076.478 2.135 1.084 3.177a8.678 8.678 0 0 0 2.271 2.595l2.275-.76c.863-.287 1.802.044 2.33.821l1.233 1.81c.615.904.505 2.15-.258 2.916l-.818.821c-.814.817-1.977 1.114-3.052.778c-2.539-.792-4.873-3.143-7.003-7.053c-2.133-3.916-2.886-7.24-2.258-9.968c.264-1.148 1.081-2.063 2.149-2.404z" /></g></svg>
                                                    <!-- <img src="{{ asset('public/img/leave-call.png') }}" style="width: 23px;" /> -->
                                                </a>
                                            </li>



                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="comment-wrp comment-wrap" id="comment-wrp">

                        <form id="loginForm" action="">        <!-- method="post"  -->
                            @csrf
                            <input id="appId" name="appId" type="hidden" value="{{ $appID }}" required>
                            <input id="accountName" name="accountName"  type="hidden" value="{{ $username }}">
                            <input id="usrtoken" name="token" type="hidden" value="{{ $chattoken }}">
                            <input id="channelName" name="channelName" type="hidden" value="{{ $channelName }}" required>
    <!--                        <input id="countUser" name="countUser" type="hidden" value="0" >-->

                            <div class="form-group">
                                <button id="login" type="submit" style="display:none;" >LOGIN</button>
                                <button id="logout" style="display:none;" >LOGOUT</button>
                                <button id="join" style="display:none">JOIN</button>
                            </div>


                            <div class="form-group">
                                <input type="text" placeholder="Add a Comment..." class="form-control m-0" name="channelMessage" id="channelMessage">
                                <input type="hidden" name="usrAvatar" id="usrAvatar" value="{{ Helper::getFile(config('path.avatar').auth()->user()->avatar) }}">
                                <button id="send_channel_message"><img src="https://webmobdemo.xyz/sponzydev/sponzy/public/uploads/avatar/send.svg"></button>
                            </div>


                        </form>


                    </div>
                </div>
            </div>


        </div>



    </div>



</section>

@else

<section>
    <p>{{trans('general.end_livestream')}}

        <a href="{{ url('/') }}">{{trans('general.back')}} </a> {{trans('general.home')}}
    </p>
</section>
@endif


@endsection