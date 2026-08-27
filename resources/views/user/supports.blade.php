@extends('user.layouts.app')
@section('title')
    @lang('Support Tickets')
@endsection
@section('content')
    
    <div class="container-fluid">
        
       <div class="text-right">
           <a class="btn btn-info" href="{{ route('user.create-support-ticket') }}">
                <i class="fas fa-life-ring"></i>
               Create Support Ticket
           </a> <br/>
       </div>
        
        <div class="row">
            @foreach($supports as $key => $support)
               <div class="col-md-12">
                    <div class="card shadow border-right">
                        <div class="card-body">
                            <p>{{ $support->msg }}</p>
                            <h4 class="text-info">Submitted At: {{ date('d F Y h:i A', strtotime($support->created_at)) }}</h4>
                            
                            <!-- Display status -->
                            <h4>Status: {{ $support->status == 1 ? 'Solved' : 'Pending' }}</h4>
                            
                            <!-- Display reply if available -->
                            @if($support->reply)
                                <h4>Reply: {{ $support->reply }}</h4>
                            @endif
                            
                            <!-- Display reply option if status is not solved -->
                            @if($support->status != 1)
                            <form action="{{ route('user.create-support-ticket', ['id' => $support->id]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="reply">Reply:</label>
                                    <textarea class="form-control" id="reply" name="reply"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Reply</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            
            {{$supports->appends(@$_GET)->links('partials.pagination')}}
            
        </div>
    </div>
@endsection

@push('js')

@endpush

@push('style')

@endpush
