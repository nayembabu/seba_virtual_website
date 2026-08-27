@php
    $formType = $formType ?? \App\Models\Nid::TYPE_NID;
    $showSignature = in_array($formType, [\App\Models\Nid::TYPE_NID, \App\Models\Nid::TYPE_APPLICATION], true);
    $showPresentBlock = in_array($formType, [\App\Models\Nid::TYPE_CDMS, \App\Models\Nid::TYPE_SIGN_TO_SERVER], true);
    $showCdmsOnly = $formType === \App\Models\Nid::TYPE_CDMS;
    $nid = $nid ?? null;
    $isEdit = $nid !== null;

    $scNid = \App\Models\ServiceCharge::active()->where('service_name', 'nidcard')->first();
    if (!$scNid) {
        $scNid = \App\Models\ServiceCharge::active()->where('service_name', 'smartcard')->first();
    }
    $chargeAmount = $scNid ? (float) $scNid->amount : 0.0;

    $o = function (string $key, $default = '') use ($nid) {
        $fallback = $default;
        if ($nid !== null && array_key_exists($key, $nid->getAttributes())) {
            $v = $nid->getAttribute($key);
            $fallback = $v instanceof \Carbon\CarbonInterface ? $v->format('Y-m-d') : ($v ?? $default);
        }

        return old($key, $fallback);
    };
@endphp

@push('css')
    <style>
        @font-face {
            font-family: 'Solaiman Lipi';
            font-style: normal;
            font-weight: normal;
            src: url('/fonts/SolaimanLipi.woff2') format('woff2'),
                 url('/fonts/SolaimanLipi.ttf') format('truetype');
        }
        @font-face {
            font-family: 'Solaiman Lipi';
            font-style: normal;
            font-weight: bold;
            src: url('/fonts/SolaimanLipi.woff2') format('woff2'),
                 url('/fonts/SolaimanLipi.ttf') format('truetype');
        }
        body {
            font-family: 'Solaiman Lipi' !important;
        }
        .required-label::after { content: " *"; color: #e74a3b; font-weight: bold; }
        #photo-preview, #signature-preview {
            min-height: 120px; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center;
            margin-top: 8px; border-radius: 4px; background: #f8f9fa;
        }
        #photo-preview img, #signature-preview img { max-width: 160px; max-height: 160px; object-fit: contain; }
    </style>
@endpush

@if($chargeAmount > 0 && ! $isEdit)
    <div class="alert alert-info border-info mb-4">
        <p class="mb-0">প্রতিটি রেকর্ডের জন্য সার্ভিস চার্জ <strong>{{ number_format($chargeAmount, 2) }}</strong> টাকা কাটা হতে পারে।</p>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0 pl-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

@if(! $isEdit)
    <div class="card border-left-info shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-2"><i class="fas fa-file-pdf mr-2"></i>পিডিএফ থেকে অটো পূরণ</h5>
            <p class="small text-muted mb-2">মূল সংরক্ষণ ফর্মের বাইরে — শুধু পার্সিংয়ের জন্য।</p>
            <input type="file" class="d-none" id="pdf" accept=".pdf">
            <label for="pdf" class="btn btn-outline-info mb-2" style="cursor:pointer;"><i class="fas fa-upload"></i> PDF নির্বাচন</label>
            <div id="selectedFileName" class="small text-muted"></div>
            <div id="pdfUploadStatus" class="mt-2" style="display:none;"></div>
        </div>
    </div>
@endif

