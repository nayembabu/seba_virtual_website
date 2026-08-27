<html lang="en">
<head>

	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>Server Copy</title>
	<link href="https://surokkha.gov.bd/favicon.png" rel="icon">
	<link href="https://surokkha.gov.bd/favicon.png" rel="apple-touch-icon">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
	<style>
	@page {
		size: A4;
		margin: 0px;
	}

	body {
		margin: 0;
	}

	.background {
		background-color: lightgrey;
		position: relative;
		width: 750px;
		height: 1065px;
		margin: auto;
	}

	.crane {
		max-width: 100%;
		height: 100%;
	}

	.topTitle {
		position: absolute;
		left: 21%;
		top: 8%;
		width: auto;
		font-size: 42px;
		color: rgb(255, 182, 47);
	}

	#loadMe {
		visibility: hidden;
	}

	@media print {
		html,body {
			width: 210mm;
			height: 297mm;
			background-color: #fff !important;
		}

		.print {
			display: none !important;
		}
	}

#print {

    background: #03a9f4;
    padding: 8px;
    width: 700px;
    height: 40px;
    border: 0px;
    font-size: 25px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 1px 4px 4px #878787;
    color: #fff;
    border-radius: 10px;
    margin: 20px;
    display: none;
}
#present_addr, #permanent_addr {
    text-align: left;
}
	</style>
</head>

<div class="background">
	<img class="crane" src="{{ url('assets/nid') }}/cb-old.jpg" height="1000px" width="750px">
	<div style="position: absolute; left: 30%; top: 8%;width: auto;font-size: 16px; color: rgb(255 224 0);"><b>National Identity Registration Wing (NIDW)</b></div>
	<div style="position: absolute; left: 37%; top: 11%;width: auto;font-size: 14px; color: rgb(255, 47, 161);"><b>Select Your Search Category</b></div>
	<div style="position: absolute; left: 45%; top: 12.8%;width: auto;font-size: 12px; color: rgb(8, 121, 4);">Search By NID / Voter No.</div>
	<div style="position: absolute; left: 45%; top: 14.3%;width: auto;font-size: 12px; color: rgb(7, 119, 184);">Search By Form No.</div>
	<div style="position: absolute; left: 30%; top: 16.9%;width: auto;font-size: 12px; color: rgb(252, 0, 0);"><b>NID or Voter No*</b></div>
	<div style="position: absolute; left: 45%; top: 16.9%; width: auto; font-size: 12px; color: rgb(143, 143, 143);">{{ $data->nid_no }}</div>
	<div style="position: absolute;left: 62.9%;top: 17.1%;width: auto;font-size: 11px;color: rgb(255 255 255);">Submit</div>
	<html>
