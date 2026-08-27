<html>
<head>


    <style>


    *,


    body {


        font-family: 'arial';


    }





    .main {


        background-repeat: no-repeat;


        background-position: center center;


        width: 580px;


        margin: 0 auto;


    }





    .font_size1 {


        font-size: 19px;


    }





    #seal {


        width: 100%;


        height: 250px;


        float: left;


    }





    .seal_pad {


        width: 50%;


        height: 100%;


        float: left;


    }





    .seal_officer {


        width: 49%;


        height: 100%;


        float: left;


    }





    #img {


        width: 100px;


        margin: 0px auto;


    }





    #img img {


        width: 100px;


    }





    .text_p {


        text-align: center;


    }





    .cr_code {


        float: left;


    }


    </style>


    <style type="text/css" media="print">


    @page {


        margin: 0 !important;


        size: A4 !important;


        color-adjust: exact !important;


        -webkit-print-color-adjust: exact !important;


        print-color-adjust: exact !important;


        background-color: #fff !important;


    }





    @media print {





        html,


        body {


            width: 210mm !important;


            height: 297mm !important;


            background-color: #fff !important;


            font-family: 'arial';


        }





        .print {


            display: none !important;


        }


    }


    </style>


</head>





<body>


  


    <div class="main">


        <button class="print" onclick="window.print()"


            style="z-index: 9999;background: green;padding: 8px;width: 100%;border: 1px solid #fff;cursor: pointer;box-shadow: 0 4px 4px #878787;color: #fff;font-size: 16px;margin-bottom: 25px;">Print


            Now</button>


        <div id="img">


            <img src="{{url('assets/police')}}/bangladesh_govt_logo.png">


        </div>





        <div class="text_p">


            <p style="font-size: 22px">


                <b>GOVERNMENT OF THE PEOPLE'S REPUBLIC OF <br />BANGLADESH</b>


            </p>


        </div>





        <!--This QR is not for verify purpus -->


<img style="float: left; margin-top: 5px" 
     src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(80)->generate('https://pcc.police.gov.bd.je/user/ords/verify?p=500:50::::RP:P50_TOKEN_ID:' . $data['police_reg'])) !!}" 
     alt="" title="PCC" width="80" height="80" />


 




        <div style="text-align: center; /* float: left; */ margin-right: 80px">


            <p class="font_size"><?php echo $data['police_station']; ?> Police Station</p>


            <p class="font_size"><?php echo $data['district']; ?></p>


        </div>


        <table width="100%" border="0">


            <tbody>


                <tr>


                    <td class="font_size">Ref No. <?php echo $data['police_reg']; ?></td>


                    <td class="font_size" style="text-align: right">


                        Dated: <?php echo strtoupper($data['police_date']); ?>


                    </td>


                </tr>


            </tbody>


        </table>


        <div>


            <p style="text-align: center; font-size: 18px">


                <b>POLICE CLEARANCE CERTIFICATE</b>


            </p>


            <br />





            <p class="font_size" style="text-align: justify">


                The character and antecedents of <?php echo $data['designation']; ?>


                <b><?php echo $data['applicant_name']; ?></b> <?php echo $data['what_of']; ?> of


                <b><?php echo $data['father_name']; ?></b> Village/ Area: <b><?php echo $data['village_area']; ?></b>,


                P/O:


                <b><?php echo $data['post_office']; ?></b>, P/S: <b><?php echo $data['police_station']; ?></b>, District:


                <b><?php echo $data['district']; ?></b> holder of Bangladesh International


                <?php echo $data['document_type']; ?> No.


                <b><?php echo $data['passport_no']; ?></b> Issued at <b> <?php echo $data['issued_location']; ?></b> on


                <b><?php echo strtoupper(date('d-M-Y',strtotime($data['issued_date']))); ?></b> have


                been verified and there is no adverse information against him/her on


                record.


            </p>


            <p class="font_size" style="text-align: justify">


                This certificate is issued in pursuance of Ministry of Home Affairs


                Memo No. Nirdesh-2/75-Pt. 2152-Bohi(1), dated the 19th May, 1977.


            </p>


        </div>


        <br /><br /><br /><br />


        <table width="100%" border="0">


            <tbody>


                <tr>


                    <td class="font_size">


                        <br />


                        Superintendent of Police<br />
                        District Special Branch <?php echo $data['district']; ?>


                    </td>





                    <td class="font_size" style="text-align: center">Seal.</td>


                    <td class="font_size" style="text-align: right">


                        Officer-in-Charge.<br />


                        <?php echo $data['police_station']; ?> Police Station.


                    </td>


                </tr>


            </tbody>


        </table>


    </div>





    <br />


    <div>


        <p style="


          font-style: italic;


          background-position: center center;


          width: 580px;


          margin: 0 auto;


          font-size: 11px;


          color: red;


        ">


            This is a digital copy of the unsigned certificate issued by Bangladesh


            Police Online Police Clearance Management System. The printed original


            must contain seal and signature of the designated officials.


        </p>


    </div>


  

</body>
</html>