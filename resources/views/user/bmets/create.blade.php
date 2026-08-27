@extends('user.layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Create BMET Record</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ url('/users/bmet/store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Create BMET Smart Card</h3>
                    </div>
                    <div class="card-body">
                        <form action="https://unique-seba.com/user/bmet/create" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="lZfcelHf2vYXLpmFXOEcpO8zdSdZe96P6p25uX36">                            <div class="row mt-5">
                                <!-- Image Upload Field -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="photo">Upload Photo</label>
                                        <div class="file-upload-wrapper">
                                            <input type="file" name="photo" class="form-control border border-2 p-2" id="photoInput" accept="image/*" onchange="previewImage(event)">
                                            <div id="imagePreview" class="image-preview" style="display:none;">
                                                <img id="previewImg" src="" alt="Image Preview" style="max-width: 100%; height: auto; margin-top: 10px;">
                                            </div>
                                            <div id="dragArea" class="drag-area" style="border: 2px dashed #ccc; padding: 20px; text-align: center; margin-top: 10px;">
                                                <p>Drag & Drop an image here or select a file</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                <!-- New Fields -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control border border-2 p-2" 
                                            value="" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="clearance_id">Clearance ID</label>
                                        <input type="text" name="clearance_id" class="form-control border border-2 p-2"
                                            value="" required placeholder="SA-I-2024-1445034">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="clearance_date">Clearance Date</label>
                                        <input type="date" max="2025-03-12"  name="clearance_date" class="form-control border border-2 p-2"
                                            value="" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_name">Father Name</label>
                                        <input type="text" name="father_name" class="form-control border border-2 p-2"
                                            value="" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mother_name">Mother Name</label>
                                        <input type="text" name="mother_name" class="form-control border border-2 p-2"
                                            value="" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bra_id">BRA ID</label>
                                        <input type="text" name="bra_id" class="form-control border border-2 p-2"
                                            value="" required placeholder="RL1944">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employer">Employer</label>
                                        <input type="text" name="employer" class="form-control border border-2 p-2"
                                            value="" required placeholder="ORIGINAL OPPORTUNITY COMPANY">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" name="country" class="form-control border border-2 p-2"
                                            value="" required placeholder="Saudi Arabia">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bmet_no">BMET Number</label>
                                        <input type="text" name="bmet_no" class="form-control border border-2 p-2"
                                            value="" required placeholder="MMM20256789489G">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="passport_no">Passport Number</label>
                                        <input type="text" name="passport_no" class="form-control border border-2 p-2"
                                            value="" required placeholder="A15450693">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="p_issue_date">Passport Issue Date</label>
                                        <input type="date" max="2025-03-12"  name="p_issue_date" class="form-control border border-2 p-2"
                                            value="" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="p_expiry_date">Passport Expiry Date</label>
                                        <input type="date" max="2025-03-12"  name="p_expiry_date" class="form-control border border-2 p-2"
                                            value="" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" 
                                           name="dob" 
                                           class="form-control border border-2 p-2" 
                                           max="2025-03-12" 
                                           value="" 
                                           required>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="visa_no">Visa Number</label>
                                        <input type="text" name="visa_no" class="form-control border border-2 p-2"
                                            value="" required placeholder="6125973351">
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="col-md-12 text-center mt-5">
                                    <button style="display:none;" class="btn btn-primary nidSubmitBtn" type="submit">Submit</button>
                                    <button onclick="confirmRecharge(); return false;" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-3 align-items-center mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">BMET Smart Card List</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Passport Number</td>
                                        <td>BMET Number</td>
                                        <td>Name</td>
                                        <td>Created At</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </form>
</div>
@endsection