<head>
    <style>
        .print-button {
            position: absolute;
            left: 89%;
            top: 11.55%;
            width: auto;
            font-size: 11px;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="print-button" onclick="window.print();">Print</div>
    <script>
  // Function to set the filename when printing
  function setPrintFileName() {
    var name_en = '{{ $data->name_en }}';
    if (name_en) {
      var fileName = name_en + '.pdf'; // You can change the extension to whatever you prefer
      document.title = fileName;
    }
  }

  // Call the function to set the file name
  setPrintFileName();
</script>

</body>
</html>
<div id="name_en2" style="position: absolute;font-weight: bold;left: 15.5%;top: 39.6%;height: 32px;width: 130px;font-size: 13px;color: rgb(7, 7, 7);margin: auto;align-items: center;" align="center">{{ $data->name_en }}</div>

	<div style="position: absolute; left: 37%; top: 27%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>জাতীয় পরিচিতি তথ্য</b></div>
	<div style="position: absolute; left: 37%; top: 29.7%; width: auto; font-size: 13px; color: rgb(7, 7, 7);">জাতীয় পরিচয় পত্র নম্বর</div>
	<div id="nid_no" style="position: absolute; left: 55%; top: 29.7%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->nid_no }}</div>
	<div style="position: absolute; left: 37%; top: 32.5%; width: auto; font-size: 13px; color: rgb(7, 7, 7);">পিন নাম্বার</div>
	<div id="nid_father" style="position: absolute; left: 55%; top: 32.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->voter_area }}</div>
	<div style="position: absolute; left: 37%; top: 35%; width: auto; font-size: 13px; color: rgb(7, 7, 7);">স্বামী/স্ত্রীর নাম</div>
	<div id="nid_mother" style="position: absolute; left: 55%; top: 35%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ @$data->spouse }}</div>
	<div style="position: absolute; left: 37%; top: 37.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">ভোটার নাম্বার</div>
	<div id="spouse" style="position: absolute; left: 55%; top: 37.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">@php
        $pin = $data->voter_area; // assuming pin number is stored in $data->voter_area
        $voterNumber = substr($pin, 4); // extract from the 5th character onwards
        echo $voterNumber;
    @endphp</div>
	<div style="position: absolute; left: 37%; top: 40.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">ফরম নাম্বার</div>
	<div id="nidMother" style="position: absolute; left: 55%; top: 40.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"> NIDFN{{ mt_rand(100000000, 999999999) }}</div>
	<div style="position: absolute; left: 37%; top: 43%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>ব্যক্তিগত তথ্য</b></div>
	<div style="position: absolute; left: 37%; top: 45.6%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><b>নাম (বাংলা)<b></div>
	<div id="name_bn" style="position: absolute; font-weight: bold; left: 55%; top: 45.6%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><b>{{ $data->name_bn }}<b></div>
	<div style="position: absolute; left: 37%; top: 48.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">নাম (ইংরেজি)</div>
	<div id="name_en" style="position: absolute; left: 55%; top:48.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->name_en }}</div>
	<div style="position: absolute; left: 37%; top: 51%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">জন্ম তারিখ</div>
	<div id="dob" style="position: absolute; left: 55%; top: 51%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->dob }}</div>
	<div style="position: absolute; left: 37%; top: 53.7%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">পিতার নাম</div>
	<div id="fathers_name" style="position: absolute; left: 55%; top: 53.7%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->fathers_name }}</div>
	<div style="position: absolute; left: 37%; top: 56.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">মাতার নাম</div>
	<div id="mothers_name" style="position: absolute; left: 55%; top: 56.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->mothers_name }}</div>
	<div style="position: absolute; left: 37%; top: 59%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>অন্যান্য তথ্য</b></div>
	<div style="position: absolute; left: 37%; top: 62.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">লিঙ্গ</div>
	<div id="gender" style="position: absolute; left: 55%; top: 62.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">@if ($data->gender == 'male')
	পুরুষ
	@else
	মহিলা
	@endif</div>
	<div style="position: absolute; left: 37%; top: 64.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">পেশা</div>
	<div id="mobile_no" style="position: absolute; left: 55%; top: 64.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ @$data->occupation }}</div>
	<div style="position: absolute; left: 37%; top: 67.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">ধর্ম</div>
	<div id="blood_grp" style="position: absolute; left: 55%; top: 67.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ ucfirst($data->religion) }}</div>
	<div style="position: absolute; left: 37%; top: 70%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">জন্মস্থান</div>
	<div id="birth_place" style="position: absolute; left: 55%; top: 70%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->district}}</div>
	<div style="position: absolute; left: 37%; top: 72.8%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>বর্তমান ঠিকানা</b></div>
	<div id="present_addr" style="position: absolute; left: 37%; top: 75.5%; width: 48%; font-size: 12px; color: rgb(7, 7, 7);">{{ $data->present_addr }}</div>
	<div style="position: absolute; left: 37%; top: 81.5%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>স্থায়ী ঠিকানা</b></div>
	<div id="permanent_addr" style="position: absolute; left: 37%; top: 84.3%; width: 48%; font-size: 12px; color: rgb(7, 7, 7);">{{ $data->permanent_addr }}</div>
	<div style="position: absolute;top: 92%;width: 100%;font-size: 12px;text-align: center;color: rgb(255, 0, 0);">উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার তালিকার সাথে সরাসরি সম্পর্কযুক্ত নয়।</div>
	<div style="position: absolute;top: 93.5%;width: 100%;text-align: center;font-size: 12px;color: rgb(3, 3, 3);">This is Software Generated Report From Bangladesh Election Commission, Signature &amp; Seal Aren't Required.</div>
	<div style="position: absolute;  left: 16%; top: 25.7%; width: auto; font-size: 12px; color: rgb(3, 3, 3);">
	   <img id="photo" src="{{ $data->photo }}" height="140px" width="121px" style="border-radius: 10px"></div>
	<div style="position: absolute;  left: 17.5%; top: 44%; width: auto; font-size: 12px; color: rgb(3, 3, 3);">
	    
	     @php
	   
    $qr = "https://verify.mygov.uno/nid/{$data->nid_no}";  // Changed to $data to match rest of template

	    @endphp
	    
	    {!! QrCode::encoding('UTF-8')->size(100)->generate($qr) !!}
	    
	</div>
	 
	<div id="name_en2" style="position: absolute;font-weight: bold;left: 15.5%;top: 39.6%;height: 32px;width: 130px;font-size: 13px;color: rgb(7, 7, 7);margin: auto;align-items: center;" align="center"></div>
</div>



</body></html>