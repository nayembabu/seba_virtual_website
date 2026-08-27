@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Mongolia Visa Verification</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="alert alert-success text-center">
                                        <h4>VISA VERIFIED</h4>
                                        <p>This visa has been verified as authentic and valid.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Visa Information</h5>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 30%">Visa Permit Number</th>
                                                <td>{{ $mongoliaVisa->visa_permit_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Full Name</th>
                                                <td>{{ $mongoliaVisa->first_name }} {{ $mongoliaVisa->middle_name }} {{ $mongoliaVisa->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Passport Number</th>
                                                <td>{{ $mongoliaVisa->passport_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nationality</th>
                                                <td>{{ $mongoliaVisa->nationality }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date of Birth</th>
                                                <td>{{ \Carbon\Carbon::parse($mongoliaVisa->date_of_birth)->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td>{{ $mongoliaVisa->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th>Visa Type</th>
                                                <td>{{ $mongoliaVisa->type_of_visa }}</td>
                                            </tr>
                                            <tr>
                                                <th>Visa Class</th>
                                                <td>{{ $mongoliaVisa->visa_class }}</td>
                                            </tr>
                                            <tr>
                                                <th>Entry Type</th>
                                                <td>{{ $mongoliaVisa->entry_type }}</td>
                                            </tr>
                                            <tr>
                                                <th>Visa Issue Date</th>
                                                <td>{{ \Carbon\Carbon::parse($mongoliaVisa->visa_issue_date)->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Visa Effective Date</th>
                                                <td>{{ \Carbon\Carbon::parse($mongoliaVisa->visa_effective_date)->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Visa Validity</th>
                                                <td>{{ $mongoliaVisa->visa_validity_days }} Days</td>
                                            </tr>
                                            <tr>
                                                <th>Valid Until</th>
                                                <td>{{ \Carbon\Carbon::parse($mongoliaVisa->visa_effective_date)->addDays($mongoliaVisa->visa_validity_days)->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Port of Entry</th>
                                                <td>{{ $mongoliaVisa->port_of_entry }}</td>
                                            </tr>
                                            <tr>
                                                <th>Inviting Company</th>
                                                <td>{{ $mongoliaVisa->inviting_company }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <p class="text-muted">This is an official verification page. The information shown above is directly from our database.</p>
                                        @php
                                            $validUntil = \Carbon\Carbon::parse($mongoliaVisa->visa_effective_date)->addDays($mongoliaVisa->visa_validity_days);
                                            $isExpired = $validUntil->isPast();
                                        @endphp
                                        @if($isExpired)
                                            <div class="alert alert-danger">
                                                <strong>NOTICE:</strong> This visa has expired on {{ $validUntil->format('d M Y') }}.
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <strong>NOTICE:</strong> This visa is valid until {{ $validUntil->format('d M Y') }}.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
