@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="text-right">
                <a href="{{route('user.ssc_certificate.create')}}" class="btn btn-success"> <i class="fas fa-plus"></i> Add SSC Certificate </a>
            </div>
            
            <div style="overflow-x:auto;">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('Student Name')</th>
                        <th scope="col">@lang('Registration No')</th>
                        <th scope="col">@lang('Roll No')</th>
                        <th scope="col">@lang('School Name')</th>
                        <th scope="col">@lang('GPA')</th>
                        <th scope="col">@lang('Certificate')</th>
                    
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($objects as $key=> $data)
                        <tr>
                            <td data-label="@lang('No.')">
                                {{ $key + 1 }}
                            </td>
                            <td data-label="@lang('Student Name')">
                                {{ $data->student_name }}
                            </td>
                            <td data-label="@lang('Registration No')">
                                {{ $data->registration_no }}
                            </td>
                            <td data-label="@lang('Roll No')">
                                {{ $data->roll_no }}
                            </td>
                            <td data-label="@lang('School Name')">
                                {{ $data->school_name }}
                            </td>
                            <td data-label="@lang('GPA')">
                                {{ $data->gpa }}
                            </td>
                            <td data-label="@lang('Certificate')">
                                <a href="{{ route('user.ssc_certificate.show', $data->id) }}" class="btn btn-primary" target="_blank"> <i class="fas fa-print"></i> Print</a>
                            </td>

                            <td data-label="@lang('Action')" class="text-lg-center text-right">
                                <a href="{{ route('user.ssc_certificate.edit', $data->id) }}" class="btn btn-info"> <i class="fas fa-pencil-alt"></i> Edit </a>
                                
                                <form style="display:inline-block" action="{{ route('user.ssc_certificate.destroy', $data->id) }}" method="post" onsubmit="return confirm('Do you really want to delete this?');">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-danger"> <i class="fas fa-trash"></i> Delete </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="9">@lang('No Data')</td>
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
        $(document).ready(function() {
            // Add any JavaScript functionality here if needed
        });
    </script>
@endpush
