<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>প্রতিবন্ধী সনদপত্র · টেমপ্লেট</title>
    <style>
        /* ----- রিসেট ও ফন্ট ----- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #eef1f7;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 15px;
            font-family: 'Noto Sans Bengali', 'Poppins', system-ui, sans-serif;
            min-height: 100vh;
        }

        /* ----- মূল কার্ড কন্টেইনার ----- */
        .card {
            max-width: 700px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px -10px rgba(0, 20, 40, 0.25);
            padding: 28px 30px 18px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 215, 0, 0.25);
            transition: all 0.2s;
            position: relative;
        }

        /* ----- সোনালি হেডার ব্যানার ----- */
        .gold-banner {
            background: linear-gradient(145deg, #f9d423, #f4b400);
            text-align: center;
            padding: 8px 12px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 1px;
            color: #1a2a3a;
            margin-bottom: 18px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            text-transform: uppercase;
            border: 1px solid #e6b422;
        }

        /* ----- সরকারি হেডার (লোগো + টাইটেল) ----- */
        .gov-header {
            text-align: center;
            margin-bottom: 16px;
        }

        .gov-logo {
            width: 54px;
            height: 54px;
            display: block;
            margin: 0 auto 4px;
        }

        .gov-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1a2b4a;
            letter-spacing: 0.3px;
        }

        .gov-sub {
            font-size: 0.75rem;
            color: #3d5277;
            margin-bottom: 2px;
        }

        .card-main-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0a1f44;
            margin-top: 2px;
            border-bottom: 2px solid #f0c000;
            display: inline-block;
            padding-bottom: 2px;
            padding-inline: 14px;
        }

        /* ----- ইনফো গ্রিড (টেবল-স্টাইল) ----- */
        .info-grid {
            display: grid;
            grid-template-columns: 130px 18px 1fr;
            gap: 6px 0;
            margin: 14px 0 10px;
            font-size: 0.95rem;
            background: #fafcff;
            padding: 12px 14px;
            border-radius: 18px;
            border: 1px solid #e6ecf5;
        }

        .info-grid .label {
            font-weight: 600;
            color: #1f3457;
            padding: 3px 0;
        }

        .info-grid .colon {
            text-align: center;
            color: #8896b0;
            font-weight: 300;
        }

        .info-grid .value {
            font-weight: 500;
            color: #0a1a33;
            padding: 3px 0;
            word-break: break-word;
        }

        .value.highlight-bg {
            background: #f3f7ff;
            padding: 0 10px;
            border-radius: 30px;
            display: inline-block;
            font-weight: 600;
            color: #00337a;
        }

        /* ----- বিশেষ অংশ: ঠিকানা (স্প্যান) ----- */
        .address-line {
            display: block;
            font-size: 0.92rem;
            line-height: 1.4;
        }

        /* ----- ফুটার অংশ ----- */
        .card-footer {
            margin-top: 14px;
            border-top: 1.5px dashed #d3dcec;
            padding-top: 12px;
            text-align: center;
        }

        .id-number-large {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #1c2d4f;
            font-family: 'Courier New', monospace;
            background: #eef3fc;
            padding: 4px 18px;
            border-radius: 60px;
            display: inline-block;
        }

        .ref-text {
            font-size: 0.75rem;
            color: #4a5f82;
            margin-top: 6px;
        }

        .footer-note {
            font-size: 0.7rem;
            color: #4f658a;
            border-top: 1px solid #e0e7f2;
            margin-top: 12px;
            padding-top: 8px;
            text-align: center;
        }

        /* ----- মোবাইল রেসপন্সিভ ----- */
        @media (max-width: 550px) {
            .card {
                padding: 18px 14px;
            }
            .info-grid {
                grid-template-columns: 1fr;
                gap: 2px 0;
                padding: 10px 12px;
            }
            .info-grid .colon {
                display: none;
            }
            .info-grid .label {
                border-bottom: 1px dotted #dce3f0;
                padding-bottom: 0px;
                font-size: 0.85rem;
            }
            .info-grid .value {
                padding-bottom: 10px;
                margin-bottom: 4px;
                border-bottom: 1px solid #eaeef6;
            }
            .info-grid .value:last-of-type {
                border-bottom: none;
            }
            .card-main-title {
                font-size: 1rem;
                padding-inline: 8px;
            }
            .id-number-large {
                font-size: 1.1rem;
            }
        }

        /* ---------- বাংলা ফন্ট সাপোর্ট ---------- */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;600;700&display=swap');
    </style>
