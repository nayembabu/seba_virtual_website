<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $signToServer->id_number }}</title>
  <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets\sign_to_server/server_v1.css') }}">
 

</head>
<style>
  p.text {
    line-height: 7px;
}
@media print {
    html, body {
      width: 210mm;
      height: 297mm;
      margin: 0;
      padding: 0;
      font-size: 11px;
      background: #fff;
    }
    .container {
      page-break-inside: avoid;
      width: 100% !important;
      max-width: 100% !important;
      margin: 0 !important;
      padding: 0 !important;
    }
    table {
      width: 100% !important;
      font-size: 11px !important;
      page-break-inside: avoid !important;
    }
    .section, .section-content, .header, .sub_container {
      page-break-inside: avoid !important;
    }
    .footer_text {
      page-break-inside: avoid !important;
    }
    /* Remove print header/footer from browser */
    @page {
      size: A4 portrait;
      margin: 10mm;
    }
  }
</style>  
<body>

  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0;">
     
    </div>
    <div style="text-align:center; margin-bottom:10px;">
      <img src="{{ asset('assets\sign_to_server/logo-server-copy.svg') }}" alt="" style="height:60px; margin-bottom:5px;">
       
      <div style="font-size:18px; font-weight:bold;">বাংলাদেশ নির্বাচন কমিশন</div>
      <div style="font-size:15px;">নির্বাচন কমিশন সচিবালয়</div>
      <div style="font-size:14px;">জাতীয় পরিচয় নিবন্ধন অনুবিভাগ</div>
    </div>
    <div style="text-align:center; margin-bottom:10px;">
      @if(!empty(
          $photoBase64
      ))
        <img src="{{ $photoBase64 }}" alt="" style="height:70px; width:70px; object-fit:cover; border-radius:6px; border:1px solid #ccc;">
      @elseif(!empty($signToServer->photo))
        <img src="{{ asset('storage/' . $signToServer->photo) }}" alt="" style="height:70px; width:70px; object-fit:cover; border-radius:6px; border:1px solid #ccc;">
      @else
        <div style="height:70px; width:70px; display:inline-block; background:#f5f5f5; border-radius:6px; border:1px dashed #ccc;"></div>
      @endif
    </div>
    <div class="sub_container">
      <table style="width:100%; max-width:500px; margin:0 auto; border-collapse:collapse; background:#fff;">
        <tr><th colspan="2" style="background:#bde6ee;text-align:left; font-size:16px;">জাতীয় পরিচিতি তথ্য</th></tr>
        <tr><td style="width:40%;font-weight:bold;">জাতীয় পরিচয় পত্র নম্বর</td><td>{{ $signToServer->id_number }}</td></tr>
        <tr><td style="font-weight:bold;">পিন নম্বর</td><td>{{ $signToServer->pin_number }}</td></tr>
        <tr><td style="font-weight:bold;">ভোটার এলাকা</td><td>{{ $signToServer->voter_area }}</td></tr>
        <tr><th colspan="2" style="background:#bde6ee;text-align:left; font-size:16px;">ব্যক্তিগত তথ্য</th></tr>
        <tr><td style="font-weight:bold;">নাম (বাংলা)</td><td>{{ $signToServer->name_bangla }}</td></tr>
        <tr><td style="font-weight:bold;">নাম (ইংরেজি)</td><td>{{ $signToServer->name_english }}</td></tr>
        <tr><td style="font-weight:bold;">জন্ম তারিখ</td><td>{{ $signToServer->date_of_birth->format('d/m/Y') }}</td></tr>
        <tr><td style="font-weight:bold;">পিতার নাম</td><td>{{ $signToServer->father_name }}</td></tr>
        <tr><td style="font-weight:bold;">মাতার নাম</td><td>{{ $signToServer->mother_name }}</td></tr>
        <tr><th colspan="2" style="background:#bde6ee;text-align:left; font-size:16px;">অন্যান্য তথ্য</th></tr>
        <tr><td style="font-weight:bold;">লিঙ্গ</td><td>{{ ucfirst($signToServer->gender) }}</td></tr>
        <tr><td style="font-weight:bold;">অভিবাসন</td><td>{{ $signToServer->occupation ?? 'N/A' }}</td></tr>
        <tr><td style="font-weight:bold;">ধর্ম</td><td>{{ ucfirst($signToServer->religion) }}</td></tr>
        <tr><td style="font-weight:bold;">শিক্ষাগত যোগ্যতা</td><td>{{ $signToServer->education ?? 'N/A' }}</td></tr>
        <tr><th colspan="2" style="background:#bde6ee;text-align:left; font-size:16px;">বর্তমান ঠিকানা</th></tr>
        <tr>
          <td colspan="2">{{ $signToServer->present_address }}</td>
        </tr>
        <tr><th colspan="2" style="background:#bde6ee;text-align:left; font-size:16px;">স্থায়ী ঠিকানা</th></tr>
        <tr> <td colspan="2">{{ $signToServer->permanent_address }}</td></tr>
      </table>
      <div class="footer_text" style="margin-top:20px;">
        <p style="text-align: center; color: red; font-size:13px;">উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার তালিকার সাথে সরাসরি সম্পর্কযুক্ত নয়।</p>
        <p id="footer_english" style="text-align:center; font-size:12px;">This is Software Generated Report From Bangladesh Election Commission, Signature & Seal Aren't Required.</p>
      </div>
    </div>
  </div>
</body>
<script src="{{ asset('assets\sign_to_server/server_vs1.js') }}"></script>

<script disable-devtool-auto="" src="https://cdn.jsdelivr.net/npm/disable-devtool@latest"></script>
<script src="{{ asset('assets\sign_to_server/disabled.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('contextmenu', function (e) {
      e.preventDefault();
    });

    document.onkeydown = function (e) {
      if (e.ctrlKey && (e.key === 'u' || e.key === 'c' || e.key === 's')) {
        e.preventDefault();
      }
    };


  });
  window.onload = function () { setTimeout(wp, 500); }; function wp() { window.print(); }
</script>
</html>