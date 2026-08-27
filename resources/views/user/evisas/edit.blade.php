@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Edit E-Visa</h2>
                </div>

                <div class="card-body">                    <form action="{{ route('user.evisas.update', $evisa) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="visa_id" class="form-label">Visa ID</label>
                                <input type="text" class="form-control @error('visa_id') is-invalid @enderror" 
                                    id="visa_id" name="visa_id" value="{{ old('visa_id', $evisa->visa_id) }}" required>
                                @error('visa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="evisa_number" class="form-label">E-Visa Number</label>
                                <input type="text" class="form-control @error('evisa_number') is-invalid @enderror" 
                                    id="evisa_number" name="evisa_number" value="{{ old('evisa_number', $evisa->evisa_number) }}" required>
                                @error('evisa_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ref_number" class="form-label">Reference Number</label>
                                <input type="text" class="form-control @error('ref_number') is-invalid @enderror" 
                                    id="ref_number" name="ref_number" value="{{ old('ref_number', $evisa->ref_number) }}" required>
                                @error('ref_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                    id="full_name" name="full_name" value="{{ old('full_name', $evisa->full_name) }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control @error('gender') is-invalid @enderror" 
                                    id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $evisa->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $evisa->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $evisa->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" class="form-control @error('nationality') is-invalid @enderror" 
                                    id="nationality" name="nationality" value="{{ old('nationality', $evisa->nationality) }}" required>
                                @error('nationality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                    id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $evisa->date_of_birth->format('Y-m-d')) }}" required>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="issue_date" class="form-label">Issue Date</label>
                                <input type="date" class="form-control @error('issue_date') is-invalid @enderror" 
                                    id="issue_date" name="issue_date" value="{{ old('issue_date', $evisa->issue_date->format('Y-m-d')) }}" required>
                                @error('issue_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expire_date" class="form-label">Expire Date</label>
                                <input type="date" class="form-control @error('expire_date') is-invalid @enderror" 
                                    id="expire_date" name="expire_date" value="{{ old('expire_date', $evisa->expire_date->format('Y-m-d')) }}" required>
                                @error('expire_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="place_of_issue" class="form-label">Place of Issue</label>
                                <input type="text" class="form-control @error('place_of_issue') is-invalid @enderror" 
                                    id="place_of_issue" name="place_of_issue" value="{{ old('place_of_issue', $evisa->place_of_issue) }}" required>
                                @error('place_of_issue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="visa_fee" class="form-label">Visa Fee</label>
                                <input type="number" step="0.01" class="form-control @error('visa_fee') is-invalid @enderror" 
                                    id="visa_fee" name="visa_fee" value="{{ old('visa_fee', $evisa->visa_fee) }}" required>
                                @error('visa_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="travel_document" class="form-label">Travel Document</label>
                                <input type="text" class="form-control @error('travel_document') is-invalid @enderror" 
                                    id="travel_document" name="travel_document" value="{{ old('travel_document', $evisa->travel_document) }}" required>
                                @error('travel_document')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="travel_doc_no" class="form-label">Travel Document No</label>
                                <input type="text" class="form-control @error('travel_doc_no') is-invalid @enderror" 
                                    id="travel_doc_no" name="travel_doc_no" value="{{ old('travel_doc_no', $evisa->travel_doc_no) }}" required>
                                @error('travel_doc_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="travel_doc_issue" class="form-label">Travel Doc Issue Date</label>
                                <input type="date" class="form-control @error('travel_doc_issue') is-invalid @enderror" 
                                    id="travel_doc_issue" name="travel_doc_issue" value="{{ old('travel_doc_issue', $evisa->travel_doc_issue->format('Y-m-d')) }}" required>
                                @error('travel_doc_issue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="travel_doc_expiry" class="form-label">Travel Doc Expiry Date</label>
                                <input type="date" class="form-control @error('travel_doc_expiry') is-invalid @enderror" 
                                    id="travel_doc_expiry" name="travel_doc_expiry" value="{{ old('travel_doc_expiry', $evisa->travel_doc_expiry->format('Y-m-d')) }}" required>
                                @error('travel_doc_expiry')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                    id="remarks" name="remarks">{{ old('remarks', $evisa->remarks) }}</textarea>
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="image" class="form-label">Image</label>
                                @if($evisa->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $evisa->image) }}" alt="Visa Image" class="img-thumbnail" style="max-height: 200px">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                    id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update E-Visa</button>
                                <a href="{{ route('user.evisas.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
