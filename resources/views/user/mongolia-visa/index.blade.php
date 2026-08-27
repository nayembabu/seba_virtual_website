@extends('user.layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title }}</h1>
            <div class="section-header-button">
                <a href="{{ route('user.mongolia-visa.create') }}" class="btn btn-primary">Add New</a>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Visa Permit Number</th>
                                            <th>Full Name</th>
                                            <th>Passport Number</th>
                                            <th>Nationality</th>
                                            <th>Visa Type</th>
                                            <th>Valid Until</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mongoliaVisas as $visa)
                                            <tr>
                                                <td>{{ $visa->visa_permit_number }}</td>
                                                <td>{{ $visa->first_name }} {{ $visa->middle_name }} {{ $visa->last_name }}</td>
                                                <td>{{ $visa->passport_number }}</td>
                                                <td>{{ $visa->nationality }}</td>
                                                <td>{{ $visa->type_of_visa }}</td>
                                                <td>
                                                    @php
                                                        $effectiveDate = \Carbon\Carbon::parse($visa->visa_effective_date);
                                                        $validUntil = $effectiveDate->addDays($visa->visa_validity_days);
                                                    @endphp
                                                    {{ $validUntil->format('Y-m-d') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('user.mongolia-visa.show', $visa->id) }}" class="btn btn-info btn-sm">View</a>
                                                    <a href="{{ route('user.mongolia-visa.edit', $visa->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('user.mongolia-visa.destroy', $visa->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this visa?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
