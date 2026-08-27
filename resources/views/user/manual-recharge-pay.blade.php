<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $method }} Payment — Secure Payment Gateway</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @switch($method)
        @case('bKash')
        <style>
            :root {
                --gateway-primary: #e2136e;
                --gateway-dark: #b80c55;
                --gateway-light: #fff0f5;
                --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
                --card-bg: rgba(15, 23, 42, 0.65);
                --card-border: rgba(255, 255, 255, 0.1);
                --text-primary: #f1f5f9;
                --text-muted: #94a3b8;
                --step-bg: rgba(226, 19, 110, 0.15);
                --step-border: rgba(226, 19, 110, 0.3);
                --glow-color: #e2136e;
                --glow-secondary: #4f46e5;
            }
        </style>
        @break
        @case('bKash Payment')
        <style>
            :root {
                --gateway-primary: #e2136e;
                --gateway-dark: #b80c55;
                --gateway-light: #fff0f5;
                --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
                --card-bg: rgba(15, 23, 42, 0.65);
                --card-border: rgba(255, 255, 255, 0.1);
                --text-primary: #f1f5f9;
                --text-muted: #94a3b8;
                --step-bg: rgba(226, 19, 110, 0.15);
                --step-border: rgba(226, 19, 110, 0.3);
                --glow-color: #e2136e;
                --glow-secondary: #4f46e5;
            }
        </style>
        @break
        @case('Nagad')
        <style>
            :root {
                --gateway-primary: #ff7a00;
                --gateway-dark: #e66a00;
                --gateway-light: #fff4e8;
                --bg-gradient: linear-gradient(135deg, #1a0a00 0%, #2d1500 50%, #1a0a00 100%);
                --card-bg: rgba(30, 15, 0, 0.7);
                --card-border: rgba(255, 122, 0, 0.15);
                --text-primary: #fef3e7;
                --text-muted: #a08a7a;
                --step-bg: rgba(255, 122, 0, 0.15);
                --step-border: rgba(255, 122, 0, 0.3);
                --glow-color: #ff7a00;
                --glow-secondary: #cc5500;
            }
        </style>
        @break
        @case('Rocket')
        <style>
            :root {
                --gateway-primary: #8b5cf6;
                --gateway-dark: #7c3aed;
                --gateway-light: #f5f3ff;
                --bg-gradient: linear-gradient(135deg, #120224 0%, #1f1147 50%, #2d0b59 100%);
                --card-bg: rgba(255, 255, 255, 0.06);
                --card-border: rgba(255, 255, 255, 0.08);
                --text-primary: #f1f5f9;
                --text-muted: #94a3b8;
                --step-bg: rgba(139, 92, 246, 0.15);
                --step-border: rgba(139, 92, 246, 0.3);
                --glow-color: #8b5cf6;
                --glow-secondary: #6d28d9;
            }
        </style>
        @break
    @endswitch
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; }

        body {
            min-height: 100vh;
            background: var(--bg-gradient);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 20px;
            color: var(--text-primary);
            position: relative;
            overflow-x: hidden;
        }

        body::before, body::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(150px);
            z-index: -1;
            opacity: 0.4;
        }
        body::before { background: var(--glow-color); top: -10%; left: -10%; }
        body::after { background: var(--glow-secondary); bottom: -10%; right: -10%; }

        .payment-card {
            width: 100%;
            max-width: 540px;
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 28px;
            border: 1px solid var(--card-border);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .top-header {
            background: linear-gradient(135deg, var(--gateway-primary) 0%, var(--gateway-dark) 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-wrapper {
            width: 76px;
            height: 76px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 16px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 32px;
            color: #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .title { font-size: 26px; font-weight: 700; color: #ffffff; }
        .subtitle { font-size: 13px; color: rgba(255, 255, 255, 0.8); margin-top: 4px; font-weight: 500; }

        .amount-badge {
            margin-top: 24px;
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 14px 24px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: 700;
            color: #fff;
        }
        .amount-badge i { color: #ffd700; }

        .main-content { padding: 32px; }

        .section-title {
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 18px;
        }

        .number-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(226, 19, 110, 0.4);
            border-radius: 20px;
            padding: 22px;
            text-align: center;
            margin-bottom: 24px;
            transition: 0.3s;
        }
        .number-card:hover {
            background: rgba(226, 19, 110, 0.02);
            border-color: var(--gateway-primary);
        }
        .number-card .label {
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .number-card .phone-num {
            font-size: 30px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
        }
        .btn-copy {
            margin-top: 14px;
            border: none;
            background: var(--gateway-primary);
            color: white;
            padding: 8px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-copy:hover {
            background: var(--gateway-dark);
            transform: translateY(-1px);
        }

        .steps-container {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 28px;
        }
        .step-row { display: flex; gap: 14px; margin-bottom: 16px; }
        .step-row:last-child { margin-bottom: 0; }
        .step-num {
            width: 28px; height: 28px; border-radius: 50%;
            background: var(--step-bg);
            color: var(--gateway-primary);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            border: 1px solid var(--step-border);
        }
        .step-info {
            font-size: 13.5px;
            color: #cbd5e1;
            line-height: 1.6;
        }
        .step-info b { color: #fff; }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }
        .form-group i {
            position: absolute;
            left: 16px;
            top: 18px;
            color: #64748b;
            font-size: 16px;
            transition: 0.3s;
        }
        .custom-input {
            width: 100%;
            height: 54px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 0 20px 0 46px;
            color: #fff;
            font-size: 14.5px;
            font-weight: 500;
            transition: 0.3s;
            outline: none;
        }
        .custom-input:focus {
            border-color: var(--gateway-primary);
            background: rgba(255, 255, 255, 0.07);
            box-shadow: 0 0 15px rgba(226, 19, 110, 0.15);
        }
        .custom-input:focus + i {
            color: var(--gateway-primary);
        }

        .file-upload-card {
            border: 2px dashed rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            padding: 24px;
            text-align: center;
            background: rgba(255, 255, 255, 0.02);
            cursor: pointer;
            display: block;
            transition: 0.3s;
            margin-bottom: 24px;
        }
        .file-upload-card:hover {
            border-color: var(--gateway-primary);
            background: rgba(226, 19, 110, 0.02);
        }
        .file-upload-card i {
            font-size: 32px;
            color: var(--gateway-primary);
            margin-bottom: 10px;
        }
        .file-upload-card p {
            margin: 0;
            font-size: 13.5px;
            color: var(--text-muted);
        }
        input[type=file] { display: none; }

        .btn-pay-submit {
            width: 100%;
            height: 54px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--gateway-primary) 0%, var(--gateway-dark) 100%);
            color: white;
            font-size: 15.5px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 10px 25px rgba(226, 19, 110, 0.25);
        }
        .btn-pay-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(226, 19, 110, 0.35);
        }

        .btn-pay-cancel {
            width: 100%;
            height: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            background: transparent;
            color: #cbd5e1;
            margin-top: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-pay-cancel:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .footer-credits {
            text-align: center;
            margin-top: 28px;
            color: #64748b;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        @media (max-width: 576px) {
            .main-content { padding: 22px; }
            .top-header { padding: 30px 20px; }
            .number-card .phone-num { font-size: 24px; }
            .title { font-size: 22px; }
        }
    </style>
</head>
<body>

<div class="payment-card">
    <div class="top-header">
        <div class="logo-wrapper">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div class="title">{{ $method }} Payment</div>
        <div class="subtitle">
            @switch($method)
                @case('bKash') অফিসিয়াল ও নিরাপদ ম্যানুয়াল রিচার্জ গেটওয়ে @break
                @case('bKash Payment') bKash Merchant Payment Gateway @break
                @case('Nagad') Official & Secure Manual Recharge Gateway @break
                @case('Rocket') Fast & Secure Recharge Gateway @break
            @endswitch
        </div>
        <div class="amount-badge">
            <i class="fa-solid fa-wallet"></i>
            ৳ {{ number_format($amount, 0) }}
        </div>
    </div>

    <div class="main-content">
        <div class="section-title">পেমেন্ট নির্দেশনাবলী</div>

        <div class="number-card">
            <div class="label">@if($method == 'bKash Payment') নিচের নাম্বারে টাকা বিকাশ হতে পেমেন্ট করুন @else নিচের নাম্বারে টাকা সেন্ড মানি করুন @endif</div>
            <div class="phone-num" id="gatewayNumber">{{ $gatewayNumber }}</div>
            <button type="button" class="btn-copy" onclick="copyNumber()">
                <i class="fa-regular fa-copy me-1"></i> নাম্বার কপি করুন
            </button>
        </div>

        <div class="steps-container">
            @switch($method)
                @case('bKash')
                <div class="step-row">
                    <div class="step-num">১</div>
                    <div class="step-info">bKash অ্যাপ অথবা <b>*247#</b> ডায়াল করে উপরের নাম্বারে <b>Send Money</b> করুন।</div>
                </div>
                <div class="step-row">
                    <div class="step-num">২</div>
                    <div class="step-info">আপনাকে অবশ্যই সঠিক পরিমাণ <b>৳ {{ number_format($amount, 0) }}</b> টাকা পাঠাতে হবে।</div>
                </div>
                <div class="step-row">
                    <div class="step-num">৩</div>
                    <div class="step-info">টাকা পাঠানো সফল হলে নিচের ফর্মে প্রয়োজনীয় তথ্য এবং স্ক্রিনশট সাবমিট করুন।</div>
                </div>
                @break
                @case('bKash Payment')
                <div class="step-row">
                    <div class="step-num">১</div>
                    <div class="step-info">bKash অ্যাপ অথবা <b>*247#</b> ডায়াল করে উপরের bKash Merchant নাম্বারে <b>Send Money</b> করুন।</div>
                </div>
                <div class="step-row">
                    <div class="step-num">২</div>
                    <div class="step-info">আপনাকে অবশ্যই সঠিক পরিমাণ <b>৳ {{ number_format($amount, 0) }}</b> টাকা পাঠাতে হবে।</div>
                </div>
                <div class="step-row">
                    <div class="step-num">৩</div>
                    <div class="step-info">টাকা পাঠানো সফল হলে নিচের ফর্মে প্রয়োজনীয় তথ্য এবং স্ক্রিনশট সাবমিট করুন।</div>
                </div>
                @break
                @case('Nagad')
                <div class="step-row">
                    <div class="step-num">১</div>
                    <div class="step-info">Nagad অ্যাপ অথবা <b>*167#</b> ডায়াল করে উপরের নাম্বারে <b>Send Money</b> করুন।</div>
                </div>
                <div class="step-row">
                    <div class="step-num">২</div>
                    <div class="step-info">আপনাকে অবশ্যই সঠিক পরিমাণ <b>৳ {{ number_format($amount, 0) }}</b> টাকা পাঠাতে হবে।</div>
                </div>
                <div class="step-row">
                    <div class="step-num">৩</div>
                    <div class="step-info">টাকা পাঠানো সফল হলে নিচের ফর্মে প্রয়োজনীয় তথ্য এবং স্ক্রিনশট সাবমিট করুন।</div>
                </div>
                @break
                @case('Rocket')
                <div class="step-row">
                    <div class="step-num">১</div>
                    <div class="step-info">Rocket অ্যাপ অথবা <b>*322#</b> ডায়াল করে উপরের নাম্বারে <b>Send Money</b> করুন।</div>
                </div>
                <div class="step-row">
                    <div class="step-num">২</div>
                    <div class="step-info">আপনাকে অবশ্যই সঠিক পরিমাণ <b>৳ {{ number_format($amount, 0) }}</b> টাকা পাঠাতে হবে।</div>
                </div>
                <div class="step-row">
                    <div class="step-num">৩</div>
                    <div class="step-info">টাকা পাঠানো সফল হলে নিচের ফর্মে প্রয়োজনীয় তথ্য এবং স্ক্রিনশট সাবমিট করুন।</div>
                </div>
                @break
            @endswitch
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('user.manual-recharge.submit', $method) }}">
            @csrf
            <input type="hidden" name="amount" value="{{ $amount }}">

            <div class="form-group">
                <input type="text" name="sender" class="custom-input" placeholder="যে নাম্বার থেকে টাকা পাঠিয়েছেন" required autocomplete="off">
                <i class="fa-solid fa-phone"></i>
            </div>

            <div class="form-group">
                <input type="text" name="trxid" class="custom-input" placeholder="ট্রানজেকশন আইডি (TrxID)" required autocomplete="off">
                <i class="fa-solid fa-receipt"></i>
            </div>

            <label class="file-upload-card">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <p id="fileName">পেমেন্ট স্ক্রিনশট আপলোড করুন</p>
                <input type="file" name="screenshot" id="fileInput" accept="image/*" required>
            </label>

            <button type="submit" class="btn-pay-submit">
                <i class="fa-solid fa-paper-plane me-2"></i> পেমেন্ট নিশ্চিত করুন
            </button>
        </form>

        <button class="btn-pay-cancel" onclick="window.location='{{ route('user.manual-recharge') }}'">পেমেন্ট বাতিল করুন</button>

        <div class="footer-credits">
            © {{ date('Y') }} Secure Payment Gateway <br>
            <span style="color: #475569;">Fast • Secure • Automated Notification</span>
        </div>
    </div>
</div>

<script>
function copyNumber(){
    let num = document.getElementById("gatewayNumber").innerText;
    if(num === '' || num === 'Not Set'){
        Swal.fire({ icon: 'error', title: 'দুঃখিত', text: 'কোনো নাম্বার পাওয়া যায়নি!', timer: 1500, showConfirmButton: false });
        return;
    }
    navigator.clipboard.writeText(num);
    Swal.fire({
        icon: 'success',
        title: 'কপি হয়েছে!',
        text: 'নাম্বারটি ক্লিপবোর্ডে কপি করা হয়েছে।',
        timer: 1500,
        showConfirmButton: false,
        background: '#1e293b',
        color: '#fff'
    });
}

document.getElementById('fileInput').addEventListener('change', function(){
    let name = this.files[0]?.name || 'পেমেন্ট স্ক্রিনশট আপলোড করুন';
    document.getElementById('fileName').innerText = name;
    document.getElementById('fileName').style.color = '#fff';
});
</script>

</body>
</html>
