@extends('admin.layouts.app')
@section('title')
    @lang("Add Manager")
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
        Username
        <span class="req">*</span>
       </label>
        <input type="text" name="username" class="form-control" required />
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
        <label>
        Phone Number
        <span class="req">*</span>
        </label>
        <input type="text" id="phone-input" name="phone" class="form-control" required />
        <span style="color:red" id="p-error"></span>
        </div>
      
     
      
        
        
      <div class="form-group">
          <button class="btn btn-success" id="sbtn">Add</button>
      </div>

      
      </form> 
          
          
            
            
        </div>
    </div>
    
    
    
   
   

@endsection


@push('js')
    <script>
    
    
    </script>
@endpush