</head>
<body>

    <!-- ========================================= -->
    <!-- ১ম কার্ড : বাংলা (প্রতিবন্ধী সনদ)        -->
    <!-- ========================================= -->
    <div class="card">
        <!-- সোনালি শীর্ষ -->
        <div class="gold-banner">🏅 সুবর্ণ নাগরিক</div>

        <!-- সরকারি হেডার -->
        <div class="gov-header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/84/Government_Seal_of_Bangladesh.svg" alt="বাংলাদেশ সীল" class="gov-logo" />
            <div class="gov-title">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</div>
            <div class="gov-sub">সমাজসেবা অধিদপ্তর, সমাজকল্যাণ মন্ত্রণালয়</div>
            <div class="card-main-title">প্রতিবন্ধী সনদপত্র</div>
        </div>

        <!-- তথ্য গ্রিড (বাংলা) -->
        <div class="info-grid">
            <span class="label">নাম</span>
            <span class="colon">:</span>
            <span class="value"><strong>আছরা বরম</strong></span>

            <span class="label">মাতা</span>
            <span class="colon">:</span>
            <span class="value">আছমা বরম</span>

            <span class="label">পিতা</span>
            <span class="colon">:</span>
            <span class="value">—</span>

            <span class="label">প্রতিবন্ধী ধরণ</span>
            <span class="colon">:</span>
            <span class="value highlight-bg">দৃষ্টি প্রতিবন্ধী (VI)</span>

            <span class="label">মোবাইল নম্বর</span>
            <span class="colon">:</span>
            <span class="value">০১**********</span>

            <span class="label">জন্ম তারিখ</span>
            <span class="colon">:</span>
            <span class="value">০১-০২-১৯৮৩</span>

            <span class="label">স্মার্ট নম্বর</span>
            <span class="colon">:</span>
            <span class="value" style="font-family: monospace; letter-spacing: 0.5px;">19831219058731154-04</span>

            <span class="label">ঠিকানা</span>
            <span class="colon">:</span>
            <span class="value">
                <span class="address-line">নূরপুর, গে-কপুর,</span>
                <span class="address-line">নাসিরনগর, ব্রাহ্মণবাড়িয়া</span>
            </span>
        </div>

        <!-- ফুটার : বড় আইডি + সতর্কতা -->
        <div class="card-footer">
            <div class="id-number-large">GC / ০০০১২৩ / ২০২৬</div>
            <div class="ref-text">স্মার্ট আইডি: 19831219058731154-04</div>
            <div class="footer-note">
                ⚠️ সনদপত্র হারানো গেলে নিকটস্থ থানায় সাধারণ ডায়েরি করে জানালে পুনরায় প্রদান করা হবে।
            </div>
        </div>
    </div>

    <!-- ========================================= -->
    <!-- ২য় কার্ড : ইংরেজি (ব্যাক/ডুপ্লিকেট)      -->
    <!-- ========================================= -->
    <div class="card">
        <div class="gold-banner">⭐ GOLDEN CITIZEN</div>

        <div class="gov-header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/84/Government_Seal_of_Bangladesh.svg" alt="Bangladesh Seal" class="gov-logo" />
            <div class="gov-title">Government of the People's Republic of Bangladesh</div>
            <div class="gov-sub">Department of Social Services, Ministry of Social Welfare</div>
            <div class="card-main-title">Disability ID Certificate</div>
        </div>

        <!-- ইনফো গ্রিড (ইংরেজি) -->
        <div class="info-grid">
            <span class="label">Name</span>
            <span class="colon">:</span>
            <span class="value"><strong>Achara Baram</strong></span>

            <span class="label">Mother</span>
            <span class="colon">:</span>
            <span class="value">Achma Baram</span>

            <span class="label">Father</span>
            <span class="colon">:</span>
            <span class="value">—</span>

            <span class="label">Disability Type</span>
            <span class="colon">:</span>
            <span class="value highlight-bg">Visual Impairment (VI)</span>

            <span class="label">Mobile No.</span>
            <span class="colon">:</span>
            <span class="value">01**********</span>

            <span class="label">Date of Birth</span>
            <span class="colon">:</span>
            <span class="value">01-02-1983</span>

            <span class="label">Smart ID</span>
            <span class="colon">:</span>
            <span class="value" style="font-family: monospace; letter-spacing: 0.5px;">19831219058731154-04</span>

            <span class="label">Address</span>
            <span class="colon">:</span>
            <span class="value">
                <span class="address-line">Nurpur, Gekpur,</span>
                <span class="address-line">Nasirnagar, Brahmanbaria</span>
            </span>
        </div>

        <!-- ফুটার ইংরেজি -->
        <div class="card-footer">
            <div class="id-number-large">GC / 000123 / 2026</div>
            <div class="ref-text">Smart ID: 19831219058731154-04</div>
            <div class="footer-note">
                ⚠️ If lost, please report to the nearest police station for re-issue.
            </div>
        </div>
    </div>

    <!-- ========================================= -->
    <!-- ৩য় কার্ড : মিনিমাল ক্লিন (শুধু ডেটা)     -->
    <!-- ========================================= -->
    <div class="card" style="border-left: 4px solid #f4b400; border-radius: 20px 8px 8px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="background: #f4b400; padding: 2px 16px; border-radius: 30px; font-weight: 600; font-size: 0.8rem; color: #1a1a2c;">📋 সংক্ষিপ্ত</span>
            <span style="font-size: 0.7rem; color: #5372a0;">ভার্সন ২.০</span>
        </div>

        <div class="info-grid" style="background: transparent; border: none; padding: 0 0 6px 0;">
            <span class="label">নাম</span>
            <span class="colon">:</span>
            <span class="value">আছরা বরম</span>

            <span class="label">ধরণ</span>
            <span class="colon">:</span>
            <span class="value">দৃষ্টি (VI)</span>

            <span class="label">জন্ম</span>
            <span class="colon">:</span>
            <span class="value">০১-০২-১৯৮৩</span>

            <span class="label">ঠিকানা</span>
            <span class="colon">:</span>
            <span class="value">নাসিরনগর, ব্রাহ্মণবাড়িয়া</span>

            <span class="label">আইডি</span>
            <span class="colon">:</span>
            <span class="value" style="font-family: monospace;">19831219058731154-04</span>
        </div>

        <div style="font-size: 0.65rem; text-align: right; color: #5f7299; border-top: 1px solid #e2e8f2; padding-top: 6px; margin-top: 2px;">
            সর্বশেষ হালনাগাদ: ১০-১০-২০২৫
        </div>
    </div>

</body>
</html>