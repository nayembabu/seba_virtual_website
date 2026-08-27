@extends('admin.layouts.app')
@section('title')
    @lang("Add users")
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
        <label>Full Name
        <span class="req">*</span>
        </label>
    
        <input type="text" name="name" class="form-control" required />
        </div>
        
        <div class="form-group">
        <label>
        Phone Number
        <span class="req">*</span>
        </label>
        <input type="text" id="phone-input" name="phone" value="" class="form-control" required />
        <span style="color:red" id="p-error"></span>
        </div>
        
        <div class="form-group">
        <label>
        Email
        <span class="req">*</span>
        </label>
      <input id="email-input" type="text" name="email" value="" class="form-control" required />
        <span style="color:red" id="e-error"></span>
        </div>
        
        <div class="form-group">
        <label>
        Password ( Min : 6 Characters )
        <span class="req">*</span>
        </label>
       <input type="password" name="password" minlength="6" value="" class="form-control" required />
        </div>
        
        
      <div class="form-group">
        <label>Gender
        <span class="req">*</span>
        </label>
        <select name="gender" class="form-control" required>
        <option value="">Select One</option>
         <option value="Male"
          >Male</option>
              <option value="Female"
          >Female</option>
          </select>
        </div>
      
      
    
      <div class="form-group">
        <label>
        National ID
       </label>
        <input type="text" name="nid" value="" class="form-control" />
        </div>
      
      <div class="form-group">
        <label>
        Date of Birth
        </label>
         <input type="date" name="dob" class="form-control datepicker" />
        
       </div>
      
     
      
        
        
      <div class="form-group">
          <button class="btn btn-success" id="sbtn">Add</button>
      </div>

      
      </form> 
          
          
            
            
        </div>
    </div>
    
    
    
   
   

@endsection


@push('script')
<script>
   
   $('#email-input').on('input', function(){
       check_user($(this).val(),'email');
   });
   
   $('#phone-input').on('input', function(){
       check_user($(this).val(),'phone');
   });


   function check_user(input,type){
       let msg = 'Email already exists';
       if ( type == 'phone' ){
           msg = 'Phone number already exists';
       }
      $.ajax({
        url: "{{ route('check-user') }}",
        type: "post",
        data: { _token: '{{ csrf_token() }}', input: input},
        success: function (response) {
            if (response == 'exists'){
                if ( type == 'phone' ){
                     $('#p-error').html(msg);
                } else {
                     $('#e-error').html(msg);
                }
                $('#sbtn').attr('disabled','disabled');
            } else {
                 if ( type == 'phone' ){
                 $('#p-error').html('');
                 } else {
                 $('#e-error').html('');
                 }
               $('#sbtn').removeAttr('disabled');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#p-error').html('');
            $('#e-error').html('');
        }
    });
   }
   
    
    
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