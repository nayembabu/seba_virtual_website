<?php
require_once __DIR__ . '/includes/config.php';
requireLogin();

$id = intval($_GET['id'] ?? 0);
$pdo = getDB();
$stmt = $pdo->prepare("SELECT * FROM trade_license_applications WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$app = $stmt->fetch();

if (!$app) {
    setFlash('error', 'ট্রেড লাইসেন্স পাওয়া যায়নি');
    redirect('index.php');
}

$isDncc = $app['city'] === 'dncc';
$corporation = $isDncc ? 'ঢাকা উত্তর সিটি কর্পোরেশন' : 'ঢাকা দক্ষিণ সিটি কর্পোরেশন';
$website = $isDncc ? 'www.dncc.gov.bd' : 'www.dscc.gov.bd';
$logoPrefix = $isDncc ? 'dncc' : 'dscc';
$verifyUrl = 'https://e-serviceportal.com/trade_license/verify.php?id=' . $app['id'];
?><!DOCTYPE html>
<html lang="bn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ই-ট্রেড লাইসেন্স - <?= strtoupper($app['city']) ?></title>
<style>
    @page { size: A4 portrait; margin: 0; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Nirmala UI', 'Bangla', 'Noto Sans Bengali', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 10.5px;
        line-height: 1.4;
        color: #000;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .print-page { width: 210mm; min-height: 297mm; padding: 10mm; margin: 0 auto; background: #fff; }
    @media print { .print-page { margin: 0; padding: 8mm 6mm; } .no-print { display: none !important; } }

    /* ===== HEADER ===== */
    .header { display: grid; grid-template-columns: 170px 1fr 160px; align-items: center; margin-bottom: 8px; }
    .header-left { text-align: center; font-size: 11px; }
    .header-center { text-align: center; }
    .header-right { text-align: center; }

    .qr-img { width: 90px; height: 90px; margin-bottom: 5px; }
    .issue-title { font-weight: bold; padding-bottom: 3px; margin-bottom: 3px; border-bottom: 1px solid #000; font-size: 11px; }
    .issue-row { font-size: 10px; line-height: 1.4; }

    .dncc-title { font-size: 18px; font-weight: bold; color: #1a4a8d; }
    .dncc-web { font-size: 11px; margin-bottom: 3px; }
    .dncc-logo { width: 75px; margin: 3px 0; }
    .license-title { font-size: 18px; font-weight: bold; }
    .license-no { margin-top: 3px; font-size: 13px; font-weight: bold; }

    .owner-photo { width: 120px; height: 150px; object-fit: cover; border-radius: 4px; box-shadow: 0 0 6px rgba(0,0,0,0.4); }

    /* ===== DISCLAIMER ===== */
    .disclaimer-box { border: 1px solid #000; padding: 3px 5px; font-size: 8.5px; margin-bottom: 5px; text-align: justify; color: #0000FF; font-weight: 500; line-height: 1.5; }

    /* ===== MAIN DATA ===== */
    .main-data-box { border: 1px solid #000; padding: 10px 8px; margin-bottom: 3px; position: relative; overflow: hidden; }
    .main-data-box::before {
        content: ""; position: absolute; top: 40%; left: 50%;
        width: 380px; height: 380px;
        background-image: url('../assets/images/<?= $logoPrefix ?>_logo.png');
        background-repeat: no-repeat; background-position: center; background-size: contain;
        opacity: 0.08; transform: translate(-50%, -50%); z-index: 0;
        -webkit-print-color-adjust: exact; print-color-adjust: exact;
    }
    .main-data-box * { position: relative; z-index: 1; }

    .data-row { display: grid; grid-template-columns: 200px 15px 1fr; margin-bottom: 4px; }
    .multi-col-row { display: grid; grid-template-columns: 200px 15px 1fr 100px 15px 1fr; margin-bottom: 4px; }
    .label { font-weight: bold; }
    .value { font-weight: bold; color: #333; }

    .grid-container { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 6px; }
    .section-title { font-weight: bold; text-decoration: underline; margin-bottom: 5px; font-size: 10px; }
    .sub-row { display: grid; grid-template-columns: 110px 12px 1fr; margin-bottom: 2px; font-size: 9.5px; }

    .fee-container { margin-top: 8px; border-top: 1px solid #000; padding-top: 6px; }
    .fee-container .label { margin-bottom: 5px; }

    .validity-line { text-align: center; font-weight: bold; margin-top: 10px; font-size: 12px; }

    /* ===== SIGNATURE ===== */
    .signature-box { border: 1px solid #000; padding: 12px 10px; margin-top: 3px; }
    .footer-signatures { display: grid; grid-template-columns: 1fr 170px 1fr; align-items: end; text-align: center; }
    .sign-block img { max-width: 180px; max-height: 75px; object-fit: contain; }
    .stamp-block img { width: 90px; height: 90px; object-fit: contain; }
    .sign-label { margin-top: 3px; padding-top: 2px; font-size: 10px; font-weight: bold; }

    .print-btn { position: fixed; top: 20px; right: 20px; padding: 10px 20px; background: #1e4db7; color: #fff; border: none; border-radius: 5px; cursor: pointer; z-index: 1000; font-size: 14px; }
    .print-btn:hover { background: #143a6f; }
</style>
</head>
<body>

<button class="print-btn no-print" onclick="window.print()">🖨️ প্রিন্ট করুন</button>

<div class="print-page">
    <!-- HEADER -->
    <div class="header">
        <div class="header-left">
            <div>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= urlencode($verifyUrl) ?>" class="qr-img" alt="QR Code">
            </div>
            <div class="issue-info">
                <div class="issue-title">লাইসেন্স ইস্যুর বিবরণ</div>
                <div class="issue-row">ইস্যুর তারিখ: <?= date('d/m/Y') ?></div>
                <div class="issue-row">ইস্যুর সময়: <?= date('H:i:s') ?></div>
            </div>
        </div>
        <div class="header-center">
            <div class="dncc-title"><?= $corporation ?></div>
            <div class="dncc-web"><?= $website ?></div>
            <img src="../assets/images/<?= $logoPrefix ?>_logo.png" class="dncc-logo" alt="Logo">
            <div class="license-title">ই-ট্রেড লাইসেন্স</div>
            <div class="license-no">লাইসেন্স নং: <?= htmlspecialchars($app['license_no']) ?></div>
        </div>
        <div class="header-right">
            <?php if ($app['owner_photo']): ?>
                <img src="../storage/<?= htmlspecialchars($app['owner_photo']) ?>" class="owner-photo" alt="Owner Photo">
            <?php else: ?>
                <div style="width:120px;height:150px;background:#f9f9f9;border-radius:4px;box-shadow:0 0 6px rgba(0,0,0,0.4);display:flex;align-items:center;justify-content:center;color:#ccc;font-size:12px;">ছবি</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- DISCLAIMER -->
    <div class="disclaimer-box">
        স্থানীয় সরকার (সিটি কর্পোরেশন) আইন, ২০০৯ (২০০৯ সনের ৬০ নং আইন) এর ধারা ৮৪-তে প্রদত্ত ক্ষমতাবলে সরকার প্রণীত আদর্শ কর তফসিল, ২০১৬ এর ১০ অনুচ্ছেদ অনুযায়ী ব্যবসা, বৃত্তি, পেশা বা শিল্প প্রতিষ্ঠানের উপর আরোপিত কর আদায়ের লক্ষ্যে নিম্ন বর্ণিত ব্যক্তি/প্রতিষ্ঠানের অনুকূলে অত্র ট্রেড লাইসেন্সটি ইস্যু করা হলো।
    </div>

    <!-- MAIN DATA -->
    <div class="main-data-box">
        <div class="data-row"><div class="label">১। ব্যবসা প্রতিষ্ঠানের নাম</div><div>:</div><div class="value"><?= htmlspecialchars($app['business_name']) ?></div></div>
        <div class="data-row"><div class="label">২। প্রতিষ্ঠানের মালিকের নাম</div><div>:</div><div class="value"><?= htmlspecialchars($app['owner_name']) ?></div></div>
        <div class="data-row"><div class="label">৩। পিতা / স্বামীর নাম</div><div>:</div><div class="value"><?= htmlspecialchars($app['father_husband_name']) ?></div></div>
        <div class="data-row"><div class="label">৪। মাতার নাম</div><div>:</div><div class="value"><?= htmlspecialchars($app['mother_name']) ?></div></div>
        <div class="data-row"><div class="label">৫। ব্যবসার প্রকৃতি</div><div>:</div><div class="value"><?= htmlspecialchars($app['business_nature']) ?></div></div>
        <div class="data-row"><div class="label">৬। ব্যবসার ধরণ</div><div>:</div><div class="value"><?= htmlspecialchars($app['business_type']) ?></div></div>
        <div class="data-row">
            <div class="label">৭। প্রতিষ্ঠানের ঠিকানা</div><div>:</div>
            <div class="value"><?php
                $a = $app;
                $addr = '';
                if ($a['business_address_house']) $addr .= 'বাড়ি নং - ' . $a['business_address_house'] . ', ';
                if ($a['business_address_road']) $addr .= 'রোড - ' . $a['business_address_road'] . ', ';
                if ($a['business_address_block']) $addr .= 'ব্লক - ' . $a['business_address_block'] . ', ';
                if ($a['business_address_area']) $addr .= $a['business_address_area'] . ', ';
                if ($a['business_address_thana']) $addr .= $a['business_address_thana'] . ', ';
                if ($a['business_address_district']) $addr .= $a['business_address_district'];
                if ($a['business_address_postcode']) $addr .= ' - ' . $a['business_address_postcode'];
                echo htmlspecialchars(rtrim($addr, ', '));
            ?></div>
        </div>
        <div class="multi-col-row">
            <div class="label">৮। অঞ্চল / বাজার শাখা</div><div>:</div><div class="value"><?= htmlspecialchars($app['business_zone'] ?? '') ?></div>
            <div class="label">ওয়ার্ড / মার্কেট</div><div>:</div><div class="value"><?= htmlspecialchars($app['business_ward_market'] ?? '') ?></div>
        </div>
        <div class="data-row"><div class="label" style="padding-left:20px;">এলাকা</div><div>:</div><div class="value"><?= htmlspecialchars($app['business_address_area'] ?? '') ?></div></div>
        <div class="multi-col-row" style="margin-top:4px;">
            <div class="label">৯। এনআইডি/পাসপোর্ট/জন্ম নিবন্ধ নং</div><div>:</div><div class="value"><?= htmlspecialchars($app['nid_passport_birth_no']) ?></div>
            <div class="label">বিআইএন নং</div><div>:</div><div class="value"><?= htmlspecialchars($app['bin_no'] ?? '') ?></div>
        </div>
        <div class="multi-col-row">
            <div class="label" style="padding-left:20px;">ফোন</div><div>:</div><div class="value"><?= htmlspecialchars($app['phone']) ?></div>
            <div class="label">ই-মেইল</div><div>:</div><div class="value"><?= htmlspecialchars($app['email'] ?? '') ?></div>
        </div>
        <div class="multi-col-row">
            <div class="label">১০। অর্থ বছর</div><div>:</div><div class="value"><?= htmlspecialchars($app['financial_year']) ?></div>
            <div class="label">ব্যবসা শুরুর তারিখ</div><div>:</div><div class="value"><?= $app['business_start_date'] ? date('Y-m-d', strtotime($app['business_start_date'])) : '' ?></div>
        </div>

        <!-- ADDRESS GRID -->
        <div class="grid-container">
            <div>
                <div class="section-title">১১। মালিকের বর্তমান ঠিকানা</div>
                <div class="sub-row"><span class="label">হোল্ডিং নং</span><span>:</span><span class="value"><?= htmlspecialchars($app['current_address_holding'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">রোড নং</span><span>:</span><span class="value"><?= htmlspecialchars($app['current_address_road'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">গ্রাম / মহল্লা</span><span>:</span><span class="value"><?= htmlspecialchars($app['current_address_village'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">পোস্ট কোড</span><span>:</span><span class="value"><?= htmlspecialchars($app['current_address_postcode'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">থানা</span><span>:</span><span class="value"><?= htmlspecialchars($app['current_address_thana'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">জেলা</span><span>:</span><span class="value"><?= htmlspecialchars($app['current_address_district'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">বিভাগ</span><span>:</span><span class="value"><?= htmlspecialchars($app['current_address_division'] ?? '') ?></span></div>
            </div>
            <div>
                <div class="section-title">মালিকের স্থায়ী ঠিকানা</div>
                <div class="sub-row"><span class="label">হোল্ডিং নং</span><span>:</span><span class="value"><?= htmlspecialchars($app['permanent_address_holding'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">রোড নং</span><span>:</span><span class="value"><?= htmlspecialchars($app['permanent_address_road'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">গ্রাম / মহল্লা</span><span>:</span><span class="value"><?= htmlspecialchars($app['permanent_address_village'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">পোস্ট কোড</span><span>:</span><span class="value"><?= htmlspecialchars($app['permanent_address_postcode'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">থানা</span><span>:</span><span class="value"><?= htmlspecialchars($app['permanent_address_thana'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">জেলা</span><span>:</span><span class="value"><?= htmlspecialchars($app['permanent_address_district'] ?? '') ?></span></div>
                <div class="sub-row"><span class="label">বিভাগ</span><span>:</span><span class="value"><?= htmlspecialchars($app['permanent_address_division'] ?? '') ?></span></div>
            </div>
        </div>

        <!-- FEE -->
        <div class="fee-container">
            <div class="label">১২। ট্রেড লাইসেন্স / নবায়ন ফি (বার্ষিক)</div>
            <div class="grid-container">
                <div>
                    <div class="sub-row"><span class="label">লাইসেন্স / নবায়ন ফি</span><span>:</span><span class="value">৳ <?= number_format($app['license_fee'], 2) ?></span></div>
                    <div class="sub-row"><span class="label">সারচার্জ</span><span>:</span><span class="value">৳ <?= number_format($app['surcharge'], 2) ?></span></div>
                    <div class="sub-row"><span class="label">আয়কর / উৎসকর</span><span>:</span><span class="value">৳ <?= number_format($app['tax'], 2) ?></span></div>
                    <div class="sub-row"><span class="label">বকেয়া</span><span>:</span><span class="value">৳ <?= number_format($app['due_amount'], 2) ?></span></div>
                    <div class="sub-row"><span class="label">সংশোধনী ফি</span><span>:</span><span class="value">৳ <?= number_format($app['amendment_fee'], 2) ?></span></div>
                </div>
                <div>
                    <div class="sub-row"><span class="label">সাইনবোর্ড কর</span><span>:</span><span class="value">৳ <?= number_format($app['signboard_fee'], 2) ?></span></div>
                    <div class="sub-row"><span class="label">ভ্যাট</span><span>:</span><span class="value">৳ <?= number_format($app['vat'], 2) ?></span></div>
                    <div class="sub-row"><span class="label">বই মূল্য</span><span>:</span><span class="value">৳ <?= number_format($app['book_price'], 2) ?></span></div>
                    <div class="sub-row"><span class="label">ফরম ফি</span><span>:</span><span class="value">৳ <?= number_format($app['form_fee'], 2) ?></span></div>
                    <div class="sub-row"><span class="label">অন্যান্য ফি</span><span>:</span><span class="value">৳ <?= number_format($app['other_fee'], 2) ?></span></div>
                    <div class="sub-row" style="border-top:1px solid #000;padding-top:2px;margin-top:2px;"><span class="label">সর্বমোট</span><span>:</span><span class="value">৳ <?= number_format($app['total_fee'], 2) ?></span></div>
                </div>
            </div>
        </div>

        <div class="validity-line">
            অত্র ট্রেড লাইসেন্স এর মেয়াদ <?= $app['license_validity_date'] ? date('d/m/Y', strtotime($app['license_validity_date'])) : '' ?> পর্যন্ত
        </div>
    </div>

    <!-- SIGNATURE -->
    <div class="signature-box">
        <div class="footer-signatures">
            <div class="sign-block">
                <img src="../assets/images/<?= $logoPrefix ?>_licence_sing.jpg" alt="Supervisor Sign">
                <div class="sign-label">লাইসেন্স ও বিজ্ঞাপন সুপারভাইজার</div>
                <div style="font-size:9px;color:#666;margin-top:3px;"><?= $corporation ?></div>
            </div>
            <div class="stamp-block">
                <img src="../assets/images/<?= $logoPrefix ?>_stemp.jpg" alt="Seal">
            </div>
            <div class="sign-block">
                <img src="../assets/images/<?= $logoPrefix ?>_tax_sing.jpg" alt="Tax Officer Sign">
                <div class="sign-label">কর কর্মকর্তা</div>
                <div style="font-size:9px;color:#666;margin-top:3px;"><?= $corporation ?></div>
            </div>
        </div>
    </div>

    <div style="text-align:center;font-size:8px;color:#888;margin-top:5px;padding-top:3px;border-top:1px solid #ddd;">
        <strong>অনলাইন সত্যতা যাচাই:</strong> <?= $verifyUrl ?>
    </div>
</div>

<script>window.print();</script>
</body>
</html>
