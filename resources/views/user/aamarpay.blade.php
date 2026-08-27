@extends('user.layouts.app')

@section('title')
    @lang('Recharge via Amarpay')
@endsection


@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3"><i class="icon-user"></i> @lang('Recharge via Amarpay')</h4>
                    
                             
            @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger">{{ $error }}</div>
     @endforeach
     @endif
     
               <div style="padding:20px;display:inline-block"> 
                <a href="{{ route('user.aamarpay') }}">
                    <img src="https://invoice.aamarpay.com/invoice-form/production/Footer-Logo.png" style="width:850px" />
                </a>
                </div>
                
                  
                <form action="" method="post">
                    @csrf
                    <label>Amount</label>
                    <input type="number" name="amount" class="form-control" required/>
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
