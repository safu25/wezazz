//<--------- Start Event -------//>
(function($) {
    
    var $uploadCrop, tempFilename, rawImg, imageId;

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            alert("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 300,
            height: 150,
        },
        enforceBoundary: false,
        enableExif: true
    });
    $('#cropImagePop').on('shown.bs.modal', function () {
        // alert('Shown pop');
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
            console.log('jQuery bind complete');
        });
    });


    $('#uploadEventImg').on('change', function () {
        imageId = $(this).data('id');
        tempFilename = $(this).val();

        $('#cancelCropBtn').data('id', imageId);
        readFile(this);
    });
    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: {width: 300, height: 150}
        }).then(function (resp) {
            $('#blah').css('display', 'inline-block');
            $('#blah').attr('src', resp);
            $('#event_images').val(resp);
            $('#cropImagePop').modal('hide');
            $(".event_img").css('display', 'none');

            // document.getElementsByClassName("event_img").style.display = "none";

            $(".img_remove_btn").css('display', 'inline-block');
        });
    });
    
    
    $('#cropImagePop').on('hidden.bs.modal', function (e) {

        $('body').addClass('modal-open');

    });
    
        $('#start-date').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            autoclose: true,
            startDate: new Date(),
            onShow: function (ct) {
                this.setOptions({
                    maxDate: $('#end-date').val() ? $('#end-date').val() : false
                })
            },
        });
//        $('#end-date').datetimepicker({
//            format: "yyyy-mm-dd hh:ii",
//            autoclose: true,
//            startDate: new Date(),
//            onShow: function (ct) {
//                this.setOptions({
//                    minDate: $('#start-date').val() ? $('#start-date').val() : false
//                })
//            },
//        });
    
   
    
    $(document).on('change', '#event-cost', function () {
        var event_cost = $(this).val();
        var input = $('input[name=event_price]');

        if (event_cost == 'paid') {
            $('#event-price').css('display', 'block');
            input.val('');
            input.focus();

        } else if (event_cost == 'free') {
            input.val(0);
            $('#event-price').css('display', 'none');
        }


    });

    $(document).on('change', '#end-date', function () {

        var event_sdate = $("#start-date").val();
        var event_duration = $(this).val();
        var duration = event_duration * 60;

        var dt = new Date(event_sdate);
        //    dt.setHours( dt.getHours() + 2 );
        dt.setMinutes(dt.getMinutes() + duration);
        $("#duration_for_event").val(dt);
        //document.write( dt );

        console.log(dt);
    });
    
    
    
    $(document).on('click', '#submitEventFrm', function (s) {

        s.preventDefault();
        submitEventFrm();

    });

    function submitEventFrm() {

        $('#submitEventFrm').attr({'disabled': 'true'});
        $('#submitEventFrm').find('i').addClass('spinner-border spinner-border-sm align-middle mr-1');

        $.ajax({
            type: "POST",
            url: URL_BASE + "/uploadEvent",
            datatype: "json",
            data: $('#formSendEvent').serialize(),
            success: function (result) {

                // success
                if (result.success == true) {

                    $('.alert-danger').hide();
                    $('#eventForm').modal('hide');
                    console.log(result.message);

                    window.location.href = URL_BASE + "/my_events";
                    toastr.success(result.message);

                    $('#submitEventFrm').removeAttr('disabled');
                    $('#submitEventFrm').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');

                } else {

                    if (result.errors)
                    {
                        $('.alert-danger').html('');

                        var error = '';
                        var $key = '';

                        for ($key in result.errors) {
                            error += '<li><i class="far fa-times-circle"></i> ' + result.errors[$key] + '</li>';
                        }
                        $('.alert-danger').show();
                        $('.alert-danger').append('<li>' + error + '</li>');

                        $('#submitEventFrm').removeAttr('disabled');
                        $('#submitEventFrm').find('i').removeClass('spinner-border spinner-border-sm align-middle mr-1');

                    }
                }

            }

        });

    }
    
    
    
})(jQuery);



 function remove_event_img() {

        $('#uploadEventImg').val('');
        $('#event_images').val('');
        $('#blah').attr('src', '');
        $('#blah').css('display', 'none');
        $(".event_img").css('display', 'inline-block');
        $(".img_remove_btn").css('display', 'none');
    }
    
    
function shareEvent(event_id, user_name) {

    $('#share-event-modal').modal('show');
    var copy_url_href = "{{ URL('/')}}" + "/events/" + event_id;
    var facebook_href = "https://www.facebook.com/sharer/sharer.php?u=" + copy_url_href;
    $("#facebook_href").attr("href", facebook_href);
    var twitter_href = "https://twitter.com/intent/tweet?url=" + copy_url_href + "&text=" + user_name;
    $("#twitter_href").attr("href", twitter_href);
    $("#twitter_href").attr('data-url', copy_url_href);
    var whatsapp_href = "whatsapp://send?text=" + copy_url_href;
    $("#whatsapp_href").attr("href", whatsapp_href);
    var mail_href = "mailto:?subject=" + user_name + "&amp;body=" + copy_url_href;
    $("#mail_href").attr("href", mail_href);
    var sms_href = "sms://?body={{ trans('general.check_this') }} " + copy_url_href;
    $("#sms_href").attr("href", sms_href);
    $('#copy_link').val(copy_url_href);
    }
    
    

    function checkInterest(interest, user_id, event_id) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: URL_BASE + "/countAdd",
            datatype: "json",
            data: {interest: interest, user_id: user_id, event_id: event_id, _token: _token},
            success: function (response) {
                if (response.result == '1') {
                    console.log(response.message);

                    if (interest == 'interested') {
                        $('.dropdownMenuButton_' + event_id).html('<i class="fa fa-star" aria-hidden="true"></i> Interested');
                        $('.dropdownMenuButton_' + event_id).css('color', '#c56cf0');

                    } else if (interest == 'going') {
                        $('.dropdownMenuButton_' + event_id).html('<i class="fa fa-check-circle" aria-hidden="true"></i> Going');
                        $('.dropdownMenuButton_' + event_id).css('color', '#c56cf0');

                    } else if (interest == 'not_interested') {
                        $('.dropdownMenuButton_' + event_id).html('<i class="fas fa-times-circle" aria-hidden="true"></i> Not Interested');
                        $('.dropdownMenuButton_' + event_id).css('color', '#c56cf0');
                    }

                    $("#showCountedInterest_" + event_id).load(window.location.href + " #showCountedInterest_" + event_id);


                }
            }
        });


        //  $('#dropdownMenuButton').text(interest);

    }