<form action="{{ $isEdit ? route('user.nid-card.update', $nid->id) : route('user.nid-card.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif
    <input type="hidden" name="type" value="{{ $formType }}">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="required-label">নাম (বাংলা)</label>
                <input type="text" name="name_bn" class="form-control bn-input @error('name_bn') is-invalid @enderror" value="{{ $o('name_bn') }}" required>
                @error('name_bn')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required-label">Name (English)</label>
                <input type="text" name="name_en" class="form-control bn-input @error('name_en') is-invalid @enderror" value="{{ $o('name_en') }}" required>
                @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required-label">পিতার নাম</label>
                <input type="text" name="father_name" class="form-control bn-input @error('father_name') is-invalid @enderror" value="{{ $o('father_name') }}" required>
                @error('father_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required-label">মাতার নাম</label>
                <input type="text" name="mother_name" class="form-control bn-input @error('mother_name') is-invalid @enderror" value="{{ $o('mother_name') }}" required>
                @error('mother_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required-label">জন্ম তারিখ</label>
                <input type="date" name="date_of_birth" class="form-control bn-input @error('date_of_birth') is-invalid @enderror" value="{{ $o('date_of_birth') }}" required>
                @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required-label">জন্মস্থান</label>
                <input type="text" name="birth_place" id="birth_place" class="form-control bn-input @error('birth_place') is-invalid @enderror" value="{{ $o('birth_place') }}" required>
                @error('birth_place')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required-label">জাতীয় পরিচয়পত্র নম্বর</label>
                <input type="text" name="nid_number" id="nid_number" class="form-control bn-input @error('nid_number') is-invalid @enderror" value="{{ $o('nid_number') }}" required>
                @error('nid_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>পিন নম্বর</label>
                <input type="text" name="pin_number" id="pin_number" class="form-control bn-input @error('pin_number') is-invalid @enderror" value="{{ $o('pin_number') }}">
                @error('pin_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>রক্তের গ্রুপ</label>
                <select name="blood_group" class="form-control bn-input @error('blood_group') is-invalid @enderror">
                    <option value="">—</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $g)
                        <option value="{{ $g }}" {{ $o('blood_group') == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
                @error('blood_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required-label">ইস্যু তারিখ</label>
                <input type="date" name="issue_date" class="form-control bn-input @error('issue_date') is-invalid @enderror" value="{{ $o('issue_date', date('Y-m-d')) }}" required>
                <small id="issue_date_bn" class="text-muted d-block mt-1"></small>
                @error('issue_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="required-label">লিঙ্গ</label>
                <select name="gender" class="form-control bn-input @error('gender') is-invalid @enderror" required>
                    <option value="">—</option>
                    <option value="male" {{ $o('gender') == 'male' ? 'selected' : '' }}>পুরুষ</option>
                    <option value="female" {{ $o('gender') == 'female' ? 'selected' : '' }}>মহিলা</option>
                    <option value="other" {{ $o('gender') == 'other' ? 'selected' : '' }}>অন্যান্য</option>
                </select>
                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="required-label">স্থায়ী ঠিকানা</label>
                <textarea name="address" rows="3" class="form-control bn-input @error('address') is-invalid @enderror" required>{{ $o('address') }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        @if($showPresentBlock)
            <div class="col-12"><h6 class="text-primary mt-2">বর্তমান ঠিকানা ও অতিরিক্ত তথ্য</h6></div>
            <div class="col-12">
                <div class="form-group">
                    <label class="required-label">বর্তমান ঠিকানা</label>
                    <textarea name="present_address" rows="2" class="form-control bn-input @error('present_address') is-invalid @enderror" required>{{ $o('present_address') }}</textarea>
                    @error('present_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>স্বামী/স্ত্রীর নাম</label>
                    <input type="text" name="spouse_name" class="form-control bn-input @error('spouse_name') is-invalid @enderror" value="{{ $o('spouse_name') }}">
                    @error('spouse_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>শিক্ষা</label>
                    <input type="text" name="education" class="form-control bn-input @error('education') is-invalid @enderror" value="{{ $o('education') }}">
                    @error('education')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>ধর্ম</label>
                    <input type="text" name="religion" class="form-control bn-input @error('religion') is-invalid @enderror" value="{{ $o('religion') }}">
                    @error('religion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>পেশা</label>
                    <input type="text" name="occupation" class="form-control bn-input @error('occupation') is-invalid @enderror" value="{{ $o('occupation') }}">
                    @error('occupation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        @endif

            <div class="col-12"><h6 class="text-primary mt-2">CDMS</h6></div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>ভোট কেন্দ্র</label>
                    <input type="text" name="vote_center" class="form-control bn-input @error('vote_center') is-invalid @enderror" value="{{ $o('vote_center') }}">
                    @error('vote_center')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>ভোটার নং</label>
                    <input type="text" name="voter_no" class="form-control bn-input @error('voter_no') is-invalid @enderror" value="{{ $o('voter_no') }}">
                    @error('voter_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>ফর্ম নং</label>
                    <input type="text" name="form_no" class="form-control bn-input @error('form_no') is-invalid @enderror" value="{{ $o('form_no') }}">
                    @error('form_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="{{ $isEdit ? '' : 'required-label' }}">ছবি</label>
                <input type="file" name="photo" id="photo" class="form-control-file @error('photo') is-invalid @enderror" accept=".jpg,.jpeg,.png,.gif">
                <textarea id="photo-base64-input" rows="4" style="width:100%; display:none;" name="img_photo" placeholder="data:image/png;base64,..."></textarea>
                <div id="photo-preview">@if($nid && $nid->photo)<img src="{{ $nid->photo }}" alt="">@endif</div>
                @if($nid && $nid->photo)
                    <small class="text-muted d-block mt-1">বর্তমান ছবি রেখে যেতে খালি রাখুন।</small>
                @endif
                @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
        </div>

{{--        @if($showSignature)--}}
            <div class="col-md-6">
                <div class="form-group">
                    <label class="{{ $isEdit ? '' : 'required-label' }}">স্বাক্ষর</label>
                    <input type="file" name="signature" id="signature" class="form-control-file @error('signature') is-invalid @enderror" accept=".jpg,.jpeg,.png,.gif">
                    <textarea id="signature-base64-input" rows="4" style="width:100%; display:none;" name="img_sign" placeholder="data:image/png;base64,..."></textarea>
                    <div id="signature-preview">@if($nid && $nid->signature)<img src="{{ $nid->signature }}" alt="">@endif</div>
                    @if($nid && $nid->signature)
                        <small class="text-muted d-block mt-1">বর্তমান স্বাক্ষর রেখে যেতে খালি রাখুন।</small>
                    @endif
                    @error('signature')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
{{--        @endif--}}
    </div>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary btn-lg px-5"><i class="fas fa-save mr-2"></i>{{ $isEdit ? 'আপডেট' : 'সংরক্ষণ' }}</button>
        <a href="{{ route('user.nid-card.index') }}" class="btn btn-outline-secondary btn-lg ml-2">তালিকা</a>
    </div>
</form>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function () {

            /* ── Image / signature preview ────────────────────────────────────────── */
            function preview(inputId, boxId) {
                var inp = document.getElementById(inputId);
                if (!inp) return;
                inp.addEventListener('change', function (e) {
                    var f = e.target.files[0];
                    var box = document.getElementById(boxId);
                    if (!f || !box) return;
                    var r = new FileReader();
                    r.onload = function (ev) { box.innerHTML = '<img src="' + ev.target.result + '">'; };
                    r.readAsDataURL(f);
                });
            }
            preview('photo',     'photo-preview');
            preview('signature', 'signature-preview');

            @if(! $isEdit)

            /* ── Date normaliser (handles "1998-03-01" and "09 JUL 2013") ─────────── */
            function toIso(d) {
                if (!d) return '';
                // Already ISO
                if (/^\d{4}-\d{2}-\d{2}$/.test(d)) return d;
                // "09 JUL 2013" → "2013-07-09"
                var m = String(d).match(/(\d{1,2})\s+([A-Za-z]{3})\s+(\d{4})/);
                if (m) {
                    var months = {
                        Jan:'01',Feb:'02',Mar:'03',Apr:'04',May:'05',Jun:'06',
                        Jul:'07',Aug:'08',Sep:'09',Oct:'10',Nov:'11',Dec:'12'
                    };
                    return m[3] + '-' + (months[m[2]] || '01') + '-' + String(m[1]).padStart(2, '0');
                }
                return d;
            }

            /* ── Convert English digits to Bengali numerals ─────────────────────── */
            function toBanglaNumerals(str) {
                var bn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
                return String(str).replace(/[0-9]/g, function(c) { return bn[c]; });
            }

            /* ── Convert YYYY-MM-DD to Bengali date string ──────────────────────── */
            function toBanglaDate(isoStr) {
                if (!isoStr) return '';
                var m = String(isoStr).match(/^(\d{4})-(\d{2})-(\d{2})$/);
                if (!m) return toBanglaNumerals(isoStr);
                var months = ['জানু','ফেব্রু','মার্চ','এপ্রি','মে','জুন','জুল','আগ','সেপ্ট','অক্টো','নভে','ডিসে'];
                var y = toBanglaNumerals(m[1]);
                var month = months[parseInt(m[2], 10) - 1] || '';
                var d = toBanglaNumerals(parseInt(m[3], 10));
                return d + ' ' + month + ' ' + y;
            }

            /* ── Set a form field by name (works for input, select, textarea) ─────── */
            function setField(name, value) {
                var el = document.querySelector('[name="' + name + '"]');
                if (!el || value === undefined || value === null) return;

                // Date fields: normalise to YYYY-MM-DD first
                if (el.type === 'date') {
                    el.value = toIso(String(value));
                    return;
                }

                // Select: match <option value="..."> case-insensitively
                if (el.tagName === 'SELECT') {
                    var target = String(value).trim().toLowerCase();
                    for (var i = 0; i < el.options.length; i++) {
                        if (el.options[i].value.toLowerCase() === target) {
                            el.selectedIndex = i;
                            return;
                        }
                    }
                    return; // no matching option – leave unchanged
                }

                el.value = value || '';
            }

            /* ── PDF upload handler ───────────────────────────────────────────────── */
            /* ── PDF upload handler ───────────────────────────────────────────────── */
            var pdfInput = document.getElementById('pdf');
            if (pdfInput) {

                pdfInput.addEventListener('change', function () {
                    var file = pdfInput.files[0];
                    if (!file) return;

                    document.getElementById('selectedFileName').textContent = file.name;

                    var fd = new FormData();
                    fd.append('pdf',    file);
                    fd.append('_token', '{{ csrf_token() }}');

                    Swal.fire({
                        title: 'অনুগ্রহ করে অপেক্ষা করুন',
                        allowOutsideClick: false,
                        didOpen: function () { Swal.showLoading(); }
                    });

                    fetch('{{ route('user.nid-card.parsePdf') }}', {
                        method: 'POST',
                        body: fd,
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                        .then(function (r) { return r.json(); })
                        .then(function (res) {
                            Swal.close();

                            if (res._debug_raw) { console.log("[PDF Raw Text]", res._debug_raw); }
                            if (!res || !res.status || !res.data) {
                                Swal.fire('ত্রুটি', (res && res.message) || 'পিডিএফ পার্স ব্যর্থ হয়েছে।', 'error');
                                return;
                            }

                            var d = res.data;
                            

                            /* ── Updated Mapping to match your API response keys ── */

                            // ── Identity ─────────────────────────────────────────────────
                            setField('name_bn',       d.nameBangla);
                            setField('name_en',       d.nameEnglish);
                            setField('father_name',   d.fatherName);
                            setField('mother_name',   d.motherName);
                            setField('spouse_name',   d.spouseName);

                            // ── Dates ────────────────────────────────────────────────────
                            setField('date_of_birth', d.dateOfBirth);
                            setField('issue_date',    d.dateOfToday); // এপিআই রেসপন্স অনুযায়ী 'dateOfToday' ব্যবহার করা হয়েছে
                            // Show Bengali date
                            var bnDateSpan = document.getElementById('issue_date_bn');
                            if (bnDateSpan && d.dateOfToday) {
                                bnDateSpan.textContent = toBanglaDate(d.dateOfToday);
                            }

                            // ── Birth ────────────────────────────────────────────────────
                            setField('birth_place',   d.birthPlace);
                            // ── NID numbers ──────────────────────────────────────────────
                            setField('nid_number',    d.nid);  // এপিআই রেসপন্স অনুযায়ী 'nationalId' ব্যবহার করা হয়েছে
                            setField('pin_number',    d.pin);

                            // ── Select fields ────────────────────────────────────────────
                            setField('blood_group',   d.bloodGroup);
                            setField('gender',        d.gender);

                            // ── Addresses ────────────────────────────────────────────────
                            setField('address',         d.address);       // স্থায়ী ঠিকানা (আপনার এপিআই রেসপন্সে শুধু একটি address আছে)
                            setField('present_address', d.permanentAddress);       // বর্তমান ঠিকানা (এপিআইতে আলাদা না থাকায় এটিও d.address দেওয়া হলো)

                            // ── Extra / CDMS fields ──────────────────────────────────────
                            setField('education',  d.education);         // যদি এপিআইতে না থাকে তবে undefined হ্যান্ডেল করবে
                            setField('religion',   d.religion);
                            setField('occupation', d.occupation);        // যদি এপিআইতে না থাকে তবে undefined হ্যান্ডেল করবে
                            setField('voter_no',   d.voterNo);           // ক্যামেল কেস করা হলো
                            setField('form_no',    d.formNo);            // ক্যামেল কেস করা হলো
                            setField('vote_center',    d.voterArea);
                            /* ── Handle Image & Signature URL Previews ── */
                            
                            
                            if (res.images && Array.isArray(res.images) && res.images.length > 0) {
                                // প্রথম ইমেজ = ইউজারের ছবি
                                var photoPreview = document.getElementById('photo-preview');
                                if (photoPreview && res.images[0]) {
                                    photoPreview.innerHTML = '<img src="' + res.images[0] + '" alt="User Photo"><span class="preview-label">ছবি</span>';
                                    document.getElementById('photo-base64-input').value = res.images[0] || '';
                                }
                                appendHiddenInput('parsed_photo_url', res.images[0] || '');
                            
                                // দ্বিতীয় ইমেজ = স্বাক্ষর
                                var signPreview = document.getElementById('signature-preview');
                                if (signPreview && res.images[1]) {
                                    signPreview.innerHTML = '<img src="' + res.images[1] + '" alt="Signature"><span class="preview-label">স্বাক্ষর</span>';
                                    document.getElementById('signature-base64-input').value = res.images[1] || '';
                                }
                                appendHiddenInput('parsed_signature_url', res.images[1] || '');
                            }

                            Swal.fire('সফল', 'ফর্ম পূরণ হয়েছে — তথ্য যাচাই করে সাবমিট করুন।', 'success');
                        })
                        .catch(function (err) {
                            Swal.close();
                            console.error('parsePdf error:', err);
                            Swal.fire('ত্রুটি', 'সার্ভার বা নেটওয়ার্ক সমস্যা হয়েছে।', 'error');
                        });
                });
            }

            /* Helper function to pass parsed image URLs back to the Laravel controller if needed */
            function appendHiddenInput(name, value) {
                var form = document.querySelector('form');
                var existing = document.querySelector('input[name="' + name + '"]');
                if (existing) existing.remove();

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = value;
                form.appendChild(input);
            }

            @endif

        })();
    </script>
@endpush

