@extends('layouts.user')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Smart Card Details</h4>
                    <div>
                        <a href="{{ route('user.smartcard.index') }}" class="btn btn-secondary">Back to List</a>
                        <a href="{{ route('user.smartcard.edit', $smartcard->id) }}" class="btn btn-warning">Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h5>Profile Photo</h5>
                                @if($smartcard->profile_image)
                                <img src="{{ url('/storage/' . $smartcard->profile_image) }}" alt="Profile Photo" class="img-fluid rounded">
                                @endif
                            </div>
                            <div>
                                <h5>Signature</h5>
                                @if($smartcard->signature_image)
                                <img src="{{ url('/storage/' . $smartcard->signature_image) }}" alt="Signature" class="img-fluid rounded">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table">
                                <tr>
                                    <th>Name (Bangla)</th>
                                    <td>{{ $smartcard->name_bn }}</td>
                                </tr>
                                <tr>
                                    <th>Name (English)</th>
                                    <td>{{ $smartcard->name_en }}</td>
                                </tr>
                                <tr>
                                    <th>Father's Name</th>
                                    <td>{{ $smartcard->father_bn }}</td>
                                </tr>
                                <tr>
                                    <th>Mother's Name</th>
                                    <td>{{ $smartcard->mother_bn }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ $smartcard->dob->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>NID Number</th>
                                    <td>{{ $smartcard->nid_no }}</td>
                                </tr>
                                <tr>
                                    <th>Place of Birth</th>
                                    <td>{{ $smartcard->place_of_birth }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $smartcard->address }}</td>
                                </tr>
                                <tr>
                                    <th>Issue Date</th>
                                    <td>{{ $smartcard->issue_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $smartcard->status === 'pending' ? 'warning' : ($smartcard->status === 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($smartcard->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $smartcard->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection