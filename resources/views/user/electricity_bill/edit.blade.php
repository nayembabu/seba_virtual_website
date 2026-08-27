@extends('user.layouts.app')
@section('title') বিল এডিট @endsection
@section('content')
<div class="container-fluid px-3">
    <div class="card card-primary shadow">
        <div class="card-header" style="background:#00695c;color:#fff;">
            <strong>DPDC বিল এডিট করুন</strong>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.electricity_bill.update', $bill->id) }}" style="font-size:13px;">
                @csrf @method('PUT')

                <div class="section-title mt-0">সাধারণ তথ্য</div>
                <div class="row g-2">
                    <div class="col-md-2"><label>ফিডার</label><input name="feeder" class="form-control" value="{{ old('feeder', $bill->feeder) }}"></div>
                    <div class="col-md-2"><label>মিটার সীল</label><input name="meter_seal" class="form-control" value="{{ old('meter_seal', $bill->meter_seal) }}"></div>
                    <div class="col-md-2"><label>বিল নং</label><input name="bill_no" class="form-control" value="{{ old('bill_no', $bill->bill_no) }}"></div>
                    <div class="col-md-2"><label>সিডি</label><input name="cd" class="form-control" value="{{ old('cd', $bill->cd) }}"></div>
                    <div class="col-md-2"><label>ইস্যুর তারিখ</label><input name="issue_date" class="form-control" value="{{ old('issue_date', $bill->issue_date) }}"></div>
                    <div class="col-md-2"><label>অফিস কোড</label><input name="office_code" class="form-control" value="{{ old('office_code', $bill->office_code) }}"></div>
                    <div class="col-md-2"><label>বিল গ্রুপ</label><input name="bill_group" class="form-control" value="{{ old('bill_group', $bill->bill_group) }}"></div>
                    <div class="col-md-2"><label>বই নং</label><input name="book" class="form-control" value="{{ old('book', $bill->book) }}"></div>
                    <div class="col-md-2"><label>ওয়াক অর্ডার</label><input name="walk_order" class="form-control" value="{{ old('walk_order', $bill->walk_order) }}"></div>
                    <div class="col-md-2"><label>বিল টাইপ</label><input name="bill_type" class="form-control" value="{{ old('bill_type', $bill->bill_type) }}"></div>
                </div>

                <div class="section-title">গ্রাহক তথ্য</div>
                <div class="row g-2">
                    <div class="col-md-4"><label>গ্রাহকের নাম</label><input name="customer_name" class="form-control" value="{{ old('customer_name', $bill->customer_name) }}"></div>
                    <div class="col-md-5"><label>ঠিকানা</label><input name="address" class="form-control" value="{{ old('address', $bill->address) }}"></div>
                    <div class="col-md-3"><label>এলাকা/জোন</label><input name="area_zone" class="form-control" value="{{ old('area_zone', $bill->area_zone) }}"></div>
                    <div class="col-md-3"><label>কাস্টমার নং</label><input name="customer_no" class="form-control" value="{{ old('customer_no', $bill->customer_no) }}"></div>
                    <div class="col-md-3"><label>পূর্বের হিসাব নং</label><input name="prev_acc" class="form-control" value="{{ old('prev_acc', $bill->prev_acc) }}"></div>
                    <div class="col-md-2"><label>ক্যাটাগরি</label><input name="cust_cat" class="form-control" value="{{ old('cust_cat', $bill->cust_cat) }}"></div>
                    <div class="col-md-2"><label>স্ট্যাটাস</label><input name="cust_status" class="form-control" value="{{ old('cust_status', $bill->cust_status) }}"></div>
                    <div class="col-md-2"><label>কানেকশন টাইপ</label><input name="conn_type" class="form-control" value="{{ old('conn_type', $bill->conn_type) }}"></div>
                </div>

                <div class="section-title">মিটার তথ্য</div>
                <div class="row g-2">
                    <div class="col-md-2"><label>ট্যারিফ</label><input name="tariff" class="form-control" value="{{ old('tariff', $bill->tariff) }}"></div>
                    <div class="col-md-2"><label>স্ট্যান্ডার্ড রুলস</label><input name="std_rules" class="form-control" value="{{ old('std_rules', $bill->std_rules) }}"></div>
                    <div class="col-md-2"><label>মিটার নং</label><input name="meter_no" class="form-control" value="{{ old('meter_no', $bill->meter_no) }}"></div>
                    <div class="col-md-2"><label>মিটার টাইপ</label><input name="meter_type" class="form-control" value="{{ old('meter_type', $bill->meter_type) }}"></div>
                    <div class="col-md-2"><label>মিটার কন্ডিশন</label><input name="meter_cond" class="form-control" value="{{ old('meter_cond', $bill->meter_cond) }}"></div>
                    <div class="col-md-1"><label>OMF</label><input name="omf" class="form-control" value="{{ old('omf', $bill->omf) }}"></div>
                    <div class="col-md-1"><label>লোড</label><input name="load_val" class="form-control" value="{{ old('load_val', $bill->load_val) }}"></div>
                </div>

                <div class="section-title">বিল ও ক্যালকুলেশন</div>
                <div class="row g-2">
                    <div class="col-md-2"><label>বর্তমান তারিখ</label><input name="curr_date" class="form-control" value="{{ old('curr_date', $bill->curr_date) }}"></div>
                    <div class="col-md-2"><label>পূর্ববর্তী তারিখ</label><input name="prev_date" class="form-control" value="{{ old('prev_date', $bill->prev_date) }}"></div>
                    <div class="col-md-2"><label>পুরাতন ইউনিট</label><input name="old_unit" class="form-control" value="{{ old('old_unit', $bill->old_unit) }}"></div>
                    <div class="col-md-2"><label>বর্তমান রিডিং</label><input name="curr_read" class="form-control" value="{{ old('curr_read', $bill->curr_read) }}"></div>
                    <div class="col-md-2"><label>পূর্ববর্তী রিডিং</label><input name="prev_read" class="form-control" value="{{ old('prev_read', $bill->prev_read) }}"></div>
                    <div class="col-md-2"><label>ব্যবহৃত ইউনিট</label><input name="consumed" class="form-control" value="{{ old('consumed', $bill->consumed) }}"></div>
                    <div class="col-md-2"><label>ইউনিটের মূল্য</label><input name="cost_unit" class="form-control" value="{{ old('cost_unit', $bill->cost_unit) }}"></div>
                    <div class="col-md-2"><label>ডিমান্ড চার্জ</label><input name="demand_chg" class="form-control" value="{{ old('demand_chg', $bill->demand_chg) }}"></div>
                    <div class="col-md-2"><label>মিটার রেন্ট</label><input name="rent" class="form-control" value="{{ old('rent', $bill->rent) }}"></div>
                    <div class="col-md-2"><label>ট্রান্সফরমার রেন্ট</label><input name="trans_rent" class="form-control" value="{{ old('trans_rent', $bill->trans_rent) }}"></div>
                    <div class="col-md-2"><label>ট্রান্সফরমার লস</label><input name="trans_loss" class="form-control" value="{{ old('trans_loss', $bill->trans_loss) }}"></div>
                    <div class="col-md-2"><label>PFC চার্জ</label><input name="pfc" class="form-control" value="{{ old('pfc', $bill->pfc) }}"></div>
                    <div class="col-md-2"><label>প্রিন্সিপাল টাকা</label><input name="principal" class="form-control" value="{{ old('principal', $bill->principal) }}"></div>
                    <div class="col-md-2"><label>৫% ভ্যাট</label><input name="vat" class="form-control" value="{{ old('vat', $bill->vat) }}"></div>
                    <div class="col-md-2"><label>মাসিক মোট বিল</label><input name="total_bill" class="form-control" value="{{ old('total_bill', $bill->total_bill) }}"></div>
                </div>

                <div class="section-title">বকেয়া ও সমন্বয়</div>
                <div class="row g-2">
                    <div class="col-md-2"><label>বকেয়া শুরু</label><input name="arr_start" class="form-control" value="{{ old('arr_start', $bill->arr_start) }}"></div>
                    <div class="col-md-2"><label>বকেয়া শেষ</label><input name="arr_end" class="form-control" value="{{ old('arr_end', $bill->arr_end) }}"></div>
                    <div class="col-md-2"><label>প্রিন্সিপাল অ্যাডজাস্ট</label><input name="prin_adj" class="form-control" value="{{ old('prin_adj', $bill->prin_adj) }}"></div>
                    <div class="col-md-2"><label>LPS অ্যাডজাস্ট</label><input name="lps_adj" class="form-control" value="{{ old('lps_adj', $bill->lps_adj) }}"></div>
                    <div class="col-md-2"><label>ভ্যাট অ্যাডজাস্ট</label><input name="vat_adj" class="form-control" value="{{ old('vat_adj', $bill->vat_adj) }}"></div>
                    <div class="col-md-2"><label>প্রিন্সিপাল এরিয়ার</label><input name="prin_arr" class="form-control" value="{{ old('prin_arr', $bill->prin_arr) }}"></div>
                    <div class="col-md-2"><label>বর্তমান LPS</label><input name="curr_lps" class="form-control" value="{{ old('curr_lps', $bill->curr_lps) }}"></div>
                    <div class="col-md-2"><label>ভ্যাট এরিয়ার</label><input name="vat_arr" class="form-control" value="{{ old('vat_arr', $bill->vat_arr) }}"></div>
                    <div class="col-md-2"><label>সর্বমোট ভ্যাট</label><input name="total_vat" class="form-control" value="{{ old('total_vat', $bill->total_vat) }}"></div>
                    <div class="col-md-2"><label>পরিশোধযোগ্য</label><input name="total_pay" class="form-control" value="{{ old('total_pay', $bill->total_pay) }}"></div>
                    <div class="col-md-2"><label>শেষ তারিখ</label><input name="last_date" class="form-control" value="{{ old('last_date', $bill->last_date) }}"></div>
                    <div class="col-md-2"><label>দেরি করলে মোট</label><input name="after_due" class="form-control" value="{{ old('after_due', $bill->after_due) }}"></div>
                    <div class="col-md-2"><label>দেরি করলে পরিশোধ</label><input name="pay_after_due" class="form-control" value="{{ old('pay_after_due', $bill->pay_after_due) }}"></div>
                    <div class="col-md-2"><label>পেমেন্ট বর্ণনা</label><input name="pay_desc" class="form-control" value="{{ old('pay_desc', $bill->pay_desc) }}"></div>
                </div>

                <div class="section-title">ব্যাংক তথ্য</div>
                <div class="row g-2">
                    <div class="col-md-5"><label>ব্যাংক ও শাখা</label><input name="pay_at" class="form-control" value="{{ old('pay_at', $bill->pay_at) }}"></div>
                    <div class="col-md-3"><label>ব্যাংক কোড</label><input name="bank_code" class="form-control" value="{{ old('bank_code', $bill->bank_code) }}"></div>
                    <div class="col-md-4"><label>শাখা কোড</label><input name="branch_code" class="form-control" value="{{ old('branch_code', $bill->branch_code) }}"></div>
                </div>

                <div class="mt-4 pt-3 d-flex justify-content-end border-top">
                    <button type="submit" class="btn btn-save">আপডেট করুন</button>
                    <a href="{{ route('user.electricity_bill.index') }}" class="btn btn-secondary ms-2">বাতিল</a>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
.section-title { background: #e0f2f1; padding: 5px 12px; font-weight: 700; color: #00695c; border-left: 4px solid #00695c; margin-top: 20px; font-size: 14px; }
.form-control { font-size: 12px; height: 34px; }
.btn-save { background: #00695c; color: white; padding: 10px 30px; border: none; }
.btn-save:hover { opacity: 0.9; color: #fff; }
</style>
@endsection