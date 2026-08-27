@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Visa Application Details</h4>
                    <a href="{{ route('visa-applications.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4 text-center">
                            @if($visaApplication->profile_photo)
                                <img src="{{ getImage(imagePath()['visa']['path'].'/'.$visaApplication->profile_photo) }}" alt="Profile Photo" class="img-fluid rounded">
                            @else
                                <img src="{{ asset('assets/images/default-avatar.png') }}" alt="Default Profile" class="img-fluid rounded">
                            @endif
                        </div>
                        
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5>Visa Number:</h5>
                                    <p>{{ $visaApplication->visa_number }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Full Name:</h5>
                                    <p>{{ $visaApplication->full_name }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Date of Birth:</h5>
                                    <p>{{ date('d M, Y', strtotime($visaApplication->date_of_birth)) }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Citizenship:</h5>
                                    <p>{{ $visaApplication->citizenship }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Passport Number:</h5>
                                    <p>{{ $visaApplication->passport_number }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Travel Document Type:</h5>
                                    <p>{{ $visaApplication->travel_document_type }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Passport Issue Date:</h5>
                                    <p>{{ date('d M, Y', strtotime($visaApplication->passport_issue_date)) }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Passport Expiry Date:</h5>
                                    <p>{{ date('d M, Y', strtotime($visaApplication->passport_expiry_date)) }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Visa Type:</h5>
                                    <p>{{ $visaApplication->visa_type }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Visa Validity:</h5>
                                    <p>{{ $visaApplication->visa_validity }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Number of Entries:</h5>
                                    <p>{{ $visaApplication->number_of_entries }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Period of Stay:</h5>
                                    <p>{{ $visaApplication->period_of_stay }} days</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Invitation:</h5>
                                    <p>{{ $visaApplication->invitation ?? 'N/A' }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Visa Issue Date:</h5>
                                    <p>{{ date('d M, Y H:i', strtotime($visaApplication->visa_issue_date)) }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h5>Application Date:</h5>
                                    <p>{{ date('d M, Y H:i', strtotime($visaApplication->created_at)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection