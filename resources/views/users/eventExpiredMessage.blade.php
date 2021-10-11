@extends('layouts.app')

@section('title')  -@endsection

@section('javascript')
<!--<script type="text/javascript">
   
window.onload = function () {
    
    @if(Session::has('success'))
        var message = Session::get('success');
        toastr.success(message);
     @endif
    }
    
</script>-->

@endsection

@section('content')
<section class="section section-sm">
    <div class="container">

        <div class="row justify-content-center text-center mb-sm">
            <div class="col-lg-12  pt-5 pb-3">

                <h2 class="mb-0 text-break">This Event has expired</h2>

            </div>
        </div>
    </div>

</section>
@endsection
