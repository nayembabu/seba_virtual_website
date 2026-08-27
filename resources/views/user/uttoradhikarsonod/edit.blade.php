@extends('user.layouts.app')

@section('content')
<div>
    <div class="card card-fullheight">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user.uttoradhikarsonod.update', $certificate->id) }}" method="POST" autocomplete="on">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="certificate_number" class="form-label">সনদ সাল</label>
                        <input type="text" 
                               class="form-control" 
                               id="certificate_number" 
                               name="certificate_number" 
                               value="{{ $certificate->certificate_number }}"
                               readonly>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label>ইউনিয়নের নাম</label>
                            <input class="form-control" type="text" name="union_name" value="{{ old('union_name', $certificate->union_name) }}" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>ইউনিয়নের ঠিকানা</label>
                            <input class="form-control" type="text" name="union_address" value="{{ old('union_address', $certificate->union_address) }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label>ওয়ার্ড নং</label>
                            <input class="form-control" type="number" name="word_no" value="{{ old('word_no', $certificate->word_no) }}" required>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>গ্রামের নাম</label>
                            <input class="form-control" type="text" name="village_name" value="{{ old('village_name', $certificate->village_name) }}" required>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>ডাকঘর</label>
                            <input class="form-control" type="text" name="post_office" value="{{ old('post_office', $certificate->post_office) }}" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>থানা</label>
                            <input class="form-control" type="text" name="thana" value="{{ old('thana', $certificate->thana) }}" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>উপজেলা</label>
                            <input class="form-control" type="text" name="upozila" value="{{ old('upozila', $certificate->upozila) }}" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label>জেলা</label>
                            <input class="form-control" type="text" name="zila" value="{{ old('zila', $certificate->zila) }}" required>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="form-group">
                                <label>লিঙ্গ</label>
                                <select class="form-control select2" name="gender" id="gender">
                                    <option value="">লিঙ্গ</option>
                                    <option value="male" {{ old('gender', $certificate->gender) == 'male' ? 'selected' : '' }}>পুরুষ</option>
                                    <option value="female" {{ old('gender', $certificate->gender) == 'female' ? 'selected' : '' }}>নারী</option>
                                    <option value="other" {{ old('gender', $certificate->gender) == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <div class="form-group">
                                <label>সনদের ধরন</label>
                                <select class="form-control select2" name="he_she_is" id="he_she_is">
                                    <option value="">সনদের ধরন</option>
                                    <option value="death" {{ old('he_she_is', $certificate->he_she_is) == 'death' ? 'selected' : '' }}>মৃত ব্যক্তির জন্য</option>
                                    <option value="live" {{ old('he_she_is', $certificate->he_she_is) == 'live' ? 'selected' : '' }}>জীবিত ব্যক্তির জন্য</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>মৃত্যু সনদ নং</label>
                            <input class="form-control" type="text" name="death_certificates_id" value="{{ old('death_certificates_id', $certificate->death_certificates_id) }}" maxlength="17">
                        </div>
                        <div class="form-group col-sm-2">
                            <label>মৃত্যু তারিখ</label>
                            <input class="form-control" type="date" name="dod" value="{{ old('dod', $certificate->dod) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label>নাম (বাংলা)</label>
                            <input class="form-control" type="text" name="person_bn" value="{{ old('person_bn', $certificate->person_bn) }}" maxlength="150" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label>পিতা/স্বামী (বাংলা)</label>
                            <input class="form-control" type="text" name="guardian_bn" value="{{ old('guardian_bn', $certificate->guardian_bn) }}" maxlength="150" required>
                        </div>
                    </div>
                    <div class="table">
                        <table class="table table-borderless" id="newRows">
                            <thead class="text-white text-center" style="background-color: #5fa2db">
                                <tr class="form-row">
                                    <th class="col" colspan="3">
                                        <h3 style="color: red;">স্বজনদের নাম</h3>
                                        <hr>
                                    </th>
                                </tr>
                                <tr class="form-row">
                                    <th class="form-group col-md-8" style="color: red;">নাম (বাংলা)</th>
                                    <th class="form-group col-md-4" style="color: red;">সম্পর্ক</th>                             
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($certificate->relatives as $index => $relative)
                                <tr class="form-row">
                                    <td class="form-group col-md-8">
                                        <input type="text" class="form-control" name="name_bn[]" value="{{ $relative['name_bn'] }}" required/>
                                    </td>
                                    <td class="form-group col-md-4">
                                        <select name="Relatives[]" class="form-control select2">
                                            @foreach(['পিতা', 'মাতা', 'স্বামী', 'স্ত্রী', 'ভাই', 'সৎ ভাই', 'বোন', 'পুত্র', 'কন্যা', 'নাতি', 'ভাতিজা', 'ভাতিজী', 'দাদী'] as $relation)
                                                <option value="{{ $relation }}" {{ $relative['relation'] == $relation ? 'selected' : '' }}>{{ $relation }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        @if($index > 0)
                                            <button type="button" class="btn btn-danger removeRow">✕</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <button type="button" id="addRowBtn" class="btn btn-danger w-100">যুক্ত করুন</button>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-outline-primary btn-block">আপডেট করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add row functionality
    document.getElementById('addRowBtn').addEventListener('click', function() {
        var tbody = document.querySelector('#newRows tbody');
        var tr = document.createElement('tr');
        tr.className = 'form-row';
        
        tr.innerHTML = `
            <td class="form-group col-md-8">
                <input type="text" class="form-control" name="name_bn[]" placeholder="নাম" required/>
            </td>
            <td class="form-group col-md-4">
                <select name="Relatives[]" class="form-control select2">
                    <option value="পিতা">পিতা</option>
                    <option value="মাতা">মাতা</option>
                    <option value="স্বামী">স্বামী</option>
                    <option value="স্ত্রী">স্ত্রী</option>
                    <option value="ভাই">ভাই</option>
                    <option value="সৎ ভাই">সৎ ভাই</option>
                    <option value="বোন">বোন</option>
                    <option value="পুত্র">পুত্র</option>
                    <option value="কন্যা">কন্যা</option>
                    <option value="নাতি">নাতি</option>
                    <option value="ভাতিজা">ভাতিজা</option>
                    <option value="ভাতিজী">ভাতিজী</option>
                    <option value="দাদী">দাদী</option>
                </select>
            </td>
            <td>
                <button type="button" class="btn btn-danger removeRow">✕</button>
            </td>
        `;
        
        tbody.appendChild(tr);
        
        // Initialize Select2 if it's being used
        if (typeof $.fn.select2 !== 'undefined') {
            $(tr).find('select').select2();
        }
    });
    
    // Initialize event listeners for remove buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
        }
    });
});
</script>
@endsection
