<?php $root = url('').'/assets/land/'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">    <title> ভূমি উন্নয়ন কর:
            Dakhila</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta content="width=600, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0, user-scalable=no" name="viewport">

    <meta content="" name="description">
    <meta content="" name="author">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css">

    <link href="https://dakhila.ldtax.gov.bd/assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/assets/global/css/plugins-md.css" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/assets/admin/layout4/css/layout.css" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/assets/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css" id="style_color">
    <link href="https://dakhila.ldtax.gov.bd/assets/admin/layout4/css/custom.css" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/css/common.css" rel="stylesheet" type="text/css">
    <link href="https://dakhila.ldtax.gov.bd/css/style.css" rel="stylesheet" type="text/css">
        <!-- END THEME STYLES -->
                                        <link rel="shortcut icon" href="https://dakhila.ldtax.gov.bd/img/favicon.ico">
    <script src="https://dakhila.ldtax.gov.bd/js/jquery-2.1.1.min.js" type="text/javascript"></script>
</head>
  <body class="page-md page-sidebar-page-sidebar-closed-hide-logo page-header-fixed page-footer-fixed">
        <div class="clearfix"></div>
    <div class="page-container">
        <div class="page-content">
            <div class="page-content">
                                <!-- end -->

<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue">
            <div style="
          display: flex;
          margin-bottom: 1.25rem;
          justify-content: center;
          align-items: center;
        ">
        <button onclick="printDiv('printArea')" style="padding-top: 0.25rem;
          padding-bottom: 0.25rem; 
          padding-left: 0.75rem;
          padding-right: 0.75rem; 
          border-radius: 0.25rem; 
          color: #ffffff; 
          background-color: #3B82F6; border-color: #3B82F6; ">
          প্রিন্ট
        </button>
      </div>

            <div class="portlet-body">

            
                   

            
        </div>
    </div>
</div>
                  @include('user.land.print-layout',array('data'=>$data,'root' => $root))
                  
                  <!-- // -->
                  
                  <div class="row">
                      
                    <div class="col-md-12">
                      <div style="text-align: center !important; display: block !important;">
                                                <!-- <a class="btn btn-md btn-success" href="https://ldtax.gov.bd/ldtax-holdings/individual-rashid-print-offline-preview/RER4YnJoTmRVVzBXaEorcDNKZ3diZz09" target="_blank" style="margin-top: 10px;padding:10px;">PDF</a> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <script type="text/javascript">
            function printDiv(divName) {
              var printContents = document.getElementById(divName).innerHTML;
              var originalContents = document.body.innerHTML;
              document.body.innerHTML = printContents;
              setTimeout(function() {}, 500);
              window.print();
              document.body.innerHTML = originalContents;
            }
          </script>
        </div>
      </div>
    </div>
    <style>
      .title {
        font-size: 15px;
        color: #592e80;
        text-align: center;
        font-weight: 600;
        padding-bottom: 7px;
      }
    </style>
    <!---<div class="page-footer no-print">
      <div class="page-footer-inner">
        <a href="http://www.bangladesh.gov.bd/" target="_blank">
          <img src="<?php echo $root; ?>bd.png" alt="">
        </a>
        <span class="title">ভূমি সংস্কার বোর্ড, ভূমি মন্ত্রণালয়, গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span>
        <!--   <a href="http://www.a2i.pmo.gov.bd/" target="_blank"><img src="https://ldtax.gov.bd/assets/admin/layout4/img/a2i.png" alt=""/></a> --> &nbsp;&nbsp;
      <!---</div>
      <!---<div class="page-footer-inner pull-right">
        <span class="title">কারিগরি সহায়তায়</span>
        <a href="http://mysoftheaven.com/" target="_blank">
          <img src="<?php echo $root; ?>auto.png" alt="" style="width: 140px;">
        </a> &nbsp;&nbsp;
      </div>
    </div>--->
    

    
  </body>
</html>