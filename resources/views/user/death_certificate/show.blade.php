
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $certificate->mother_name_bengali }}</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css" integrity="sha512-NZ19NrT58XPK5sXqXnnvtf9T5kLXSzGQlVZL9taZWeTBtXoN3xIfTdxbkQh6QSoJfJgpojRqMfhyqBAAEeiXcA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
    <link rel="stylesheet" href="{{ asset('assets/death_certificate/nibondons.css') }}">


	<link rel="stylesheet" href="https://cdn.rawgit.com/sh4hids/bangla-web-fonts/solaimanlipi/stylesheet.css">
	<link href="https://fonts.cdnfonts.com/css/solaimanlipi" rel="stylesheet">
	<style>
		@page {
			margin: 0;
			size: A4;
		}

		.bmarg {
			margin-top: -1px;
		}

		.bngla {
			font-family: SolaimanLipi !important;
			font-size: 16px !important;
		}

	</style>
	<link href="https://fonts.cdnfonts.com/css/arial?styles=48878" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('death_certificate/style.css') }}">
	<script src="{{ asset('death_certificate/disabled.js') }}" type="text/javascript"></script>
    

    <link href="https://fonts.maateen.me/nikosh/font.css" rel="stylesheet">

	<style>
		@import url('https://fonts.cdnfonts.com/css/arial?styles=48878');

		@media print {
			#button_group {
				display: none;
			}
		}


		.correct_duplicate {
			position: absolute;
			border: 2px solid #111;
			padding: 3px 8px;
			right: 45px;
			top: 63px;
			font-size: 14.4px;
			font-family: SolaimanLipi !important;
		}

		.button_group button {
			background: orange;
			padding: 8px 20px;
			color: white;
			font-weight: bold;
			border: 1px solid;
		}

		.button_group button:hover {
			background: #00006f;
		}
      .button_group button.active{
         background: blue;
      }
		button#printBtn {
			background: green;
		}
	</style>
</head>

