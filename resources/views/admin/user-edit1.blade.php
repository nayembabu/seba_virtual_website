@extends('manager.layouts.app')
@section('title')
    @lang("Edit user")
@endsection
@section('content')
    <style>
        .fa-ellipsis-v:before {
            content: "\f142";
        }
    </style>
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">



         <form action="{{ route('manager.user-update',$user->id) }}" method="post" enctype="multipart/form-data" id="m-form">
            
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
    
        <input value="{{ $user->name }}" type="text" name="name" class="form-control" required />
        </div>
        
        
        <div class="form-group">
        <label>Gender
        <span class="req">*</span>
        </label>
        <select name="gender" class="form-control">
        <option value="">Select One</option>
         <option value="Male"
          >Male</option>
              <option value="Female"
          >Female</option>
          </select>
        </div>
      
     
      
        <div class="form-group">
        <label>
        Email
        <span class="req">*</span>
        </label>
      <input value="{{ $user->email }}" id="email-input" type="text" name="email" value="" class="form-control" required />
        <span style="color:red" id="e-error"></span>
        </div>
        
         <div class="form-group">
        <label>
        Password ( Min : 6 Characters ) <small>Leave blank for no change</small>
        <span class="req">*</span>
        </label>
       <input type="password" name="password" minlength="6" value="" class="form-control" />
        </div>
        
         
    
        <div class="form-group">
        <label>
        Phone Number
        <span class="req">*</span>
        </label>
        <input type="text" id="phone-input" name="phone" value="{{ $user->phone }}" class="form-control" required />
        <span style="color:red" id="p-error"></span>
        </div>
      
     
      <div class="form-group">
        <label>
        National ID
      </label>
        <input type="text" name="nid" value="{{ $user->nid }}" class="form-control" />
        </div>
        
          <div class="form-group">
        <label>
        Date of Birth
        </label>
         <input value="{{ $user->dob }}" type="date" name="dob" class="form-control datepicker" />
        
       </div>
      
      
       
       
     
        
        
      <div class="form-group">
          <button class="btn btn-success" id="sbtn">Update</button>
      </div>

      
      </form> 
          
          
            
            
        </div>
    </div>
    
    
    
   
   

@endsection


@push('js')
    <script>
    
    $('select[name="gender"]').val("{!! $user->gender !!}");
    
photof.onchange = evt => {
  const [file] = photof.files
  if (file) {
    let name = file.name;
    let size = file.size;
    let ext = name.split('.').pop();
    if ( ext !== 'jpg' && ext !== 'png' && ext !== 'jpeg' ){
        alert('Invalid image format');
        $('#photof').val('');
        return false;
    }
    if ( size > 2048576){
        alert('Image is too big');
        $('#photof').val('');
        return false;
    }
    let src = URL.createObjectURL(file);
    $('.img-p').attr('src',src);
  }
}

cv.onchange = evt => {
  const [file] = cv.files
  if (file) {
    let name = file.name;
    let size = file.size;
    let ext = name.split('.').pop();
    if ( ext !== 'pdf' && ext !== 'doc' && ext !== 'docx' ){
        alert('Invalid file format');
        $('#cv').val('');
        return false;
    }
    if ( size > 2048576){
        alert('File is too big');
        $('#cv').val('');
        return false;
    }
    
  }
}
    </script>
@endpush