@extends('user.layouts.app')
@push('css')
<style>
.card-box{background:#fff;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,.1);padding:20px;margin-bottom:20px;font-family:"NotoSansBengali","SolaimanLipi",sans-serif}
.card-box h4{border-bottom:2px solid #4CAF50;padding-bottom:8px;margin-bottom:15px;font-size:16px}
.form-group{margin-bottom:12px}
.form-group label{font-weight:600;font-size:13px;margin-bottom:3px;display:block}
.form-group .form-control{border:1px solid #ddd;border-radius:5px;padding:8px 12px;font-size:14px;width:100%;font-family:"NotoSansBengali","SolaimanLipi",sans-serif}
.form-row{display:flex;gap:12px}
.form-row .form-group{flex:1}
.file-row{display:flex;gap:15px;margin-top:5px}
.file-item{flex:1}
.file-preview{width:80px;height:100px;border:1px dashed #aaa;display:flex;align-items:center;justify-content:center;font-size:11px;color:#999;margin-top:5px;overflow:hidden;background:#fafafa}
.file-preview img{width:100%;height:100%;object-fit:cover}
.file-preview-sm{width:60px;height:30px;border:1px dashed #aaa;display:flex;align-items:center;justify-content:center;font-size:11px;color:#999;margin-top:5px;overflow:hidden;background:#fafafa}
.file-preview-sm img{width:100%;height:100%;object-fit:cover}
.btn-submit{background:#4CAF50;color:#fff;border:none;padding:10px 30px;border-radius:5px;cursor:pointer;font-size:15px;font-family:"NotoSansBengali","SolaimanLipi",sans-serif}
.btn-submit:hover{background:#45a049}
.btn-auto{background:#ff9800;color:#fff;border:none;padding:6px 15px;border-radius:3px;cursor:pointer;font-size:12px;font-family:"NotoSansBengali","SolaimanLipi",sans-serif;white-space:nowrap}
.btn-auto:hover{background:#f57c00}
.btn-print{background:#2196F3;color:#fff;border:none;padding:6px 15px;border-radius:3px;cursor:pointer;font-size:12px;text-decoration:none;display:inline-block;font-family:"NotoSansBengali","SolaimanLipi",sans-serif}
.btn-print:hover{background:#0b7dda}
.table-wrap{overflow-x:auto}
.table{width:100%;border-collapse:collapse;font-family:"NotoSansBengali","SolaimanLipi",sans-serif}
.table th,.table td{padding:8px 10px;border:1px solid #ddd;text-align:left;font-size:13px;vertical-align:middle}
.table th{background:#f5f5f5;font-weight:600}
.pagination{margin-top:15px}
fieldset{border:1px solid #ddd;border-radius:8px;padding:15px;margin-bottom:15px}
legend{font-size:14px;font-weight:bold;color:#4CAF50;padding:0 8px;font-family:"NotoSansBengali","SolaimanLipi",sans-serif}
.thumb-preview{width:50px;height:40px;object-fit:cover;border:1px solid #ddd;border-radius:3px}
.thumb-preview-sm{width:50px;height:20px;object-fit:cover;border:1px solid #ddd;border-radius:3px}
.auto-hint{font-size:11px;color:#999;margin-top:2px}
@media(max-width:768px){.form-row{flex-direction:column;gap:0}.file-row{flex-direction:column}}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card-box">
        <h4>গোল্ডেন কার্ড / Golden Card</h4>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="close" data-dismiss="alert">&times;</button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="close" data-dismiss="alert">&times;</button></div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>
        @endif

        <form id="cardForm" method="POST" action="{{ route('user.golden-card.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>কার্ড নম্বর (Card No)</label>
                <div class="input-group" style="display:flex;gap:8px">
                    <input type="text" name="card_no" id="card_no" class="form-control" value="{{ $card_no }}" style="flex:1" readonly>
                    <button type="button" class="btn-auto" onclick="generateCardNo()">Auto Generate</button>
                </div>
            </div>

            <fieldset>
                <legend>বাংলা তথ্য / Bengali Information</legend>
                <div class="form-group">
                    <label>নাম (Name) [বাংলা]</label>
                    <input type="text" name="name_bn" id="name_bn" class="form-control" onkeyup="autoFillEn()" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>মাতা (Mother) [বাংলা]</label>
                        <input type="text" name="mother_bn" id="mother_bn" class="form-control" onkeyup="autoFillEn()" required>
                    </div>
                    <div class="form-group">
                        <label>পিতা (Father) [বাংলা]</label>
                        <input type="text" name="father_bn" id="father_bn" class="form-control" onkeyup="autoFillEn()" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>প্রতিবন্ধিতার ধরন (Disability Type) [বাংলা]</label>
                    <input type="text" name="disability_bn" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>জন্ম তারিখ (Date of Birth)</label>
                        <input type="text" name="dob" class="form-control" placeholder="DD-MM-YYYY" required>
                    </div>
                    <div class="form-group">
                        <label>আইডি নম্বর (ID Number)</label>
                        <input type="text" name="id_no" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>ঠিকানা (Address) [বাংলা]</label>
                    <input type="text" name="address_bn" id="address_bn" class="form-control" onkeyup="autoFillEn()" required>
                </div>
                <div class="form-group">
                    <label>ইস্যুর তারিখ (Issue Date)</label>
                    <input type="text" name="issue_date" class="form-control" value="{{ date('d-m-Y') }}" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>ইংরেজি তথ্য / English Information <span class="auto-hint">(বাংলা টাইপ করলে Auto-fill হবে)</span></legend>
                <div class="form-row">
                    <div class="form-group">
                        <label>Name (English)</label>
                        <input type="text" name="name_en" id="name_en" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Blood Group</label>
                        <input type="text" name="blood_group" class="form-control" placeholder="A+ / B+ / O+ etc">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Mother (English)</label>
                        <input type="text" name="mother_en" id="mother_en" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Father (English)</label>
                        <input type="text" name="father_en" id="father_en" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Disability Type (English)</label>
                    <input type="text" name="disability_en" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Mobile No</label>
                        <input type="text" name="mobile" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Address (English)</label>
                    <input type="text" name="address_en" id="address_en" class="form-control" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>ছবি / Images</legend>
                <div class="file-row">
                    <div class="file-item">
                        <label>ছবি / Photo</label>
                        <input type="file" name="photo" accept="image/*" onchange="previewFile(this, 'photoPreview')">
                        <div class="file-preview" id="photoPreview"><i class="fas fa-camera"></i></div>
                    </div>
                    <div class="file-item">
                        <label>স্বাক্ষর / Signature</label>
                        <input type="file" name="signature" accept="image/*" onchange="previewFile(this, 'signPreview')">
                        <div class="file-preview-sm" id="signPreview"><i class="fas fa-pen"></i></div>
                    </div>
                </div>
            </fieldset>

            <div style="text-align:center;margin-top:15px;">
                <button type="submit" class="btn-submit" id="submitBtn">জমা দিন / Submit</button>
            </div>
        </form>
    </div>

    <div class="card-box">
        <h4>আমার কার্ড সমূহ / My Cards</h4>
        @if($cards->count() > 0)
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>কার্ড নং</th>
                            <th>ছবি</th>
                            <th>নাম</th>
                            <th>প্রতিবন্ধিতার ধরন</th>
                            <th>মোবাইল</th>
                            <th>তারিখ</th>
                            <th>প্রিন্ট</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cards as $c)
                        <tr>
                            <td>{{ $c->card_no }}</td>
                            <td>
                                @if($c->photo && Storage::disk('public')->exists($c->photo))
                                    <img src="{{ asset('storage/' . $c->photo) }}" class="thumb-preview" alt="Photo">
                                @else
                                    <span style="color:#ccc">--</span>
                                @endif
                            </td>
                            <td>{{ $c->name_bn }}</td>
                            <td>{{ $c->disability_bn }}</td>
                            <td>{{ $c->mobile }}</td>
                            <td>{{ $c->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('user.golden-card.print', $c->id) }}" class="btn-print" target="_blank">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination">{{ $cards->links() }}</div>
        @else
            <p style="color:#999;text-align:center;padding:20px;">কোনো কার্ড পাওয়া যায়নি। উপরের ফর্মটি পূরণ করে জমা দিন।</p>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
function previewFile(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="'+e.target.result+'" alt="Preview">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function generateCardNo() {
    fetch('{{ route('user.golden-card.generate') }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(d => { if(d.success) document.getElementById('card_no').value = d.nextCardNo; })
    .catch(() => alert('কার্ড নম্বর জেনারেট করা যায়নি'));
}

function autoFillEn() {
    const map = {
        name_bn: 'name_en',
        mother_bn: 'mother_en',
        father_bn: 'father_en',
        address_bn: 'address_en'
    };
    for (let bn in map) {
        const en = map[bn];
        const bnVal = document.getElementById(bn).value.trim();
        const enField = document.getElementById(en);
        if (bnVal && !enField.value.trim()) {
            enField.value = bnVal;
        }
    }
}

(function() {
    const form = document.getElementById('cardForm');
    const btn = document.getElementById('submitBtn');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        btn.disabled = true;
        btn.textContent = 'প্রক্রিয়াধীন...';
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                alert(d.message || 'সফলভাবে জমা হয়েছে!');
                location.reload();
            } else {
                alert(d.message || 'ত্রুটি হয়েছে, আবার চেষ্টা করুন।');
                btn.disabled = false;
                btn.textContent = 'জমা দিন / Submit';
            }
        })
        .catch(() => {
            alert('নেটওয়ার্ক ত্রুটি');
            btn.disabled = false;
            btn.textContent = 'জমা দিন / Submit';
        });
    });
})();
</script>
@endpush
