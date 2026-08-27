@extends('user.layouts.app')

@section('title')
    Edit BMET Smart Card
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
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
                    <h3 class="text-center">Edit BMET Smart Card</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('bmet.update', $bmet->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="photo">Upload Photo</label>
                                    <input type="file" name="photo" class="form-control border border-2 p-2" id="photoInput" accept="image/*" onchange="previewImage(event)">
                                    <div id="imagePreview" class="image-preview" style="margin-top: 10px;">
                                        <img id="previewImg" src="{{ asset('storage/' . $bmet->photo) }}" alt="Image Preview" style="max-width: 200px; height: auto;">
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Information Fields -->
                            @php
                                $fields = [
                                    'name' => 'Name',
                                    'clearance_id' => 'Clearance ID',
                                    'clearance_date' => 'Clearance Date',
                                    'father_name' => 'Father Name',
                                    'mother_name' => 'Mother Name',
                                    'bra_id' => 'BRA ID',
                                    'employer' => 'Employer',
                                    'country' => 'Country',
                                    'bmet_no' => 'BMET Number',
                                    'passport_no' => 'Passport Number',
                                    'p_issue_date' => 'Passport Issue Date',
                                    'p_expiry_date' => 'Passport Expiry Date',
                                    'dob' => 'Date of Birth',
                                    'visa_no' => 'Visa Number'
                                ];
                            @endphp

                            @foreach ($fields as $field => $label)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ $field }}">{{ $label }}</label>
                                        <input type="{{ in_array($field, ['clearance_date', 'p_issue_date', 'p_expiry_date', 'dob']) ? 'date' : 'text' }}"
                                               name="{{ $field }}"
                                               class="form-control border border-2 p-2"
                                               value="{{ old($field, $bmet->$field) }}" required>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-md-12 text-center mt-5">
                                <button type="submit" class="btn btn-success">Update BMET Smart Card</button>
                                <a href="{{ route('bmet.index') }}" class="btn btn-secondary">Back</a>
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
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
