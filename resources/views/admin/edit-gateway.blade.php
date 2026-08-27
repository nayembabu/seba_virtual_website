@extends('layouts.admin')
@section('title')
    @lang('Edit Gateway')
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif
                @csrf
                <div class="form-group">
                    <label>Name <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ $gateway->name }}" required />
                </div>
                <div class="form-group">
                    <label>Account Number <span class="req">*</span></label>
                    <input type="text" name="account" value="{{ $gateway->account }}" class="form-control" required />
                </div>
                <div class="form-group">
                    <img id="img" src="{{ url('storage/uploads/'.$gateway->logo) }}" style="width:100px" /><br/>
                    <label>Logo ( <small>Leave empty for no changes</small> )</label>
                    <input type="file" id="logo" name="logo" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $gateway->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $gateway->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Extra Details</label>
                    <textarea name="details" rows="7" class="form-control">{!! $gateway->details !!}</textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" id="sbtn">Edit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
    $(document).on('change','body #logo',function(){
        let file = $(this)[0].files[0];
        let src = URL.createObjectURL(file);
        $('#img').attr('src',src);
    });
    </script>
@endpush
