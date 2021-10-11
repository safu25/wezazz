@extends('admin.layout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h4>
            {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> {{ trans('admin.ad_managment')
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

        <div class="box-body table-responsive no-padding">
            <table class="table table-hover ">
                <tbody>


                    <tr>
                        <th class="active">ID</th>
                        <th class="active">{{ trans('admin.image_name') }}</th>
                        <th class="active">{{ trans('admin.status') }}</th>
                        <th class="active">{{ trans('admin.actions') }}</th>
                    </tr>

                    @foreach( $image as $img )
                    <tr style="text-transform: uppercase;">
                        <td width="10%">{{ $img->id }}</td>
                        <td width="50%">{{ $img->name }}</td>
                       
                        <td width="20%">
                            <!-- status Active enactive -->
                            <?php if($img->status == '1'){ ?>

                            <a href="ad_status/{{$img->id}}" class="btn btn-success">Active</a>

                            <?php }else{?>

                            <a href="ad_status/{{$img->id}}" class="btn btn-danger">Inactive</a>

                            <?php } ?>

                        </td>

                        <td width="20%">

                            @if($img->id == '1')

                            <a href="home_cropimg/{{$img->id}}"  class=" btn btn-primary ">
                                {{ trans('admin.edit') }}
                            </a> &nbsp;

                            @elseif($img->id == '2')

                            <a href="side_cropimg/{{$img->id}}"  class=" btn btn-primary ">
                                {{ trans('admin.edit') }}
                            </a> &nbsp;

                            @else

                            <a href="ad_insede_cropimg/{{$img->id}}"  class=" btn btn-primary ">
                                {{ trans('admin.edit') }}
                            </a> &nbsp;

                            @endif

                        </td>
                    </tr><!-- /.TR -->
                    @endforeach


                    @if( isset( $query ) )
                    <div class="col-md-12 text-center padding-bottom-15">
                        <a href="{{url('panel/admin/users_events')}}" class="btn btn-sm btn-danger">{{
                            trans('auth.back') }}</a>
                    </div>

                    @endif

                </tbody>
            </table>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection


