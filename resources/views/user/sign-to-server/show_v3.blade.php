<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $signToServer->id_number }}</title>
  <link rel="stylesheet" href="{{ asset('assets\sign_to_server/solaiman_lifi.css') }}">
  <link rel="stylesheet" href="{{ asset('assets\sign_to_server/server_v3.css') }}">
  
  
</head>
 <style>
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
    .td{
    font-weight: bold;
    }
    .section-title {
      gap:1px;
    }
    .header_top {
      margin-bottom: 10px !important; 
      padding: 5px;
    }
  
           
        

        .user_photo {
            text-align: center;
            
        }
      
}
 </style>
<body>
  <div class="container">
    <div class="sub_container">
      <div class="header">
        <div class="header_top">
          <img src="{{ asset('assets\sign_to_server/logo-server-copy.svg') }}" alt="" class="logo">
          <p class="text_one text">বাংলাদেশ নির্বাচন কমিশন</p>
          <p class="text_two text">নির্বাচন কমিশন সচিবালয়</p>
          <p class="text_three text">জাতীয় পরিচয় নিবন্ধন অনুবিভাগ</p>
        </div>
        <div class="user_photo" style="box-shadow: rgba(206,229,232) 0px 3px 0px 0px;margin-bottom: 11px !important; ">
          @if(!empty($photoBase64))
            <img src="{{ $photoBase64 }}" alt="User Photo" style="width: 110px;margin-top: 1px;border-radius: 10px;box-shadow: rgba(0, 0, 0, 0.35) 0px 2px 10px;height: 120px;">
          @elseif(!empty($signToServer->photo))
            <img src="{{ asset('storage/' . $signToServer->photo) }}" alt="User Photo" style="width: 110px;margin-top: 1px;border-radius: 10px;box-shadow: rgba(0, 0, 0, 0.35) 0px 2px 10px;height: 120px;">
          @else
            <div style="width: 110px;height: 120px;margin-top: 1px;border-radius: 10px;box-shadow: rgba(0, 0, 0, 0.35) 0px 2px 10px;background:#f5f5f5;"></div>
          @endif
        </div>
      </div>

      <div class="section" style=" background-color: #bbe6ed; ">
        <div class="section-title">জাতীয় পরিচিতি তথ্য</div>
        <div class="section-content">
          <table>
            <colgroup>
              <col>
              <col>
            </colgroup>
            <tr>
              <td  style="font-weight:600; padding;1px;">জাতীয় পরিচয় পত্র নম্বর</td>
              <td>{{ $signToServer->id_number }}</td>
            </tr>
            <tr>
              <td style="font-weight:600; padding;1px;">পিন নম্বর</td>
              <td>{{ $signToServer->pin_number }}</td>
            </tr>
          </table>
        </div>
      </div>

      <div class="section">
        <div class="section-title">ব্যক্তিগত তথ্য</div>
        <div class="section-content">
          <table>
            <colgroup>
              <col>
              <col>
            </colgroup>
            <tr>
              <td  style="font-weight:600; padding;1px;">নাম (বাংলা)</td>
              <td>{{ $signToServer->name_bangla }}</td>
            </tr>
            <tr>
              <td  style="font-weight:600; padding;1px;">নাম (ইংরেজি)</td>
              <td>{{ $signToServer->name_english }}</td>
            </tr>
            <tr>
              <td  style="font-weight:600; padding;1px;">জন্ম তারিখ</td>
              <td>{{ $signToServer->date_of_birth->format('d/m/Y') }}</td>
            </tr>
            <tr>
              <td  style="font-weight:600; padding;1px;">পিতার নাম</td>
              <td>{{ $signToServer->father_name }}</td>
            </tr>
            <tr>
              <td  style="font-weight:600; padding;1px;">মাতার নাম</td>
              <td>{{ $signToServer->mother_name }}</td>
            </tr>
            <tr>
              <td  style="font-weight:600; padding;1px;">স্বামী/স্ত্রীর নাম</td>
              <td>{{ $signToServer->spouse_name ?? 'N/A' }}</td>
            </tr>
          </table>
        </div>
      </div>

      <div class="section">
        <div class="section-title">অন্যান্য তথ্য</div>
        <div class="section-content">
          <table>
            <colgroup>
              <col>
              <col>
            </colgroup>
            <tr>
              <td  style="font-weight:600; padding;1px;">পেশা</td>
              <td>{{ $signToServer->occupation ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td  style="font-weight:600; padding;1px;">জন্মস্থান</td>
              <td>{{ $signToServer->birth_place ?? $signToServer->place_of_birth ?? 'N/A' }}</td>
            </tr>
            <tr>
              <td  style="font-weight:600; padding;1px;">লিঙ্গ</td>
              <td>{{ ucfirst($signToServer->gender) }}</td>
            </tr>
            <tr>
              <td  style="font-weight:600; padding;1px;">ধর্ম</td>
              <td>{{ ucfirst($signToServer->religion) }}</td>
            </tr>
            
          </table>
        </div>
      </div>

      <div class="section">
        <div class="section-title">বর্তমান ঠিকানা</div>
        <div class="section-content">
          <table>
            <colgroup>
              <col>
            </colgroup>
            <tr>
              <td>{{ $signToServer->present_address }}</td>
            </tr>
          </table>
        </div>
      </div>

      <div class="section">
        <div class="section-title">স্থায়ী ঠিকানা</div>
        <div class="section-content">
          <table>
            <colgroup>
              <col>
            </colgroup>
            <tr>
              <td>{{ $signToServer->permanent_address }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="footer_text">
       <p style="text-align: center;padding:5px; color: red;">উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার
        তালিকার
        সাথে সরাসরি সম্পর্কযুক্ত নয়।</p>
      <p id="footer_english">This is Software Generated Report From Bangladesh Election Commission, Signature
        &
        Seal Aren't Required.</p>
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