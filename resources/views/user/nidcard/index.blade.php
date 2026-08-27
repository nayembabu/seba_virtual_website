@extends('user.layouts.app')
@section('title')
    এনআইডি কার্ড তালিকা
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <h5 class="mb-0">এনআইডি কার্ড তালিকা</h5>
                {{--<div class="btn-group flex-wrap" role="group">
                    <a href="{{ route('user.nid-card.create', ['type' => \App\Models\Nid::TYPE_NID]) }}" class="btn btn-primary btn-sm">+ সাধারণ NID</a>
                    <a href="{{ route('user.nid-card.create', ['type' => \App\Models\Nid::TYPE_APPLICATION]) }}" class="btn btn-info btn-sm">+ Application</a>
                    <a href="{{ route('user.nid-card.create', ['type' => \App\Models\Nid::TYPE_SIGN_TO_SERVER]) }}" class="btn btn-secondary btn-sm">+ Sign-to-server</a>
                    <a href="{{ route('user.nid-card.create', ['type' => \App\Models\Nid::TYPE_CDMS]) }}" class="btn btn-dark btn-sm">+ CDMS</a>
                </div>--}}
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center datatable" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
{{--                            <th>ধরন</th>--}}
                            <th>নাম (বাংলা)</th>
                            <th>NID নং</th>
                            <th>জন্ম তারিখ</th>
                            <th>ডাউনলোড</th>
                            <th>সময়</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nids as $i => $n)
                            <tr>
                                <td>{{ $i + 1 }}</td>
{{--                                <td><span class="badge badge-secondary">{{ $n->type }}</span></td>--}}
                                <td>{{ $n->name_bn }}</td>
                                <td>{{ $n->nid_number }}</td>
                                <td>{{ $n->date_of_birth ? $n->date_of_birth->format('Y-m-d') : '—' }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('user.nid-card.view', [$n->id, 'nid']) }}" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener">NID</a>
                                    <a href="{{ route('user.nid-card.view', [$n->id, 'v1']) }}" class="btn btn-sm btn-outline-info" target="_blank" rel="noopener">V1</a>
                                    <a href="{{ route('user.nid-card.view', [$n->id, 'v2']) }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">V2</a>
                                    <a href="{{ route('user.nid-card.view', [$n->id, 'v3']) }}" class="btn btn-sm btn-outline-dark" target="_blank" rel="noopener">V3</a>
                                <form action="{{ route('user.nid-card.destroy', $n->id) }}" method="post" class="d-inline" onsubmit="return confirm('মুছে ফেলবেন?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">ডিলিট</button>
                                    </form>
                                </td>
                                <td>{{ $n->created_at?->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">কোনো রেকর্ড নেই। উপরে থেকে ধরন বেছে নিন।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            if ($.fn.DataTable && $('.datatable').length) {
                if ($.fn.DataTable.isDataTable('.datatable')) {
                    $('.datatable').DataTable().destroy();
                }
                $('.datatable').DataTable({ pageLength: 25, order: [] });
            }
        });
    </script>
@endpush
