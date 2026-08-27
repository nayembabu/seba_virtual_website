<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সুরক্ষা সনদ তৈরি করুন</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>সুরক্ষা সনদ তৈরি করুন</h3>
            </div>
            <div class="card-body">
                <center>
                    <h3 class="text-info"> 
                        Charge : 0 (For demonstration purposes)
                    </h3>
                </center>
                <form action="certificate.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <h4> Beneficiary Information </h4>
                            <div class="mb-3 mt-3">
                                <label>Certificate No :</label>
                                <input type="text" class="form-control" placeholder="Certificate No" name="certi_no" value="BD<?php echo rand(100000000000, 999999999999); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label> Choose any :</label>
                                <input id="nid" type="radio" name="type" value="One" checked /> 
                                <label for="nid"> NID No. </label>
                                <input id="bn" type="radio" name="type" value="Two" /> <label for="bn"> Birth No.</label>
                            </div>
                            
                            <div class="mb-3" id="nid_show">
                                <label>National ID :</label>
                                <input type="text" class="form-control" placeholder="National ID " name="national_id">
                            </div>

                            <div class="mb-3" id="bn_show" style="display:none">
                                <label> Birth No:</label>
                                <input type="text" class="form-control" placeholder="Birth Number" name="birth_id">
                            </div>

                            <div class="mb-3 mt-3">
                                <label>Passport No.:</label>
                                <input type="text" class="form-control" placeholder="Passport No" name="passport_no">
                            </div>

                            <div class="mb-3">
                                <label>Nationality:</label>
                                <select class="form-control" name="nationality">
                                    <option value="Bangladeshi">Bangladeshi</option>
                                    <option value="India">India</option>
                                </select>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" placeholder="Name" name="name">
                            </div>

                            <div class="mb-3">
                                <label>Date of Birth:</label>
                                <input type="date" class="form-control" id="dob" name="date_birth" value="">
                            </div>

                            <div class="mb-3">
                                <label for="gender">Gender:</label>
                                <select class="form-control" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4> Vaccination Details </h4>

                            <div class="mb-3 mt-3">
                                <label>Date of vaccination (Dose 1):</label>
                                <input type="date" class="form-control" id="dose-1" name="doseone_date" value="">
                            </div>

                            <div class="mb-3">
                                <label> Name of vaccine:</label>
                                <select class="form-control" name="doseone_name" onchange="vc1(this);">
                                    <option value=""></option>
                                    <option value="Pfizer (Pfizer-BioNTech)">Pfizer (Pfizer-BioNTech)</option>
                                    <option value="COVISHIELD (AstraZeneca)">COVISHIELD (AstraZeneca)</option>
                                    <option value="Moderna (Moderna)">Moderna (Moderna)</option>
                                    <option value="Vero Cell (Sinopharm)">Vero Cell (Sinopharm)</option>
                                    <option value="Janssen (Johnson & Johnson)">Janssen (Johnson & Johnson)</option>
                                    <option value="other1">Other</option>
                                </select>
                            </div>
                            <label> Other vaccine Name:</label>
                            <div class="mb-3" id="ifYesv1" style="display: none;">
                                <input type="text" class="form-control" name="doseone_name2">
                            </div>

                            <div class="mb-3 mt-3">
                                <label>Date of vaccination (Dose 2):</label>
                                <input type="date" class="form-control" id="dose-2" name="dosetwo_date" value="">
                            </div>

                            <div class="mb-3">
                                <label> Name of vaccine:</label>
                                <select class="form-control" name="dosetwo_name" onchange="vc2(this);">
                                    <option value=""></option>
                                    <option value="Pfizer (Pfizer-BioNTech)">Pfizer (Pfizer-BioNTech)</option>
                                    <option value="COVISHIELD">COVISHIELD (AstraZeneca)</option>
                                    <option value="Moderna (Moderna)">Moderna (Moderna)</option>
                                    <option value="Vero Cell (Sinopharm)">Vero Cell (Sinopharm)</option>
                                    <option value="Janssen (Johnson & Johnson)">Janssen (Johnson & Johnson)</option>
                                    <option value="other2">Other</option>
                                </select>
                            </div>

                            <label> Other vaccine Name:</label>
                            <div class="mb-3" id="ifYesv2" style="display: none;">
                                <input type="text" class="form-control" name="dosetwo_name2">
                            </div>

                            <div class="mb-3 mt-3">
                                <label>Date of vaccination (Dose 3):</label>
                                <input type="date" class="form-control" id="dose-3" name="dosethree_date" value="">
                            </div>

                            <div class="mb-3">
                                <label> Name of vaccine:</label>
                                <select class="form-control" name="dosethree_name" onchange="vc3(this);">
                                    <option value=""></option>
                                    <option value="Pfizer (Pfizer-BioNTech)">Pfizer (Pfizer-BioNTech)</option>
                                    <option value="COVISHIELD (AstraZeneca)">COVISHIELD (AstraZeneca)</option>
                                    <option value="Moderna (Moderna)">Moderna (Moderna)</option>
                                    <option value="Vero Cell (Sinopharm)">Vero Cell (Sinopharm)</option>
                                    <option value="Janssen (Johnson & Johnson)">Janssen (Johnson & Johnson)</option>
                                    <option value="other3">Other</option>
                                </select>
                            </div>

                            <label> Other vaccine Name:</label>
                            <div class="mb-3" id="ifYesv3" style="display: none;">
                                <input type="text" class="form-control" name="dosethree_name2">
                            </div>

                            <div class="mb-3 mt-3">
                                <label> vaccination Center:</label>
                                <select class="form-control" name="vacc_center" onchange="center(this);">
                                    <option value="Bagerhat 250 Bed Hospital">Bagerhat 250 Bed Hospital</option>
                                    <option value="Bandarban Sadar Hospital">Bandarban Sadar Hospital</option>
                                    <option value="Barguna Zilla Sadar Government Hospital">Barguna Zilla Sadar Government Hospital</option>
                                    <option value="Sher-E-Bangla Medical College Hospital">Sher-E-Bangla Medical College Hospital</option>
                                    <option value="Bhola 250 bed District Sadar Hospital">Bhola 250 bed District Sadar Hospital</option>
                                    <option value="Bogra 250 bed Mohammad Ali District Hospital">Bogra 250 bed Mohammad Ali District Hospital</option>
                                    <option value="250 Bedded General Hospital, Brahmanbaria">250 Bedded General Hospital, Brahmanbaria</option>
                                    <option value="Chandpur 250 Bed General Hospital">Chandpur 250 Bed General Hospital</option>
                                    <option value="Chittagong 250 bed general hospital">Chittagong 250 bed general hospital</option>
                                    <option value="Chuadanga Sadar Hospital">Chuadanga Sadar Hospital</option>
                                    <option value="Comilla Medical College Hospital">Comilla Medical College Hospital</option>
                                    <option value="250 Bed District Sadar Hospital, Cox's Bazar">250 Bed District Sadar Hospital, Cox's Bazar</option>
                                    <option value="Dhaka Medical College Hospital">Dhaka Medical College Hospital</option>
                                    <option value="Dinajpur 250 bed General Hospital">Dinajpur 250 bed General Hospital</option>
                                    <option value="Bangabandhu Sheikh Mujib Medical College and Hospital">Bangabandhu Sheikh Mujib Medical College and Hospital</option>
                                    <option value="Feni Government General Hospital">Feni Government General Hospital</option>
                                    <option value="Zilla Government Hospital, Gaibandha">Zilla Government Hospital, Gaibandha</option>
                                    <option value="Gazipur Sadar Upazila Health complex, Gazipur">Gazipur Sadar Upazila Health complex, Gazipur</option>
                                    <option value="250 Bedded General Hospital, Gopalganj">250 Bedded General Hospital, Gopalganj</option>
                                    <option value="Adhunik Zilla Sadar Hospital, Habiganj">Adhunik Zilla Sadar Hospital, Habiganj</option>
                                    <option value="Joypurhat Adhunik Hospital">Joypurhat Adhunik Hospital</option>
                                    <option value="250 Bed Jamalpur General Hospital, Jamalpur">250 Bed Jamalpur General Hospital, Jamalpur</option>
                                    <option value="Jessore General Hospital">Jessore General Hospital</option>
                                    <option value="Jhalokathi Sadar Hospital, Jhalokati">Jhalokathi Sadar Hospital, Jhalokati</option>
                                    <option value="Jhenaidah Sadar Hospital">Jhenaidah Sadar Hospital</option>
                                    <option value="Khagrachari District Sadar Hospital">Khagrachari District Sadar Hospital</option>
                                    <option value="Khulna 250 Bed General Hospital">Khulna 250 Bed General Hospital</option>
                                    <option value="Kishoreganj 250 Bed District Sadar Hospital">Kishoreganj 250 Bed District Sadar Hospital</option>
                                    <option value="Kurigram General Hospital">Kurigram General Hospital</option>
                                    <option value="Kushtia General Hospital">Kushtia General Hospital</option>
                                    <option value="Lakshmipur Sadar Hospital">Lakshmipur Sadar Hospital</option>
                                    <option value="Lalmonirhat Sadar Hospital">Lalmonirhat Sadar Hospital</option>
                                    <option value="Madaripur Sadar Hospital">Madaripur Sadar Hospital</option>
                                    <option value="Chittagong Medical College Hospital">Chittagong Medical College Hospital</option>
                                    <option value="Sheikh Russel National Gastroliver Institute & Hospital">Sheikh Russel National Gastroliver Institute & Hospital</option>
                                    <option value="Shaheed Suhrawardy Medical College & Hospital">Shaheed Suhrawardy Medical College & Hospital</option>
                                    <option value="Kurmitola 500 Bed General Hospital">Kurmitola 500 Bed General Hospital</option>
                                    <option value="Dhaka Metropolitan General Hospital">Dhaka Metropolitan General Hospital</option>
                                    <option value="Central Police Hospital, Rajarbag, Dhaka">Central Police Hospital, Rajarbag, Dhaka</option>
                                    <option value="Sheikh Hasina National Institute of Burn & Plastic Surgery ">Sheikh Hasina National Institute of Burn & Plastic Surgery </option>
                                    <option value="Mugda 500 Bed General Hospital">Mugda 500 Bed General Hospital</option>
                                    <option value="Sir Salimullah Medical College Mitford Hospital">Sir Salimullah Medical College Mitford Hospital</option>
                                    <option value="DNCC Dedicated Covid-19 Hospital, Dhaka">DNCC Dedicated Covid-19 Hospital, Dhaka</option>
                                    <option value="Police Hospital, Chittagong">Police Hospital, Chittagong</option>
                                    <option value="Combined Military Hospital (CMH)">Combined Military Hospital (CMH)</option>
                                    <option value="Bondar Tila Maternity Hospital">Bondar Tila Maternity Hospital</option>
                                    <option value="City Corporation General Hospital, Chittagong">City Corporation General Hospital, Chittagong</option>
                                    <option value="Safa Motaleb Maternity Hospital">Safa Motaleb Maternity Hospital</option>
                                    <option value="Mostafa-Hakim Maternity Hospital">Mostafa-Hakim Maternity Hospital</option>
                                    <option value="BNS Patenga, Chittagong">BNS Patenga, Chittagong</option>
                                    <option value="Medical Squadron, BAF Zahur, Chittagong">Medical Squadron, BAF Zahur, Chittagong</option>
                                    <option value="Chattogram Port Hospital">Chattogram Port Hospital</option>
                                    <option value="Upazila Health Complex, Anowara">Upazila Health Complex, Anowara</option>
                                    <option value="Upazila Health Complex, Karnafuli">Upazila Health Complex, Karnafuli</option>
                                    <option value="Upazila Health Complex, Hathazari">Upazila Health Complex, Hathazari</option>
                                    <option value="Barisal (sadar) Upazila Health Office">Barisal (sadar) Upazila Health Office</option>
                                    <option value="Zilla Sadar Hospital, Barisal">Zilla Sadar Hospital, Barisal</option>
                                    <option value="Police Hospital, Barisal">Police Hospital, Barisal</option>
                                    <option value="Upazila Health Complex, Gauranadi">Upazila Health Complex, Gauranadi</option>
                                    <option value="250 Bed General Hospital, Khulna">250 Bed General Hospital, Khulna</option>
                                    <option value="Khulna Medical College Hospital">Khulna Medical College Hospital</option>
                                    <option value="Police Hospital, Khulna">Police Hospital, Khulna</option>
                                    <option value="BNS Upsham Khulna">BNS Upsham Khulna</option>
                                    <option value="Shaheed Sheikh Abu Naser Specialized Hospital">Shaheed Sheikh Abu Naser Specialized Hospital</option>
                                    <option value="Bogura (sadar) Upazila Health Office">Bogura (sadar) Upazila Health Office</option>
                                    <option value="Rajshahi Medical College Hospital">Rajshahi Medical College Hospital</option>
                                    <option value="Police Hospital, Rajshahi">Police Hospital, Rajshahi</option>
                                    <option value="Combined Military Hospital (CMH), Rajshahi">Combined Military Hospital (CMH), Rajshahi</option>
                                    <option value="Infected Disease Hospital">Infected Disease Hospital</option>
                                    <option value="250 Bed Zilla Sadar Hospital, Feni">250 Bed Zilla Sadar Hospital, Feni</option>
                                    <option value="Feni (sadar) Upazila Health Office">Feni (sadar) Upazila Health Office</option>
                                    <option value="Upazila Health Complex, Dagonbhuiyan">Upazila Health Complex, Dagonbhuiyan</option>
                                    <option value="Police Hospital, Feni">Police Hospital, Feni</option>
                                    <option value="250 Bed General Hospital, Hobiganj">250 Bed General Hospital, Hobiganj</option>
                                    <option value="Moulavibazar 250 Bed Zilla Sadar Hospital">Moulavibazar 250 Bed Zilla Sadar Hospital</option>
                                    <option value="Sunamganj 250 Bed Zilla Sadar Hospital">Sunamganj 250 Bed Zilla Sadar Hospital</option>
                                    <option value="Sylhet MAG Osmani Medical College Hospital-2">Sylhet MAG Osmani Medical College Hospital-2</option>
                                    <option value="Combined Military Hospital (CMH), Jalalabad">Combined Military Hospital (CMH), Jalalabad</option>
                                    <option value="Sylhet (sadar) Upazila Health Office">Sylhet (sadar) Upazila Health Office</option>
                                    <option value="Sylhet M.A.G Osmani Medical College Hospital">Sylhet M.A.G Osmani Medical College Hospital</option>
                                    <option value="Police Hospital, Sylhet">Police Hospital, Sylhet</option>
                                    <option value="Zilla Sadar Hospital, Comilla">Zilla Sadar Hospital, Comilla</option>
                                    <option value="Combined Military Hospital (CMH), Comilla">Combined Military Hospital (CMH), Comilla</option>
                                    <option value="250 Bed General Hospital, Kishoreganj">250 Bed General Hospital, Kishoreganj</option>
                                    <option value="Jessore 250 Bed General  Hospital">Jessore 250 Bed General Hospital</option>
                                    <option value="250 bed General hospital, habiganj">250 bed General hospital, habiganj</option>
                                    <option value="Magura 250 bed District Hospital">Magura 250 bed District Hospital</option>
                                    <option value="250 Bed District Hospital, Manikganj">250 Bed District Hospital, Manikganj</option>
                                    <option value="Meherpur 250 Bed District Hospital">Meherpur 250 Bed District Hospital</option>
                                    <option value="Moulvibazar Sodor Hospital">Moulvibazar Sodor Hospital</option>
                                    <option value="Munshiganj 250 bed District Hospital">Munshiganj 250 bed District Hospital</option>
                                    <option value="Mymensingh gov Medical Hospital">Mymensingh gov Medical Hospital</option>
                                    <option value="Naogaon 250 bed District Hospital">Naogaon 250 bed District Hospital</option>
                                    <option value="Narail Sadar Hospital">Narail Sadar Hospital</option>
                                    <option value="Narayanganj 300 Bed Hospital">Narayanganj 300 Bed Hospital</option>
                                    <option value="Narsingdi 100 Bed Zilla Hospital">Narsingdi 100 Bed Zilla Hospital</option>
                                    <option value="Natore Sadar Hospital">Natore Sadar Hospital</option>
                                    <option value="Nawabganj Upazila Health Complex">Nawabganj Upazila Health Complex</option>
                                    <option value="Netrakona Sadar Hospital">Netrakona Sadar Hospital</option>
                                    <option value="Nilphamari 250 bed District Hospital">Nilphamari 250 bed District Hospital</option>
                                    <option value="Noakhali 250 Bed General Hospital">Noakhali 250 Bed General Hospital</option>
                                    <option value="Pabna 250 bed General Hospital">Pabna 250 bed General Hospital</option>
                                    <option value="Panchagarh District Hospital">Panchagarh District Hospital</option>
                                    <option value="Parbatya Chattagram Government Hospital">Parbatya Chattagram Government Hospital</option>
                                    <option value="Patuakhali 250 bed Sadar Hospital">Patuakhali 250 bed Sadar Hospital</option>
                                    <option value="Pirojpur District Hospital">Pirojpur District Hospital</option>
                                    <option value="Rajbari General Hospital">Rajbari General Hospital</option>
                                    <option value="Department Of Orthopedic Surgery And Traumatology (Gent's)">Department Of Orthopedic Surgery And Traumatology (Gent's)</option>
                                    <option value="Upazila Health Complex, Sadar Rangpur">Upazila Health Complex, Sadar Rangpur</option>
                                    <option value="Satkhira Sadar Hospital">Satkhira Sadar Hospital</option>
                                    <option value="Shariatpur Sadar Hospital">Shariatpur Sadar Hospital</option>
                                    <option value="District Hospital, Sherpur">District Hospital, Sherpur</option>
                                    <option value="Sheikh Fazilatunnessa Mujib General Hospital, Sirajganj">Sheikh Fazilatunnessa Mujib General Hospital, Sirajganj</option>
                                    <option value="Sunamganj Sadar Hospital">Sunamganj Sadar Hospital</option>
                                    <option value="Sylhet District Hospital">Sylhet District Hospital</option>
                                    <option value="Tangail 250 Bed District Hospital">Tangail 250 Bed District Hospital</option>
                                    <option value="Adhunik Sadar Hospital">Adhunik Sadar Hospital</option>
                                    <option value="other">Other</option>
                                </select>

                            </div>
                            <label> Other vaccination Center :</label>
                            <div class="mb-3" id="ifYes" style="display: none;">
                                <input type="text " class="form-control" name="vacc_center2">
                            </div>

                            <div class="mb-3">
                                <label> vaccination By :</label>
                                <input type="text " class="form-control" value="Directorate General of Health Services (DGHS)" name="vacc_by">
                            </div>

                            <div class="mb-3">
                                <label> Total Dose Given :</label>
                                <input type="text " class="form-control" placeholder="Total Dose Given" name="total_dose">
                            </div>


                            <button class="btn btn-primary"> Submit </button>

                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('js')
     <script>
     let val = $('input[type=radio][name=type]').val();
     if (val == 'One') {
             $('#nid_show').show();
             $('#bn_show').hide();
      } else if ( val == 'Two' ) {
             $('#nid_show').hide();
             $('#bn_show').show();
      } else {
             $('#nid_show').hide();
             $('#bn_show').hide();
      }
     
     
     $('input[type=radio][name=type]').change(function() {
         if (this.value == 'One') {
             $('#nid_show').show();
             $('#bn_show').hide();
         } else if ( this.value == 'Two' ) {
             $('#nid_show').hide();
             $('#bn_show').show();
         } else {
             $('#nid_show').hide();
             $('#bn_show').hide();
         }
         
     });
     
      function center(that) {
      if (that.value == "other") {
        alert("Please enter the vaccination Center Name");
        document.getElementById("ifYes").style.display = "block";
      } else {
        document.getElementById("ifYes").style.display = "none";
      }
    }

    function vc1(that) {
      if (that.value == "other1") {
        alert("Please enter the vaccination Center Name");
        document.getElementById("ifYesv1").style.display = "block";
      } else {
        document.getElementById("ifYesv1").style.display = "none";
      }
    }

    function vc2(that) {
      if (that.value == "other2") {
        alert("Please enter the vaccine Name");
        document.getElementById("ifYesv2").style.display = "block";
      } else {
        document.getElementById("ifYesv2").style.display = "none";
      }
    }

    function vc3(that) {
      if (that.value == "other3") {
        alert("Please enter the vaccine Name");
        document.getElementById("ifYesv3").style.display = "block";
      } else {
        document.getElementById("ifYesv3").style.display = "none";
      }
    }
    $(document).on('change','body #photo',function(){
            let file = $(this)[0].files[0];
            let src = URL.createObjectURL(file);
            $('#img').attr('src',src);
    });
    
    </script>
@endpush