
<html lang="en,bn">
<head>

	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>E-Trade License</title>
	<link href="https://surokkha.gov.bd/favicon.png" rel="icon">
	<link href="https://surokkha.gov.bd/favicon.png" rel="apple-touch-icon">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/css2?family=Solaiman+Lipi&display=swap" rel="stylesheet">
</head>

<div class="background">
	<img class="crane" src="{{ url('assets/nid') }}/cb123.png" height="1000px" width="750px">
	<div id="union_name" style="position: absolute;font-weight: bold; left: 50%; top: 5%; transform: translateX(-50%); width: auto; font-size: 16px; color: green;"><?php echo $data['union_name']; ?></div>
<div id="union_address" style="position: absolute;font-weight: bold; left: 50%; top: 7%; transform: translateX(-50%); width: auto; font-size: 16px; color: red;"><?php echo $data['union_address']; ?></div>
<div style="position: absolute; left: 50%; top: 8.8%; transform: translateX(-50%); width: auto; font-size: 9px; color: black;">ওয়েবসাইট : www.upsheba.com.bd</b></div>

	<div style="position: absolute; left: 6.4%; top: 16.5%;width: auto;font-size: 10px; color: black;">লাইসেন্স ইস্যুর বিবরন:</div>
<div style="position: absolute; left: 6.4%; top: 20.6%;width: auto;font-size: 10px; color: black;" id="issue_date">ইস্যুর তারিখ:</div>
<div style="position: absolute; left: 6.4%; top: 18.6%;width: auto;font-size: 10px; color: black;" id="issue_time">ইস্যুর সময়:</div>

	<div style="position: absolute; left: 6.4%; top: 23.3%;width:88.1%;font-size: 10px; color: black;">স্থানীয় সরকার (ইউনিয়ন পিরষদ) আইন, ২০০৯ (২০০৯ সেনর ৬১ নং আইন) এর ধারা ৬৬  প্রদত্ত ক্ষমতা বলে সরকার প্রনীত আদর্শ কর  তফিসল, ২০১৩ এর ৬ ও ১৭ নং অনুচ্ছেদ অনুযায়ী  ব্যাবসা, বৃত্তী, পেশা বা শিল্প  প্রতিষ্টানের  উপর আরোপিত কর আদায়ের লক্ষে নির্ধারিত শর্তে নিন্মবর্ণিত ব্যক্তি/প্রতিষ্টানের অনুকূলে এই ট্রেড লাইসেন্সটি ইস্যু করা হল:</div>
	<div style="position: absolute; left: 39%; top: 20.5%;width: auto;font-size: 10px; color: black;">ট্রেড লাইসেন্স নং:</b></div>
    <div id="trade_no" style="position: absolute; left: 50%; top: 20.5%; width: auto; font-size: 11px; color: black;"><?php echo $data['trade_no']; ?>  </div>
	
	<html>
<head>
    
</head>
<body>
   
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Solaiman+Lipi&display=swap" rel="stylesheet">
<style>
    

    body {
        body {
               width: 210mm !important;
               height: 297mm !important;
               background-color: #fff !important;
               overflow: hidden;
            }
        font-family: 'Noto Sans Bengali', Arial, sans-serif; /* Use a font that supports Bengali characters and numerals */
    }

    /* Apply the font to specific elements */
    bangla-text {
        font-family: 'Noto Sans Bengali', Arial, sans-serif;
    }

    .background {
        background-color: white;
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

    #present_addr,
    #permanent_addr {
        text-align: left;
    }
</style>


<script>
    // Function to get current date and time in the desired format
    function getCurrentDateTime() {
        var now = new Date();
        var date = now.toLocaleDateString('bn-BD'); // Date format in Bengali
        var time = now.toLocaleTimeString('bn-BD'); // Time format in Bengali
        return { date: date, time: time };
    }

    // Function to update the div elements with current date and time
    function updateDateTime() {
        var dateTime = getCurrentDateTime();
        document.getElementById('issue_date').innerHTML = 'ইস্যুর তারিখ: ' + dateTime.date;
        document.getElementById('issue_time').innerHTML = 'ইস্যুর সময়: ' + dateTime.time;
    }

    // Call the function initially to set the current date and time
    updateDateTime();

    // Function to execute when printing
    function beforePrint() {
        updateDateTime(); // Update the time before printing
    }

    // Attach the beforePrint function to the beforeprint event
    window.addEventListener('beforeprint', beforePrint);
</script>

<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>


<div id="qrCodeContainer" style="position: absolute; left: 8%; top: 6%;"></div>

<script>
    // Function to generate the QR code
    function generateQRCode(tradeNo) {
        // Concatenate the trade number with the verification link
        var verificationLink = 'https://upsheba.com.bd/user/trade/verify/' + tradeNo;

        // Create a new div element for the QR code
        var qrCodeContainer = document.getElementById('qrCodeContainer');
        var qrCodeDiv = document.createElement('div');

        // Generate the QR code inside the new div element
        new QRCode(qrCodeDiv, {
            text: verificationLink,
            width: 90,
            height: 90
        });

        // Append the QR code div to the container
        qrCodeContainer.appendChild(qrCodeDiv);
    }

    // Call the function to generate the QR code with the trade number
    generateQRCode('<?php echo $data['id']; ?>');
</script>


</body>
</html>

 

	<div style="position: absolute; left: 43%; top: 17.3%;font-weight: bold; width: auto; font-size: 16px; color: red;"class="bangla-text">ট্রেড লাইসেন্স</b></div>
	

	<div style="position: absolute; left: 6.4%; top: 27.7%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">১। ব্যাবসা প্রতিষ্ঠানের নাম: </div>
	<div id="b_name" style="position: absolute;font-weight: bold; left: 22%; top: 27.7%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['b_name']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 30%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">২। স্বত্বাধীকারী/লাইসেন্সধারীর নাম: </div>
	<div id="malik_name" style="position: absolute;font-weight: bold; left: 26%; top: 30%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['malik_name']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 32%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">৩। পিতার নাম: </div>
	<div id="father_name" style="position: absolute;font-weight: bold; left: 15%; top: 32%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['father_name']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 34%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">৪। মাতার নাম: </div>
	<div id="mother_name" style="position: absolute;font-weight: bold; left: 15%; top: 34%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['mother_name']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 36%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">৫। স্ত্রীর নাম (প্রযোজ্য ক্ষেত্রে):</div>
	<div id="wife_name" style="position: absolute;font-weight: bold; left: 24%; top: 36%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['wife_name']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 38%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">৬। ব্যবসার প্রকৃতি ( একক/যৈাথ/একক ):</div>
	<div id="malik_type" style="position: absolute; font-weight: bold; left: 30%; top: 38%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['malik_type']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 40.5%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">৭। ব্যবসার ধরন:</div>
	<div id="b_type" style="position: absolute;font-weight: bold; left: 17%; top:40.5%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['b_type']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 43%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">৮। ব্যবসা প্রতিষ্ঠানের ঠিকানা: </div>
	<div id="bu_name" style="position: absolute;font-weight: bold; left: 24%; top: 43%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['bu_name']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 46%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">৯। কর-অঞ্চল (প্রযোজ্য ক্ষেত্রে  ) :<b> প্রযোজ্য নয়</b> </div>
	

	<div style="position: absolute; left: 6.4%; top: 49%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">১০। এন.আই.ডি / পাসপোর্ট/ জন্ম নিবন্ধন নম্বর: </div>
	<div id="nid_no" style="position: absolute;font-weight: bold; left: 32.5%; top: 49%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['nid_no']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 52%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">১১। অর্থবছর: </div>
	<div id="account_year" style="position: absolute;font-weight: bold; left: 15%; top: 52%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['account_year']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top: 55.7%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">১২। মালিক/স্বত্বাধীকারীর বর্তমান ঠিকানা:</div>
	<div id="address" style="position: absolute; font-weight: bold;left: 8%; top: 57.8%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['address']; ?>  </div>
		<div style="position: absolute; left: 70%; top: 55.7%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text"> মালিক/স্বত্বাধীকারীর স্থায়ী ঠিকানা:</div>
	<div id="address" style="position: absolute;font-weight: bold; left: 70%; top: 57.8%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"><?php echo $data['address']; ?>  </div>
	
	<div style="position: absolute; left: 6.4%; top:65%; width: auto; font-size: 10px; color: rgb(7, 7, 7);"class="bangla-text">১৩। আদর্শ কর তফসিল, ২০১৩ এর ক্রমিক নং: ৩৩৭</div>
	

	
	<div style="position: absolute; left: 6.4%; top:68%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text">১৪। ট্রেড লাইসেন্স ফি  ( নতুন):</div>
	<div id="fee" style="position: absolute; left: 30%; top: 68%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['fee']; ?>    টাকা।  </div>
	<div style="position: absolute; left: 9%; top:70%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text">পারমিট ফি:</div>
	<div id="permit_fee" style="position: absolute; left: 30%; top: 70%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['permit_amount']; ?>   টাকা।  </div>
	<div style="position: absolute; left: 9%; top:72%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text">সার্ভিস চার্জ:</div>
	<div id="charge_amount" style="position: absolute; left: 30%; top: 72%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['charge_amount']; ?>   টাকা।  </div>
	<div style="position: absolute; left: 9%; top:74%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text">বকেয়া:</div>
	<div id="due_amount" style="position: absolute; left: 30%; top: 74%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['due_amount']; ?>   টাকা।  </div>
	<div style="position: absolute; left: 9%; top:76%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text">সারচার্জ:</div>
	<div id="others_amount" style="position: absolute; left: 30%; top: 76%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['others_amount']; ?>   টাকা।  </div>
	<div style="position: absolute; left: 60%; top:68%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text"class="bangla-text">পেশা ব্যবসা ও বৃত্তির উপর কর :</div>
	<div id="income_amount" style="position: absolute; left: 85%; top: 68%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['income_amount']; ?>   টাকা।  </div>
	<div style="position: absolute; left: 60%; top:70%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text">সাইনবোর্ড (পরিচিতিমূলক) :</div>
	<div id="sine_amount" style="position: absolute; left: 85%; top: 70%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['sine_amount']; ?>   টাকা।  </div>
	<div style="position: absolute; left: 60%; top:72%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text">আয়কর/উৎস কর : </div>
	<div id="tax_amount" style="position: absolute; left: 85%; top: 72%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['tax_amount']; ?>   টাকা।  </div>
	<div style="position: absolute; left: 60%; top:74%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text">ভ্যাট :</div>
	<div id="vat_amount" style="position: absolute; left: 85%; top: 74%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['vat_amount']; ?>    টাকা। </div>
	<div style="position: absolute; left: 60%; top:76%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"class="bangla-text">সংশোধন ফি:</div>
	<div id="cr_amount" style="position: absolute; left: 85%; top: 76%; width: auto; font-size: 8px; color: rgb(7, 7, 7);"><?php echo $data['cr_amount']; ?>   টাকা।  </div>
	

	<div style="position: absolute; left: 7%;;top: 80%;width: 100%;font-size: 14px;color: rgb(255, 0, 0);"class="bangla-text">অত্র ট্রেড লাইসেন্স এর মেয়াদ:</div>
	<div id="ex_date" style="position: absolute; left: 32%; top: 80%; width: auto; font-size: 14px; color: rgb(255, 0, 0);"><?php echo $data['ex_date']; ?>  পর্যন্ত  </div>

	<div style="position: absolute; left: 66%;;top: 80%;width: 80%;font-size: 13px;color: rgb(3, 3, 3);"class="bangla-text">সর্বমোট: </div>
	<div id="total_amount" style="position: absolute; left: 75%; top: 80%; width: auto; font-size: 13px; color: rgb(7, 7, 7);"><?php echo $data['total_amount']; ?> টাকা মাত্র।  </div>
	
<div style="position: absolute; left: 20%; bottom: 13%; transform: translateX(-50%); width: 80%; font-size: 8px; color: rgb(3, 3, 3); text-align: center;" class="bangla-text">সচিব</div>
<div id="union_name" style="position: absolute; left: 20%; bottom: 10%; transform: translateX(-50%); width: auto; font-size: 8px; color: black;"><?php echo $data['union_name']; ?></div>
<div id="union_address" style="position: absolute; left: 20%; bottom: 9%; transform: translateX(-50%); width: auto; font-size: 8px; color: black;"><?php echo $data['union_address']; ?></div>



<div style="position: absolute; left: 80%; bottom: 13%; transform: translateX(-50%); width: 80%; font-size: 8px; color: rgb(3, 3, 3); text-align: center;" class="bangla-text">চেয়ারম্যান</div>
<div id="union_name" style="position: absolute; left: 80%; bottom: 10%; transform: translateX(-50%); width: auto; font-size: 8px; color: black;"><?php echo $data['union_name']; ?></div>
<div id="union_address" style="position: absolute; left: 80%; bottom: 9%; transform: translateX(-50%); width: auto; font-size: 8px; color: black;"><?php echo $data['union_address']; ?></div>

	
	

	   

	 




</body></html>