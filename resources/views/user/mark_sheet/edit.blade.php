@extends('user.layouts.app')
@section('title') মার্কশিট এডিট @endsection

@push('css')
<style>.required-field::after { content: " *"; color: #dc3545; font-weight: bold; }</style>
@endpush

@section('content')
@php $subjects = is_string($markSheet->subjects) ? json_decode($markSheet->subjects, true) : $markSheet->subjects; @endphp
<div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
    <div class="card-body">
        <h5 class="mb-4">মার্কশিট এডিট করুন</h5>

        <form action="{{ route('user.mark_sheet.update', $markSheet->id) }}" method="POST" id="marksheetForm">
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">নাম (ইংরেজিতে)</label>
                    <input type="text" class="form-control @error('student_name') is-invalid @enderror" name="student_name" value="{{ old('student_name', $markSheet->student_name) }}" required>
                    @error('student_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">পিতার নাম (ইংরেজিতে)</label>
                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name', $markSheet->father_name) }}" required>
                    @error('father_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">মাতার নাম (ইংরেজিতে)</label>
                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" value="{{ old('mother_name', $markSheet->mother_name) }}" required>
                    @error('mother_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">জন্ম তারিখ</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', $markSheet->date_of_birth ? $markSheet->date_of_birth->format('Y-m-d') : '') }}">
                    @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">শিক্ষা প্রতিষ্ঠানের নাম</label>
                    <input type="text" class="form-control @error('institute_name') is-invalid @enderror" name="institute_name" value="{{ old('institute_name', $markSheet->institute_name) }}" required>
                    @error('institute_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">রোল নম্বর</label>
                    <input type="number" class="form-control @error('roll_no') is-invalid @enderror" name="roll_no" value="{{ old('roll_no', $markSheet->roll_no) }}" required>
                    @error('roll_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">রেজিস্ট্রেশন নম্বর</label>
                    <input type="text" class="form-control" name="registration_no" value="{{ old('registration_no', $markSheet->registration_no) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">বোর্ড</label>
                    <select class="form-select @error('board') is-invalid @enderror" name="board" required>
                        <option value="">বোর্ড নির্বাচন করুন</option>
                        @foreach(['BARISAL','CHITTAGONG','COMILLA','DHAKA','DINAJPUR','JESSORE','MYMENSINGH','RAJSHAHI','SYLHET','MADRASAH','TECHNICAL','DIBS(DHAKA)'] as $b)
                            <option value="{{ $b }}" {{ old('board', $markSheet->board) == $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                    @error('board')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">ধরন</label>
                    <select class="form-select @error('student_type') is-invalid @enderror" name="student_type" required>
                        <option value="REGULAR" {{ old('student_type', $markSheet->student_type) == 'REGULAR' ? 'selected' : '' }}>Regular</option>
                        <option value="IRREGULAR" {{ old('student_type', $markSheet->student_type) == 'IRREGULAR' ? 'selected' : '' }}>Irregular</option>
                    </select>
                    @error('student_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">ফলাফল</label>
                    <select class="form-select @error('result') is-invalid @enderror" name="result" required>
                        <option value="">ফলাফল নির্বাচন করুন</option>
                        <option value="PASSED" {{ old('result', $markSheet->result) == 'PASSED' ? 'selected' : '' }}>PASSED</option>
                        <option value="FAILED" {{ old('result', $markSheet->result) == 'FAILED' ? 'selected' : '' }}>FAILED</option>
                    </select>
                    @error('result')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">জিপিএ</label>
                    <input type="number" step="0.01" min="0" max="5" class="form-control @error('gpa') is-invalid @enderror" name="gpa" value="{{ old('gpa', $markSheet->gpa) }}" required>
                    @error('gpa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">গ্রেড</label>
                    <select class="form-select @error('grade') is-invalid @enderror" name="grade">
                        <option value="">গ্রেড নির্বাচন করুন</option>
                        @foreach(['A+','A','A-','B','C','D','F'] as $g)
                            <option value="{{ $g }}" {{ old('grade', $markSheet->grade) == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                    @error('grade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">পরীক্ষার নাম</label>
                    <select class="form-select @error('exam_name') is-invalid @enderror" name="exam_name" required>
                        <option value="">পরীক্ষা নির্বাচন করুন</option>
                        @foreach(['SSC/Dakhil/Equivalent','JSC/JDC','SSC/Dakhil','SSC(Vocational)','HSC/Alim','HSC(Vocational)','HSC(BM)','Diploma in Commerce','Diploma in Business Studies'] as $e)
                            <option value="{{ $e }}" {{ old('exam_name', $markSheet->exam_name) == $e ? 'selected' : '' }}>{{ $e }}</option>
                        @endforeach
                    </select>
                    @error('exam_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">পরীক্ষার বছর</label>
                    <input type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year', $markSheet->year) }}" min="1900" max="2100" required>
                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">গ্রুপ</label>
                    <select class="form-select @error('group_name') is-invalid @enderror" name="group_name" required>
                        <option value="">গ্রুপ নির্বাচন করুন</option>
                        @foreach(['SCIENCE','HUMANITIES','BUSINESS STUDIES','VOCATIONAL','TECHNICAL','ISLAMIC STUDIES','AGRICULTURE','HOME ECONOMICS','MUSIC'] as $g)
                            <option value="{{ $g }}" {{ old('group_name', $markSheet->group_name) == $g ? 'selected' : '' }}>{{ ucwords(strtolower($g)) }}</option>
                        @endforeach
                    </select>
                    @error('group_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3">বিষয়সমূহ</h5>

            <div class="table-responsive">
                <table class="table table-bordered" id="subjectsTable">
                    <thead><tr><th style="width:15%;">কোড</th><th style="width:50%;">বিষয়</th><th style="width:15%;">গ্রেড</th><th style="width:20%;">কার্যক্রম</th></tr></thead>
                    <tbody id="subjectsBody">
                        @foreach($subjects as $i => $s)
                        <tr>
                            <td><input type="text" name="subjects[{{$i}}][code]" class="form-control form-control-sm" value="{{ $s['code'] ?? '' }}" placeholder="কোড"></td>
                            <td><input type="text" name="subjects[{{$i}}][name]" class="form-control form-control-sm" value="{{ $s['name'] ?? '' }}" placeholder="বিষয়ের নাম" required></td>
                            <td>
                                <select name="subjects[{{$i}}][grade]" class="form-select form-select-sm" required>
                                    <option value="">গ্রেড</option>
                                    @foreach(['A+','A','A-','B','C','D','F'] as $grd)
                                        <option value="{{ $grd }}" {{ ($s['grade'] ?? '') == $grd ? 'selected' : '' }}>{{ $grd }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><button type="button" class="btn btn-sm btn-danger remove-subject"><i class="fas fa-times"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-3">
                <button type="button" id="addSubject" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> বিষয় যোগ করুন</button>
            </div>

            <hr class="my-4">

            <div class="mb-3">
                <label class="form-label">বিবরণ</label>
                <textarea name="details" class="form-control" rows="2">{{ old('details', $markSheet->details) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary px-5"><i class="fas fa-save me-1"></i>আপডেট করুন</button>
            <a href="{{ route('user.mark_sheet.index') }}" class="btn btn-secondary px-4 ms-2">বাতিল</a>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    let si = {{ count($subjects) }};
    document.getElementById('addSubject')?.addEventListener('click', function() {
        const tbody = document.getElementById('subjectsBody'), tr = document.createElement('tr');
        tr.innerHTML = '<td><input type="text" name="subjects['+si+'][code]" class="form-control form-control-sm" placeholder="কোড"></td>' +
            '<td><input type="text" name="subjects['+si+'][name]" class="form-control form-control-sm" placeholder="বিষয়ের নাম" required></td>' +
            '<td><select name="subjects['+si+'][grade]" class="form-select form-select-sm" required><option value="">গ্রেড</option>@foreach(['A+','A','A-','B','C','D','F'] as $grd)<option value="{{ $grd }}">{{ $grd }}</option>@endforeach</select></td>' +
            '<td><button type="button" class="btn btn-sm btn-danger remove-subject"><i class="fas fa-times"></i></button></td>';
        tbody.appendChild(tr); si++;
    });
    document.addEventListener('click', function(e) { const btn = e.target.closest('.remove-subject'); if (btn && document.querySelectorAll('#subjectsBody tr').length > 1) btn.closest('tr').remove(); });
    document.getElementById('marksheetForm')?.addEventListener('submit', function(e) {
        const subjects = [];
        document.querySelectorAll('#subjectsBody tr').forEach(function(row) {
            const code = row.querySelector('input[name*="[code]"]')?.value || '';
            const name = row.querySelector('input[name*="[name]"]')?.value;
            const grade = row.querySelector('select[name*="[grade]"]')?.value;
            if (name) subjects.push({ code, name, grade: grade || '' });
        });
        const input = document.createElement('input');
        input.type = 'hidden'; input.name = 'subjects'; input.value = JSON.stringify(subjects);
        document.querySelectorAll('[name^="subjects["]').forEach(el => el.remove());
        this.appendChild(input);
    });
</script>
@endpush