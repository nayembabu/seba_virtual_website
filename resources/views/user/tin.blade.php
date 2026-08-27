@extends('user.layouts.app')

@section('title')
   Search Tin
@endsection

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                   
                <center>
                    <h3 class="text-info"> 
                        Charge : {{ inum(get_settings()->tin_fee) }}
                    </h3>
                    <a href="/user/nid-to-tin" class="btn btn-primary">Click Here To Get Search TIN Number with nid/phone/passport/etc</a><br/>
                </center>
                  
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif
             
                <form action="" method="post">
                    @csrf
                    <label> TIN Number </label>
                    <input value="{{ old('tin') }}" type="number" name="tin" class="form-control" required/>
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
