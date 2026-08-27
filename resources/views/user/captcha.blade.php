@extends('user.layouts.app')

@section('title')
   Verify You are not a robot
@endsection


@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                   
                             
            @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger">{{ $error }}</div>
     @endforeach
     @endif
             
               
                    <img id="img" src="{!! $cp !!}" /><br/>
                    <p class="r-msg" style="display:none">Please wait..</p>
                    <button class="refresh btn btn-primary">Refresh Captcha</button>
                    
                    
                    <form action="" method="post">
                    @csrf
                    <label style="color:red">Enter Captcha to continue</label>
                    <input type="text" name="captcha" class="form-control" required/>
                    <br/>
                    <button class="btn btn-success">Submit</button>
                </form>
           
                
                </div>
            </div>
        </div>
    </div>
</div>







@endsection

@push('js')
<script>
$(document).ready(function (e) {
            "use strict";
            
   $(document).on('click', 'body .refresh', function(e) {
         e.preventDefault();
         $('.r-msg').show();
         $('.refresh').attr('disabled','disabled');
         $.ajax({
         type: "POST",
         url: '{{ route('user.verify-robot-refresh') }}',
         data: {'_token': '{{ csrf_token() }}'},
         success: function (data) {
              $('.r-msg').hide();
              $('.refresh').removeAttr('disabled');
              
              if ( data !== 'failed' ){
                  $('#img').attr('src',data);
              }
              
           },
         });
    
     });
            
});
</script>
@endpush
