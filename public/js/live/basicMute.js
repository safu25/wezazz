// create Agora client
var client = AgoraRTC.createClient({mode: "live", codec: "vp8"});
var localTracks = {
    videoTrack: null,
    audioTrack: null
};

var remoteTracks = {
    videoTrack: null,
    audioTrack: null
};

var localTrackState = {
    videoTrackEnabled: true,
    audioTrackEnabled: true
}

var remoteUsers = {};
// Agora client options
var options = {
    appid: null,
    channel: null,
    uid: null,
    token: null,
    role: "audience" // host or audience

};

var btn = {
    AudioMute: $('#muteAudio').val(),
    AudioUnmute: $('#unmuteAudio').val(),
    videoMute: $('#muteVideo').val(),
    videoUnmute: $('#unmuteVideo').val(),
};

var cams = []; // all cameras devices you can use
var currentCam; // the camera you are using




// the demo can auto join channel with params in url
$(() => {
//    var urlParams = new URL(location.href).searchParams;
//    options.appid = urlParams.get("appid");
//    options.channel = urlParams.get("channel");
//    options.token = urlParams.get("token");
//
//
//    if (options.appid && options.channel) {
//        $("#appid").val(options.appid);
//        $("#token").val(options.token);
//        $("#channel").val(options.channel);
//        $("#join-form").submit();
//    }

    
})

$("#host-join").click(function (e) {
    options.role = "host"

    options.status = $("#status").val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: 'startStreaming',
        datatype: "json",
        data: {status: options.status, _token: _token},
        success: function (response) {
            console.log(response.message);
        }
    });

})

$("#host-join-live-event").click(function (e) {
    options.role = "host"

    options.status = $("#status").val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $('input[name="_token"]').val();
    var eventId = $('input[name="eventId"]').val();
    $.ajax({
        type: "post",
        url: URL_BASE + '/startEventStreaming',
        datatype: "json",
        data: {status: options.status, eventId: eventId, _token: _token},
        success: function (response) {
            console.log(response.message);
        }
    });

})


$("#audience-join").click(function (e) {
    options.role = "audience"

})

//async function mediaDeviceTest() {
//  // create local tracks
//  [ localTracks.audioTrack, localTracks.videoTrack ] = await Promise.all([
//    // create local tracks, using microphone and camera
//    AgoraRTC.createMicrophoneAudioTrack(),
//    AgoraRTC.createCameraVideoTrack()
//  ]);
//
//  // play local track on device detect dialog
//  localTracks.videoTrack.play("full-screen-video");
//  // localTracks.audioTrack.play();
//
//  // get cameras
//  cams = await AgoraRTC.getCameras();
//  currentCam = cams[0];
//  $(".cam-input").val(currentCam.label);
//  cams.forEach(cam => {
//    $(".cam-list").append(`<a class="dropdown-item" href="#">${cam.label}</a>`);
//  });
//}

$("#join-form").submit(async function (e) {

    e.preventDefault();
    // $("#host-join").attr("disabled", true);
    // $("#audience-join").attr("disabled", true);

    try {
        options.appid = $("#appid").val();
        options.token = $("#token").val();
        options.channel = $("#channel").val();
        options.streamername = $("#streamername").val();


        await join();
        if (options.role === "host") {
            $("#success-alert a").attr("href", '/liveStreaming');
            if (options.token) {
                $("#success-alert-with-token").css("display", "block");
            } else {
                $("#success-alert a").attr("href", '/liveStreaming');
                $("#success-alert").css("display", "block");
            }
        }
    } catch (error) {
        console.error(error);
    } finally {
        $("#leave").attr("disabled", false);
    }
})

//$("#leave").click(function (e) {
//    leave();
//});

// $(".coHostLeave").click(function (e) {
//     leaveCohost();
//  
// });

// $(".cohost-remove").click(function (e) {
//     hostleaveCohost();
//  
// });


$("#mute-audio").click(function (e) {
    if (localTrackState.audioTrackEnabled) {
        muteAudio();
        $("#mute-audio").html("<img src=" + btn.AudioMute + "  />");
        $("#liveAudioBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024"><defs/><path d="M682 455V311l-76 76v68c-.1 50.7-42 92.1-94 92c-19.1.1-36.8-5.4-52-15l-54 55c29.1 22.4 65.9 36 106 36c93.8 0 170-75.1 170-168z" fill="#fff"/><path d="M833 446h-60c-4.4 0-8 3.6-8 8c0 140.3-113.7 254-254 254c-63 0-120.7-23-165-61l-54 54c48.9 43.2 110.8 72.3 179 81v102H326c-13.9 0-24.9 14.3-25 32v36c.1 4.4 2.9 8 6 8h408c3.2 0 6-3.6 6-8v-36c0-17.7-11-32-25-32H547V782c165.3-17.9 294-157.9 294-328c0-4.4-3.6-8-8-8zm13.1-377.7l-43.5-41.9c-3.1-3-8.1-3-11.2.1l-129 129C634.3 101.2 577 64 511 64c-93.9 0-170 75.3-170 168v224c0 6.7.4 13.3 1.2 19.8l-68 68c-10.5-27.9-16.3-58.2-16.2-89.8c-.2-4.4-3.8-8-8-8h-60c-4.4 0-8 3.6-8 8c0 53 12.5 103 34.6 147.4l-137 137c-3.1 3.1-3.1 8.2 0 11.3l42.7 42.7c3.1 3.1 8.2 3.1 11.3 0L846.2 79.8l.1-.1c3.1-3.2 3-8.3-.2-11.4zM417 401V232c0-50.6 41.9-92 94-92c46 0 84.1 32.3 92.3 74.7L417 401z" fill="#fff"/></svg>');
    } else {
        unmuteAudio();
        $("#mute-audio").html("<img src=" + btn.AudioUnmute + "  />");
        $("#liveAudioBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024"><path fill="#fff" d="M842 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 140.3-113.7 254-254 254S258 594.3 258 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 168.7 126.6 307.9 290 327.6V884H326.7c-13.7 0-24.7 14.3-24.7 32v36c0 4.4 2.8 8 6.2 8h407.6c3.4 0 6.2-3.6 6.2-8v-36c0-17.7-11-32-24.7-32H548V782.1c165.3-18 294-158 294-328.1zM512 624c93.9 0 170-75.2 170-168V232c0-92.8-76.1-168-170-168s-170 75.2-170 168v224c0 92.8 76.1 168 170 168zm-94-392c0-50.6 41.9-92 94-92s94 41.4 94 92v224c0 50.6-41.9 92-94 92s-94-41.4-94-92V232z" /></svg>');
    }
});

$("#mute-video").click(function (e) {
    if (localTrackState.videoTrackEnabled) {
        muteVideo();
        $("#mute-video").html("<img src=" + btn.videoMute + " />");
        $("#liveVideoBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path d="M20.31 6H4a2 2 0 0 0-2 2v16a2.85 2.85 0 0 0 0 .29z" fill="#fff"/><path d="M29.46 8.11a1 1 0 0 0-1 .08L23 12.06v-1.62l7-7L28.56 2L2 28.56L3.44 30l4-4H21a2 2 0 0 0 2-2v-4.06l5.42 3.87A1 1 0 0 0 30 23V9a1 1 0 0 0-.54-.89z" fill="#fff"/></svg>');
    } else {
        unmuteVideo();
        $("#mute-video").html("<img src=" + btn.videoUnmute + " />");
        $("#liveVideoBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g class="icon-tabler" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14v-4z" fill="none"></path><rect x="3" y="6" width="12" height="12" rx="2"></rect></g></svg>');
    }
})


function liveAudioBtn() {
    if (localTrackState.audioTrackEnabled) {
        muteAudio();
        $("#mute-audio").html("<img src=" + btn.AudioMute + "  />");
        $("#liveAudioBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024"><defs/><path d="M682 455V311l-76 76v68c-.1 50.7-42 92.1-94 92c-19.1.1-36.8-5.4-52-15l-54 55c29.1 22.4 65.9 36 106 36c93.8 0 170-75.1 170-168z" fill="#fff"/><path d="M833 446h-60c-4.4 0-8 3.6-8 8c0 140.3-113.7 254-254 254c-63 0-120.7-23-165-61l-54 54c48.9 43.2 110.8 72.3 179 81v102H326c-13.9 0-24.9 14.3-25 32v36c.1 4.4 2.9 8 6 8h408c3.2 0 6-3.6 6-8v-36c0-17.7-11-32-25-32H547V782c165.3-17.9 294-157.9 294-328c0-4.4-3.6-8-8-8zm13.1-377.7l-43.5-41.9c-3.1-3-8.1-3-11.2.1l-129 129C634.3 101.2 577 64 511 64c-93.9 0-170 75.3-170 168v224c0 6.7.4 13.3 1.2 19.8l-68 68c-10.5-27.9-16.3-58.2-16.2-89.8c-.2-4.4-3.8-8-8-8h-60c-4.4 0-8 3.6-8 8c0 53 12.5 103 34.6 147.4l-137 137c-3.1 3.1-3.1 8.2 0 11.3l42.7 42.7c3.1 3.1 8.2 3.1 11.3 0L846.2 79.8l.1-.1c3.1-3.2 3-8.3-.2-11.4zM417 401V232c0-50.6 41.9-92 94-92c46 0 84.1 32.3 92.3 74.7L417 401z" fill="#fff"/></svg>');
    } else {
        unmuteAudio();
        $("#mute-audio").html("<img src=" + btn.AudioUnmute + "  />");
        $("#liveAudioBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024"><path fill="#fff" d="M842 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 140.3-113.7 254-254 254S258 594.3 258 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 168.7 126.6 307.9 290 327.6V884H326.7c-13.7 0-24.7 14.3-24.7 32v36c0 4.4 2.8 8 6.2 8h407.6c3.4 0 6.2-3.6 6.2-8v-36c0-17.7-11-32-24.7-32H548V782.1c165.3-18 294-158 294-328.1zM512 624c93.9 0 170-75.2 170-168V232c0-92.8-76.1-168-170-168s-170 75.2-170 168v224c0 92.8 76.1 168 170 168zm-94-392c0-50.6 41.9-92 94-92s94 41.4 94 92v224c0 50.6-41.9 92-94 92s-94-41.4-94-92V232z" /></svg>');
    }
}

function liveVideoBtn() {
    if (localTrackState.videoTrackEnabled) {
        muteVideo();
        $("#mute-video").html("<img src=" + btn.videoMute + " />");
        $("#liveVideoBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path d="M20.31 6H4a2 2 0 0 0-2 2v16a2.85 2.85 0 0 0 0 .29z" fill="#fff"/><path d="M29.46 8.11a1 1 0 0 0-1 .08L23 12.06v-1.62l7-7L28.56 2L2 28.56L3.44 30l4-4H21a2 2 0 0 0 2-2v-4.06l5.42 3.87A1 1 0 0 0 30 23V9a1 1 0 0 0-.54-.89z" fill="#fff"/></svg>');
    } else {
        unmuteVideo();
        $("#mute-video").html("<img src=" + btn.videoUnmute + " />");
        $("#liveVideoBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g class="icon-tabler" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14v-4z" fill="none"></path><rect x="3" y="6" width="12" height="12" rx="2"></rect></g></svg>');
    }
}


function liveCommentOffBtn() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: URL_BASE + '/commentStatus',
        datatype: "json",
        data: {status: 1, _token: _token},
        success: function (response) {
            if (response.message = 'success') {
                $('#comment-on').css('display', 'none');
                $('#comment-off').css('display', 'inline-block');
                $('#hideComment').css('display', 'none');
                $('#showComment').css('display', 'inline-block');
            }
            console.log(response.message);
        }
    });
}

function liveCommentOnBtn() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: URL_BASE + '/commentStatus',
        datatype: "json",
        data: {status: 0, _token: _token},
        success: function (response) {
            if (response.message = 'success') {
                $('#comment-off').css('display', 'none');
                $('#comment-on').css('display', 'inline-block');
                $('#showComment').css('display', 'none');
                $('#hideComment').css('display', 'inline-block');
            }
            console.log(response.message);
        }
    });
}

function liveCommentBoxHide() {
    $('#log').css('display', 'none');
    $('#comment-wrp').css('display', 'none');
    $('#comment-hide').css('display', 'none');
    $('#comment-show').css('display', 'inline-block');
    $('#hideCommentBox').css('display', 'none');
    $('#showCommentBox').css('display', 'inline-block');
}

function liveCommentBoxShow() {
    $('#log').css('display', 'inline-block');
    $('#comment-wrp').css('display', 'inline-block');
    $('#comment-hide').css('display', 'inline-block');
    $('#comment-show').css('display', 'none');
    $('#hideCommentBox').css('display', 'inline-block');
    $('#showCommentBox').css('display', 'none');
}


//$("#comment-on").click(function (e) {
//        
// $.ajaxSetup({
//        headers: {
//            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//        }
//    });
//    var _token = $('input[name="_token"]').val();
//    $.ajax({
//        type: "post",
//        url: URL_BASE+'/commentStatus',
//        datatype: "json",
//        data: {status: 1, _token: _token},
//        success: function (response) {
//             if(response.message = 'success'){
//                $('#comment-on').css('display', 'none');
//                $('#comment-off').css('display', 'inline-block');
//            }
//            console.log(response.message);
//        }
//    });
//        
//});
//
//
//$("#comment-off").click(function (e) {
//    $.ajaxSetup({
//        headers: {
//            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//        }
//    });
//    var _token = $('input[name="_token"]').val();
//    $.ajax({
//        type: "post",
//        url: URL_BASE+'/commentStatus',
//        datatype: "json",
//        data: {status: 0, _token: _token},
//        success: function (response) {
//             if(response.message = 'success'){
//               $('#comment-off').css('display', 'none');
//                $('#comment-on').css('display', 'inline-block');
//            }
//            console.log(response.message);
//        }
//    });
//    
//});

//$("#comment-hide").click(function (e) {
//    $('#log').css('display', 'none');
//  //  $('#comment-wrp').css('display', 'none');
//    $('#comment-hide').css('display', 'none');
//    $('#comment-show').css('display', 'inline-block');
//
//});
//$("#comment-show").click(function (e) {
//    $('#log').css('display', 'inline-block');
//  //  $('#comment-wrp').css('display', 'inline-block');
//    $('#comment-hide').css('display', 'inline-block');
//    $('#comment-show').css('display', 'none');
//
//});


$("#switchBtn1").click(function (e) {

    var camId = $(this).attr("data-camid");
    var camLabel = $(this).attr("data-camlabel");

    $("#switchBtn1").css("display", "none");
    $("#switchBtn2").css("display", "inline-block");
    $("#liveFrontCameraBtn").css("display", "none");
    $("#liveBackCameraBtn").css("display", "inline-block");


    console.log('btn1:' + camId);
    switchCamera(camLabel);
})

$("#switchBtn2").click(function (e) {


    var camId = $(this).attr("data-camid");
    var camLabel = $(this).attr("data-camlabel");

    $("#switchBtn2").css("display", "none");
    $("#switchBtn1").css("display", "inline-block");
    $("#liveBackCameraBtn").css("display", "none");
    $("#liveFrontCameraBtn").css("display", "inline-block");


    console.log('btn2:' + camId);
    switchCamera(camLabel);
})

function liveFrontCameraBtn(camId, camLabel) {

//    var camId = that.getAttribute("data-camid");
//    var camLabel = that.getAttribute("data-camlabel");

    $("#switchBtn1").css("display", "none");
    $("#switchBtn2").css("display", "inline-block");
    $("#liveFrontCameraBtn").css("display", "none");
    $("#liveBackCameraBtn").css("display", "inline-block");


    console.log('btn1:' + camId);
    switchCamera(camLabel);
}

function liveBackCameraBtn(camId, camLabel) {


//    var camId = that.getAttribute("data-camid");
//    var camLabel = that.getAttribute("data-camlabel");

    $("#switchBtn2").css("display", "none");
    $("#switchBtn1").css("display", "inline-block");
    $("#liveBackCameraBtn").css("display", "none");
    $("#liveFrontCameraBtn").css("display", "inline-block");


    console.log('btn2:' + camId);
    switchCamera(camLabel);
}


$(".cam-list").delegate("a", "click", function (e) {
    switchCamera(this.text);
});

$("#screen-share").click(function (e) {
    screenShare();
})

async function screenShare() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: URL_BASE + '/screenSharing',
        datatype: "json",
        data: {status: 1, _token: _token},
        success: function (response) {
            console.log(response.message);
        }
    });


    client.unpublish(localTracks.videoTrack);
    localTracks.videoTrack.stop();
    localTracks.videoTrack.close();
    localTracks.videoTrack = await AgoraRTC.createScreenVideoTrack();
    localTracks.videoTrack.play("full-screen-video");
