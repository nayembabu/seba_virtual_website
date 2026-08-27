@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
@php
    $serviceCharge = \App\Models\ServiceCharge::getCharge('khatian');
@endphp

<div class="container-fluid mb-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            @if($serviceCharge)
                <div class="alert alert-info shadow-sm">
                    <i class="fas fa-info-circle me-2"></i> সঠিক তথ্য দিয়ে মিউটেশন খতিয়ান (নামজারি) জেনারেট করুন। সাবমিট করলে আপনার ব্যালেন্স থেকে <strong>{{ number_format($serviceCharge, 2) }}</strong> টাকা কাটা হবে এবং ডাটা সার্ভারে সেভ হবে। কিউআর কোড স্ক্যান করে ভেরিফাই লিংক চেক করে নিন।
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="form-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>খতিয়ান ডকুমেন্ট ক্রিয়েটর প্যানেল</h2>
                <a href="{{ route('user.khatian.logs') }}" class="btn btn-info btn-sm"><i class="fas fa-list"></i> লিস্ট দেখুন</a>
            </div>

                <form action="{{ route('user.khatian.store') }}" method="POST" id="khatianForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="owners_json" id="owners_json">
                    <input type="hidden" name="lands_json" id="lands_json">

                    <div class="form-section">
                        <h3>১. সাধারণ ও প্রশাসনিক তথ্য</h3>
                        <div class="grid-layout">
                            <div class="input-box"><label>খতিয়ান নং</label><input type="text" name="khatian_no" value="১২৩৪" required></div>
                            <div class="input-box"><label>জেলা</label><input type="text" name="district" value="ঢাকা" required></div>
                            <div class="input-box"><label>উপজেলা/সার্কেল</label><input type="text" name="upazila" value="ধানমন্ডি"></div>
                            <div class="input-box"><label>মৌজা</label><input type="text" name="mouza" value="শংকর"></div>
                            <div class="input-box"><label>জে এল নং</label><input type="text" name="jl_no" value="১০"></div>

                            <div class="input-box"><label>আবেদন নম্বর</label><input type="text" name="app_no" value="১৪০৭৭০৭৪"></div>
                            <div class="input-box"><label>আবেদন তারিখ</label><input type="text" name="app_date" value="২০-০১-২০২৬"></div>
                            <div class="input-box"><label>মিউটেশন মামলা নং</label><input type="text" name="mutation_case_no" value="১১৮৪৩(IX-I)/২০২৫-২৬"></div>
                            <div class="input-box"><label>ডিসিআর নং</label><input type="text" name="dcr_no" value="26338600711843"></div>
                            <div class="input-box"><label>খতিয়ান পরিচিতি নং</label><input type="text" name="khatian_pid" value="৩০৩৩৮৬-২১০৩২৬-১০০১০৬"></div>

                            <div class="input-box"><label>সহকারী কমিশনারের নাম</label><input type="text" name="ac_name" value="পলাশ চন্দ্র সরকার"></div>
                            <div class="input-box"><label>সিলমোহর</label>
                                <select name="seal_select">
                                    <option value="https://domain.com/seals/seal1.png">সিলমোহর ডিজাইন ১</option>
                                    <option value="https://domain.com/seals/seal2.png">সিলমোহর ডিজাইন ২</option>
                                    <option value="https://domain.com/seals/seal3.png">সিলমোহর ডিজাইন ৩</option>
                                    <option value="https://domain.com/seals/seal4.png">সিলমোহর ডিজাইন ৪</option>
                                    <option value="https://domain.com/seals/seal5.png">সিলমোহর ডিজাইন ৫</option>
                                    <option value="https://domain.com/seals/seal6.png">সিলমোহর ডিজাইন ৬</option>
                                    <option value="https://domain.com/seals/seal7.png">সিলমোহর ডিজাইন ৭</option>
                                    <option value="https://domain.com/seals/seal8.png">সিলমোহর ডিজাইন ৮</option>
                                    <option value="https://domain.com/seals/seal9.png">সিলমোহর ডিজাইন ৯</option>
                                    <option value="https://domain.com/seals/seal10.png">সিলমোহর ডিজাইন ১০</option>
                                </select>
                            </div>
                            <div class="input-box"><label>অথবা কাস্টম সিল আপলোড করুন</label><input type="file" name="seal_upload" accept="image/png, image/jpeg"></div>

                            <div class="input-box"><label>মোট জমির পরিমাণ</label><input type="text" name="total_land_val" value="০০.১৭৫০০০"></div>
                            <div class="input-box full-width"><label>কথায় জমির পরিমান</label><input type="text" name="amount_in_words" value="০ একর ১৭ শতক ৫০ অযুতাংশ ০০ লক্ষ্যাংশ"></div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>২. মালিকের তথ্য (কলাম ১, ২, ৩)</h3>
                        <div id="ownerContainer">
                            <div class="dynamic-row owner-entry">
                                <div class="grid-layout">
                                    <div class="input-box"><label>মালিকের নাম</label><input type="text" class="o-name" value="মোহাম্মদ আলামিন ফকির" required></div>
                                    <div class="input-box"><label>পিতা/স্বামী</label><input type="text" class="o-father" value="আবুল হাসেম ফকির"></div>
                                    <div class="input-box"><label>মাতা</label><input type="text" class="o-mother" value="জরিনা বেগম"></div>
                                    <div class="input-box"><label>জাতীয় পরিচয়পত্র</label><input type="text" class="o-nid" value="৩৩১৮২৩৪৫৮৮"></div>
                                    <div class="input-box"><label>অংশ</label><input type="text" class="o-share" value="১.০০০"></div>
                                    <div class="input-box"><label>ভূমি উন্নয়ন কর</label><input type="text" class="o-tax" value="১০"></div>
                                    <div class="input-box full-width"><label>ঠিকানা</label><input type="text" class="o-address" value="কয়রা পাড়া, ওমার, ওয়ার্ড নং-০৯,ধামইরহাট-৩৪৫৬,ধামইরহাট, নওগা।"></div>
                                </div>
                                <button type="button" class="remove-btn" onclick="this.parentElement.remove()">মুছুন</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addOwner()">+ নতুন মালিক যোগ করুন</button>
                    </div>

                    <div class="form-section">
                        <h3>৩. জমির বিবরণ (কলাম ৪-৯)</h3>
                        <div id="landContainer">
                            <div class="dynamic-row land-entry">
                                <div class="grid-layout">
                                    <div class="input-box"><label>দাগ নং (৪)</label><input type="text" class="l-dag" value="১০১"></div>
                                    <div class="input-box"><label>রেকর্ডীয় শ্রেণী (৫)</label><input type="text" class="l-class" value="কৃষি"></div>
                                    <div class="input-box"><label>মোট পরিমাণ (৬)</label><input type="text" class="l-total" value="১.২০০"></div>
                                    <div class="input-box"><label>খতিয়ান অংশ (৭)</label><input type="text" class="l-ks" value="১.০০০"></div>
                                    <div class="input-box"><label>অংশানুযায়ী পরিমাণ (৮)</label><input type="text" class="l-part" value="১.২০০"></div>
                                    <div class="input-box full-width"><label>দখল সত্ববিষয়িক বা অন্যান্য বিষয়ে মন্তব্য (৯)</label><textarea class="l-rem" rows="4">দলিল নং; ৫৩৪৫, তারিখ- ১২/২১/২০১৯
