<!-- MODEL FOR UPDATE EVENTS -->

<div class="modal fade" tabindex="-1" role="dialog" id="editeventForm" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content wave_content">
            <div class="modal-header wave_head" style="padding: 0; margin: 0;">
                
              
                <a href="javascript:;" class="event_img  position-absolute button-event-upload "  onclick="$('#uploadEventImg').trigger('click');" id="event_file">
                    <div >
                                <span id="store_event"></span>            
                    </div>
                </a>

                <img src="" width="100%" height="100%" class="blah" style="display:none; margin-bottom: 8px;">

                <a href="javascript:;" class="img_remove_btn" style="display:none;" onclick="remove_event_img();">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a> 
            </div>
              <form action="{{url('editevents')}}" method="POST" enctype="multipart/form-data" >
                    
                    @csrf
                    @method('PUT')
          
            <div class="modal-body p-0 ">
                <div class="card border-0">
                    <div class="card-body px-lg-5 py-lg-5 position-relative">

                    <ul class="alert alert-warning d-none" id="edit_error_list"></ul>

                    <input type="file" name="event_image" id="uploadEventImg" accept="image/*" class="visibility-hidden">
                  
                    <input type="hidden" name="event_img" class="event_images">

                            <input type="hidden" name="event_id" id="event_id" value="">

                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="mb-3" for="event_cost" style=" padding: .625rem .75rem;">
                                        {{trans('general.event_cost')}} :
                                    </label>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <select id="cost" name="event_cost" class="form-control browser-default mb-3"
                                        required>
                                        
                                        <option value="free">Free</option>
                                        <option value="paid">Paid</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group" id="cost-price" >
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input class="form-control isNumber" autocomplete="off" id="price" name="event_price"
                                                type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="mb-3" for="event_name" style=" padding: .625rem .75rem;">
                                        {{trans('general.event_name')}}:
                                    </label>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <input type="text" name="event_name" id="name" class="form-control mb-3" required />
                                    <b style="color: red;" id="start_time_error"></b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="mb-3" for="start_date" style=" padding: .625rem .75rem;">

                                        {{trans('general.start_time')}} :
                                    </label>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    
                                    <input type="text" id="start" name="start_date" class="form-control mb-3"
                                        placeholder="{{trans('general.start_time')}}" required  readonly/>

                                    <b style="color: red;" id="end_time_error"></b>
                                    
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="mb-3" for="duration" style=" padding: .625rem .75rem;">
                                        {{trans('general.duration')}} :
                                    </label>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <select id="end-date" name="end_date" class="form-control browser-default mb-3"
                                        required>
                                        <option value="">{{trans('general.duration')}}</option>
                                        <option value="0.5">0.5 hr</option>
                                        <option value="1">1 hr</option>
                                        <option value="1.5">1.5 hr</option>
                                        <option value="2">2 hr</option>
                                        <option value="2.5">2.5 hr</option>
                                        <option value="3">3 hr</option>
                                        <option value="3.5">3.5 hr</option>
                                        <option value="4">4 hr</option>
                                        <option value="4.5">4.5 hr</option>
                                        <option value="5">5 hr</option>
                                        <option value="5.5">5.5 hr</option>
                                        <option value="6">6 hr</option>

                                    </select>

                                    <input type="hidden" id="duration_for_event" name="duration_for_event">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="mb-3" for="event_place" style=" padding: .625rem .75rem;">
                                        {{trans('general.event_place')}} :
                                    </label>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <input type="text" id="event-place" name="event_place" class="form-control mb-3"
                                        required />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <label class="mb-3" for="event-type" style=" padding: .625rem .75rem;">
                                        {{trans('general.event_type')}} :
                                    </label>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <select id="event-type" name="event_type" class="form-control browser-default mb-3"
                                        required>
                                        <option value="">{{trans('general.select_event_type')}}</option>
                                        @foreach (Categories::where('mode','on')->orderBy('name')->get() as $category)
                                        <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-6">
                                    <label class="mb-3" for="event_place" style=" padding: .625rem .75rem;">
                                        {{trans('general.event_details')}} {{trans('general.option')}} :
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="event_detail" id="event_detail" class="form-control" cols="5"
                                        rows="5"> </textarea>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn e-none mt-4"
                                    data-dismiss="modal">{{trans('admin.cancel')}}</button>
                                <button type="submit" class="btn btn-primary mt-4"><i></i>{{trans('general.update')}}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Crop Image 300*150</h5>
                <button type="button" class="close close-inherit" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times-circle"></i></span>
                </button>

            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div>
</div>
<!-- END UPDATE MODEL  ---- -->