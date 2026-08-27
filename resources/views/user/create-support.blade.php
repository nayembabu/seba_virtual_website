@extends('user.layouts.app')

@section('title')
     {{ 'Create Support Ticket' }} 
@endsection


@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                       Create Support Ticket </h4>
                    
                             
            @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger">{{ $error }}</div>
     @endforeach
     @endif
     
               
                  
             
                <form action="" method="post">
                    @csrf
                    <label>Message</label>
                    <textarea name="msg" rows="5" class="form-control" required></textarea>
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

            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush
