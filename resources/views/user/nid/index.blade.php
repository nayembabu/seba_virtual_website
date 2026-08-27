@extends('user.layouts.app')

@section('title')
    এনআইডি তালিকা
@endsection

@section('content')
<div class="card card-custom m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <div class="row justify-content-between mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-primary mb-0">
                        <i class="fas fa-id-card fa-fw"></i> এনআইডি তালিকা
                    </h3>
                    <a href="{{ route('user.nid.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus fa-fw"></i> নতুন এনআইডি
                    </a>
                </div>
                <hr class="border-primary opacity-75 mt-3">
            </div>
        </div>

        @if($nids->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ক্রমিক</th>
                            <th>ছবি</th>
                            <th>নাম (বাংলা)</th>
                            <th>এনআইডি নাম্বার</th>
                            <th>জন্ম তারিখ</th>
                            <th>স্ট্যাটাস</th>
                            <th width="150">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nids as $key => $nid)
                            <tr>
                                <td>{{ $nids->firstItem() + $key }}</td>
                                <td class="text-center">
                                    @if(!empty($nid->photo))
                                        @php
                                            $photoPath = $nid->photo;
                                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photoPath)) {
                                                try {
                                                    $photoContents = \Illuminate\Support\Facades\Storage::disk('public')->get($photoPath);
                                                    $mime = finfo_buffer(finfo_open(), $photoContents, FILEINFO_MIME_TYPE) ?: 'image/jpeg';
                                                    $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode($photoContents);
                                                } catch (\Exception $e) {
                                                    $photoBase64 = null;
                                                }
                                            }
                                        @endphp
                                        @if(!empty($photoBase64))
                                            <img src="{{ $photoBase64 }}" alt="ফটো" class="img-thumbnail" style="max-width: 50px;">
                                        @else
                                            <img src="{{ asset('storage/' . $nid->photo) }}" alt="ফটো" class="img-thumbnail" style="max-width: 50px;">
                                        @endif
                                    @else
                                        <div class="img-thumbnail" style="width:50px;height:50px;display:inline-block;background:#f5f5f5;"></div>
                                    @endif
                                </td>
                                <td>{{ $nid->name_bn }}</td>
                                <td>{{ $nid->nid_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($nid->date_of_birth)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-pill badge-success">
                                        সম্পন্ন
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('user.nid.show', $nid->id) }}" 
                                           class="btn btn-info" 
                                           title="বিস্তারিত দেখুন">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('user.nid.edit', $nid->id) }}" 
                                           class="btn btn-primary" 
                                           title="সম্পাদনা করুন">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('user.nid.destroy', $nid->id) }}" 
                                              method="POST" 
                                              class="d-inline delete-form"
                                              onsubmit="return confirm('আপনি কি নিশ্চিত যে আপনি এই এনআইডি মুছে ফেলতে চান?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger" 
                                                    title="মুছে ফেলুন">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

   
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-2x mb-2"></i>
                <p class="mb-0">কোন এনআইডি পাওয়া যায়নি!</p>
            </div>
        @endif
    </div>
</div>
@endsection

