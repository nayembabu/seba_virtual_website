<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TIN Certificate</title>
    <style type="text/css" media="print">
    @page {
        margin: 0 !important;
        size: A4 !important;
        color-adjust: exact !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    </style>
    
    <script>
        window.print();
    </script>
 
</head>

<body>
<div class="cert_div">
        
        <div>
                <img src="/storage/uploads/tin_cert_back.png" style="position:absolute; z-index: -1; top: 225px; left:200px; height:300px; width:300px;">



            <table class="cert_table" style="background-position: center center; border-style: solid; border-color: Black; border-width: 1px; font-size:medium;">
                <tbody><tr>
                    <td>
                        <table class="cert_table" style="background-position: center center; border-style: solid; border-color: Black; border-width: 2px; font-size:medium;">
                            <tbody><tr>
                                <td>
                                    <table class="cert_table" style="background-position: center center; border-style: solid; border-color: Black; border-width: 1px; font-size:medium;">
                                        <tbody><tr>
                                            <td>
                                                
                                                <table class="inner_cert_table" style="padding-left:5px; padding-right:5px">
                                                    
                                                    
                                                    <tbody><tr>
                                                        <td colspan="2" style="text-align: right;">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: center">
                                                            <img style="text-align:center" src="/storage/uploads/tin_cert_logo.png" alt="NBR" width="60px; height:60px;">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: center">
                                                            <span style="font-size: large; font-weight: bold;">Government of the People's Republic
                                                                of Bangladesh</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: center">
                                                            <span style="font-size: large; font-weight: bold;">National Board of Revenue</span>
                                                        </td>
                                                    </tr>
                                                     
                                                    
                                                    <tr>
                                                        <td colspan="2" style="text-align: center">
                                                            <span style="font-size: large">Taxpayer's Identification Number (TIN) Certificate</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: center;">
                                                            <span style="font-weight: bold; font-size: large; text-align: center; text-decoration: underline;">
                                                                TIN : <?php echo $result['DATA']['tin']; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            &nbsp;<br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            This is to Certify that <span style="font-weight: bold;"> <?php echo $result['DATA']['assesName']; ?>
                                                            </span>is a Registered Taxpayer of National Board of Revenue under the jurisdiction
                                                            of <span style="font-weight: bold;">Taxes <?php echo $result['DATA']['circle']['circleName']; ?> </span>
                                                            , Taxes Zone <span style="font-weight: bold;"><?php echo $result['DATA']['zone']['zoneName']; ?></span>.
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td colspan="2">
                                                            <span style="font-weight: bold;">Taxpayer's Particulars : </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            1) Name : <span style="font-weight: bold;"> <?php echo $result['DATA']['assesName']; ?> </span>
                                                        </td>
                                                    </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                2) Father's Name : <span style="font-weight: bold;"> <?php echo $result['DATA']['fathersName']; ?> </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                3) Mother's Name : <span style="font-weight: bold;"><?php echo $result['DATA']['mothersName']; ?> </span>
                                                            </td>
                                                        </tr>                        
                                                        <tr>
                                                            <td colspan="2">
                                                                4.a) Current Address : <span style="font-weight: bold;"><?php echo $result['DATA']['address']['present']['addr'].', '.$result['DATA']['address']['present']['thanaName'].', '.$result['DATA']['address']['present']['distName'].', PO: ' .$result['DATA']['address']['present']['postCode']; ?> </span>
                                                            </td>
                                                        </tr>                        
                                                        <tr>
                                                            <td colspan="2">
                                                                4.b) Permanent Address : <span style="font-weight: bold;">
                                                      <?php echo $result['DATA']['address']['permanent']['addr']; ?>   
                                                         <?php echo $result['DATA']['address']['permanent']['thanaName'].', '.$result['DATA']['address']['permanent']['distName'].', PO: '.$result['DATA']['address']['permanent']['postCode']; ?>, Bangladesh           
                                                                     </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                5) Previous TIN : <span style="font-weight: bold;">Not Applicable </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                6) Status : <span style="font-weight: bold;">Individual </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <br><br>
                                                            </td>
                                                        </tr>


                                                     
                                                    <tr>
                                                        <td colspan="2">
                                                            Date : <?php if(!isset($result['issue_date'])){ 
                                         $qrDate = date('d/m/Y' );
                                        echo date('F d, Y' ); } else{ 
                                        $qrDate = date("F d, Y", strtotime($result['issue_date']));
                                        echo date("F d, Y", strtotime($result['issue_date'])); } ?>
                                                        </td>
                                                    </tr>
                                                    
                                                    
                                                    <tr>
                                                        <td colspan="2">
                                                            <table width="100%">
                                                                <tbody><tr>
                                                                    <td style="width: 30%; vertical-align: top;">
                                                                            <table style="width: 200px; vertical-align: top; text-align: left;">
                                                                                <tbody><tr>
                                                                                    <td colspan="2">
                                                                                        <span style="font-weight: bold; text-align: left; text-decoration: underline;">Please
                                                                                            Note:</span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="width: 10px;">
                                                                                    </td>
                                                                                    <td>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr style="text-align: left; font-size: x-small;">
                                                                                    <td style="width: 10px; vertical-align: top;">
                                                                                        1.
                                                                                    </td>
                                                                                    <td>
                                                                                        A Taxpayer is liable to file the Return of Income under section 166 of the Income Tax Act, 2023.
                                                                                    </td>
                                                                                </tr>
                                                                                <tr style="text-align: left; font-size: x-small;">
                                                                                    <td style="width: 10px; vertical-align: top;">
                                                                                        2.
                                                                                    </td>
                                                                                    <td>
                                                                                        Failure to file Return of Income under Section 166 is liable to-
                                                                                    </td>
                                                                                </tr>
                                                                                <tr style="text-align: left; font-size: x-small;">
                                                                                    <td style="width: 10px; vertical-align: top;">
                                                                                    </td>
                                                                                    <td>
                                                                                        (a) Penalty under section 266; and
                                                                                    </td>
                                                                                </tr>
                                                                                <tr style="text-align: left; font-size: x-small;">
                                                                                    <td style="width: 10px; vertical-align: top;">
                                                                                    </td>
                                                                                    <td>
                                                                                        (b) Prosecution under section 311 of the Income Tax Act, 2023.
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody></table>

                                                                    </td>
                                                                    <td style="text-align: center; width: 40%;">
                                                                      
                                                             
                                                             <?php
                                                              $qrData = "T​a​x​p​a​y​e​r​'​s​ ​N​a​m​e​ ​:​ ".$result['DATA']['assesName'].
                        "%0A​D​O​B​ ​​:​ ".date("d/m/Y", strtotime($result['DATA']['dob'])).
                        "%0A​F​a​t​h​e​r​'​s​ ​N​a​m​e​ ​​:​ ".$result['DATA']['fathersName'].
                        "%0ATIN​ ​​:​ ".$result['DATA']['tin'].
                        "%0ADate​ ​​:​ ".$qrDate.
                        "%0AZ​o​n​e ​​:​ ".$result['DATA']['zone']['zoneName'].
                        "%0A​C​i​r​c​l​e​ ​​:​ ".$result['DATA']['circle']['circleName']; ?>
                                                                      
                                                                        
                                                        <img src="data:image/png;base64, {!! base64_encode(QrCode::encoding('UTF-8')->format('png')->merge('/assets/nbr.png')->size(150)->generate( $qrData)) !!}" height="150px;" width="150px;" alt="QR Code" style="text-align:center;">          
                                                                        
                                                                    </td>
                                                                    <td style="text-align: left; width: 30%; vertical-align: top;">
                                                                        <span style="text-align: left; font-size: x-small;">
                                                                               <span style="font-weight: bold">Deputy Commissioner
                                                                                of Taxes </span>
                                                                            <br>
                                                                            Taxes <?php echo $result['DATA']['circle']['circleName']; ?>
                                                                            <br>
                                                                            Taxes Zone <?php echo $result['DATA']['zone']['zoneName']; ?>
                                                                            <br>
                                                                            Address : 4, Purana Paltan (Motahar Lodge),  Dhaka-1000.
                                                                            Phone : 223352517
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                     
                                                    <tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                &nbsp;<br>
                                                            </td>
                                                        </tr>

                                                    <tr>
                                                        <td colspan="2" style="text-align: center">
                                                            <span style="text-align: center; text-decoration: underline; font-size: x-small;">N.
                                                                B: This is a system generated certificate and requires no manual signature.
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: center">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>

        </div>
    </div>
    
</body>
</html>