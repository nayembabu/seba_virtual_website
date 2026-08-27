@extends('admin.layouts.app')
@section('title')
    @lang("Send Notification")
@endsection
@section('content')
    <style>
        .fa-ellipsis-v:before {
            content: "\f142";
        }
    </style>
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">



        <form action="" method="post" enctype="multipart/form-data" id="m-form">
            
     @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger">{{ $error }}</div>
     @endforeach
     @endif
     
     
        @csrf
            
       
        <div class="form-group">
        <label> Send To
        <span class="req">*</span>
        </label>
        <select id="type" name="type" class="form-control" required>
         <option value="all">All User</option>
         <option value="specific">Specific User</option>
        </select>
        </div>
        
        <div class="form-group" id="u" style="display:none">
        <label> User ID ( Email ) 
        <span class="req">*</span>
        </label>
        <input id="uid" class="form-control" name="user_id" type="text">
        </div>
        
         
    
        
        
        <div class="form-group">
        <label>Message
        <span class="req">*</span>
        </label>
        <textarea name="msg" rows="5" class="form-control"></textarea>
        </div>
        
        
        
        
        
        <div class="form-group">
          <button class="btn btn-success" id="sbtn">Send Notification</button>
         </div>

      
      </form> 
          
          
            
            
        </div>
    </div>
    
    
    
   
   

@endsection


@push('js')
<script>
   
  $(document).on('change','body #type',function(){
       let v = $(this).val();
   
       if ( v == 'specific' ){
            $('#uid').val('');
            $('#u').show();
       } else {
           $('#u').hide();
           $('#uid').val('all');
       }
     
   });
   
  
   
    
    
</script>
@endpush

@push('style')
<style>
    .preview{
        max-width:300px;
        margin:0 auto;
        border:2px solid gray;
        border-radius:5px;
        padding:5px;
        margin-bottom:5px;
    }
    .preview img{
        max-width:100%;
    }
    #m-form .req{
        color:red;
    }
    #m-form label{
        font-weight:bold;
    }
</style>

@endpush