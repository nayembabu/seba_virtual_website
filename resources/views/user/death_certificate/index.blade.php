@extends('user.layouts.app')

@section('title')
    মৃত্যু সনদপত্র তালিকা
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

            @if($notification ?? false)
                <div class="alert alert-info">
                    {{ $notification }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="card-title text-primary mb-0">
                    <i class="fas fa-file-medical fa-fw"></i> মৃত্যু সনদপত্র তালিকা
                </h3>
                <a href="{{ route('user.death_certificate.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> নতুন সনদপত্র যোগ করুন
                </a>
            </div>

            <hr class="border-primary opacity-75">

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered datatable">
                    <thead class="thead-dark">
                        <tr>
                            <th>ক্রমিক</th>
                            <th>নিবন্ধন নং</th>
                            <th>নাম (বাংলা)</th>
                            <th>নাম (ইংরেজি)</th>
                            <th>মৃত্যুর তারিখ</th>
                            <th>নিবন্ধন তারিখ</th>
                            <th>ইস্যু তারিখ</th>
                            <th>ডাউনলোড</th>
                            <th>কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deathCertificates as $key => $certificate)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $certificate->registration_no }}</td>
                                <td>{{ $certificate->name_bengali }}</td>
                                <td>{{ $certificate->name_english ?? 'N/A' }}</td>
                                <td>{{ $certificate->date_of_death->format('d/m/Y') }}</td>
                                <td>{{ $certificate->registration_date->format('d/m/Y') }}</td>
                                <td>{{ $certificate->issue_date->format('d/m/Y') }}</td>
                               
                                <td data-label="সনদপত্র">
                                    <a href="{{ route('user.death_certificate.show', $certificate->id) }}" 
                                       class="btn btn-primary btn-sm" 
                                       target="_blank">
                                        <i class="fas fa-print"></i> প্রিন্ট
                                    </a>
                                </td>
                                
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('user.death_certificate.edit', $certificate->id) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-pencil-alt"></i> সম্পাদনা
                                        </a>

                                        <form style="display:inline-block" 
                                              action="{{ route('user.death_certificate.destroy', $certificate->id) }}" 
                                              method="post" 
                                              onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এটি মুছে ফেলতে চান?');">
                                            @csrf 
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> মুছুন
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    কোনো মৃত্যু সনদপত্র পাওয়া যায়নি
                                </td>
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
    .table {
        margin-bottom: 0;
    }
    .table thead th {
        vertical-align: middle;
        border-bottom: 2px solid #dee2e6;
        background-color: #343a40;
        color: white;
        font-weight: 600;
    }
    .table tbody td {
        vertical-align: middle;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .text-muted i {
        color: #6c757d;
        opacity: 0.5;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert:not(.alert-info)').fadeOut('slow');
        }, 5000);

        // Confirm before delete
        $('form[onsubmit]').on('submit', function(e) {
            if (!confirm('আপনি কি নিশ্চিতভাবে এটি মুছে ফেলতে চান?')) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endpush