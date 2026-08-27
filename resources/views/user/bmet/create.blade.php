@extends('user.layouts.app')
@section('title')
    @lang($title)
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
                    <h3 class="text-center">Create3 BMET Smart Card</h3>
                </div>
                <div class="card-body">
                    <!-- Direct form action to the correct route -->
                    <form action="{{ url('/user/bmet/store') }}" method="POST" enctype="multipart/form-data" id="bmetForm">
                        @csrf
                        <input type="hidden" name="generate_qr" value="1">
                        <div class="row mt-5">
                            <!-- Image Upload Field -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="photo">Upload Photo</label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="photo" class="form-control border border-2 p-2" id="photoInput" accept="image/*" onchange="previewImage(event)" required>
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
                                <!-- Personal Information Fields -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control border border-2 p-2" 
                                            value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="clearance_id">Clearance ID</label>
                                        <input type="text" name="clearance_id" class="form-control border border-2 p-2"
                                            value="{{ old('clearance_id') }}" required placeholder="SA-I-2024-1445034">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="clearance_date">Clearance Date</label>
                                        <input type="date" max="{{ date('Y-m-d') }}" name="clearance_date" class="form-control border border-2 p-2"
                                            value="{{ old('clearance_date') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_name">Father Name</label>
                                        <input type="text" name="father_name" class="form-control border border-2 p-2"
                                            value="{{ old('father_name') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mother_name">Mother Name</label>
                                        <input type="text" name="mother_name" class="form-control border border-2 p-2"
                                            value="{{ old('mother_name') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bra_id">BRA ID</label>
                                        <input type="text" name="bra_id" class="form-control border border-2 p-2"
                                            value="{{ old('bra_id') }}" required placeholder="RL1944">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employer">Employer</label>
                                        <input type="text" name="employer" class="form-control border border-2 p-2"
                                            value="{{ old('employer') }}" required placeholder="ORIGINAL OPPORTUNITY COMPANY">
                                    </div>
                                </div>
                              <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employer">Job</label>
                                        <input type="text" name="job" class="form-control border border-2 p-2"
                                            value="{{ old('job') }}" required placeholder="CLEANER">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" name="country" class="form-control border border-2 p-2"
                                            value="{{ old('country') }}" required placeholder="Saudi Arabia">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bmet_no">BMET Number</label>
                                        <input type="text" name="bmet_no" class="form-control border border-2 p-2"
                                            value="{{ old('bmet_no') }}" required placeholder="MMM20256789489G">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="passport_no">Passport Number</label>
                                        <input type="text" name="passport_no" class="form-control border border-2 p-2"
                                            value="{{ old('passport_no') }}" required placeholder="A15450693">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="p_issue_date">Passport Issue Date</label>
                                        <input type="date" max="{{ date('Y-m-d') }}" name="p_issue_date" class="form-control border border-2 p-2"
                                            value="{{ old('p_issue_date') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="p_expiry_date">Passport Expiry Date</label>
                                        <input type="date" min="{{ date('Y-m-d') }}" name="p_expiry_date" class="form-control border border-2 p-2"
                                            value="{{ old('p_expiry_date') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" 
                                            name="dob" 
                                            class="form-control border border-2 p-2" 
                                            max="{{ date('Y-m-d', strtotime('-18 years')) }}" 
                                            value="{{ old('dob') }}" 
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="visa_no">Visa Number</label>
                                        <input type="text" name="visa_no" class="form-control border border-2 p-2"
                                            value="{{ old('visa_no') }}" required placeholder="6125973351">
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-md-12 text-center mt-5">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <span>Submit BMET Smart Card</span>
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

    // Drag and drop functionality
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

    document.getElementById('bmetForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        const spinner = document.getElementById('submitSpinner');
        const btnText = btn.querySelector('span');
        
        btnText.style.display = 'none';
        spinner.classList.remove('d-none');
        btn.disabled = true;
    });
</script>
@endpush