//     await client.publish(Object.values(localTracks));
    await client.publish(localTracks.videoTrack);
    console.log('screen share video track:' + localTracks.videoTrack);
    $("#screen-share").css('display', 'none');
    $("#screen-share-hide").css('display', 'inline-block');
    $("#liveScreenShareBtn").css('display', 'none');
    $("#liveScreenShareHideBtn").css('display', 'inline-block');
    $("#overlay-for-screen").css('display', 'inline-block');
    $('.agora_video_player').addClass('screen-share-video');
    // $('.agora_video_player').attr('style', 'transform: rotate(0deg) !important');

}

$("#screen-share-hide").click(function (e) {
    screenShareHide();
})

async function screenShareHide() {
    $("#overlay-for-screen").css('display', 'none');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: URL_BASE + '/screenSharing',
        datatype: "json",
        data: {status: 0, _token: _token},
        success: function (response) {
            console.log(response.message);
        }
    });

    client.unpublish(localTracks.videoTrack);
    localTracks.videoTrack.stop();
    localTracks.videoTrack.close();
    localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();
    localTracks.videoTrack.play("full-screen-video");
//     await client.publish(Object.values(localTracks));
    await client.publish(localTracks.videoTrack);

    $("#screen-share-hide").css('display', 'none');
    $("#screen-share").css('display', 'inline-block');
    $("#liveScreenShareHideBtn").css('display', 'none');
    $("#liveScreenShareBtn").css('display', 'inline-block');

}

