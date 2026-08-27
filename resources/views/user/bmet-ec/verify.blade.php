
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="hhTZiJMMNyLmqJ7ka72rbndNLZ5JByxJRrLXo9dJ">

    <title>OEP RAIMS</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="OEP RAIMS">
    <meta name="author" content="RAIMS Application">
    <link rel="apple-touch-icon" href="https://raims.oep.gov.bd/img/brand/logo.png">
    <link rel="shortcut icon" type="image/x-icon" href="https://raims.oep.gov.bd/img/brand/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Serif+Bengali:wght@100..900&display=swap" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/vendors/css/tables/extensions/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/vendors/css/tables/extensions/colReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/vendors/css/tables/extensions/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/vendors/css/extensions/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/vendors/css/extensions/toastr.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/css/pages/hospital.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/css/style.css">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="https://raims.oep.gov.bd/assets/css/ec-card.css">
<title>BMET - EC Card Verify</title>
<style>
    .noto-serif-bengali {
        font-family: "Noto Serif Bengali", sans-serif;
    } 
	#top{
		background-image: url('https://raims.oep.gov.bd/assets/images/card/card_map.png');		
        display: flex;
        justify-content: space-evenly;
	}

    .title {
        align-content: space-evenly;
        font-family: "Noto Serif Bengali", sans-serif;
        font-weight: 700;
    }
    
</style>

