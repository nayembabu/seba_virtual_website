@extends('user.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary font-weight-bold">
                            <i class="fas fa-users mr-2"></i> Uttoradhikar Certificate List
                        </h5>
                        <a href="{{ route('user.uttoradhikarsonod.create') }}" class="btn btn-primary btn-sm px-4 shadow-sm">
                            <i class="fas fa-plus-circle mr-1"></i> Add New
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover datatable dt-responsive nowrap w-100">
                                <thead class="thead-light">
                                    <tr>
                                        <th>@lang('ID')</th>
                                        <th>@lang('Certificate Number')</th>
                                        <th>@lang('Name (Bengali)')</th>
                                        <th>@lang('Relationship')</th>
                                        <th>@lang('Issue Date')</th>
                                        <th>@lang('Status')</th>
                                        <th class="text-center">@lang('Actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($certificates as $certificate)
                                        <tr>
                                            <td>{{ $certificate->id }}</td>
                                            <td><span class="badge badge-light border text-muted">{{ $certificate->certificate_number }}</span></td>
                                            <td class="font-weight-medium text-dark">{{ $certificate->person_bn }}</td>
                                            <td>{{ $certificate->he_she_is }}</td>
                                            <td>{{ $certificate->created_at->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $certificate->status == 'active' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($certificate->status ?? 'Pending') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('user.uttoradhikarsonod.show', $certificate->id) }}" class="btn btn-sm btn-outline-info mr-1" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('user.uttoradhikarsonod.edit', $certificate->id) }}" class="btn btn-sm btn-outline-warning mr-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if(isset($certificate->certificate_number))
                                                        <a href="{{ route('verify.uttoradhikar', $certificate->certificate_number) }}" target="_blank" class="btn btn-sm btn-outline-success mr-1" title="Verify">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                    @endif
                                                    <form action="{{ route('user.uttoradhikarsonod.destroy', $certificate->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this certificate?')" title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
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
@endsection

@push('css')
<style>
    .card { border-radius: 10px; }
    .card-header { border-radius: 10px 10px 0 0 !important; border-bottom: 1px solid #f0f0f0; }
    .table thead th { 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px; 
        font-weight: 700; 
        border-bottom: none;
        background: #f8f9fa;
    }
    .table td { vertical-align: middle; font-size: 14px; }
    .badge { padding: 5px 10px; font-weight: 500; border-radius: 4px; }
    .btn-sm { border-radius: 4px; }
</style>
@endpush
