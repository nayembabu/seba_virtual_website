<?php $root = url('').'/assets/land/'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> ভূমি উন্নয়ন কর সিস্টেম অটোমেশন:LdtaxHoldings</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=600, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0, user-scalable=no" name="viewport">
    <link href="/assets/favicon.png" type="image/x-icon" rel="icon"/>
    <link href="/assets/favicon.png" type="image/x-icon" rel="shortcut icon"/>
    <meta content="" name="description">
    <meta content="" name="author">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="/assets/land/land.css">
    <link href="<?php echo $root; ?>css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $root; ?>simple-line-icons.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $root; ?>bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $root; ?>bootstrap-switch.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $root; ?>components-rounded.css" id="style_components" rel="stylesheet" type="text/css">    
    <link href="<?php echo $root; ?>layout.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $root; ?>light.css" rel="stylesheet" type="text/css" id="style_color">
    <link href="<?php echo $root; ?>custom.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $root; ?>common.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $root; ?>custom(1).css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo $root; ?>select2.min.css">
    <link rel="shortcut icon" href="/assets/images/favicon.png"> <!-- Updated favicon link -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
      @media print {
         .no-print {
             display:none!important;
         }
         .print {
             display:block!important;
         }
      }
      
      .print {
             display:none;
         }

      .loaderDiv {
          background: rgba(255,255,255,.95);
          width: 100%;
          height: 100%;
          z-index: 10000;
          position: fixed;
          top: 0;
          left: 0;
          display: none;
      }
      
      .loader {
          border: 5px solid #f3f3f3;
          border-radius: 50%;
          border-top: 5px solid blue;
          border-bottom: 5px solid green;
          -webkit-animation: spin 2s linear infinite;
          animation: spin 2s linear infinite;
          display: none;
          left: 47%;
          top: 36%;
          height: 50px;
          width: 50px;
      }

      @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
      }

      @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
      }
    </style>

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
                <div id="printArea" style="width: 815px; margin: 0 auto;">
                   

            
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
    
    <div class="print">
         @include('user.land.print-layout',array('data'=>$data,'root' => $root))
    </div>
    
  </body>
</html>