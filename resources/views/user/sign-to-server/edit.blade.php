@extends('user.layouts.app')

@section('title')
    @lang($title ?? 'Edit Sign To Server Entry')
@endsection

@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <h4 class="mb-3">@lang($title ?? 'Edit Entry')</h4>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif

            <form action="{{ route('user.sign-to-server.update', $signToServer->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_number">ID Number</label>
                            <input type="text" name="id_number" id="id_number" class="form-control" value="{{ old('id_number', $signToServer->id_number) }}" required>
                            @error('id_number')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="pin_number">PIN Number</label>
                            <input type="text" name="pin_number" id="pin_number" class="form-control" value="{{ old('pin_number', $signToServer->pin_number) }}" required>
                            @error('pin_number')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="name_bangla">Name (Bangla)</label>
                            <input type="text" name="name_bangla" id="name_bangla" class="form-control" value="{{ old('name_bangla', $signToServer->name_bangla) }}" required>
                            @error('name_bangla')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="name_english">Name (English)</label>
                            <input type="text" name="name_english" id="name_english" class="form-control" value="{{ old('name_english', $signToServer->name_english) }}" required>
                            @error('name_english')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $signToServer->date_of_birth) }}">
                            @error('date_of_birth')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $signToServer->phone) }}" required>
                            @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="mb-3" id="bn_show" style="display:none">
                            <label>Date of Birth:</label>
                            <input type="text" class="form-control" placeholder="Birth Number" name="date_of_birth" value="{{ old('birth_no', $signToServer->birth_no ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label>Father's Name:</label>
                            <input type="text" class="form-control" placeholder="Father's Name" name="father_name" value="{{ old('father_name', $signToServer->father_name) }}">
                        </div>
                        <div class="mb-3">
                            <label>Father's ID:</label>
                            <input type="text" class="form-control" placeholder="Father's ID" name="father_id" value="{{ old('father_id', $signToServer->father_id) }}">
                        </div>

                        <div class="mb-3">
                            <label>Mother's Name:</label>
                            <input type="text" class="form-control" placeholder="Mother's Name" name="mother_name" value="{{ old('mother_name', $signToServer->mother_name) }}">
                        </div>
                        <div class="mb-3">
                            <label>Mother's ID:</label>
                            <input type="text" class="form-control" placeholder="Mother's ID" name="mother_id" value="{{ old('mother_id', $signToServer->mother_id) }}">
                        </div>

                        <div class="mb-3">
                            <label>Spouse's Name:</label>
                            <input type="text" class="form-control" placeholder="Spouse Name" name="spouse_name" value="{{ old('spouse_name', $signToServer->spouse_name) }}">
                        </div>

                        <div class="mb-3">
                            <label>Place of Birth:</label>
                            <input type="text" class="form-control" placeholder="Birth Place" name="birth_place" value="{{ old('birth_place', $signToServer->place_of_birth ?? $signToServer->birth_place ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="present_address">Present Address</label>
                            <textarea name="present_address" id="present_address" class="form-control" rows="3">{{ old('present_address', $signToServer->present_address) }}</textarea>
                            @error('present_address')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" id="photo" class="form-control-file">
                            @if($signToServer->photo)
                                @php
                                    $photoUrl = url('public/sign_to_server/' . basename($signToServer->photo));
                                @endphp
                                <div class="mt-2">
                                    <a href="{{ $photoUrl }}" target="_blank"><img src="{{ $photoUrl }}" alt="photo" style="max-width:160px;max-height:160px;"></a>
                                </div>
                            @endif
+                            @error('photo')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="signature">Signature</label>
                            <input type="file" name="signature" id="signature" class="form-control-file">
                            @if($signToServer->signature)
                                @php
                                    $sigUrl = url('public/sign_to_server/' . basename($signToServer->signature));
                                @endphp
                                <div class="mt-2">
                                    <a href="{{ $sigUrl }}" target="_blank"><img src="{{ $sigUrl }}" alt="signature" style="max-width:160px;max-height:80px;"></a>
                                </div>
                            @endif
+                            @error('signature')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

    

                        <div class="mb-3">
                            <label>Religion:</label>
                            <select class="form-control" name="religion">
                                <option value="">Select</option>
                                <option value="islam" {{ old('religion', $signToServer->religion) == 'islam' ? 'selected' : '' }}>ইসলাম</option>
                                <option value="hinduism" {{ old('religion', $signToServer->religion) == 'hinduism' ? 'selected' : '' }}>হিন্দু</option>
                                <option value="christianity" {{ old('religion', $signToServer->religion) == 'christianity' ? 'selected' : '' }}>খ্রিস্টান</option>
                                <option value="buddhism" {{ old('religion', $signToServer->religion) == 'buddhism' ? 'selected' : '' }}>বৌদ্ধ</option>
                                <option value="other" {{ old('religion', $signToServer->religion) == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Blood Group:</label>
                            <select class="form-control" name="blood_group">
                                @php $bg = old('blood_group', $signToServer->blood_group); @endphp
                                <option value="Unknown" {{ $bg == 'Unknown' ? 'selected' : '' }}>অজানা</option>
                                <option value="A+" {{ $bg == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ $bg == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ $bg == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ $bg == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="O+" {{ $bg == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ $bg == 'O-' ? 'selected' : '' }}>O-</option>
                                <option value="AB+" {{ $bg == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ $bg == 'AB-' ? 'selected' : '' }}>AB-</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Occupation:</label>
                            <input type="text" class="form-control" placeholder="Occupation" name="occupation" value="{{ old('occupation', $signToServer->occupation) }}">
                        </div>

                        <div class="mb-3">
                            <label>Education:</label>
                            <input type="text" class="form-control" placeholder="Educational Qualification" name="education" value="{{ old('education', $signToServer->education) }}">
                        </div>

                        <div class="mb-3">
                            <label>Form No.:</label>
                            <input type="text" class="form-control" placeholder="Form No." name="form_no" value="{{ old('form_no', $signToServer->form_no) }}">
                        </div>

                        <div class="mb-3">
                            <label>Voter No.:</label>
                            <input type="text" class="form-control" placeholder="Voter No." name="voter_no" value="{{ old('voter_no', $signToServer->voter_no) }}">
                        </div>

                        <div class="mb-3">
                            <label>Voter Area:</label>
                            <input type="text" class="form-control" placeholder="Voter Area" name="voter_area" value="{{ old('voter_area', $signToServer->voter_area) }}">
                        </div>

                        <div class="mb-3">
                            <label>Gender:</label>
                            <select class="form-control" name="gender">
                                @php $g = old('gender', $signToServer->gender); @endphp
                                <option value="">Select</option>
                                <option value="male" {{ strtolower($g) == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                <option value="female" {{ strtolower($g) == 'female' ? 'selected' : '' }}>মহিলা</option>
                                <option value="other" {{ strtolower($g) == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="permanent_address">Permanent Address</label>
                            <textarea name="permanent_address" id="permanent_address" class="form-control" rows="3">{{ old('permanent_address', $signToServer->permanent_address) }}</textarea>
                            @error('permanent_address')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>

@endsection
