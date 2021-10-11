<!-- DELETE EVENT MODEL -->
<div class="modal   fade" tabindex="-1" role="dialog" id="deleteEvent" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content wave_content">
            <div class="modal-header  ">
                <h3 >{{trans('admin.delete_event_msg')}}</h3>
            </div>
            <div class="modal-body p-0 ">
                <div class="card border-0 ">

                    <div class="card-body px-lg-5 py-lg-5 position-relative"  style="margin: auto;">

                        <form action="{{url('deleteEvent')}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="_method" value="DELETE">

                           <div >
                                <h5>{{trans('admin.delete_msg')}}</h5>
                                
                           </div>

                               
                            <input type="hidden" id="deleting_id" name="delete_event">

                            <div class="text-center">
                                <button type="button" class="btn btn-secondary mt-4"
                                    data-dismiss="modal">{{trans('admin.no')}}</button>
                                <button type="submit" class="btn btn-primary mt-4"><i></i>{{trans('admin.yes')}}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END DELETE EVENT -->