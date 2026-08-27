@extends('mod.layouts.app')
@section('title')
    @lang("Application List")
@endsection
@section('content')
    <style>
        .fa-ellipsis-v:before {
            content: "\f142";
        }
    </style>
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <br/>
            <table class="categories-show-table table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('ID No')</th>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Type')</th>
                        <th scope="col">@lang('User')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Date')</th>
                        <th scope="col" style="text-align:center">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $key => $application)
                        <tr style="{{ $application->type == 'Biometric' ? 'background-color: red; color: white;' : '' }}">
                            <td data-label="@lang('No.')">
                                {{ $key + 1 }}
                            </td>
                            <td data-label="@lang('ID No')">
                                {{ $application->nid }}
                            </td>
                            <td data-label="@lang('Name')">
                                {{ $application->name }}
                            </td>
                            <td data-label="@lang('Type')">
                                {{ $application->type }}
                            </td>
                            <td data-label="@lang('User')">
                                {{ @$application->user->name }}
                            </td>
                            <td data-label="@lang('Status')">
                                @if ($application->status == '0')
                                    <b style="color:red">Pending</b>
                                @elseif ($application->status == '3')
                                    <b style="color:red">Cancelled ( {{ $application->cancel_reason }} )</b>
                                @endif
                            </td>
                            <td data-label="@lang('Date')">
                                {{ date('d F Y', strtotime(@$application->created_at)) }}
                            </td>
                            <td data-label="@lang('Action')" class="text-lg-center text-right">
                                @if ($application->status == '0')
                                    <form style="display:inline-block" action="{{ route('mod.accept-application', $application->id) }}" method="post" onsubmit="return confirm('Do you really want to accept this application?');">
                                        @csrf 
                                        <button class="btn btn-success"> <i class="fas fa-check"></i> Accept </button>
                                    </form>
                                @endif
                                @if ($application->type == 'Advanced')
                                    <a data-info='{!! $application->extra !!}' href='javascript:void(0);' class='view-info btn btn-info'> <i class="fas fa-eye"></i> View Info </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="9">@lang('No Data')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{$applications->appends(@$_GET)->links('partials.pagination')}}
        </div>
    </div>
    
    <div class="modal fade" id="m-info" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Application Info')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <div id="info-html"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        // Function to play notification sound
        function playNotificationSound() {
            var audio = new Audio('/assets/admin/noti.mp3');
            var playCount = 0;
            var maxPlays = 3; // Number of times to repeat

            function playSound() {
                audio.play().then(() => {
                    console.log('Sound played successfully');
                    playCount++;
                    if (playCount < maxPlays) {
                        setTimeout(playSound, 1500); // Adjusted to wait 1.5 seconds between repeats
                    }
                }).catch(error => {
                    console.error('Sound playback error:', error);
                });
            }

            playSound();
        }

        // AJAX request to check pending applications
        function checkPendingApplications() {
            $.ajax({
                type: 'POST',
                url: "{{ secure_url('mod/check-applications') }}",  // Ensure the request is HTTPS
                success: function(response) {
                    // Check the response for pending applications count
                    if (response.pending_count > 0) {
                        playNotificationSound(); // Play sound if there are pending applications
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking pending applications:', error);
                }
            });
        }

        // Set an interval to check for pending applications every 10 seconds
        setInterval(checkPendingApplications, 10000); // Check every 10 seconds
    </script>
@endpush
