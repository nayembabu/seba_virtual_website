@extends('user.layouts.app')
@section('title') নতুন মার্কশিট @endsection

@push('css')
<style>
    .required-field::after { content: " *"; color: #dc3545; font-weight: bold; }
    .autocomplete-items {
        position: absolute; z-index: 99; top: 100%; left: 0; right: 0;
        background: var(--bg-card, #fff); border: 1px solid var(--border-color, #ddd); border-top: none;
        max-height: 200px; overflow-y: auto; border-radius: 0 0 8px 8px;
    }
    .autocomplete-items div { padding: 8px 12px; cursor: pointer; font-size: 13px; }
    .autocomplete-items div:hover, .autocomplete-active { background: #e9e9e9; }
    .position-relative { position: relative; }
    .btn-group-sm-actions .btn { padding: 4px 8px; font-size: 13px; }
</style>
@endpush

@section('content')
<div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="alert alert-info d-flex justify-content-between align-items-center mb-3">
            <span><i class="fas fa-info-circle"></i> <strong>সার্ভিস চার্জ:</strong> প্রতি মার্কশিট তৈরি করতে চার্জ প্রযোজ্য</span>
            <span class="badge bg-primary fs-6"> ৳{{ $charge ?? 0 }} </span>
        </div>

    <div class="card-body">
        <h5 class="mb-4">মার্কশিট তৈরী করুন</h5>
        <p class="text-muted small mb-4">নিচের ফর্মটি পূরণ করে মার্কশিট তৈরী করুন</p>

        <div class="alert alert-info border-info" id="costInfo">লোড হচ্ছে...</div>

        <form action="{{ route('user.mark_sheet.store') }}" method="POST" id="marksheetForm">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">নাম (ইংরেজিতে)</label>
                    <input type="text" class="form-control @error('student_name') is-invalid @enderror" name="student_name" value="{{ old('student_name') }}" placeholder="আপনার পূর্ণ নাম লিখুন" required>
                    @error('student_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">পিতার নাম (ইংরেজিতে)</label>
                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name') }}" placeholder="পিতার নাম লিখুন" required>
                    @error('father_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">মাতার নাম (ইংরেজিতে)</label>
                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" value="{{ old('mother_name') }}" placeholder="মাতার নাম লিখুন" required>
                    @error('mother_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">জন্ম তারিখ</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3 position-relative">
                    <label class="form-label required-field">শিক্ষা প্রতিষ্ঠানের নাম</label>
                    <input type="text" class="form-control @error('institute_name') is-invalid @enderror" name="institute_name" id="Institute" value="{{ old('institute_name') }}" placeholder="শিক্ষা প্রতিষ্ঠানের নাম লিখুন" required>
                    <div id="schoolSuggestions" class="autocomplete-items" style="display: none;"></div>
                    @error('institute_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">রোল নম্বর</label>
                    <input type="number" class="form-control @error('roll_no') is-invalid @enderror" name="roll_no" value="{{ old('roll_no') }}" placeholder="রোল নম্বর লিখুন" required>
                    @error('roll_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">রেজিস্ট্রেশন নম্বর</label>
                    <input type="text" class="form-control" name="registration_no" value="{{ old('registration_no') }}" placeholder="রেজি নং (যদি থাকে)">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">বোর্ড</label>
                    <select class="form-select @error('board') is-invalid @enderror" name="board" required>
                        <option value="">বোর্ড নির্বাচন করুন</option>
                        @foreach(['BARISAL','CHITTAGONG','COMILLA','DHAKA','DINAJPUR','JESSORE','MYMENSINGH','RAJSHAHI','SYLHET','MADRASAH','TECHNICAL','DIBS(DHAKA)'] as $b)
                            <option value="{{ $b }}" {{ old('board') == $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                    @error('board')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required-field">ধরন</label>
                    <select class="form-select @error('student_type') is-invalid @enderror" name="student_type" required>
                        <option value="REGULAR" {{ old('student_type') == 'REGULAR' ? 'selected' : '' }}>Regular</option>
                        <option value="IRREGULAR" {{ old('student_type') == 'IRREGULAR' ? 'selected' : '' }}>Irregular</option>
                    </select>
                    @error('student_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">ফলাফল</label>
                    <select class="form-select @error('result') is-invalid @enderror" name="result" required>
                        <option value="">ফলাফল নির্বাচন করুন</option>
                        <option value="PASSED" {{ old('result') == 'PASSED' ? 'selected' : '' }}>PASSED</option>
                        <option value="FAILED" {{ old('result') == 'FAILED' ? 'selected' : '' }}>FAILED</option>
                    </select>
                    @error('result')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">জিপিএ</label>
                    <input type="number" step="0.01" min="0" max="5" class="form-control @error('gpa') is-invalid @enderror" name="gpa" value="{{ old('gpa') }}" placeholder="যেমন: 4.60" required>
                    @error('gpa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">গ্রেড</label>
                    <select class="form-select @error('grade') is-invalid @enderror" name="grade">
                        <option value="">গ্রেড নির্বাচন করুন</option>
                        @foreach(['A+','A','A-','B','C','D','F'] as $g)
                            <option value="{{ $g }}" {{ old('grade') == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                    @error('grade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">পরীক্ষার নাম</label>
                    <select class="form-select @error('exam_name') is-invalid @enderror" name="exam_name" id="examName" required>
                        <option value="">পরীক্ষা নির্বাচন করুন</option>
                        @foreach(['SSC/Dakhil/Equivalent','JSC/JDC','SSC/Dakhil','SSC(Vocational)','HSC/Alim','HSC(Vocational)','HSC(BM)','Diploma in Commerce','Diploma in Business Studies'] as $e)
                            <option value="{{ $e }}" {{ old('exam_name') == $e ? 'selected' : '' }}>{{ $e }}</option>
                        @endforeach
                    </select>
                    @error('exam_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">পরীক্ষার বছর</label>
                    <input type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}" placeholder="যেমন: 2025" min="1900" max="2100" required>
                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">গ্রুপ</label>
                    <select class="form-select @error('group_name') is-invalid @enderror" name="group_name" id="groupName" required>
                        <option value="">গ্রুপ নির্বাচন করুন</option>
                        @foreach(['SCIENCE','HUMANITIES','BUSINESS STUDIES','VOCATIONAL','TECHNICAL','ISLAMIC STUDIES','AGRICULTURE','HOME ECONOMICS','MUSIC'] as $g)
                            <option value="{{ $g }}" {{ old('group_name') == $g ? 'selected' : '' }}>{{ ucwords(strtolower($g)) }}</option>
                        @endforeach
                    </select>
                    @error('group_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3">বিষয়সমূহ</h5>

            <div class="alert alert-secondary border-secondary" id="subjectInfo">
                <i class="fas fa-info-circle me-1"></i> পরীক্ষার নাম ও গ্রুপ নির্বাচন করলে বিষয়সমূহ অটো লোড হবে
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="subjectsTable">
                    <thead>
                        <tr>
                            <th style="width: 12%;">কোড</th>
                            <th style="width: 48%;">বিষয়</th>
                            <th style="width: 15%;">গ্রেড</th>
                            <th style="width: 25%;">কার্যক্রম</th>
                        </tr>
                    </thead>
                    <tbody id="subjectsBody">
                        <tr id="noSubjectsRow">
                            <td colspan="4" class="text-center text-muted py-3">
                                <i class="fas fa-arrow-up me-1"></i> উপরে পরীক্ষা ও গ্রুপ নির্বাচন করুন
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-3">
                <button type="button" id="addSubject" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> বিষয় যোগ করুন
                </button>
            </div>

            <hr class="my-4">

            <div class="mb-3">
                <label class="form-label">বিবরণ</label>
                <textarea name="details" class="form-control" rows="2">{{ old('details') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary px-5">
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span class="submit-text"><i class="fas fa-save me-1"></i>মার্কশিট তৈরী করুন</span>
            </button>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
$(function() {

    // ──────────────────────────────────────
    // SUBJECT DATA (client-side)
    // ──────────────────────────────────────
    var allSubjects = [
        {code:"101",name:"BANGLA"},{code:"107",name:"ENGLISH"},{code:"109",name:"MATHEMATICS"},
        {code:"150",name:"BANGLADESH AND GLOBAL STUDIES"},{code:"111",name:"ISLAM AND MORAL EDUCATION"},
        {code:"136",name:"PHYSICS"},{code:"137",name:"CHEMISTRY"},{code:"138",name:"BIOLOGY"},
        {code:"154",name:"INFORMATION AND COMMUNICATION TECHNOLOGY"},{code:"126",name:"HIGHER MATHEMATICS"},
        {code:"147",name:"PHYSICAL EDUCATION, HEALTH & SPORTS"},{code:"156",name:"CAREER EDUCATION"},
        {code:"134",name:"AGRICULTURAL STUDIES"},{code:"151",name:"HOME SCIENCE"},{code:"149",name:"MUSIC"},
        {code:"152",name:"FINANCE & BANKING"},{code:"146",name:"ACCOUNTING"},{code:"143",name:"BUSINESS ENTREPRENEURSHIP"},
        {code:"127",name:"GENERAL SCIENCE"},{code:"153",name:"HISTORY OF BANGLADESH"},{code:"110",name:"GEOGRAPHY"},
        {code:"140",name:"CIVIC & CITIZENSHIP"},{code:"141",name:"ECONOMICS"}
    ];

    var sscScience = [
        {code:"101",name:"BANGLA"},{code:"107",name:"ENGLISH"},{code:"109",name:"MATHEMATICS"},
        {code:"150",name:"BANGLADESH AND GLOBAL STUDIES"},{code:"111",name:"ISLAM AND MORAL EDUCATION"},
        {code:"136",name:"PHYSICS"},{code:"137",name:"CHEMISTRY"},{code:"138",name:"BIOLOGY"},
        {code:"154",name:"INFORMATION AND COMMUNICATION TECHNOLOGY"},{code:"126",name:"HIGHER MATHEMATICS"},
        {code:"147",name:"PHYSICAL EDUCATION, HEALTH & SPORTS"},{code:"156",name:"CAREER EDUCATION"}
    ];

    var sscHumanities = [
        {code:"101",name:"BANGLA"},{code:"107",name:"ENGLISH"},{code:"109",name:"MATHEMATICS"},
        {code:"150",name:"BANGLADESH AND GLOBAL STUDIES"},{code:"111",name:"ISLAM AND MORAL EDUCATION"},
        {code:"153",name:"HISTORY OF BANGLADESH"},{code:"110",name:"GEOGRAPHY"},{code:"141",name:"ECONOMICS"},
        {code:"154",name:"INFORMATION AND COMMUNICATION TECHNOLOGY"},{code:"151",name:"HOME SCIENCE"},
        {code:"147",name:"PHYSICAL EDUCATION, HEALTH & SPORTS"},{code:"156",name:"CAREER EDUCATION"}
    ];

    var sscBusiness = [
        {code:"101",name:"BANGLA"},{code:"107",name:"ENGLISH"},{code:"109",name:"MATHEMATICS"},
        {code:"150",name:"BANGLADESH AND GLOBAL STUDIES"},{code:"111",name:"ISLAM AND MORAL EDUCATION"},
        {code:"152",name:"FINANCE & BANKING"},{code:"146",name:"ACCOUNTING"},{code:"143",name:"BUSINESS ENTREPRENEURSHIP"},
        {code:"154",name:"INFORMATION AND COMMUNICATION TECHNOLOGY"},{code:"127",name:"GENERAL SCIENCE"},
        {code:"147",name:"PHYSICAL EDUCATION, HEALTH & SPORTS"},{code:"156",name:"CAREER EDUCATION"}
    ];

    var $tbody = $('#subjectsBody');
    var si = 0;

    function getGradeOptions(sel) {
        var h = '<option value="">গ্রেড</option>';
        ['A+','A','A-','B','C','D','F'].forEach(function(g) {
            h += '<option value="'+g+'"'+(g===sel?' selected':'')+'>'+g+'</option>';
        });
        return h;
    }

    function createRow(idx, sub) {
        sub = sub || {};
        var $row = $(
            '<tr>\
                <td><input type="text" name="subjects['+idx+'][code]" class="form-control form-control-sm codeInput" value="'+(sub.code||'')+'" placeholder="কোড" readonly></td>\
                <td class="position-relative">\
                    <input type="text" name="subjects['+idx+'][name]" class="form-control form-control-sm subjectInput" value="'+(sub.name||'')+'" placeholder="বিষয় খুঁজুন..." autocomplete="off" required>\
                    <div class="autocomplete-items" style="display:none;"></div>\
                </td>\
                <td><select name="subjects['+idx+'][grade]" class="form-select form-select-sm" required>'+getGradeOptions(sub.grade||'')+'</select></td>\
                <td>\
                    <div class="btn-group btn-group-sm btn-group-sm-actions">\
                        <button type="button" class="btn btn-success addBelow" title="নিচে যোগ করুন"><i class="fas fa-chevron-down"></i></button>\
                        <button type="button" class="btn btn-primary addAbove" title="উপরে যোগ করুন"><i class="fas fa-chevron-up"></i></button>\
                        <button type="button" class="btn btn-danger removeSubject" title="মুছুন"><i class="fas fa-trash"></i></button>\
                    </div>\
                </td>\
            </tr>'
        );
        attachAutocomplete($row.find('.subjectInput'));
        return $row;
    }

    function attachAutocomplete($input) {
        var currentFocus = -1;
        var $listDiv = $input.siblings('.autocomplete-items');

        $input.on('input', function() {
            var val = this.value.toUpperCase().trim();
            $listDiv.empty().hide();
            if (!val) { currentFocus = -1; return; }

            var selected = [];
            $('.subjectInput').not(this).each(function() {
                var v = $(this).val().trim().toUpperCase();
                if (v) selected.push(v);
            });

            var found = 0;
            allSubjects.forEach(function(item) {
                var idx = item.name.toUpperCase().indexOf(val);
                if (idx !== -1 && selected.indexOf(item.name.toUpperCase()) === -1) {
                    var before = item.name.substring(0, idx);
                    var match = item.name.substring(idx, idx + val.length);
                    var after = item.name.substring(idx + val.length);
                    var $div = $('<div>'+before+'<strong>'+match+'</strong>'+after+'</div>');
                    $div.on('click', function() {
                        $input.val(item.name);
                        $input.closest('tr').find('.codeInput').val(item.code);
                        $listDiv.empty().hide();
                    });
                    $listDiv.append($div);
                    found++;
                }
            });
            if (found) $listDiv.show();
            currentFocus = -1;
        });

        $input.on('keydown', function(e) {
            var $items = $listDiv.find('div');
            if (e.keyCode === 40) { currentFocus++; addActive($items); e.preventDefault(); }
            else if (e.keyCode === 38) { currentFocus--; addActive($items); e.preventDefault(); }
            else if (e.keyCode === 13) { e.preventDefault(); if (currentFocus > -1 && $items.length) $items.eq(currentFocus).click(); }
        });

        function addActive($items) {
            $items.removeClass('autocomplete-active');
            if (!$items.length) return;
            if (currentFocus >= $items.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = $items.length - 1;
            $items.eq(currentFocus).addClass('autocomplete-active');
        }
    }

    $(document).on('click', function(e) {
        if (!$(e.target).hasClass('subjectInput')) {
            $('.autocomplete-items').empty().hide();
        }
    });

    $tbody.on('click', '.removeSubject', function() {
        if ($tbody.find('tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            Swal.fire('সতর্কতা!', 'অন্তত একটি বিষয় থাকতে হবে।', 'warning');
        }
    });

    $tbody.on('click', '.addAbove', function() {
        var $row = createRow(si++);
        $(this).closest('tr').before($row);
    });

    $tbody.on('click', '.addBelow', function() {
        var $row = createRow(si++);
        $(this).closest('tr').after($row);
    });

    $('#addSubject').on('click', function() {
        $tbody.append(createRow(si++));
    });

    function populateTable(subjects) {
        $tbody.empty();
        si = 0;
        if (!subjects || !subjects.length) {
            $tbody.html('<tr id="noSubjectsRow"><td colspan="4" class="text-center text-muted py-3"><i class="fas fa-arrow-up me-1"></i> উপরে পরীক্ষা ও গ্রুপ নির্বাচন করুন</td></tr>');
            return;
        }
        subjects.forEach(function(sub) {
            $tbody.append(createRow(si++, sub));
        });
    }

    function loadFromApi() {
        var examName = $('#examName').val();
        var groupName = $('#groupName').val();
        var $info = $('#subjectInfo');

        if (!examName || !groupName) {
            $tbody.html('<tr id="noSubjectsRow"><td colspan="4" class="text-center text-muted py-3"><i class="fas fa-arrow-up me-1"></i> উপরে পরীক্ষা ও গ্রুপ নির্বাচন করুন</td></tr>');
            $info.attr('class','alert alert-secondary border-secondary').html('<i class="fas fa-info-circle me-1"></i> পরীক্ষার নাম ও গ্রুপ নির্বাচন করলে বিষয়সমূহ অটো লোড হবে');
            return;
        }

        $info.attr('class','alert alert-info border-info').html('<span class="spinner-border spinner-border-sm me-1"></span> বিষয় লোড হচ্ছে...');

        $.getJSON('{{ route('user.mark_sheet.subjects') }}', {exam_name: examName, group_name: groupName}, function(data) {
            if (data.status && data.subjects && data.subjects.length) {
                populateTable(data.subjects);
                $info.attr('class','alert alert-success border-success').html('<i class="fas fa-check-circle me-1"></i> মোট '+data.subjects.length+' টি বিষয় লোড হয়েছে');
            } else {
                populateTable([]);
                $info.attr('class','alert alert-warning border-warning').html('<i class="fas fa-exclamation-triangle me-1"></i> এই পরীক্ষা ও গ্রুপের জন্য কোনো বিষয় পাওয়া যায়নি');
            }
        }).fail(function() {
            $info.attr('class','alert alert-danger border-danger').html('<i class="fas fa-times-circle me-1"></i> বিষয় লোড করতে সমস্যা হয়েছে');
        });
    }

    function autoFillFromClient() {
        var examName = $('#examName').val();
        var groupName = $('#groupName').val();
        if (!examName || !groupName) return;

        var list = [];
        if (examName.indexOf('SSC') !== -1) {
            if (groupName === 'SCIENCE') list = sscScience;
            else if (groupName === 'HUMANITIES') list = sscHumanities;
            else if (groupName === 'BUSINESS STUDIES') list = sscBusiness;
            else list = sscScience;
        }
        if (list.length) {
            populateTable(list);
            $('#subjectInfo').attr('class','alert alert-success border-success').html('<i class="fas fa-check-circle me-1"></i> মোট '+list.length+' টি বিষয় লোড হয়েছে');
        } else {
            loadFromApi();
        }
    }

    $('#examName, #groupName').on('change', function() {
        autoFillFromClient();
        loadFromApi();
    });

    $('#marksheetForm').on('submit', function(e) {
        var subjects = [];
        $tbody.find('tr').each(function() {
            var code = $(this).find('.codeInput').val() || '';
            var name = $(this).find('.subjectInput').val();
            var grade = $(this).find('select[name*="[grade]"]').val();
            if (name) subjects.push({ code: code, name: name, grade: grade || '' });
        });
        var $input = $('<input>').attr({type:'hidden', name:'subjects'}).val(JSON.stringify(subjects));
        $('[name^="subjects["]').remove();
        $(this).append($input);
    });

    var $inst = $('#Institute');
    if ($inst.length) {
        var $sug = $('#schoolSuggestions');
        var schools = ["Dhaka College","Notre Dame College","St. Joseph Higher Secondary School","Rajshahi College","Chittagong College","Government Laboratory High School","Viqarunnisa Noon School & College","Holy Cross College","Adamjee Cantonment College","Barisal Govt. Women's College","Comilla Victoria College","Sylhet MC College","Mymensingh Girls' Cadet College","Rajuk Uttara Model College"];
        $inst.on('input', function() {
            var v = this.value.toLowerCase().trim();
            $sug.empty().hide();
            if (v.length < 1) return;
            var m = schools.filter(function(s) { return s.toLowerCase().indexOf(v) !== -1; });
            if (!m.length) return;
            $sug.show();
            m.forEach(function(s) {
                var d = $('<div></div>').text(s).on('click', function() { $inst.val(s); $sug.empty().hide(); });
                $sug.append(d);
            });
        });
        $(document).on('click', function(e) { if (!$(e.target).closest('.position-relative').length) $sug.empty().hide(); });
    }

    $.getJSON('{{ route('user.mark_sheet.cost') }}', function(d) {
        if (d.status) {
            var html = d.cost > 0
                ? '<strong>সার্ভিস চার্জ:</strong> '+d.cost.toFixed(2)+' টাকা | <strong>ব্যালেন্স:</strong> '+d.balance.toFixed(2)+' টাকা'
                : '<strong>ব্যালেন্স:</strong> '+d.balance.toFixed(2)+' টাকা';
            $('#costInfo').html(html);
        }
    }).fail(function() { $('#costInfo').text('সার্ভিস চার্জ লোড করতে সমস্যা হয়েছে।'); });

    @if(old('exam_name') && old('group_name'))
        autoFillFromClient();
    @endif

});
</script>
@endpush