আগত খতিয়ান নং-৪৫৪৫
অনুমোদনের তারিখে ব্যাবহারে ধরণ: চালা
অবকাঠামোর ধরণ: (.....)

জোত নং ৫৩৪৩৪,
এস এ আর এস খতিয়ান
৪৩৪৪/৩৪৩৪
এস এ আর এস দাগ
৩৪৩৪,৩৪৩৪/৩৪৩৪</textarea></div>
                                </div>
                                <button type="button" class="remove-btn" onclick="this.parentElement.remove()">মুছুন</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addLand()">+ নতুন জমির তথ্য যোগ করুন</button>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn">
                        <i class="fas fa-file-contract"></i> ডকুমেন্ট জেনারেট করুন
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    body { -webkit-user-select: none; user-select: none; }
    .form-card { max-width: 1100px; margin: 0 auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); font-family: 'Open Sans', sans-serif; }
    .form-card h2 { text-align: center; color: #1a73e8; border-bottom: 2px solid #1a73e8; padding-bottom: 10px; margin-bottom: 20px; font-weight: 700; }
    .form-section { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ddd; }
    .form-section h3 { margin: 0 0 15px 0; font-size: 18px; color: #d93025; font-weight: bold; }
    .grid-layout { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; }
    .input-box { display: flex; flex-direction: column; }
    .input-box label { font-size: 13px; font-weight: bold; margin-bottom: 5px; color: #444; }
    .input-box input, .input-box select, .input-box textarea { padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; font-size: 13px; }
    .full-width { grid-column: 1 / -1; }
    .dynamic-row { border: 1px dashed #1a73e8; padding: 15px; background: #fff; position: relative; margin-bottom: 10px; border-radius: 6px; }
    .remove-btn { position: absolute; top: 10px; right: 10px; background: #ff4757; color: #fff; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; font-size: 12px; }
    .add-btn { background: #28a745; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 5px; font-weight: bold; margin-bottom: 10px; font-size: 13px; }
    .submit-btn { width: 100%; padding: 15px; background: #1a73e8; color: white; border: none; font-size: 18px; font-weight: bold; cursor: pointer; border-radius: 6px; transition: 0.3s; margin-top: 10px; }
    .submit-btn:hover { background: #1557b0; transform: translateY(-2px); }
</style>

<script>
    function addOwner() {
        const div = document.createElement('div');
        div.className = 'dynamic-row owner-entry';
        div.innerHTML = `<div class="grid-layout">
            <div class="input-box"><label>মালিকের নাম</label><input type="text" class="o-name" required></div>
            <div class="input-box"><label>পিতা/স্বামী</label><input type="text" class="o-father"></div>
            <div class="input-box"><label>মাতা</label><input type="text" class="o-mother"></div>
            <div class="input-box"><label>জাতীয় পরিচয়পত্র</label><input type="text" class="o-nid"></div>
            <div class="input-box"><label>অংশ</label><input type="text" class="o-share" value="০.৫০০"></div>
            <div class="input-box"><label>কর</label><input type="text" class="o-tax" value="ফাকা রাখুন"></div>
            <div class="input-box full-width"><label>ঠিকানা</label><input type="text" class="o-address"></div>
        </div><button type="button" class="remove-btn" onclick="this.parentElement.remove()">মুছুন</button>`;
        document.getElementById('ownerContainer').appendChild(div);
    }

    function addLand() {
        const div = document.createElement('div');
        div.className = 'dynamic-row land-entry';
        div.innerHTML = `<div class="grid-layout">
            <div class="input-box"><label>দাগ নং (৪)</label><input type="text" class="l-dag" value="১০২"></div>
            <div class="input-box"><label>রেকর্ডীয় শ্রেণী (৫)</label><input type="text" class="l-class" value="অকৃষি"></div>
            <div class="input-box"><label>মোট পরিমাণ (৬)</label><input type="text" class="l-total" value="০.৫০০"></div>
            <div class="input-box"><label>অংশ (৭)</label><input type="text" class="l-ks" value="১.০০০"></div>
            <div class="input-box"><label>অংশানুযায়ী পরিমাণ (৮)</label><input type="text" class="l-part" value="০.৫০০"></div>
            <div class="input-box full-width"><label>মন্তব্য (৯)</label><textarea class="l-rem" rows="2">ফাকা রাখুন</textarea></div>
        </div><button type="button" class="remove-btn" onclick="this.parentElement.remove()">মুছুন</button>`;
        document.getElementById('landContainer').appendChild(div);
    }

    document.getElementById('khatianForm').addEventListener('submit', function(e) {
        const owners = [];
        document.querySelectorAll('.owner-entry').forEach(row => {
            owners.push({
                name: row.querySelector('.o-name').value,
                father: row.querySelector('.o-father').value,
                mother: row.querySelector('.o-mother').value,
                nid: row.querySelector('.o-nid').value,
                address: row.querySelector('.o-address').value,
                share: row.querySelector('.o-share').value,
                tax: row.querySelector('.o-tax').value
            });
        });
        document.getElementById('owners_json').value = JSON.stringify(owners);

        const lands = [];
        document.querySelectorAll('.land-entry').forEach(row => {
            lands.push({
                dag: row.querySelector('.l-dag').value,
                agri: row.querySelector('.l-class').value,
                ta: row.querySelector('.l-total').value,
                ks: row.querySelector('.l-ks').value,
                pa: row.querySelector('.l-part').value,
                rem: row.querySelector('.l-rem').value
            });
        });
        document.getElementById('lands_json').value = JSON.stringify(lands);

        let isConfirmed = confirm("খতিয়ান জেনারেট করতে {{ $serviceCharge ?: 80 }} টাকা কাটা হবে। আপনি কি নিশ্চিত?");
        if (isConfirmed) {
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> প্রসেসিং হচ্ছে...';
            return true;
        }
        return false;
    });
</script>
@endsection
