@extends('user.layouts.app')

@section('title') @lang('ম্যানুয়্যাল রিচার্জ') @endsection

@push('css')
<style>
:root {
    --primary: #6c5ce7;
    --secondary: #8e44ad;
    --success: #00c853;
    --danger: #ff4757;
    --light: #ffffff;
    --dark: #111827;
    --gray: #6b7280;
    --bg: #f3f6fb;
    --card: #ffffff;
    --border: #e5e7eb;
    --accent-green: #10b981;
    --accent-red: #ef4444;
}

body {
    background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 50%, #eef7ff 100%);
    font-family: 'Hind Siliguri', 'Segoe UI', sans-serif;
}

.premium-container { max-width: 700px; margin-top: 2rem; margin-bottom: 3rem; }

.glass-card {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(16px);
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,0.6);
    box-shadow: 0 20px 60px rgba(17, 24, 39, 0.1);
    overflow: hidden;
    margin-bottom: 25px;
}

.balance-banner {
    position: relative;
    padding: 35px 30px 25px;
    background: linear-gradient(135deg, #6c5ce7 0%, #8e44ad 100%);
    color: white;
    overflow: hidden;
    border-radius: 24px 24px 0 0;
}

.balance-banner::before {
    content: '';
    position: absolute;
    width: 220px;
    height: 220px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    top: -120px;
    right: -100px;
    pointer-events: none;
}

.balance-amount { font-size: 2.5rem; font-weight: 700; line-height: 1.2; }

.amount-input-group { position: relative; max-width: 400px; margin: 0 auto; }
.amount-input-group .currency-symbol {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
}
.custom-amount-input {
    padding: 16px 20px 16px 50px;
    font-size: 1.8rem;
    font-weight: 700;
    border-radius: 16px;
    border: 2px solid #e2e8f0;
    text-align: center;
    transition: all 0.3s ease;
    background: #fff;
    width: 100%;
}
.custom-amount-input::placeholder {
    font-size: 14px;
    color: #94a3b8;
}
.custom-amount-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.15);
    outline: none;
}

.quick-amounts {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 15px;
}
.amount-chip {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    padding: 8px 18px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
}
.min-label{font-size:10px;opacity:.7;font-weight:400;display:inline}.amount-chip:hover, .amount-chip.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108, 92, 231, 0.25);
}

.payment-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
.payment-method {
    position: relative;
    background: #fff;
    border: 2px solid #edf2f7;
    border-radius: 22px;
    padding: 20px 10px;
    text-align: center;
    cursor: pointer;
    transition: .3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}
