@extends('admin.layouts.app')
@section('title')
    @lang("Support Tickets")
@endsection
@section('content')

<div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>@lang('No.')</th>
                    <th>@lang('User')</th>
                    <th>@lang('Message')</th>
                    <th>@lang('Reply')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Date')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($supports as $key => $support)
                    @php
                        $statusClass = '';
                        switch ($support->status) {
                            case 'pending':
                                $statusClass = 'bg-danger text-white';
                                break;
                            case 'waiting_for_customer_reply':
                                $statusClass = 'bg-info text-white';
                                break;
                            case 'closed':
                                $statusClass = 'bg-secondary text-white';
                                break;
                            case 'hold':
                                $statusClass = 'bg-brown text-white';
                                break;
                            case 'processing':
                                $statusClass = 'bg-success text-white';
                                break;
                            default:
                                $statusClass = 'bg-light';
                        }
                    @endphp
                    <tr class="{{ $statusClass }}">
                        <td>{{ $loop->iteration + ($supports->currentPage() - 1) * $supports->perPage() }}</td>
                        <td>{{ $support->user->email }}</td>
                        <td>{{ $support->msg }}</td>
                        <td>{{ $support->reply }}</td>
                        <td>
                            @if ($support->status == 'pending') Pending
                @elseif ($support->status == 'waiting_for_customer_reply') Waiting for Customer's Reply
                @elseif ($support->status == 'closed') Closed
                @elseif ($support->status == 'hold') On Hold
                @elseif ($support->status == 'processing') Processing
                @else Unknown
                @endif
                        </td>
                        <td>{{ $support->created_at->format('d F Y') }}</td>
                        <td>
                            <a href="{{ route('admin.support-detail', $support->id) }}" class="btn btn-info">View</a>
                            @if ($support->status == 'pending')
                                <form action="{{ route('admin.reply-to-support', $support->id) }}" method="POST" enctype="multipart/form-data" style="display:inline-block;">
                                    @csrf
                                    <div class="form-group">
                                        <label for="reply">Reply</label>
                                        <textarea id="reply" name="reply" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Upload Photo (Max 2MB)</label>
                                        <input type="file" id="photo" name="photo" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Reply</button>
                                </form>
                                <form action="{{ route('admin.mark-support-solved', $support->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Mark as Solved</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-danger">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Custom Pagination Links without Arrows -->
        @if ($supports->hasPages())
            <div class="pagination-wrapper">
                <ul class="pagination">
                    @for ($i = 1; $i <= $supports->lastPage(); $i++)
                        <li class="page-item {{ $i == $supports->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $supports->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                </ul>
            </div>
        @endif

    </div>
</div>

@endsection
