@extends('user.layouts.app')
@section('title') DPDC Electricity Bill @endsection
@section('content')
<div class="container-fluid px-3">
    <div class="card card-primary shadow">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:#00695c;color:#fff;">
            <span><strong>DPDC Electricity Bill Entry</strong></span>
            <span class="badge bg-warning text-dark">চার্জ: ২০ টাকা</span>
            <button type="button" class="btn btn-warning btn-sm" onclick="autoFill()">অটো ফিল</button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            <form method="POST" action="{{ route('user.electricity_bill.store') }}" style="font-size:13px;">
                @csrf

                <div class="section-title mt-0">সাধারণ তথ্য</div>
                <div class="row g-2">
                    <div class="col-md-2"><label>ফিডার</label><input name="feeder" class="form-control" placeholder="GULSHAN" value="{{ old('feeder') }}"></div>
                    <div class="col-md-2"><label>মিটার সীল</label><input name="meter_seal" class="form-control" placeholder="123/A" value="{{ old('meter_seal') }}"></div>
                    <div class="col-md-2"><label>বিল নং</label><input name="bill_no" class="form-control" placeholder="5895144" value="{{ old('bill_no') }}"></div>
                    <div class="col-md-2"><label>সিডি</label><input name="cd" class="form-control" placeholder="64" value="{{ old('cd') }}"></div>
                    <div class="col-md-2"><label>ইস্যুর তারিখ</label><input name="issue_date" class="form-control" placeholder="29/08/20" value="{{ old('issue_date') }}"></div>
                    <div class="col-md-2"><label>অফিস কোড</label><input name="office_code" class="form-control" placeholder="A6/63" value="{{ old('office_code') }}"></div>
                    <div class="col-md-2"><label>বিল গ্রুপ</label><input name="bill_group" class="form-control" placeholder="01" value="{{ old('bill_group') }}"></div>
                    <div class="col-md-2"><label>বই নং</label><input name="book" class="form-control" placeholder="Z03" value="{{ old('book') }}"></div>
                    <div class="col-md-2"><label>ওয়াক অর্ডার</label><input name="walk_order" class="form-control" placeholder="1350" value="{{ old('walk_order') }}"></div>
                    <div class="col-md-2"><label>বিল টাইপ</label><input name="bill_type" class="form-control" placeholder="99" value="{{ old('bill_type') }}"></div>
                </div>

                <div class="section-title">গ্রাহক তথ্য</div>
                <div class="row g-2">
                    <div class="col-md-4"><label>গ্রাহকের নাম</label><input name="customer_name" class="form-control" placeholder="MD. MEHEDI HASAN" value="{{ old('customer_name') }}"></div>
                    <div class="col-md-5"><label>ঠিকানা</label><input name="address" class="form-control" placeholder="GULSHAN-2" value="{{ old('address') }}"></div>
                    <div class="col-md-3"><label>এলাকা/জোন</label><input name="area_zone" class="form-control" placeholder="DHAKA-1212" value="{{ old('area_zone') }}"></div>
                    <div class="col-md-3"><label>কাস্টমার নং</label><input name="customer_no" class="form-control" placeholder="13521504" value="{{ old('customer_no') }}"></div>
                    <div class="col-md-3"><label>পূর্বের হিসাব নং</label><input name="prev_acc" class="form-control" placeholder="14247" value="{{ old('prev_acc') }}"></div>
                    <div class="col-md-2"><label>ক্যাটাগরি</label><input name="cust_cat" class="form-control" placeholder="11" value="{{ old('cust_cat') }}"></div>
                    <div class="col-md-2"><label>স্ট্যাটাস</label><input name="cust_status" class="form-control" placeholder="05" value="{{ old('cust_status') }}"></div>
                    <div class="col-md-2"><label>কানেকশন টাইপ</label><input name="conn_type" class="form-control" placeholder="00" value="{{ old('conn_type') }}"></div>
                </div>

                <div class="section-title">মিটার তথ্য</div>
                <div class="row g-2">
                    <div class="col-md-2"><label>ট্যারিফ</label><input name="tariff" class="form-control" placeholder="LT-A" value="{{ old('tariff') }}"></div>
                    <div class="col-md-2"><label>স্ট্যান্ডার্ড রুলস</label><input name="std_rules" class="form-control" placeholder="CPC" value="{{ old('std_rules') }}"></div>
                    <div class="col-md-2"><label>মিটার নং</label><input name="meter_no" class="form-control" placeholder="143485" value="{{ old('meter_no') }}"></div>
                    <div class="col-md-2"><label>মিটার টাইপ</label><input name="meter_type" class="form-control" placeholder="01" value="{{ old('meter_type') }}"></div>
                    <div class="col-md-2"><label>মিটার কন্ডিশন</label><input name="meter_cond" class="form-control" placeholder="00" value="{{ old('meter_cond') }}"></div>
                    <div class="col-md-1"><label>OMF</label><input name="omf" class="form-control" placeholder="1.000" value="{{ old('omf') }}"></div>
                    <div class="col-md-1"><label>লোড</label><input name="load_val" class="form-control" placeholder="3.00" value="{{ old('load_val') }}"></div>
                </div>

                <div class="section-title">বিল ও ক্যালকুলেশন</div>
                <div class="row g-2">
                    <div class="col-md-2"><label>বর্তমান তারিখ</label><input name="curr_date" class="form-control" placeholder="29/08/20" value="{{ old('curr_date') }}"></div>
                    <div class="col-md-2"><label>পূর্ববর্তী তারিখ</label><input name="prev_date" class="form-control" placeholder="20/07/20" value="{{ old('prev_date') }}"></div>
                    <div class="col-md-2"><label>পুরাতন ইউনিট</label><input name="old_unit" class="form-control" placeholder="0" value="{{ old('old_unit') }}"></div>
                    <div class="col-md-2"><label>বর্তমান রিডিং</label><input name="curr_read" class="form-control" placeholder="93149" value="{{ old('curr_read') }}"></div>
                    <div class="col-md-2"><label>পূর্ববর্তী রিডিং</label><input name="prev_read" class="form-control" placeholder="92197" value="{{ old('prev_read') }}"></div>
                    <div class="col-md-2"><label>ব্যবহৃত ইউনিট</label><input name="consumed" class="form-control" placeholder="952" value="{{ old('consumed') }}"></div>
                    <div class="col-md-2"><label>ইউনিটের মূল্য</label><input name="cost_unit" class="form-control" placeholder="8285.17" value="{{ old('cost_unit') }}"></div>
                    <div class="col-md-2"><label>ডিমান্ড চার্জ</label><input name="demand_chg" class="form-control" placeholder="90.00" value="{{ old('demand_chg') }}"></div>
                    <div class="col-md-2"><label>মিটার রেন্ট</label><input name="rent" class="form-control" placeholder="0.00" value="{{ old('rent') }}"></div>
                    <div class="col-md-2"><label>ট্রান্সফরমার রেন্ট</label><input name="trans_rent" class="form-control" placeholder="0.00" value="{{ old('trans_rent') }}"></div>
                    <div class="col-md-2"><label>ট্রান্সফরমার লস</label><input name="trans_loss" class="form-control" placeholder="0.00" value="{{ old('trans_loss') }}"></div>
                    <div class="col-md-2"><label>PFC চার্জ</label><input name="pfc" class="form-control" placeholder="0.00" value="{{ old('pfc') }}"></div>
                    <div class="col-md-2"><label>প্রিন্সিপাল টাকা</label><input name="principal" class="form-control" placeholder="8375.17" value="{{ old('principal') }}"></div>
                    <div class="col-md-2"><label>৫% ভ্যাট</label><input name="vat" class="form-control" placeholder="418.76" value="{{ old('vat') }}"></div>
                    <div class="col-md-2"><label>মাসিক মোট বিল</label><input name="total_bill" class="form-control" placeholder="8793.93" value="{{ old('total_bill') }}"></div>
                </div>

                <div class="section-title">বকেয়া ও সমন্বয়</div>
                <div class="row g-2">
                    <div class="col-md-2"><label>বকেয়া শুরু</label><input name="arr_start" class="form-control" placeholder="05/09/20" value="{{ old('arr_start') }}"></div>
                    <div class="col-md-2"><label>বকেয়া শেষ</label><input name="arr_end" class="form-control" placeholder="10/09/20" value="{{ old('arr_end') }}"></div>
                    <div class="col-md-2"><label>প্রিন্সিপাল অ্যাডজাস্ট</label><input name="prin_adj" class="form-control" placeholder="0.70" value="{{ old('prin_adj') }}"></div>
                    <div class="col-md-2"><label>LPS অ্যাডজাস্ট</label><input name="lps_adj" class="form-control" placeholder="0.00" value="{{ old('lps_adj') }}"></div>
                    <div class="col-md-2"><label>ভ্যাট অ্যাডজাস্ট</label><input name="vat_adj" class="form-control" placeholder="0.00" value="{{ old('vat_adj') }}"></div>
                    <div class="col-md-2"><label>প্রিন্সিপাল এরিয়ার</label><input name="prin_arr" class="form-control" placeholder="-0.63" value="{{ old('prin_arr') }}"></div>
                    <div class="col-md-2"><label>বর্তমান LPS</label><input name="curr_lps" class="form-control" placeholder="0.00" value="{{ old('curr_lps') }}"></div>
                    <div class="col-md-2"><label>ভ্যাট এরিয়ার</label><input name="vat_arr" class="form-control" placeholder="0.00" value="{{ old('vat_arr') }}"></div>
                    <div class="col-md-2"><label>সর্বমোট ভ্যাট</label><input name="total_vat" class="form-control" placeholder="418.76" value="{{ old('total_vat') }}"></div>
                    <div class="col-md-2"><label>পরিশোধযোগ্য</label><input name="total_pay" class="form-control" placeholder="8794.00" value="{{ old('total_pay') }}"></div>
                    <div class="col-md-2"><label>শেষ তারিখ</label><input name="last_date" class="form-control" placeholder="03/09/20" value="{{ old('last_date') }}"></div>
                    <div class="col-md-2"><label>দেরি করলে মোট</label><input name="after_due" class="form-control" placeholder="9213.00" value="{{ old('after_due') }}"></div>
                    <div class="col-md-2"><label>দেরি করলে পরিশোধ</label><input name="pay_after_due" class="form-control" placeholder="9213.00" value="{{ old('pay_after_due') }}"></div>
                    <div class="col-md-2"><label>পেমেন্ট বর্ণনা</label><input name="pay_desc" class="form-control" placeholder="13122.00" value="{{ old('pay_desc') }}"></div>
                </div>

                <div class="section-title">ব্যাংক তথ্য</div>
                <div class="row g-2">
                    <div class="col-md-5"><label>ব্যাংক ও শাখা</label><input name="pay_at" class="form-control" placeholder="AGRANI BANK - GULSHAN-2" value="{{ old('pay_at') }}"></div>
                    <div class="col-md-3"><label>ব্যাংক কোড</label><input name="bank_code" class="form-control" placeholder="04" value="{{ old('bank_code') }}"></div>
                    <div class="col-md-4"><label>শাখা কোড</label><input name="branch_code" class="form-control" placeholder="6309" value="{{ old('branch_code') }}"></div>
                </div>

                <div class="mt-4 pt-3 d-flex justify-content-end gap-2 border-top">
                    <a href="{{ route('user.electricity_bill.index') }}" class="btn btn-light border">লিস্ট দেখুন</a>
                    <button type="submit" class="btn btn-save" onclick="return confirm('সাবমিট করলে চার্জ কাটা হবে।')">সাবমিট করুন</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.section-title {
    background: #e0f2f1; padding: 5px 12px; font-weight: 700; color: #00695c;
    border-left: 4px solid #00695c; margin-top: 20px; font-size: 14px;
}
.form-control { font-size: 12px; height: 34px; }
.btn-save { background: #00695c; color: white; padding: 10px 30px; border: none; }
.btn-save:hover { opacity: 0.9; color: #fff; }
</style>
<script>
function autoFill() {
    document.querySelectorAll('input.form-control').forEach(function(inp) {
        if (inp.placeholder) inp.value = inp.placeholder;
    });
}
</script>
@endsection