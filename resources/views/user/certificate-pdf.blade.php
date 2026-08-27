<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<style>
@page { margin: 12mm 10mm; size: A4 portrait; }
body { font-family: 'noto serif bengali', 'nikosh', serif; margin: 0; padding: 0; background: #fff; color: #000; }
.royal-border { border: 3px solid #0369a1; outline: 2px solid #d97706; outline-offset: -6px; padding: 14px 20px; box-sizing: border-box; background: #fff; position: relative; }
.watermark { position: absolute; top: 50%; left: 50%; width: 320px; opacity: 0.08; z-index: 0; pointer-events: none; }
.digit-box { display: inline-block; border: 1px solid #0369a1; background: #f0f9ff; color: #0369a1; padding: 1px 4px; margin: 0 1px; font-family: monospace; font-weight: bold; font-size: 12px; border-radius: 2px; }
.cert-title-badge { display: inline-block; background: #0369a1; color: #fff; padding: 4px 24px; border-radius: 50px; font-size: 18px; font-weight: bold; line-height: 1.4; border: 2px solid #f59e0b; white-space: nowrap; }
.cert-text-p { font-size: 14px; line-height: 2.0; color: #1e293b; text-align: justify; margin-bottom: 0; }
.cert-table { width: 100%; border-collapse: collapse; margin-top: 6px; margin-bottom: 6px; font-size: 13px; }
.cert-table th { background: #f1f5f9; color: #0369a1; border: 1px solid #0369a1; padding: 4px 6px; text-align: center; font-weight: bold; }
.cert-table td { border: 1px solid #cbd5e1; padding: 4px 6px; text-align: center; color: #0f172a; }
.signature-box { text-align: center; width: 220px; position: relative; }
.signature-line { width: 100%; border-top: 2px solid #1e293b; margin-top: 20px; position: relative; z-index: 3; }
.signature-img { max-height: 40px; max-width: 130px; position: absolute; top: -18px; left: 50%; margin-left: -65px; z-index: 4; }
.custom-seal-en { position: absolute; top: 12px; left: 50%; margin-left: -110px; width: 220px; color: rgba(30,58,138,0.8); font-family: 'Arial', sans-serif; font-size: 8px; font-weight: bold; line-height: 1.2; text-transform: uppercase; text-align: center; white-space: pre-line; pointer-events: none; z-index: 1; }
</style>
</head>
<body>
<div class="royal-border">

    <img src="{{ asset('assets/images/gov-seal.svg') }}" class="watermark" onerror="this.style.display='none'" alt="Watermark" style="">

    <!-- HEADER -->
    <table width="100%" style="border-bottom:2px solid #0369a1;padding-bottom:6px;margin-bottom:6px;">
        <tr>
            <td width="15%" style="vertical-align:middle;">
                <img src="{{ asset('assets/images/gov-seal.svg') }}" width="70" height="70" alt="Emblem" onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/8/84/Government_Seal_of_Bangladesh.svg';">
            </td>
            <td width="70%" style="text-align:center;vertical-align:middle;">
                <h2 style="margin:0;color:#0369a1;font-weight:bold;font-size:22px;">{{ $cert->union_name ?: 'ইউনিয়ন পরিষদ' }}</h2>
                <p style="margin:2px 0;font-size:13px;font-weight:bold;color:#334155;">উপজেলা: {{ $cert->upazila ?: 'কুমিল্লা আদর্শ সদর' }}, জেলা: {{ $cert->present_district ?: 'কুমিল্লা' }}</p>
                <small style="color:#64748b;font-size:11px;font-weight:bold;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার - স্থানীয় সরকার বিভাগ</small>
            </td>
            <td width="15%" style="text-align:right;vertical-align:middle;">
                <div style="font-size:11px;font-weight:bold;color:#0f172a;background:#f1f5f9;padding:4px 8px;border-radius:4px;border:1px solid #cbd5e1;display:inline-block;">তারিখঃ {{ $cert->issue_date ? $cert->issue_date->format('d-m-Y') : date('d-m-Y') }}</div>
            </td>
        </tr>
    </table>

    <!-- SERIAL -->
    <div style="background:#f0f9ff;border:1px dashed #0284c7;padding:3px 10px;border-radius:4px;margin-bottom:8px;">
        <table width="100%"><tr>
            <td style="font-weight:bold;color:#0369a1;font-size:12.5px;">সনদপত্র নম্বর :</td>
            <td style="text-align:right;">
                @foreach(str_split($cert->certificate_no) as $d)
                    <span class="digit-box">{{ $d }}</span>
                @endforeach
            </td>
        </tr></table>
    </div>

    <!-- TITLE -->
    <div style="text-align:center;margin-bottom:8px;">
        <span class="cert-title-badge">
            @php
                $titles = [
                    'national' => 'জাতীয়তা সনদপত্র',
                    'warisan' => 'ওয়ারিশ সনদপত্র',
                    'character' => 'চারিত্রিক সনদপত্র',
                    'family' => 'পারিবারিক সনদপত্র',
                    'unmarried' => 'অবিবাহিত সনদপত্র',
                    'landless' => 'ভূমিহীন সনদপত্র',
                    'income' => 'বার্ষিক আয় সনদপত্র',
                    'remarriage' => 'পুনর্বিবাহ না হওয়া সনদপত্র'
                ];
            @endphp
            {{ $titles[$cert->cert_type] ?? 'জাতীয়তা সনদপত্র' }}
        </span>
    </div>

    <!-- BODY -->
    <p style="text-align:center;font-weight:bold;font-size:15px;color:#334155;margin-bottom:4px;margin-top:8px;">এই মর্মে প্রত্যয়ন করা যাইতেছে যে,</p>
    <p class="cert-text-p">
        নাম: <strong style="font-size:16px;color:#0369a1;">{{ $cert->applicant_name }}</strong>,
        এনআইডি / জন্ম নম্বর: <strong style="font-family:'noto serif bengali',monospace;font-size:14.5px;color:#0369a1;">{{ $cert->nid_no }}</strong>,
        পিতা: <strong>{{ $cert->father_name ?? '' }}</strong>,
        মাতা: <strong>{{ $cert->mother_name ?? '' }}</strong>,
        স্বামী/স্ত্রী: <strong>{{ $cert->spouse_name ?: 'প্রযোজ্য নয়' }}</strong>,
        ঠিকানা: গ্রাম/ওয়ার্ড: <strong>{{ $cert->present_village ?? '' }}</strong>,
        ডাকঘর: <strong>{{ $cert->present_post ?? '' }}</strong>,
        উপজেলা: <strong>{{ $cert->present_upazila ?? '' }}</strong>,
        জেলা: <strong>{{ $cert->present_district ?? '' }}</strong>।
    </p>

    @if(in_array($cert->cert_type, ['warisan', 'family']))
        @php $members = $cert->members ?: []; @endphp
        <div class="cert-text-p" style="margin-top:6px;">
            @if($cert->cert_type == 'warisan')
                তিনি উক্ত স্থায়ী পরিবারের একজন বৈধ নাগরিক। তথ্য যাচাই সাপেক্ষে নিম্নে বর্ণিত ব্যক্তিগণ তাঁহার বৈধ ওয়ারিশ/উত্তরাধিকারীঃ
            @else
                উক্ত নাগরিকের পরিবারে সক্রিয় ও নিবন্ধিত সদস্যদের বিস্তারিত তালিকা নিম্নে প্রদান করা হলোঃ
            @endif
        </div>
        @if(!empty($members) && is_array($members))
        <table class="cert-table">
            <thead><tr><th width="8%">ক্রমিক</th><th width="35%">সদস্যের নাম</th><th width="18%">সম্পর্ক</th><th width="14%">বয়স</th><th width="25%">এনআইডি / পরিচয় নম্বর</th></tr></thead>
            <tbody>
                @foreach($members as $i=>$m)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td style="text-align:left;font-weight:bold;">{{ $m['name'] ?? '' }}</td>
                    <td>{{ $m['relation'] ?? '' }}</td>
                    <td>{{ $m['age'] ?? '' }}</td>
                    <td style="font-family:'noto serif bengali',monospace;">{{ $m['nid'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <table class="cert-table">
            <thead><tr><th width="8%">ক্রমিক</th><th width="35%">সদস্যের নাম</th><th width="18%">সম্পর্ক</th><th width="14%">বয়স</th><th width="25%">এনআইডি / পরিচয় নম্বর</th></tr></thead>
            <tbody><tr><td colspan="5" style="text-align:center;">কোনো সদস্য তথ্য পাওয়া যায়নি</td></tr></tbody>
        </table>
        @endif
    @endif

    <div class="cert-text-p" style="margin-top:6px;">
        @php $type = $cert->cert_type; @endphp
        @if($type == 'national')
            তিনি এই কার্যালয়ের আওতাধীন এলাকার একজন স্থায়ী বাসিন্দা ও জন্মসূত্রে বাংলাদেশের নাগরিক। আমার জানা মতে, তিনি রাষ্ট্র বা সমাজ বিরোধী কোনো কর্মকাণ্ডে জড়িত নন। আমি তাঁর সর্বাঙ্গীন উন্নতি ও মঙ্গল কামনা করি।
        @elseif($type == 'character')
            তিনি একজন সৎ, বিনয়ী ও উত্তম চারিত্রিক বৈশিষ্ট্যের অধিকারী। আমার জানামতে তিনি রাষ্ট্রীয় বা সমাজবিরোধী কোনো অনৈতিক কর্মকাণ্ডের সাথে জড়িত নন। তাঁর স্বভাব-চরিত্র অত্যন্ত গঠনমূলক।
        @elseif($type == 'unmarried')
            আমার জানা মতে ও স্থানীয় তদন্ত সাপেক্ষে তিনি এ যাবৎ কোনো বিবাহ বন্ধনে আবদ্ধ হন নাই। তিনি বর্তমানে সম্পূর্ণ অবিবাহিত।
        @elseif($type == 'landless')
            আমার জানামতে এবং সরজমিনে তদন্ত মতে উক্ত ব্যক্তি ও তাঁহার পরিবারের নিজস্ব কোনো আবাদি বা বসতবাড়ির জমি জমা নাই। তিনি প্রকৃতপক্ষে একজন ভূমিহীন নাগরিক।
        @elseif($type == 'income')
            যাবতীয় বৈধ উৎস হতে তাঁহার ও তাঁহার পরিবারের সর্বমোট বার্ষিক আয় আনুমানিক <strong>{{ $cert->income_amount }}</strong> টাকা। আমার জানামতে উক্ত আয়ের বিবরণ সঠিক।
        @elseif($type == 'remarriage')
            আমার জানা মতে এবং স্থানীয়ভাবে অনুসন্ধানে জানা যায় যে, তিনি এ যাবৎ দ্বিতীয়বার বা পুনরায় কোনো প্রকার বিবাহ বন্ধনে আবদ্ধ হন নাই।
        @else
            তিনি এই কার্যালয়ের আওতাধীন এলাকার একজন স্থায়ী বাসিন্দা ও জন্মসূত্রে বাংলাদেশের নাগরিক। আমার জানা মতে, তিনি রাষ্ট্র বা সমাজ বিরোধী কোনো কর্মকাণ্ডে জড়িত নন। আমি তাঁর সর্বাঙ্গীন উন্নতি ও মঙ্গল কামনা করি।
        @endif
    </div>

    <!-- SIGNATURES -->
    <div style="margin-top:20px;">
        <table width="100%"><tr>
            <td style="text-align:center;width:50%;">
                <div class="signature-box" style="margin:0 auto;">
                    <img src="{{ asset('assets/images/signature-1.png') }}" class="signature-img" onerror="this.style.display='none'" alt="Signature 1">
                    <div class="signature-line"></div>
                    @if($cert->prepared_seal_en)
                    <div class="custom-seal-en">{{ $cert->prepared_seal_en }}</div>
                    @endif
                    <div style="font-size:12px;font-weight:bold;color:#0f172a;">{{ $cert->prepared_by ?: 'প্রস্তুতকারী' }}</div>
                    <div style="color:#475569;font-size:10.5px;font-weight:bold;">প্রস্তুতকারী / ইউপি সচিব</div>
                </div>
            </td>
            <td style="text-align:center;width:50%;">
                <div class="signature-box" style="margin:0 auto;">
                    <img src="{{ asset('assets/images/signature-2.png') }}" class="signature-img" onerror="this.style.display='none'" alt="Signature 2">
                    <div class="signature-line"></div>
                    @if($cert->authority_seal_en)
                    <div class="custom-seal-en">{{ $cert->authority_seal_en }}</div>
                    @endif
                    <div style="font-size:12px;font-weight:bold;color:#0369a1;">{{ $cert->authority_name ?: 'অনুমোদনকারী' }}</div>
                    <div style="color:#d97706;font-weight:bold;font-size:11px;">{{ $cert->authority_title ?: 'চেয়ারম্যান' }}</div>
                </div>
            </td>
        </tr></table>

        @php $verifyUrl = url('verify/' . $cert->certificate_no); @endphp
        <div style="border-top:1.5px solid #0369a1;padding-top:3px;margin-top:8px;">
            <table width="100%"><tr>
                <td style="font-size:9px;color:#334155;">
                    <strong>অনলাইন সত্যতা যাচাইঃ</strong>
                    ক্যামেরা বা কিউআর স্ক্যানার দিয়ে স্ক্যান করে অনলাইন পোর্টালে সনদের সত্যতা যাচাই করুন।
                    <br><span style="color:#64748b;font-family:'noto serif bengali',monospace;font-size:8.5px;">{{ $verifyUrl }}</span>
                </td>
                <td style="text-align:right;width:60px;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($verifyUrl) }}" width="48" height="48" alt="QR Code" style="border:1px solid #cbd5e1;padding:1px;background:#fff;">
                </td>
            </tr></table>
        </div>
    </div>

</div>
</body>
</html>