<body>
	<!-- php start form here -->

	<input type="text" hidden id="forBarCode" value="{{ $certificate->registration_no }}">
	<div id="button_group">
		<div class="button_group">
			<button id="newBtn" class="active">New</button>
			<button id="correctedBtn">Corrected</button>
			<button id="duplicateBtn">Duplicate</button>
			<button id="printBtn">Print</button>
		</div>
	</div>
	<div class="a4_page" id="a4_page">
		<div class="main_wrapper">
			<div class="correct_duplicate" style="display:none;">
				<p></p>
			</div>
			<img src="{{ asset('assets/death_certificate/rgk.png') }}" class="main_logo" alt="">
          

			<span style="z-index: 10;">
				<div class="mr_header">
					<div class="left_part_hidden"></div>
					<div class="left_part">
						<img style="" src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=<?php echo urlencode($certificate['qr_code'] ?? 'No QR Data'); ?>" alt="">
						<h2 style="text-transform:uppercase"><?php echo htmlspecialchars($certificate['qr_text'] ?? 'N/A'); ?></h2>
					</div>
					<div class="middle_part">
						<!-- <img src="https://bdris.net/assist/images/gbs.png" alt="" class="main_logo_r">-->
						<img src="{{ asset('assets/death_certificate/gbs.png') }}" alt="" class="main_logo_r">
						<img src="{{ asset('assets/death_certificate/gbs.png') }}" alt="" style="opacity: 0;">
						<h2>Government of the People’s Republic of Bangladesh</h2>
						<p class="office">Office of the Registrar, Birth and Death Registration</p>
						<p class="address1">{{ $certificate->office_address }}</p>
						<p class="address2">{{ $certificate->office_name }}</p>
						<p class="rule_y">(Rule 11, 12)</p>
						<h1><span class="bn" style="font-family: SolaimanLipi!important;font-size: 19.5px!important; letter-spacing:0!important">মৃত্যু নিবন্ধন সনদ /</span> <span style="font-size: 20px" class="en" >Death Registration Certificate</span></h1>
					</div>
					<div class="right_part_hidden"></div>
					<div class="right_part">
						<canvas style="height: 30px; width:220px;" id="barcode" width="310" height="120"></canvas>
					</div>
				</div>
				<div class="mr_body">
					<div class="top_part1">
						<div class="left">
							<p>Date of Registration</p>
							<p>{{ $certificate->registration_date->format('d/m/Y') }}</p>
						</div>
						<div class="middle">
							<h2>Death Registration Number</h2>
							<h1>{{ $certificate->registration_no }}</h1>
						</div>
						<div class="right">
							<p>Date of Issuance</p>
							<p>{{ $certificate->issue_date->format('d/m/Y') }}</p>
						</div>
					</div>
					<div class="middle">
						<div style="margin-top: 2px;margin-bottom: 2px;" class="new_td_2">
							<div class="left">
								<div class="part1">
									<p class="bn">Date of Birth<span style="margin-left: 36px;" class="clone">:</span></p>
								</div>
								<div class="part2">
									<p><span class="bn">{{ App\Helpers\BanglaDateFormatter::formatDate($certificate->date_of_death) }}</span></p>
								</div>
							</div>
							<div class="right">
								<div class="part1">
									<p><span style="margin-left: 65px;" class="clone">Sex :</span></p>
								</div>
								<div class="part2">
									<p><span>{{ ucfirst($certificate->gender) }}</span></p>
								</div>
							</div>
						</div>
                      <div style="margin-top: 0px;margin-bottom: 0px !important;" class="td">
							<div class="left">
								<div style="width: 130px;" class="part1">
									<p>Date of Death<span>:</span></p>
								</div>
								<div class="part2" style="width: 400px;">

									<p><span name="dobb" style="margin-left:2px">{{ $certificate->date_of_death->format('d/m/Y') }}</span></p>
								</div>
							</div>
						</div>
						<div style="margin-top: 2px;margin-bottom: 24px !important;" class="td">
							<div class="left">
								<div style="width: 130px;" class="part1">
									<p>In Word<span>:</span></p>
								</div>
								<div class="part2" style="width: 400px;">

									<p><span name="dobb" style="margin-left:5px;font-style: italic;">{{ App\Helpers\DateFormatter::formatDateToWords($certificate->date_of_death) }}</span></p>
								</div>
							</div>
						</div>
						<div style="margin-top: 7px;" class="new_td">
							<div class="left left_self">
								<div class="part1">
									<p class="bn" style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px;">নাম<span style="margin-left: 103px;" class="clone">:</span></p>
								</div>
								<div class="part2" id="name_data_bn">
									<p><span class="bn" style="font-family: SolaimanLipi!important;font-size: 16px !important;">{{ $certificate->name_bengali }}</span></p>
								</div>
							</div>
							<div class="right self_name_en">
								<div class="part1 ">
									<p style="font-weight:500">Name<span style="margin-left: 83px;" class="clone">:</span></p>
								</div>
								<div class="part2" id="en_size">
									<p><span style="font-weight:500">{{ $certificate->name_english }}</span></p>
								</div>
							</div>
						</div>
						<div id="mother_content" style="" class="new_td">
							<div class="left left_self">
								<div class="part1">
									<p class="bn" style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px;">মাতা<span style="margin-left: 98px;" class="clone">:</span></p>
								</div>
								<div class="part2" id="motherName_data_bn">
									<p style="margin-top: -1.5px;"><span class="bn" style="font-family: SolaimanLipi!important;font-size: 16px !important;">{{ $certificate->mother_name_bengali }}</span></p>
								</div>
							</div>
							<div class="right">
								<div class="part1">
									<p style="font-weight:500">Mother<span style="margin-left: 76px;" class="clone">:</span></p>
								</div>
								<div class="part2" id="en_size">
									<p><span style="font-weight:500">{{ $certificate->mother_name_english }}</span></p>
								</div>
							</div>
						</div>
						<div id="motherNanality_content" style="" class="new_td">
							<div class="left left_self">
								<div class="part1">
									<p class="bn" style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px;">মাতার জাতীয়তা<span style="margin-left: 32px;" class="clone">:</span></p>
								</div>
								<div class="part2">
									<p><span class="bn" style="font-family: SolaimanLipi!important;font-size: 16px !important;">বাংলাদেশী</span></p>
								</div>
							</div>
							<div class="right">
								<div class="part1">
									<p style="font-weight:500">Nationality<span style="margin-left: 54px;" class="clone">:</span></p>
								</div>
								<div class="part2" id="en_size">
									<p><span style="font-weight:500">Bangladeshi</span></p>
								</div>
							</div>
						</div>
						<div style="" class="new_td">
							<div class="left left_self">
								<div class="part1">
									<p class="bn" style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px;">পিতা<span style="margin-left: 96.5px;" class="clone">:</span></p>
								</div>
								<div class="part2" id="fatherName_data_bn">
									<p><span class="bn" style="font-family: SolaimanLipi!important;font-size: 16px !important;">{{ $certificate->father_name_bengali }}</span></p>
								</div>
							</div>
							<div class="right">
								<div class="part1">
									<p style="font-weight:500">Father<span style="margin-left: 80px;" class="clone">:</span></p>
								</div>
								<div class="part2" id="en_size">
									<p><span style="font-weight:500">{{ $certificate->father_name_english }}</span></p>
								</div>
							</div>
						</div>
						<div id="fatherNanality_content" style="" class="new_td">
							<div class="left left_self">
								<div class="part1">
									<p class="bn" style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px;">পিতার জাতীয়তা<span style="margin-left: 31px;" class="clone">:</span></p>
								</div>
								<div class="part2">
									<p><span class="bn" style="font-family: SolaimanLipi!important;font-size: 16px !important;"> বাংলাদেশী</span></p>
								</div>
							</div>
							<div class="right">
								<div class="part1">
									<p style="font-weight:500">Nationality<span style="margin-left: 54px;" class="clone">:</span></p>
								</div>
								<div class="part2" id="en_size">
									<p><span style="font-weight:500">Bangladeshi</span></p>
								</div>
							</div>
						</div>
						<div style="" class="new_td">
							<div class="left">
								<div class="part1">
									<p class="bn" style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px;">মৃত্যুস্থান<span style="margin-left: 79px;" class="clone">:</span></p>
								</div>
								<div class="part2">
									<p><span class="bn" style="font-family: SolaimanLipi!important;font-size: 16px !important;">{{ $certificate->place_of_death_bengali }}</span></p>
								</div>
							</div>
							<div class="right">
								<div class="part1">
									<p style="width: 140px; font-weight:500">Place of Death<span style="margin-left: 25px;margin-right: 0;" class="clone">:</span></p>
								</div>
								<div class="part2" id="en_size">
									<p><span style="font-weight:500">{{ $certificate->place_of_death_english }}</span></p>
								</div>
							</div>
						</div>
						<div style="margin-top: 30px;" class="new_td">
							<div class="left left_self">
								<div class="part1">
									<p class="bn" style="width: 142px;font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px;">মৃত্যুর কারণ<span style="margin-left:56px;margin-right: 0;" class="clone">:</span></p>
                                    <span style="font-family: SolaimanLipi!important;font-size: 9px;">(আই সি ডি ভার্সন অনুসারে)</span>
								</div>
								<div class="part2">
									<p><span class="bn" style="font-family: SolaimanLipi!important;font-size: 15.5px !important;">স্টক </span></p>
								</div>
							</div>
							<div class="right">
								<div class="part1">
									<p style="width:143px; font-weight:500; font-size: 14.5px;">Cause of Death<span style="margin-left: 23px;" class="clone">:</span></p>
                                    <span style="font-family: Arial!important;font-size: 8px;">(As Per ICD Version)</span>
								</div>
								<div class="part2" id="en_size">
									<p><span style="font-weight:500">Stroke </span></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</span>
			<div class="mr_footer">
				<div class="top">
					<div class="left">
						<h2 style="width:10rem; margin-top: 0px;">Seal & Signature</h2>
						<p style="margin-top: 0px;">Assistant to Registrar</p>
						<p style="margin-top: 0px;">(Preparation, Verification)</p>
					</div>
					<div class="right">
						<h2 style="width:10rem">Seal & Signature<h2>
								<p>Registrar</p>
					</div>
				</div>
				<div style="margin-top:8rem" class="bottom">
					<p>This certificate is generated from bdris.gov.bd, and to verify this certificate, please scan the above QR Code & Bar Code.</p>
				</div>
			</div>
		</div>
	</div>




	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
	<script>
		let dob_n = document.getElementById('forBarCode').value;
		JsBarcode("#barcode", dob_n, {
			format: "CODE128",
			displayValue: false,
		});
	</script>

	<script>
		window.print();

		$(document).ready(function() {
			var elementWidth = $('#name_data_bn').height();
			if (Number(Math.floor(elementWidth)) > 23) {
				$('#mother_content').css("margin-top", "0px");
			}

			var elementWidth = $('#motherName_data_bn').height();
			if (Number(Math.floor(elementWidth)) > 23) {
				$('#motherNanality_content').css("margin-top", "0px");
			}

			var elementWidth = $('#fatherName_data_bn').height();
			if (Number(Math.floor(elementWidth)) > 23) {
				$('#fatherNanality_content').css("margin-top", "0px");
			}
		});
	</script>




	<script>
		// random data
		function getRandomFiveCapitalLetterWord() {
			const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			let word = "";
			for (let i = 0; i < 4; i++) {
				const randomIndex = Math.floor(Math.random() * alphabet.length);

				word += alphabet[randomIndex];
			}
			return word;
		}

		const randomCapitalWord = getRandomFiveCapitalLetterWord();

		document.getElementById('randomLetter').innerText = randomCapitalWord
		// To disable right click
		document.addEventListener('contextmenu', event => event.preventDefault());
	</script>

 <script>
    $(document).ready(function() {
      // Handle Corrected button
      $('#correctedBtn').click(function() {
        $('.correct_duplicate p').text('সংশোধিত/Corrected');
        $('.correct_duplicate').show();
        setActiveButton($(this)); // Make the clicked button active
      });
  
      // Handle Duplicate button
      $('#duplicateBtn').click(function() {
        $('.correct_duplicate p').text('প্রতিলিপি/Duplicate');
        $('.correct_duplicate').show();
        setActiveButton($(this)); // Make the clicked button active
      });
  
      // Handle New button
      $('#newBtn').click(function() {
        $('.correct_duplicate').hide();
        setActiveButton($(this)); // Make the clicked button active
      });
  
      // Print functionality
      $('#printBtn').click(function() {
        window.print();
      });
  
      // Function to set the active class
      function setActiveButton(button) {
        $('.button_group button').removeClass('active'); // Remove active class from all buttons
        button.addClass('active'); // Add active class to the clicked button
      }
    });
  </script>
<script src="{{ asset('assets/death_certificate/disabled.js') }}"></script> 
  <script disable-devtool-auto="" src="{{ asset('assets/death_certificate/develop.js') }}"></script> 

      <script>
   document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    document.onkeydown = function(e) {
        if (e.ctrlKey && (e.key === 'u' || e.key === 'c' || e.key === 's')) {
            e.preventDefault();
        }
    };

   
});



</script>
</body>

</html>
