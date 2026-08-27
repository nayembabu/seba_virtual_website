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
		background-color: #FFFFFF;
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
			background-color: #5BEF0C !important;
		}

		.print {
			display: none !important;
		}
	}

#print {

    background: #5BEF0C;
    padding: 8px;
    width: 700px;
    height: 40px;
    border: 0px;
    font-size: 25px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: #5BEF0C;
    color: #5BEF0C;
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
	<img class="crane" src="{{ url('assets/nid') }}/cb11.png?ver=1.1" height="1000px" width="750px">
	
	<html>
<head>
    <style>
        .print-button {
            position: absolute;
            left: 89%;
            top: 11.55%;
            width: auto;
            font-size: 11px;
            color: #5BEF0C;
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
<div id="name_en2" style="position: absolute;font-weight: bold;left: 34%;top: 29%;height: 32px;width: 250px;font-size: 13px;color: rgb(7, 7, 7);margin: auto;align-items: center;" align="center">{{ $data->name_en }} </div>

	<div style="position: absolute;font-weight: bold; left: 11%; top: 33.8%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>জাতীয় পরিচিতি তথ্য</b></div>
	<div style="position: absolute;font-weight: bold; left: 11%; top: 36.8%; width: auto; font-size: 13px; color: rgb(7, 7, 7);">জাতীয় পরিচয় পত্র নম্বর</div>
	<div id="nid_no" style="position: absolute;font-weight: bold; left: 32%;;;; top: 36.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->nid_no }}</div>
	<div style="position: absolute;font-weight: bold; left: 11%; top: 39.8%; width: auto; font-size: 13px; color: rgb(7, 7, 7);">পিন নাম্বার</div>
	<div id="nid_father" style="position: absolute;font-weight: bold; left: 32%;;;; top: 39.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->voter_area }}</div>
	<div style="position: absolute; font-weight: bold; left: 11%; top: 42.3%; width: auto; font-size: 13px; color: rgb(7, 7, 7);">ফরম নাম্বার </div>
<div id="nid_father" style="position: absolute; font-weight: bold; left: 32%; top: 42.3%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">
    NIDFN{{ mt_rand(100000000, 999999999) }}
</div>

	<div style="position: absolute;font-weight: bold; left: 11%; top: 67%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">স্বামী/স্ত্রীর নাম</div>
	<div id="nid_mother" style="position: absolute; font-weight: bold;left: 32%;;;; top: 67%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ @$data->spouse }}</div>
	<div style="position: absolute;font-weight: bold; left: 11%; top: 44.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">ভোটার নম্বার</div>
	<div id="voter_number" style="position: absolute; font-weight: bold; left: 32%; top: 44.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">
    @php
        $pin = $data->voter_area; // assuming pin number is stored in $data->voter_area
        $voterNumber = substr($pin, 4); // extract from the 5th character onwards
        echo $voterNumber;
    @endphp
</div>
	<div style="position: absolute;font-weight: bold; left: 11%; top: 47.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">ভোটার এলাকা</div>
	<div id="voter_area" style="position: absolute;font-weight: bold; left: 32%;;;; top: 47.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->voter_area }}</div>
	<div style="position: absolute; left: 11%; top: 50.5%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>ব্যক্তিগত তথ্য</b></div>
	<div style="position: absolute; left: 11%; top: 53.1%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><b>নাম (বাংলা)<b></div>
	<div id="name_bn" style="position: absolute; font-weight: bold; left: 32%;;; top: 53.1%; width: auto; font-size: 14px; color: rgb(7, 7, 7);"><b>{{ $data->name_bn }}<b></div>
	<div style="position: absolute; left: 11%; top: 56%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">নাম (ইংরেজি)</div>
	<div id="name_en" style="position: absolute; left: 32%;;;; top:56%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->name_en }}</div>
	<div style="position: absolute; left: 11%; top:59%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">জন্ম তারিখ</div>
	<div id="dob" style="position: absolute; left: 32%;;;; top: 59%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->dob }}</div>
	<div style="position: absolute; left: 11%; top: 61.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">পিতার নাম</div>
	<div id="fathers_name" style="position: absolute; left: 32%;;;; top: 61.5%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->fathers_name }}</div>
	<div style="position: absolute; left: 11%; top: 64.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">মাতার নাম</div>
	<div id="mothers_name" style="position: absolute; left: 32%;;;; top: 64.2%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->mothers_name }}</div>
	<div style="position: absolute; left: 11%; top: 69.5%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>অন্যান্য তথ্য</b></div>
	<div style="position: absolute; left: 11%; top: 72.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">লিঙ্গ</div>
	<div id="gender" style="position: absolute; left: 32%;;;; top: 72.8%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">@if ($data->gender == 'male')
	পুরুষ
	@else
	মহিলা
	@endif</div>
	<div style="position: absolute; left: 11%; top: 75.3%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">শিক্ষাগত যোগ্যতা </div>
<div id="mobile_no" style="position: absolute; left: 32%;;;; top: 75.3%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">
    {{ 'তথ্য নাই' }}
</div>

	
	<div style="position: absolute; left: 11%; top: 78%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">জন্মস্থান</div>
	<div id="district" style="position: absolute; left: 32%;;;; top: 78%; width: auto; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->district}}</div>
	<div style="position: absolute; left: 11%; top: 80.8%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>বর্তমান ঠিকানা</b></div>
	<div id="present_addr" style="position: absolute; left: 11%; top: 83.8%; width: 80%; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->present_addr }}</div>
	<div style="position: absolute; left: 11%; top: 88%; width: auto; font-size: 16px; color: rgb(7, 7, 7);"><b>স্থায়ী ঠিকানা</b></div>
	<div id="permanent_addr" style="position: absolute; left: 11%; top: 91%; width: 80%; font-size: 14px; color: rgb(7, 7, 7);">{{ $data->permanent_addr }}</div>
	<div style="position: absolute;  left: 42%; top: 15.7%; width: auto; font-size: 12px; color: rgb(3, 3, 3);">
	   <img id="photo" src="{{ $data->photo }}" height="140px" width="121px" style="border-radius: 10px"></div>
	<div style="position: absolute;  left: 17.5%; top: 44%; width: auto; font-size: 12px; color: rgb(3, 3, 3);">
	 
	
</div>



<style>
.dl-bar{text-align:center;padding:20px;margin-top:10px}
.dl-btn{display:inline-block;padding:12px 30px;margin:0 8px;background:#28a745;color:#fff;text-decoration:none;border-radius:6px;font-size:16px;font-weight:bold}
.dl-btn:hover{opacity:0.9}
.dl-btn.v2{background:#007bff}
.dl-btn.v3{background:#fd7e14}
</style>
<div class="dl-bar">
<a class="dl-btn" href="{{ route('user.server-copy-view',['id'=>$data->id,'type'=>'v1','download'=>'1']) }}">ডাউনলোড v1</a>
<a class="dl-btn v2" href="{{ route('user.server-copy-view',['id'=>$data->id,'type'=>'v2','download'=>'1']) }}">ডাউনলোড v2</a>
<a class="dl-btn v3" href="{{ route('user.server-copy-view',['id'=>$data->id,'type'=>'v3','download'=>'1']) }}">ডাউনলোড v3</a>
</div>
</body></html>