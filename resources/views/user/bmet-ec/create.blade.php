@extends('user.layouts.app')
@section('title')
    @lang('Create BMET EC')
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Create BMET EC</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.bmet-ec.store') }}" method="POST" enctype="multipart/form-data" id="bmetEcForm">
                        @csrf

                        @php
                            $serviceCharge = \App\Models\ServiceCharge::where('service_name', 'bmet-ec')->first();
                        @endphp

                        @if($serviceCharge)
                            <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle fa-2x mr-3 text-info"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1 font-weight-bold">Service Charge</h6>
                                        <p class="mb-0 small text-muted">A fee of <span class="font-weight-bold text-danger">{{ number_format($serviceCharge->amount, 2) }}</span> will be deducted for each BMET EC creation.</p>
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="profile_photo">Upload Photo</label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="profile_photo" class="form-control border border-2 p-2" id="photoInput" accept="image/*" onchange="previewImage(event)" required>
                                        <div id="imagePreview" class="image-preview" style="display:none;">
                                            <img id="previewImg" src="" alt="Image Preview" style="max-width: 200px; height: auto; margin-top: 10px;">
                                        </div>
                                        <div id="dragArea" class="drag-area" style="border: 2px dashed #ccc; padding: 20px; text-align: center; margin-top: 10px;">
                                            <p>Drag & Drop an image here or select a file</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ec_no">EC No</label>
                                        <input type="text" name="ec_no" class="form-control border border-2 p-2" value="{{ old('ec_no') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="birth_date">Birth Date</label>
                                        <input type="date" name="birth_date" class="form-control border border-2 p-2" value="{{ old('birth_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="passport_no">Passport No</label>
                                        <input type="text" name="passport_no" class="form-control border border-2 p-2" value="{{ old('passport_no') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="passport_issue_date">Passport Issue Date</label>
                                        <input type="date" name="passport_issue_date" class="form-control border border-2 p-2" value="{{ old('passport_issue_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="passport_expire_date">Passport Expire Date</label>
                                        <input type="date" name="passport_expire_date" class="form-control border border-2 p-2" value="{{ old('passport_expire_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="visa_no">Visa No</label>
                                        <input type="text" name="visa_no" class="form-control border border-2 p-2" value="{{ old('visa_no') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="visa_issue_date">Visa Issue Date</label>
                                        <input type="date" name="visa_issue_date" class="form-control border border-2 p-2" value="{{ old('visa_issue_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="visa_expire_date">Visa Expire Date</label>
                                        <input type="date" name="visa_expire_date" class="form-control border border-2 p-2" value="{{ old('visa_expire_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="recruiting_agency">Recruiting Agency</label>
                                        <input type="text" name="recruiting_agency" class="form-control border border-2 p-2" value="{{ old('recruiting_agency') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rl_id">RL ID</label>
                                        <input type="text" name="rl_id" class="form-control border border-2 p-2" value="{{ old('rl_id') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employer">Employer</label>
                                        <input type="text" name="employer" class="form-control border border-2 p-2" value="{{ old('employer') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" name="country" class="form-control border border-2 p-2" value="{{ old('country') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bmet_no">BMET No</label>
                                        <input type="text" name="bmet_no" class="form-control border border-2 p-2" value="{{ old('bmet_no') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control border border-2 p-2" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_name">Father's Name</label>
                                        <input type="text" name="father_name" class="form-control border border-2 p-2" value="{{ old('father_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mother_name">Mother's Name</label>
                                        <input type="text" name="mother_name" class="form-control border border-2 p-2" value="{{ old('mother_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <input type="text" name="gender" class="form-control border border-2 p-2" value="{{ old('gender') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="blood_group">Blood Group</label>
                                        <input type="text" name="blood_group" class="form-control border border-2 p-2" value="{{ old('blood_group') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nid">NID</label>
                                        <input type="text" name="nid" class="form-control border border-2 p-2" value="{{ old('nid') }}">
                                    </div>
                                </div>

                                <div class="col-md-12 text-center mt-5">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <span>Submit</span>
                                        <div class="spinner-border spinner-border-sm d-none" role="status" id="submitSpinner">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('previewImg');
            output.src = reader.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('dragArea').style.display = 'none';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    const dragArea = document.getElementById('dragArea');
    const photoInput = document.getElementById('photoInput');

    dragArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dragArea.style.border = '2px dashed #007bff';
    });

    dragArea.addEventListener('dragleave', () => {
        dragArea.style.border = '2px dashed #ccc';
    });

    dragArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dragArea.style.border = '2px dashed #ccc';
        
        if (e.dataTransfer.files.length) {
            photoInput.files = e.dataTransfer.files;
            previewImage({target: {files: [e.dataTransfer.files[0]]}});
        }
    });

    document.getElementById('bmetEcForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        const spinner = document.getElementById('submitSpinner');
        const btnText = btn.querySelector('span');
        
        btnText.style.display = 'none';
        spinner.classList.remove('d-none');
        btn.disabled = true;
    });
</script>
@endpush
