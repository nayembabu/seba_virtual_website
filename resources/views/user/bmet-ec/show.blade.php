@extends('user.layouts.app')
@section('title')
    @lang('View BMET EC')
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">View BMET EC</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $bmetEc->profile_photo) }}" alt="Profile Photo" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th>EC No</th>
                                    <td>{{ $bmetEc->ec_no }}</td>
                                </tr>
                                <tr>
                                    <th>Birth Date</th>
                                    <td>{{ $bmetEc->birth_date }}</td>
                                </tr>
                                <tr>
                                    <th>Passport No</th>
                                    <td>{{ $bmetEc->passport_no }}</td>
                                </tr>
                                <tr>
                                    <th>Passport Issue Date</th>
                                    <td>{{ $bmetEc->passport_issue_date }}</td>
                                </tr>
                                <tr>
                                    <th>Passport Expire Date</th>
                                    <td>{{ $bmetEc->passport_expire_date }}</td>
                                </tr>
                                <tr>
                                    <th>Visa No</th>
                                    <td>{{ $bmetEc->visa_no }}</td>
                                </tr>
                                <tr>
                                    <th>Visa Issue Date</th>
                                    <td>{{ $bmetEc->visa_issue_date }}</td>
                                </tr>
                                <tr>
                                    <th>Visa Expire Date</th>
                                    <td>{{ $bmetEc->visa_expire_date }}</td>
                                </tr>
                                <tr>
                                    <th>Recruiting Agency</th>
                                    <td>{{ $bmetEc->recruiting_agency }}</td>
                                </tr>
                                <tr>
                                    <th>RL ID</th>
                                    <td>{{ $bmetEc->rl_id }}</td>
                                </tr>
                                <tr>
                                    <th>Employer</th>
                                    <td>{{ $bmetEc->employer }}</td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td>{{ $bmetEc->country }}</td>
                                </tr>
                                <tr>
                                    <th>BMET No</th>
                                    <td>{{ $bmetEc->bmet_no }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $bmetEc->name }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ $bmetEc->gender }}</td>
                                </tr>
                                <tr>
                                    <th>Blood Group</th>
                                    <td>{{ $bmetEc->blood_group }}</td>
                                </tr>
                                <tr>
                                    <th>NID</th>
                                    <td>{{ $bmetEc->nid }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