async function join() {
    // create Agora client
    client.setClientRole(options.role);

    // get cameras
    cams = await AgoraRTC.getCameras();
    console.log('camera :' + JSON.stringify(cams));
    currentCam = cams[0];
    //   $(".cam-input").val(currentCam.label);

//    $("#switchBtn1").attr('data-camlabel', cams[0].label);
//    $("#switchBtn1").attr('data-camid', cams[0].deviceId);
//    
//    // $("#switchBtn1").text(cams[0].deviceId);
//    if (cams.length > 2) {
//        
//         $("#switchBtn2").attr('data-camlabel', cams[0].label);
//    $("#switchBtn2").attr('data-camid', cams[0].deviceId);
//   
//    }
    //  var add = 0;
//    cams.forEach(cam => {
//        
//        if(add == '0') {
//          $("#switchBtn1").attr('data-camlabel', cam.label);
//          $("#switchBtn1").attr('data-camid', cam.deviceId);
//          add++;
//          console.log("check camera first id" +add);
//        }if(add == '1') {
//            $("#switchBtn2").attr('data-camlabel', cam.label);
//          $("#switchBtn2").attr('data-camid', cam.deviceId);
//          add++;
//          console.log("check camera second id" +add);
//        }
//        
////        $(".switchCameraBtn").append(` <button id="switchBtn1" type="button" class="btn btn-primary btn-sm" data-camid="${cam.deviceId}" data-camlabel="${cam.label}">
////                                    <img src="public/img/camera.png" />
////                                </button>`);
//        $(".cam-list").append(`<a class="dropdown-item" href="#">${cam.label}</a>`);
//    });


    Object.entries(cams).forEach(([key, cam]) => {

        //   $("#switchBtn1").text(cam.deviceId);
        if (key == 0) {
            $("#switchBtn1").attr('data-camlabel', cam.label);
            $("#switchBtn1").attr('data-camid', cam.deviceId);
            $("#liveFrontCameraBtn").attr('data-camlabel', cam.label);
            $("#liveFrontCameraBtn").attr('data-camid', cam.deviceId);


            //console.log(`key ${key}: ${cam.label}`);

        }
        if (key == 1) {

            $("#switchBtn2").attr('data-camlabel', cam.label);
            $("#switchBtn2").attr('data-camid', cam.deviceId);
            $("#liveBackCameraBtn").attr('data-camlabel', cam.label);
            $("#liveBackCameraBtn").attr('data-camid', cam.deviceId);

            //      console.log(`key 2: ${cam.label}`);
    }
    });


    if (options.role === "audience") {
        // add event listener to play remote tracks when remote user publishs.
        client.on("user-published", handleUserPublished);
        client.on("user-joined", handleUserJoined);
        client.on("user-left", handleUserLeft);
        client.on("user-unpublished", handleUserUnpublished);
        //  client.on("user-unpublished", handleUserUnpublished);
    }
    // join the channel
    options.uid = await client.join(options.appid, options.channel, options.token || null);

    if (options.role === "host") {

        if (!localTracks.videoTrack) {
            [localTracks.videoTrack] = await Promise.all([
                // create local tracks, using microphone and camera
                AgoraRTC.createCameraVideoTrack({cameraId: currentCam.deviceId})
            ]);
        }
        // create local audio and video tracks
        localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
        // localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();
        // play local video track
        // localTracks.videoTrack.play("local-player");

        // play local track on device detect dialog
        localTracks.videoTrack.play("full-screen-video");
        // localTracks.audioTrack.play();



        //   localTracks.videoTrack.play("full-screen-video");
        // $("#local-player-name").text(`localTrack(${options.uid})`);
        $("#streamer-name").text(`${options.streamername}`);
        $("#streamer-name-mobile").text(`${options.streamername}`);
        // publish local tracks to channel
        await client.publish(Object.values(localTracks));

        console.log("publish success");



    }




    initStats();
    showMuteButton();

}



async function switchCamera(label) {
    currentCam = cams.find(cam => cam.label === label);
    // $(".cam-input").val(currentCam.label);

    // switch device of local video track.
    await localTracks.videoTrack.setDevice(currentCam.deviceId);
    console.log('cameras deviceId : ' + currentCam.deviceId);
}


//$("#tipBtn").click(function (e) {
//    
//    var sender_name = $("#cardholder-name").val();
//    var amount = $("#onlyNumber").val();
//
//
//    var view = '<p>' + sender_name + ' send you a tip amount $' + amount + '.</p>';
// 
//        
//      $('#tip_notification').append(view);
//    
//});


async function leave() {
    for (trackName in localTracks) {
        var track = localTracks[trackName];
        if (track) {
            track.stop();
            track.close();
            localTracks[trackName] = undefined;
        }
    }


    // remove remote users and player views
    remoteUsers = {};
    $("#remote-playerlist").html("");
    $(".chatbox").css("display", "none");

    // leave the channel
    await client.leave();

    $("#local-player-name").text("");
    $(".chat").css("display", "none");
    $("#full-screen-video").addClass('col-md-12');
    $("#full-screen-video").removeClass('col-md-6');
    $("#full-screen-video").removeClass('host-live');
    hideMuteButton();


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: 'startStreaming',
        datatype: "json",
        data: {status: 0, _token: _token},
        success: function (response) {
            console.log(response.message);
        }
    });

    console.log("client leaves channel success");
}

async function leaveEvent() {
    for (trackName in localTracks) {
        var track = localTracks[trackName];
        if (track) {
            track.stop();
            track.close();
            localTracks[trackName] = undefined;
        }
    }


    // remove remote users and player views
    remoteUsers = {};
    $("#remote-playerlist").html("");
    $(".chatbox").css("display", "none");

    // leave the channel
    await client.leave();

    $("#local-player-name").text("");
    $(".chat").css("display", "none");
    $("#full-screen-video").addClass('col-md-12');
    $("#full-screen-video").removeClass('col-md-6');
    $("#full-screen-video").removeClass('host-live');
    hideMuteButton();


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $('input[name="_token"]').val();
    var eventId = $('input[name="eventId"]').val();
    $.ajax({
        type: "post",
        url: URL_BASE + '/startEventStreaming',
        datatype: "json",
        data: {status: 0, eventId: eventId, _token: _token},
        success: function (response) {
            console.log(response.message);
        }
    });

    console.log("client leaves channel success");
}



async function leaveCohost() {
    for (trackName in localTracks) {
        var track = localTracks[trackName];
        if (track) {
            track.stop();
            track.close();
            localTracks[trackName] = undefined;
        }
    }


    // remove remote users and player views
    remoteUsers = {};
    $("#remote-playerlist").html("");

    // leave the channel
    await client.leave();

    $("#full-screen-video-user").addClass('col-md-12');
    $("#full-screen-video-user").addClass('host-live-full-screen');
    $("#full-screen-video-user").removeClass('col-md-6');
    $("#full-screen-video-user").removeClass('host-live');
    $("#videobutton").removeClass('cohost-video-btn');
    options.role = "audience"
    client.setClientRole(options.role);

    if (options.role === "audience") {
        // add event listener to play remote tracks when remote user publishs.
        client.on("user-published", handleUserPublished);
        client.on("user-joined", handleUserJoined);
        client.on("user-left", handleUserLeft);
        client.on("user-unpublished", handleUserUnpublished);
    }
    // join the channel
    options.uid = await client.join(options.appid, options.channel, options.token || null);



    console.log("CoHost leaves channel success");
}

async function audienceRemove() {
    client.on("user-published", handleUserPublished);
    client.on("user-unpublished", handleUserUnpublished);
    client.on("user-left", handleUserLeft);
}
async function hostleaveCohost() {
    //await client.leave( function(){ 
    for (trackName in remoteTracks) {
        var track = remoteTracks[trackName];
        if (track) {
            track.stop();
            track.close();
            //  client.unpublish(track);
            remoteTracks[trackName] = undefined;
        }
    }
    //  });

    //   await join();

    // remove remote users and player views
    // remoteUsers = {};
    //  $("#remote-playerlist").html("");

    $(".player").remove();
    $("#co-host-video").html("");
    // leave the channel
    await client.leave();

    //  client.unpublish(remoteTracks.videoTrack);

    $("#full-screen-video").addClass('col-md-12');
    $("#full-screen-video").removeClass('col-md-6');
    $("#videobtn").removeClass('cohost-video-btn');
    $("#videobtn").css("display", "none");


    console.log("CoHost leaves channel successed");
}


async function subscribe(user, mediaType) {
    const uid = user.uid;
    // subscribe to a remote user
    await client.subscribe(user, mediaType);
    console.log("subscribe success");


    // if the video wrapper element is not exist, create it.

    if (!user.audioTrack) {
        $("#mute-audio-host").html("<img src=" + btn.AudioMute + " />");
    } else {
        $("#mute-audio-host").html("<img src=" + btn.AudioUnmute + " />");
    }
    if (!user.videoTrack) {
        $("#mute-video-host").html("<img src=" + btn.videoMute + " />");
    } else {
        $("#mute-video-host").html("<img src=" + btn.videoUnmute + " />");
    }

    if (mediaType === 'video') {

        if ($(`#player-wrapper-${uid}`).length === 0) {
            const player = $(`<div class="audienceSide">
                    <div id="player-wrapper-${uid}" class="mainPlayer">
                        <div id="player-${uid}" class="player"></div>
                    </div>
                    </div>
                
      `);
            var DivSize = $("#full-screen-video-user div.mainPlayer").length;
            if (DivSize == 1) {
                $("#full-screen-video-user").addClass("twoHostJoin");
            } else {
                $("#full-screen-video-user").removeClass("twoHostJoin");
            }

            var DivSizeCheck = $(".checkhost div.mainPlayer").length;
            if (DivSizeCheck == 1) {
                $(".checkhost").addClass("twoCoHostJoin");
            } else {
                $(".checkhost").removeClass("twoCoHostJoin");
            }

            var VideoSize = document.getElementsByTagName("video").length;

            console.log('video length :' + VideoSize);



            $("#full-screen-video-user").append(player);

            //  $("#remote-playerlist").append(player);
//            <p class="streamer-name">remoteUser(${user.streamername})</p>
        }

        $("#full-screen-video").removeClass('col-md-12');
        $("#full-screen-video").addClass('col-md-6');
        $("#full-screen-video").addClass('host-live');
        $("#full-screen-video").removeClass('host-live-full-screen');
        $(".cohost").addClass('Cohost-live');
        $("#videobtn").addClass('cohost-video-btn');
        $("#videobutton").css("display", "none");
        $(".cohost-video-btn").css("display", "inline-block");

        // play the remote video.
        user.videoTrack.play(`player-${uid}`);

    }
    if (mediaType === 'audio') {
        user.audioTrack.play();
    }
}

async function unsubscribe(user, mediaType) {

    if (!user.audioTrack) {
        $("#mute-audio-host").html("<img src=" + btn.AudioMute + " />");
    } else {
        $("#mute-audio-host").html("<img src=" + btn.AudioUnmute + " />");
    }
    if (!user.videoTrack) {
        $("#mute-video-host").html("<img src=" + btn.videoMute + " />");
    } else {
        $("#mute-video-host").html("<img src=" + btn.videoUnmute + " />");
    }

}

function handleUserJoined(user) {
    const id = user.uid;
    remoteUsers[id] = user;
}

function handleUserLeft(user) {
    const id = user.uid;
    delete remoteUsers[id];
    $(`#player-wrapper-${id}`).remove();
}

function handleUserPublished(user, mediaType) {
    subscribe(user, mediaType);
}

//function handleUserUnpublished(user) {
//    const id = user.uid;
//    delete remoteUsers[id];
//    $(`#player-wrapper-${id}`).remove();
//}

function handleUserUnpublished(user, mediaType) {
    unsubscribe(user, mediaType);

}


function hideMuteButton() {
    $("#host-join").css("display", "none");
    $("#audience-join").css("display", "none");
    $(".chat").css("display", "none");
    $(".videButton").css("display", "none");
    $("#mute-video").css("display", "none");
    $("#mute-audio").css("display", "none");
    $("#full-video").css("display", "none");
    $("#switchBtn").css("display", "none");
    $("#leave").css("display", "none");
}

function showMuteButton() {
    $('#loading').hide();
    $('#loader').css("display", "none");
    $('#streaming').css("display", "none");
    $("#host-join").css("display", "none");
    $("#audience-join").css("display", "none");
    $(".chat").css("display", "inline-block");
    $(".host-video-btn").css("display", "inline-block");
    $("#mute-video").css("display", "inline-block");
    $("#mute-audio").css("display", "inline-block");
    $("#switchBtn").css("display", "inline-block");
    $(".mute-video-host").css("display", "inline-block");
    $(".mute-audio-host").css("display", "inline-block");
    $("#full-video").css("display", "inline-block");
    $("#half-screen-video").css("display", "inline-block");
    $(".tip-btn").css("display", "inline-block");
    $(".leave-btn").css("display", "inline-block");
    $("#leave").css("display", "inline-block");
    $(".chatbox").css("display", "inline-block");


}

async function muteAudio() {
    if (!localTracks.audioTrack)
        return;
    await localTracks.audioTrack.setEnabled(false);
    localTrackState.audioTrackEnabled = false;
    //$("#mute-audio").text("Unmute Audio");
    $("#mute-audio").html("<img src=" + btn.AudioMute + " />");
    $("#liveAudioBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024"><defs/><path d="M682 455V311l-76 76v68c-.1 50.7-42 92.1-94 92c-19.1.1-36.8-5.4-52-15l-54 55c29.1 22.4 65.9 36 106 36c93.8 0 170-75.1 170-168z" fill="#fff"/><path d="M833 446h-60c-4.4 0-8 3.6-8 8c0 140.3-113.7 254-254 254c-63 0-120.7-23-165-61l-54 54c48.9 43.2 110.8 72.3 179 81v102H326c-13.9 0-24.9 14.3-25 32v36c.1 4.4 2.9 8 6 8h408c3.2 0 6-3.6 6-8v-36c0-17.7-11-32-25-32H547V782c165.3-17.9 294-157.9 294-328c0-4.4-3.6-8-8-8zm13.1-377.7l-43.5-41.9c-3.1-3-8.1-3-11.2.1l-129 129C634.3 101.2 577 64 511 64c-93.9 0-170 75.3-170 168v224c0 6.7.4 13.3 1.2 19.8l-68 68c-10.5-27.9-16.3-58.2-16.2-89.8c-.2-4.4-3.8-8-8-8h-60c-4.4 0-8 3.6-8 8c0 53 12.5 103 34.6 147.4l-137 137c-3.1 3.1-3.1 8.2 0 11.3l42.7 42.7c3.1 3.1 8.2 3.1 11.3 0L846.2 79.8l.1-.1c3.1-3.2 3-8.3-.2-11.4zM417 401V232c0-50.6 41.9-92 94-92c46 0 84.1 32.3 92.3 74.7L417 401z" fill="#fff"/></svg>');
}

async function muteVideo() {
    if (!localTracks.videoTrack)
        return;
    await localTracks.videoTrack.setEnabled(false);
    localTrackState.videoTrackEnabled = false;
    //$("#mute-video").text("Unmute Video");
    $("#mute-video").html("<img src=" + btn.videoMute + " />");
    $("#liveVideoBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32"><path d="M20.31 6H4a2 2 0 0 0-2 2v16a2.85 2.85 0 0 0 0 .29z" fill="#fff"/><path d="M29.46 8.11a1 1 0 0 0-1 .08L23 12.06v-1.62l7-7L28.56 2L2 28.56L3.44 30l4-4H21a2 2 0 0 0 2-2v-4.06l5.42 3.87A1 1 0 0 0 30 23V9a1 1 0 0 0-.54-.89z" fill="#fff"/></svg>');
}

async function unmuteAudio() {
    if (!localTracks.audioTrack)
        return;
    await localTracks.audioTrack.setEnabled(true);
    localTrackState.audioTrackEnabled = true;
    //$("#mute-audio").text("Mute Audio");
    $("#mute-audio").html("<img src=" + btn.AudioUnmute + " />");
    $("#liveAudioBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024"><path fill="#fff" d="M842 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 140.3-113.7 254-254 254S258 594.3 258 454c0-4.4-3.6-8-8-8h-60c-4.4 0-8 3.6-8 8c0 168.7 126.6 307.9 290 327.6V884H326.7c-13.7 0-24.7 14.3-24.7 32v36c0 4.4 2.8 8 6.2 8h407.6c3.4 0 6.2-3.6 6.2-8v-36c0-17.7-11-32-24.7-32H548V782.1c165.3-18 294-158 294-328.1zM512 624c93.9 0 170-75.2 170-168V232c0-92.8-76.1-168-170-168s-170 75.2-170 168v224c0 92.8 76.1 168 170 168zm-94-392c0-50.6 41.9-92 94-92s94 41.4 94 92v224c0 50.6-41.9 92-94 92s-94-41.4-94-92V232z" /></svg>');
}

async function unmuteVideo() {
    if (!localTracks.videoTrack)
        return;
    await localTracks.videoTrack.setEnabled(true);
    localTrackState.videoTrackEnabled = true;
    //$("#mute-video").text("Mute Video");
    $("#mute-video").html("<img src=" + btn.videoUnmute + " />");
    $("#liveVideoBtn").html('<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g class="icon-tabler" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14v-4z" fill="none"></path><rect x="3" y="6" width="12" height="12" rx="2"></rect></g></svg>');
}

$("#full-video").click(function () {

    $('.navbar').css("display", "none");
    $('footer').css("display", "none");
    $('#hide-full-screen').css("display", "none");
    $('#full-screen-video').css("display", "inline-block");
    localTracks.videoTrack.play("full-screen-video");

//	var elem = document.getElementById(document.querySelector('.agora_video_player').id);
//	if (elem.requestFullscreen) {
//		elem.requestFullscreen();
//	} else if (elem.webkitRequestFullscreen) { /* Safari */
//		elem.webkitRequestFullscreen();
//	} else if (elem.msRequestFullscreen) { /* IE11 */
//		elem.msRequestFullscreen();
//	}
});

$('#half-screen-video').click(function () {
    $('.navbar').css("display", "inline-block");
    $('footer').css("display", "inline-block");
    $('#hide-full-screen').css("display", "inline-block");
    $('#full-screen-video').css("display", "none");
    $('#full-screen-video-user').css("display", "none");
    $('#remote-player').css("display", "none");
    localTracks.videoTrack.play("local-player");

    //  user.videoTrack.play(`player-${uid}`)

});

function initStats() {
    statsInterval = setInterval(flushStats, 2000);
}

function flushStats() {
    // get the client stats message
    client.on("user-published", handleUserPublished);
    client.on("user-unpublished", handleUserUnpublished);

}


async function CoHost() {

    options.role = "host";
    $("#join-host-form").submit();


}

$("#join-host-form").submit(async function (e) {

    e.preventDefault();

    try {
        options.appid = $("#app_Id").val();
        options.token = $("#hosttoken").val();
        options.channel = $("#hostchannel").val();
        options.streamername = $("#streamername").val();

        leave()

        client.setClientRole(options.role);

        // get cameras
        cams = await AgoraRTC.getCameras();
        console.log('camera :' + JSON.stringify(cams));
        currentCam = cams[0];


        Object.entries(cams).forEach(([key, cam]) => {

            //   $("#switchBtn1").text(cam.deviceId);
            if (key == 0) {
                $("#switchBtn1").attr('data-camlabel', cam.label);
                $("#switchBtn1").attr('data-camid', cam.deviceId);
                $("#liveFrontCameraBtn").attr('data-camlabel', cam.label);
                $("#liveFrontCameraBtn").attr('data-camid', cam.deviceId);


                //console.log(`key ${key}: ${cam.label}`);

            }
            if (key == 1) {

                $("#switchBtn2").attr('data-camlabel', cam.label);
                $("#switchBtn2").attr('data-camid', cam.deviceId);
                $("#liveBackCameraBtn").attr('data-camlabel', cam.label);
                $("#liveBackCameraBtn").attr('data-camid', cam.deviceId);

                //      console.log(`key 2: ${cam.label}`);
        }
        });

        // join the channel
        options.uid = await client.join(options.appid, options.channel, options.token || null);

        if (options.role === "host") {
            // create local audio and video tracks
            localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
            localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();
            // play local video track
            // localTracks.videoTrack.play("local-player");
            remoteTracks.audioTrack = localTracks.audioTrack
            remoteTracks.videoTrack = localTracks.videoTrack
            localTracks.videoTrack.play("co-host-video");


            $("#local-player-name").text(`remoteTracks(${options.uid})`);
            $("#streamer-name").text(`${options.streamername}`);
            $("#streamer-name-mobile").text(`${options.streamername}`);
            // publish local tracks to channel
            await client.publish(Object.values(remoteTracks));

            console.log("publish success");


        }

        //initStats();
        $("#videobutton").addClass('cohost-video-btn');
        $(".cohost-video-btn").css("display", "inline-block");

        showMuteButton();


    } catch (error) {
        console.error(error);
    } finally {
        $("#leave").attr("disabled", false);
    }
})