.payment-method:hover { transform: translateY(-5px); border-color: #6c5ce7; box-shadow: 0 15px 30px rgba(108, 92, 231, 0.12); }
.payment-method.selected { border-color: #6c5ce7; background: #f6f4ff; box-shadow: 0 15px 30px rgba(108, 92, 231, 0.18); }
.payment-method.inactive { cursor: not-allowed; opacity: 0.7; }
.payment-method.inactive:hover { transform: none; border-color: #edf2f7; box-shadow: none; }
.payment-method img { width: 62px; height: 62px; object-fit: contain; margin-bottom: 6px; }
.payment-method h4 { font-size: 15px; font-weight: 700; color: #111827; margin: 0; }
.payment-method p { color: #6b7280; font-size: 12px; margin: 0; }

.status-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.status-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    display: inline-block;
}
.dot-active {
    background-color: var(--accent-green);
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: pulse-green 2s infinite;
}
.dot-inactive {
    background-color: var(--accent-red);
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    animation: pulse-red 2s infinite;
}
@keyframes pulse-green {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
@keyframes pulse-red {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
}

.info-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 22px;
}
.info-icon {
    width: 42px; height: 42px; border-radius: 12px;
    background: #eef2ff;
    display: flex; justify-content: center; align-items: center;
    color: #6c5ce7; font-size: 18px; flex-shrink: 0;
}
.info-text { flex: 1; color: #374151; font-size: 14px; line-height: 1.6; }

.security { margin-top: 18px; display: flex; justify-content: center; align-items: center; gap: 10px; color: #6b7280; font-size: 13px; }
.security i { color: var(--success); }

.pay-btn {
    width: 100%;
    border: none;
    border-radius: 18px;
    padding: 16px;
    background: linear-gradient(135deg, #6c5ce7, #8e44ad);
    color: white;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: .3s;
    box-shadow: 0 15px 30px rgba(108, 92, 231, 0.25);
    margin-top: 20px;
}
.pay-btn:hover { transform: translateY(-2px); }
.pay-btn:disabled { opacity: .55; cursor: not-allowed; transform: none; box-shadow: none; }

.footer-text { margin-top: 24px; text-align: center; color: #94a3b8; font-size: 13px; padding-bottom: 24px; }

@media(max-width: 650px) {
    .payment-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .payment-method { padding: 16px 8px; }
    .payment-method img { width: 54px; height: 54px; }
    .balance-amount { font-size: 2rem; }
    .custom-amount-input { font-size: 1.4rem; }
}

/* History Table */
.history-section{margin-top:40px;padding:0 10px 10px;}
.history-section h5{font-size:20px;font-weight:700;color:#111827;margin-bottom:20px;padding-top:15px;}
.history-wrap{background:#fff;border-radius:18px;border:1px solid #e2e8f0;overflow-x:auto;}
.history-wrap table{width:100%;border-collapse:collapse;min-width:auto;}
.history-wrap th{background:#2c3e50;color:#fff;padding:14px 16px;text-align:left;font-size:14px;white-space:nowrap;}
.history-wrap td{padding:12px 16px;border-bottom:1px solid #eee;font-size:14px;vertical-align:middle;}
.history-wrap tr:last-child td{border-bottom:none;}
.history-wrap .badge{padding:4px 14px;border-radius:14px;display:inline-block;font-size:13px;font-weight:600;}
.badge-pending{background:#ffc107;color:#000;}
.badge-approved{background:#28a745;color:#fff;}
.badge-cancelled{background:#dc3545;color:#fff;}
.history-note{font-size:13px;color:#6b7280;max-width:200px;white-space:normal;word-break:break-all;}


.pagination .page-link svg{display:none;}
</style>
@endpush

@section('content')
<div class="container premium-container">

    <div class="glass-card">
        <div class="balance-banner">
            <div style="text-align: center; position: relative; z-index: 1;">
                <div style="width: 80px; height: 80px; border-radius: 22px; background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); display: flex; justify-content: center; align-items: center; margin: 0 auto 18px; border: 1px solid rgba(255,255,255,0.15);">
                    <i class="fa-solid fa-shield-halved" style="font-size: 34px; color: white;"></i>
                </div>
                <h3 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;">Secure Payment</h3>
                <p style="color: rgba(255,255,255,0.85); font-size: 14px;">নিরাপদ ও দ্রুত মোবাইল ব্যাংকিং পেমেন্ট সিস্টেম</p>
                <div style="margin-top: 20px; display: flex; justify-content: center;">
                    <div style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.15); backdrop-filter: blur(8px); padding: 14px 28px; border-radius: 20px;">
                        <div style="font-size: 12px; opacity: 0.8; margin-bottom: 4px;">বর্তমান ব্যালেন্স</div>
                        <div class="balance-amount">৳ {{ number_format(auth()->user()->balance ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding: 28px;">
            <h5 style="font-size: 17px; font-weight: 700; color: #111827; margin-bottom: 18px;">
                <i class="fa-solid fa-wallet text-primary me-2"></i>একাউন্ট রিচার্জ করুন
            </h5>

            <form id="rechargeForm" action="{{ route('user.manual-recharge.process') }}" method="POST">
                @csrf

                <div style="text-align: center; margin-bottom: 24px;">
                    <label style="font-weight: 600; margin-bottom: 12px; display: block; color: #374151;">রিচার্জের পরিমাণ লিখুন</label>
                    <div class="amount-input-group">
                        <span class="currency-symbol">৳</span>
                        <input type="number" class="custom-amount-input" id="amount" name="amount" placeholder="সর্বনিম্ন রিচার্জ {{ $min_d }}" min="{{ $min_d }}" required>
                    </div>
                    <div class="quick-amounts">
                        <span class="amount-chip" data-amount="{{ $min_d }}">৳<span class="min-label">ন্যূনতম</span> {{ $min_d }}</span>
                        <span class="amount-chip" data-amount="200">৳২০০</span>
                        <span class="amount-chip" data-amount="500">৳৫০০</span>
                        <span class="amount-chip" data-amount="1000">৳১০০০</span>
                        <span class="amount-chip" data-amount="2000">৳২০০০</span>
                        <span class="amount-chip" data-amount="5000">৳৫০০০</span>
                    </div>
                </div>

                <h5 style="font-size: 15px; font-weight: 700; color: #111827; margin-bottom: 16px;">Payment Method নির্বাচন করুন</h5>

                <div class="payment-grid">
                    @forelse($gateways as $gw)
                    <div class="payment-method" data-method="{{ $gw->name }}" data-status="active">
                        <div class="status-badge">
                            <span class="status-dot dot-active" title="Active"></span>
                        </div>
                        <img src="{{ asset('storage/uploads/' . $gw->logo) }}" alt="{{ $gw->name }}" onerror="this.src='{{ asset('images/gateways/' . strtolower($gw->name) . '.png') }}'">
                        <h4>{{ $gw->name }}</h4>
                        <p>{{ $gw->details ?? '' }}</p>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4" style="grid-column: 1 / -1;">
                        <i class="fa-solid fa-credit-card" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                        কোনো পেমেন্ট গেটওয়ে বর্তমানে সচল নেই
                    </div>
                    @endforelse
                </div>

                <div class="info-box" id="infoBox">
                    <div class="info-icon"><i class="fa-solid fa-circle-info"></i></div>
                    <div class="info-text">পেমেন্ট সম্পন্ন করতে একটি মোবাইল ব্যাংকিং নির্বাচন করুন</div>
                </div>

                <div class="security">
                    <i class="fa-solid fa-lock"></i> SSL Secured & Encrypted Payment Gateway
                </div>

                <input type="hidden" name="method" id="selectedMethod" value="">

                <button type="submit" class="pay-btn" id="payBtn" disabled>
                    <i class="fa-solid fa-arrow-right me-2"></i> Continue Payment
                </button>
            </form>



                    {{-- Recharge History --}}
        <div class="history-section">
            <h5><i class="fa-solid fa-clock-rotate-left me-2"></i>রিচার্জ হিস্ট্রি</h5>
            <div class="history-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>পরিমাণ</th>
                            <th>মেথড</th>
                            <th>Sender</th>
                            <th>TrxID</th>
                            <th>তারিখ</th>
                            <th>স্ট্যাটাস</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recharges as $r)
                        @php
                            $badge = $r->status == "pending" ? "badge-pending" : ($r->status == "approved" ? "badge-approved" : "badge-cancelled");
                            $statusIcon = $r->status == "pending" ? "⏳" : ($r->status == "approved" ? "✅" : "❌");
                            $statusBn = $r->status == "pending" ? "পেন্ডিং" : ($r->status == "approved" ? "অ্যাপ্রভড" : "ক্যানসেলড");
                        @endphp
                        <tr>
                            <td><strong>৳{{ number_format($r->amount, 0) }}</strong></td>
                            <td>{{$r->gateway_id ?? "—"}}</td>
                            <td>{{$r->from ?? "—"}}</td>
                            <td style="font-size:12px;">{{$r->txid ?? "—"}}</td>
                            <td style="font-size:12px;color:#666;">{{$r->created_at->format("d M Y")}}</td>
                            <td><span class="badge {{$badge}}">{{$statusIcon}} {{$statusBn}}</span>@if($r->status == 'cancelled' && $r->note)<br><small style="color:#dc3545;font-size:11px;font-weight:500;">{{$r->note}}</small>@endif</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:30px;color:#999;">
                                <i class="fa-solid fa-inbox" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                                কোনো রিচার্জ রিকোয়েস্ট নেই
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($recharges->hasPages())
            <div style="margin-top:15px;">{{$recharges->links()}}</div>
            @endif
        </div>

        <div class="footer-text">
                © {{ date('Y') }} Secure Payment Gateway <br>
                Safe &bull; Fast &bull; Trusted
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    $(".amount-chip").click(function () {
        $(".amount-chip").removeClass("active");
        $(this).addClass("active");
        var val = $(this).data("amount");
        $("#amount").val(val).focus();
    });

    $("#amount").on('input', function() {
        $(".amount-chip").removeClass("active");
    });

    let selectedMethod = '';

    $('.payment-method:not(.inactive)').click(function(){
        $('.payment-method').removeClass('selected');
        $(this).addClass('selected');
        selectedMethod = $(this).data('method');
        $('#selectedMethod').val(selectedMethod);
        $('#payBtn').prop('disabled', false);
        $('#infoBox').html(`
            <div class="info-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div class="info-text">
                <b>${selectedMethod}</b> নির্বাচন করা হয়েছে।<br>
                এখন Continue Payment বাটনে ক্লিক করুন।
            </div>
        `);
    });

    $('.payment-method.inactive').click(function(){
        Swal.fire({
            icon: 'info',
            title: 'এই পদ্ধতি বর্তমানে অনুপলব্ধ',
            text: 'এই গেটওয়েটি ডিয়েক্টিভ আছে। অনুগ্রহ করে অন্য একটি পদ্ধতি নির্বাচন করুন।',
            confirmButtonColor: '#6c5ce7'
        });
    });

    $('#rechargeForm').submit(function(e){
        var amount = $('#amount').val().trim();
        var minAmount = {{ $min_d }};

        if (amount === "" || isNaN(amount) || parseFloat(amount) < minAmount) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'সঠিক পরিমাণ প্রদান করুন',
                text: 'ন্যূনতম রিচার্জের পরিমাণ হলো ৳ ' + minAmount + ' টাকা।',
                confirmButtonColor: '#6c5ce7'
            });
            return;
        }

        if (!selectedMethod) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'পেমেন্ট মেথড নির্বাচন করুন',
                text: 'অনুগ্রহ করে bKash অথবা Nagad নির্বাচন করুন।',
                confirmButtonColor: '#6c5ce7'
            });
            return;
        }

        e.preventDefault();

        Swal.fire({
            title: 'পেমেন্ট কনফার্মেশন',
            html: `<div style="text-align:left;padding:10px">
                <p><strong>পরিমাণ:</strong> ৳${parseFloat(amount).toFixed(2)}</p>
                <p><strong>মেথড:</strong> ${selectedMethod}</p>
            </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ, এগিয়ে যান',
            cancelButtonText: 'বাতিল',
            confirmButtonColor: '#6c5ce7',
            cancelButtonColor: '#ef4444'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#rechargeForm')[0].submit();
            }
        });
    });

});
</script>
@endpush
