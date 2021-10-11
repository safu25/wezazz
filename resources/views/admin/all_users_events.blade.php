@extends('admin.layout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h4>
            {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> {{ trans('admin.users_events')
            }}
        </h4>
    </section>

    <!-- Main content -->
    <section class="content">

        @if(Session::has('info_message'))
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-warning margin-separator"></i> {{ Session::get('info_message') }}
        </div>
        @endif

        @if(Session::has('success_message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check margin-separator"></i> {{ Session::get('success_message') }}
        </div>
        @endif

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            @if( $data->count() != 0 && $data->currentPage() != 1 )
                            <a href="{{url('panel/admin/users_events')}}">{{ trans('admin.view_all_events') }}</a>
                            @else
                            {{ trans('admin.users_events') }}
                            @endif

                        </h3>

                        <div class="box-tools">
                            @if( $data->total() != 0 )
                            <!-- form -->
                            <form role="search" autocomplete="off" action="{{ url('panel/admin/users_events') }}"
                                method="get">
                                <div class="input-group input-group-sm w-150">
                                    <input type="text" name="search" class="form-control pull-right"
                                        placeholder="{{ trans('general.search_by_events') }}">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form><!-- form -->
                            @endif
                        </div>

                    </div><!-- /.box-header -->

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover ">
                            <tbody>

                                @if( $data->total() != 0 && $data->count() != 0 )
                                <tr>
                                    <th class="active">ID</th>
                                    <th class="active">{{ trans('admin.event_name') }}</th>
                                    <th class="active">{{ trans('admin.event') }}</th>
                                    <th class="active">{{ trans('admin.end_date') }}</th>
                                    <th class="active">{{ trans('admin.event_place') }}</th>
                                    <th class="active">{{ trans('admin.event_type') }}</th>
                                    <th class="active">{{ trans('admin.event_details') }}</th>
                                    <th class="active">{{ trans('admin.actions') }}</th>
                                </tr>

                                @foreach( $data as $events )
                                <tr style="text-transform: uppercase;">
                                    <td>{{ $events->id }}</td>
                                    <td>{{ $events->event_name }}</td>

                                    <td>
                                        @if($events->event_img != '')
                                        <img src="{{Helper::getFile(config('path.event').$events->event_img)}}"
                                            width="65" height="65" />
                                        @else
                                        <img src="{{url('/public/uploads/default-event-image/', $settings->event_default_image)}}"
                                            width="65" height="65" />
                                        @endif

                                    </td>

                                    <td>{{ Helper::formatDate($events->duration) }}</td>
                                    <td>{{ $events->event_place}}</td>
                                    <td>{{ $events->event_type}}</td>
                                    <td>{{$events->event_details}}</td>

                                    <td>

                                
                                                <a href="edit_events/{{$events->id}}" value="{{ $events->id}}"
                                                    class="btn btn-success btn-sm padding-btn">
                                                    {{ trans('admin.edit') }}

                                                </a>

                                                    <button  class="deletebtn btn btn-danger" type="button"
                                                    data-toggle="modal" value="{{ $events->id}}"> {{ trans('admin.delete') }}</button>


                                    </td>

                                </tr><!-- /.TR -->
                                @endforeach

                                @else
                                <hr />
                                <h3 class="text-center no-found">{{ trans('general.no_results_found') }}</h3>

                                @if( isset( $query ) )
                                <div class="col-md-12 text-center padding-bottom-15">
                                    <a href="{{url('panel/admin/users_events')}}" class="btn btn-sm btn-danger">{{
                                        trans('auth.back') }}</a>
                                </div>

                                @endif
                                @endif

                            </tbody>

                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                @if ($data->hasPages())
                {{ $data->appends(['search' => $query])->links() }}
                @endif
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->



<!-- DELETE EVENT MODEL -->
<div class="modal   fade" tabindex="-1" role="dialog" id="delete_event_user" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content wave_content">
            <div class="modal-header  ">
                <h3 >Delete Event</h3>
            </div>
            <div class="modal-body p-0 ">
                <div class="card border-0 ">

                    <div class="card-body px-lg-5 py-lg-5 position-relative"  style="margin: auto;">

                        <form action="delete_event" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="_method" value="DELETE">

                           <div>
                                <h3 class="text-center" style="margin-bottom: 60px;">{{trans('admin.event_delete_msg')}}</h3>
                               
                           </div>

                               
                            <input type="hidden" id="deleting_id" name="delete_event">

                            <div class="text-center">
                                <button type="button" class="btn  mt-4"
                                    data-dismiss="modal" style="width: 50px;">{{trans('admin.no')}}</button>
                                <button type="submit" class="btn btn-danger mt-4" style="width: 100px; margin-left: 9px;"><i></i>Yes</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END DELETE EVENT -->

@endsection

@section('javascript')

<script>

    $(document).ready(function () {
        //DELETE EVENT ------>
        $(document).on('click', '.deletebtn ', function () {

            var event_id = $(this).val();
            //   alert(event_id);
            $('#delete_event_user').modal('show');
            $('#deleting_id').val(event_id);

        });
        //end delete event


    });

</script>
@endsection