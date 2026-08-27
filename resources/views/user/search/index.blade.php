@extends('user.layouts.app')

@section('title', 'Search NID')

@push('style')
    <style>
        /* Custom Styling to match the design reference perfectly */
        .page-wrapper {
            background-color: #f8fafc;
            min-height: 100vh;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .main-title {
            color: #0b1a30;
            font-weight: 700;
            font-size: 2rem;
        }
        .custom-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: none;
        }
        .custom-input {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 10px !important;
            color: #334155;
            font-weight: 500;
            padding-left: 15px;
        }
        .custom-input:focus {
            background-color: #f1f5f9;
            border-color: #6366f1;
            box-shadow: none;
        }
        .btn-gradient-search {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            border: none;
            border-radius: 10px !important;
            font-weight: 600;
            padding-left: 24px;
            padding-right: 24px;
            transition: opacity 0.2s;
        }
        .btn-gradient-search:hover {
            color: white;
            opacity: 0.9;
        }
        .hint-pill {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
            border-radius: 50px;
            padding: 5px 14px;
            font-size: 13px;
            display: inline-block;
            margin: 4px;
        }
        .stat-box {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #ffffff;
        }
        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
        }
        .stat-number.blue { color: #3b82f6; }
        .stat-number.green { color: #10b981; }
        .stat-lbl {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }
        .section-heading {
            color: #475569;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .clean-table {
            background: transparent;
        }
        .clean-table thead th {
            border-top: none !important;
            border-bottom: 2px solid #e2e8f0 !important;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .clean-table tbody td {
            border-top: none;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
            font-size: 15px;
            vertical-align: middle !important;
        }
        .btn-danger-light {
            background-color: #fee2e2;
            color: #ef4444;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            padding: 6px 16px;
        }
        .btn-danger-light:hover {
            background-color: #fca5a5;
            color: #b91c1c;
        }
        /* Loading button configuration toggles */
        #searchBtn .spinner-border,
        #searchBtn .loading-text {
            display: none;
        }
        #searchBtn.is-searching .btn-text {
            display: none;
        }
        #searchBtn.is-searching .spinner-border,
        #searchBtn.is-searching .loading-text {
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="container">

            <!-- Center Header -->
            <div class="text-center mb-4">
                <h1 class="main-title mb-2">🔍 NID Search</h1>
                <p class="text-muted" style="font-size: 16px;">Search by National ID, Voter No, Form No, or Birth Certificate</p>
                <p class="text-muted" style="font-size: 16px;">Cost per search {{ getServiceCharge('auto-service') }} BDT</p>

            </div>

            <!-- Centered Search Card Container -->
            <div class="row justify-content-center mb-5">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="card custom-card p-4">
                        <form action="{{ route('user.search.submit') }}" method="POST" id="searchForm">
                            @csrf
                            <div class="form-row mx-0 mb-3">
                                <div class="col-9 pr-2">
                                    <input
                                            type="text"
                                            name="query"
                                            class="form-control form-control-lg custom-input"
                                            placeholder="demo"
                                            value="{{ old('query') }}"
                                            autocomplete="off"
                                            autofocus
                                            required
                                    >
                                </div>
                                <div class="col-3 pl-0">
                                    <button type="submit" class="btn btn-block btn-lg btn-gradient-search" id="searchBtn">
                                        <span class="btn-text">Search</span>
                                        <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                        <span class="loading-text">...</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Centered Formats / Pills -->
                            <div class="text-center px-2">
                                <span class="hint-pill">10 digit NID</span>
                                <span class="hint-pill">17 digit NID</span>
                                <span class="hint-pill">12 digit Voter No</span>
                                <span class="hint-pill">8 digit Form No</span>
                                <span class="hint-pill">BRN 17digits</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @php
                $todayCount = \App\Models\ServerCopy::where('user_id', auth()->user()->id)
                    ->whereDate('created_at', today())->count();
                $totalCount = \App\Models\ServerCopy::where('user_id', auth()->user()->id)->count();
            @endphp

                    <!-- Stats Boxes Row -->
            <div class="row justify-content-center text-center mb-5 mx-auto" style="max-width: 900px;">
                <div class="col-md-2"></div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="stat-box p-3">
                        <div class="stat-number blue mb-1">{{ $todayCount }}</div>
                        <div class="stat-lbl">Today's Searches</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="stat-box p-3">
                        <div class="stat-number blue mb-1">{{ $totalCount }}</div>
                        <div class="stat-lbl">Total Searches</div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>

            <!-- Recent Searches List Layout -->
            @if($history->count())
                <div class="px-2 mb-2">
                    <h2 class="section-heading">Recent Searches</h2>
                </div>

                <div class="table-responsive">
                    <table class="table clean-table mb-0">
                        <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Search ID</th>
                            <th>Name</th>
                            <th>NID</th>
                            <th>Time</th>
                            <th width="140">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($history as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->search_by }}</td>
                                <td>{{ $row->nameEn ?: $row->nameBn }}</td>
                                <td>{{ $row->nationalId }}</td>
                                <td class="text-muted">{{ $row->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('user.search.download', $row->id) }}" class="btn btn-danger-light btn-sm">
                                        ↓ PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('searchForm').addEventListener('submit', function() {
            const btn = document.getElementById('searchBtn');

            // Trigger clean animation style matching layout changes
            btn.classList.add('is-searching');
            btn.disabled = true;

            // Simple safety timeout fallback
            setTimeout(function() {
                btn.classList.remove('is-searching');
                btn.disabled = false;
            }, 4000);
        });
    </script>
@endpush