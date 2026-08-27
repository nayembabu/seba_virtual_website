@extends('user.layouts.app')
@section('title')
    Smart Card List
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(isset($notification))
                <div class="alert alert-info">
                    {{ $notification }}
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Smart Card তালিকা</h5>
                <a href="{{ route('user.smartcard.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add New Smart Card
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered datatable">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Name (Bangla)</th>
                            <th>Name (English)</th>
                            <th>NID Number</th>
                            <th>Date of Birth</th>
                            <th>Issue Date</th>
                            <th>Download</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($smartCards as $key => $card)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $card->name_bn }}</td>
                                <td>{{ $card->name_en }}</td>
                                <td>{{ $card->nid_no }}</td>
                                <td>{{ $card->date_of_birth->format('d/m/Y') }}</td>
                                <td>{{ $card->issue_date->format('d/m/Y') }}</td>
                               
                                    <td data-label="@lang('Certificate')">
                                <a href="{{ route('user.smartcard.show',  $card->id) }}" class="btn btn-primary" target="_blank"> <i class="fas fa-print"></i> Print</a>
                                </td>
                                <td>
                                    
                                    <div class="text-lg-center text-right">
                                        
                                        <a href="{{ route('user.smartcard.edit',  $card->id) }}" class="btn btn-info"> <i class="fas fa-pencil-alt"></i> Edit </a>

                                         <form style="display:inline-block" action="{{ route('user.smartcard.destroy',  $card->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-danger"> <i class="fas fa-trash"></i> Delete </button>
                                </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No Smart Cards found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@push('css')
<style>
    .badge {
        font-size: 0.9em;
        padding: 5px 10px;
    }
    .btn-group .btn {
        margin: 0 2px;
    }
    .alert {
        border-radius: 0.25rem;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('.datatable')) {
            $('.datatable').DataTable().destroy();
        }

        $('.datatable').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 25,
            order: []
        });

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert:not(.alert-info)').fadeOut('slow');
        }, 5000);
    });
</script>
@endpush