</head>
<!-- END: Head-->
<body class="vertical-layout vertical-menu 1-column   blank-page  pace-done" data-open="click" data-menu="vertical-menu" data-col="1-column">
    <div id="app">
        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-body">
                    	<div class="container-fluid">
		<div class="row mb-5">
			<div class="col-12">
								<div id="wrap">
					<div id="top" class="text-center">
						<div>
                            <img src="https://raims.oep.gov.bd/img/brand/logo.png" height="50px">
                        </div>
						<div class="title">
                            <span style="color:green;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span><br>
                            <span style="color:violet;">জনশক্তি কর্মসংস্থান ও প্রশিক্ষন ব্যুরো</span>
                        </div>
						<div>
                            <img src="https://raims.oep.gov.bd/assets/images/card/govt_logo.png">
                        </div>
					</div>
					<div id="content">
						<h5 class="text-center pb-1 noto-serif-bengali" style="font-weight: 700">
                            বহির্গমন ছাড়পত্র <br> Emigration Clearance
                        </h5>
						<div id="info-board">
							<div id="pic-wrap">
								<img src="{{ asset('public/' . $bmetEc->profile_photo) }}">
								
							</div>
							<p style="margin-bottom: 0px;">{{ $bmetEc->name }}</p>
							<p><span class="card-label">EC No: </span><span>{{ $bmetEc->ec_no }}</span></p>
							<img src="https://raims.oep.gov.bd/assets/images/card/card_line.png" id="card-line">
							<img src="https://raims.oep.gov.bd/assets/images/card/card_star.png" id="card-star">
						</div>
						<div id="agency-board" class="mt-1">
							<table class="table table-bordered table-sm mb-0"> 
								<tbody>
									<tr>
										<th class="card-label">Birth Date </th> <td class="card-text">{{ $bmetEc->birth_date }}</td>
									</tr>
									<tr>
										<th class="card-label">Passport No </th> <td class="card-text">{{ $bmetEc->passport_no }}</td>
									</tr>
									<tr>
										<th class="card-label">Passport Issue Date </th> <td class="card-text">{{ $bmetEc->passport_issue_date }}</td>
									</tr>
									<tr>
										<th class="card-label">Passport Expire Date </th> <td class="card-text">{{ $bmetEc->passport_expire_date }}</td>
									</tr>
									
									<tr>
										<th class="card-label">Visa No </th> <td class="card-text">{{ $bmetEc->visa_no }}</td>
									</tr>
									<tr>
										<th class="card-label">Visa Issue Date </th> <td class="card-text">{{ $bmetEc->visa_issue_date }}</td>
									</tr>
									<tr>
										<th class="card-label">Visa Expire Date </th> <td class="card-text">{{ $bmetEc->visa_expire_date }}</td>
									</tr>

																		<tr>
										<th class="card-label">Recruiting Agency </th>
										<td class="card-text">
											{{ $bmetEc->recruiting_agency }}
											({{ $bmetEc->rl_id }})
										</td>
									</tr>
																		<tr>
										<th class="card-label">Employer </th> <td class="card-text">{{ $bmetEc->employer }}</td>
									</tr>
									<tr>
										<th class="card-label">Country </th> <td class="card-text">{{ $bmetEc->country }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				
				<div id="wrap">
					<div id="top" class="px-1" style="justify-content: space-between;">
						<div class="title text-start">
                            <span style="color:green; font-size: 18px;">BMET Registration</span><br>
                        </div>
						<div class="text-end">
                            <img src="https://raims.oep.gov.bd/assets/images/card/govt_logo.png" height="45px">
                            <img src="https://raims.oep.gov.bd/img/brand/logo.png" height="45px">
                        </div>
					</div>
					<div id="content" >
						<div style="padding: 10px; background-color: #fff;">
							<table class="table table-bordered table-sm mb-0" > 
								<tbody>
									<tr>
										<th class="card-label">BMET No </th> <td class="card-text">{{ $bmetEc->bmet_no }}</td>
									</tr>
									<tr>
										<th class="card-label">Name </th> <td class="card-text">{{ $bmetEc->name }}</td>
									</tr>
									<tr>
										<th class="card-label">Father Name </th> <td class="card-text">{{ $bmetEc->father_name }}</td>
									</tr>
									<tr>
										<th class="card-label">Mother Name </th> <td class="card-text">{{ $bmetEc->mother_name }}</td>
									</tr>
									<tr>
										<th class="card-label">Birth Date </th> <td class="card-text">{{ $bmetEc->birth_date }}</td>
									</tr>
									<tr>
										<th class="card-label">Gender </th> <td class="card-text">{{ $bmetEc->gender }}</td>
									</tr>
									<tr>
										<th class="card-label">Blood Group </th> <td class="card-text">{{ $bmetEc->blood_group }}</td>
									</tr>
									<tr>
										<th class="card-label">NID </th> <td class="card-text">{{ $bmetEc->nid }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				
				
				<div id="wrap">
					<div id="top" class="px-1" style="justify-content: space-between;">
						<div class="title text-start">
                            <span style="color:green; font-size: 18px;">Passports</span><br>
                        </div>
						<div class="text-end">
                            <img src="https://raims.oep.gov.bd/assets/images/card/govt_logo.png" height="45px">
                            <img src="https://raims.oep.gov.bd/img/brand/logo.png" height="45px">
                        </div>
					</div>
					<div id="content">
						<div style="padding: 10px; background-color: #fff;">
							
							<table class="table table-bordered table-sm mb-0" > 
								<tbody>
									<tr>
										<th class="card-label">Name </th> <td class="card-text">{{ $bmetEc->name }}</td>
									</tr>
																		<tr>
										<th class="card-label">Passport No 1</th> <td class="card-text">{{ $bmetEc->passport_no }}</td>
									</tr>
																		
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
			
				
							</div>
		</div>
                </div>
            </div>
        </div>
        <!-- END: Content-->
    </div>
        <script src="https://raims.oep.gov.bd/assets/vendors/js/vendors.min.js"></script>
    <script src="https://raims.oep.gov.bd/assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="https://raims.oep.gov.bd/assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="https://raims.oep.gov.bd/assets/vendors/js/tables/buttons.colVis.min.js"></script>
    <script src="https://raims.oep.gov.bd/assets/vendors/js/tables/datatable/dataTables.colReorder.min.js"></script>
    <script src="https://raims.oep.gov.bd/assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
    <script src="https://raims.oep.gov.bd/assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
    <script src="https://raims.oep.gov.bd/assets/vendors/js/tables/datatable/dataTables.fixedHeader.min.js"></script>
    <script src="https://raims.oep.gov.bd/assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="https://raims.oep.gov.bd/assets/vendors/js/extensions/toastr.min.js"></script>
    <script>
        $(document).on("keypress keydown keyup",".validMobile", function(key){
            var regex=/^[0-9]$/;
            let allow = ['Backspace','Del','Right','Left', 'Shift'];
            if(allow.indexOf(key.key) != -1){
                return true;
            }
            else if (!key.key.match(regex))
            {
                return false;
            }
        })

    </script>
    </body>
</html>
