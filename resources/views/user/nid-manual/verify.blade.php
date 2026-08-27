<?php $root = url('').'/assets/land/'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> ভূমি উন্নয়ন কর সিস্টেম অটোমেশন:LdtaxHoldings</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=600, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0, user-scalable=no" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
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
    <link rel="shortcut icon" href="https://ldtax.gov.bd/img/favicon.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style type="text/css">
      /* Chrome, Safari, Edge, Opera */
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      /* Firefox */
      input[type=number] {
        -moz-appearance: textfield;
      }

      span.input-group-addon.addonExtra {
        background: #8dc642;
      }
    </style>
    <style>
      .loaderDiv {
        background: rgba(255, 255, 255, .95);
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
        /*position: relative;*/
        display: none;
        left: 47%;
        top: 36%;
        height: 50px;
        width: 50px;
      }

      @-webkit-keyframes spin {
        0% {
          -webkit-transform: rotate(0deg);
        }

        100% {
          -webkit-transform: rotate(360deg);
        }
      }

      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }

        100% {
          transform: rotate(360deg);
        }
      }
    </style>
  </head>

  <body class="page-md page-sidebar-page-sidebar-closed-hide-logo page-header-fixed page-footer-fixed ecommerce_nomal_version">
    <div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
      <!-- BEGIN HEADER INNER -->
      <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
          <!-- <a href=""> -->
          <a href="https://office.land.gov.bd/">
            <img src="<?php echo $root; ?>logo-light.png" alt="logo" class="logo-default">
          </a>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
        <div class="page-top">
          <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
              <li class="separator hide"></li>
              <li>
                <br>
              </li>
              <li class="separator hide"></li>
              <img src="<?php echo $root; ?>nagorik.png">
              <!-- END USER LOGIN DROPDOWN -->
            </ul>
          </div>
          <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
      </div>
      <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER-->
    <!-- <div>You will be auto logged out in <span id="timeOut"></span> seconds.</div> -->
    <div class="clearfix"></div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
      <!-- BEGIN SIDEBAR -->
      <!-- END SIDEBAR -->
      <div class="page-content-wrapper">
        <div class="">
          <!-- end -->
          <div class="row">
            <div class="col-md-12">
              <div class="portlet box blue">
                <div class="portlet-title">
                  <div class="caption">
                    <i class="fa fa-globe"></i>ভূমি উন্নয়ন কর পরিশোধ রসিদ
                  </div>
                  <div class="tools" style="display: none;">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""></a>
                    <a href="#" data-toggle="modal" class="config" data-original-title="" title=""></a>
                    <a href="javascript:;" class="reload" data-original-title="" title=""></a>
                    <a href="javascript:;" class="remove" data-original-title="" title=""></a>
                  </div>
                </div>
                <div class="portlet-body" style="overflow: hidden;">
                  <div id="printArea" style="width: 815px; margin: 0 auto;">
                    <div class="col-md-12">
                      <style type="text/css">
                        body {
                          font-family: "kalpurush", Arial, sans-serif;
                          font-size: 13px !important;
                          line-height: 1.2;
                          color: #333;
                          background-color: #fff;
                        }

                        .dotted_botton {
                          border: none;
                          border-bottom: 1px dotted #000;
                          background-color: #fff;
                        }

                        .border_none {
                          border-top: none !important;
                        }

                        .table-bordered {
                          border: 1px solid #ddd;
                        }

                        .qrcode-print {
                          <?php
                         
                          $cht = "qr";
                          $chld = "L";
                          $chs = "82x82";
                          $chl = urlencode(route('user.land.verify',$data['id']));
                          $choe = "UTF-8";
                          $qrcode = 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chld='.$chld.'|0&chl=' . $chl . '&choe=' . $choe;
                          ?>
                            width: 100%;
                            display: list-item;
                            list-style-image: url('<?php echo $qrcode; ?>');
                            list-style-position: inside;
                            background-repeat: no-repeat;
                        }

                        .b1 {
                          border: 1px dotted;
                          padding: 2px;
                        }
                      </style>
                      <style type="text/css" media="print">
                        @page {
                          size: A4;
                          /* auto is the initial value */
                          margin: 0mm;
                          /* this affects the margin in the printer settings */
                        }

                        html {
                          background-color: #FFFFFF;
                          margin: 0px;
                          /* this affects the margin on the html before sending to printer */
                        }

                        body {
                          border: solid 0px blue;
                          margin: 0mm;
                          /* margin you want for the content */
                        }
                      </style>
                      <div style="font-family:&#39;kalpurush&#39;,Arial,sans-serif; font-size:14px !important; line-height:1.2;color: #333; background-color: #fff; width: 7.9in; border-radius: 10px; border: dotted 1px; padding: 10px; float: left; margin: 30px auto;">
                        <div class="row">
                          <div class="col-md-12">
                            <div style="">
                              <table style="width: 100%;">
                                <tbody>
                               
                                  <tr>
                                    <td class="text-left">বাংলাদেশ ফরম নং ১০৭৭</td>
                                    <td class="text-right">(পরিশিষ্ট: ৩৮)</td>
                                  </tr>
                                  <tr>
                                    <td class="text-left">(সংশোধিত)</td>
                                    <td class="text-right input_bangla">ক্রমিক নং <?php echo bn_number($data['sl_no']); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="text-center" colspan="2"> ভূমি উন্নয়ন কর পরিশোধ রসিদ </td>
                                  </tr>
                                  <tr>
                                    <td class="text-center" colspan="2"> (অনুচ্ছেদ ৩৯২ দ্রষ্টব্য) </td>
                                  </tr>
                                </tbody>
                              </table>
                              <div style="width: 100%; height: 20px;"></div>
                              <table style="width:100%;">
                                <tbody>
                                  <tr>
                                    <td style="width: 320px;">সিটি কর্পোরেশন /পৌর /ইউনিয়ন ভূমি অফিসের নাম :</td>
                                    <td class="dotted_botton"><?php echo $data['office_name']; ?></td>
                                  </tr>
                                </tbody>
                              </table>
                              <table style="margin-top:5px; width:100%;">
                                <tbody>
                                  <tr>
                                    <td style="width: 130px;">মৌজার ও জে. এল. নং:</td>
                                    <td class="dotted_botton input_bangla" style="padding: 0 10px 0 5px;"><?php echo $data['muja_no']; ?></td>
                                    <td style="width: 105px">উপজেলা / থানা :</td>
                                    <td class="dotted_botton" style="padding: 0 10px 0 5px;"><?php echo $data['upazila_name']; ?></td>
                                    <td style="width: 40px">জেলা:</td>
                                    <td class="dotted_botton" style="padding: 0 10px 0 5px;"><?php echo $data['zila_name']; ?></td>
                                  </tr>
                                </tbody>
                              </table>
                              <table style="margin-top:5px; width:100%;">
                                <tbody>
                                  <tr>
                                    <td style="width: 90px">মালিকের নাম :</td>
                                    <td class="dotted_botton" style="padding-left: 10px;"> <?php echo $data['malik_name']; ?></td>
                                  </tr>
                                </tbody>
                              </table>
                              <table style="margin-top:5px; width:100%;">
                                <tbody>
                                  <tr>
                                    <td style="width: 225px">২ নং রেজিস্টার অনুযায়ী হোল্ডিং নম্বর:</td>
                                    <td class="dotted_botton numeric_bangla" style="padding-left: 10px;"> <?php echo bn_number($data['holding_no']); ?> </td>
                                  </tr>
                                </tbody>
                              </table>
                              <table style="margin-top:5px; width:100%;">
                                <tbody>
                                  <tr>
                                    <td style="width: 75px">খতিয়ান নং:</td>
                                    <td class="dotted_botton numeric_bangla" style="padding-left: 10px;"> <?php echo bn_number($data['khotiyan_no']); ?> </td>
                                  </tr>
                                </tbody>
                              </table>
                              <div style="height: 10px"></div>
                            </div>
                            <table class="b1" style="border-collapse: collapse; margin:10px 2px ; width: 99%; font-size: 9px; float: left;">
                              <thead>
                                <tr>
                                  <th class="b1">ক্রমঃ</th>
                                  <!-- <th class="b1">খতিয়ান নং</th> -->
                                  <th class="b1">দাগ নং</th>
                                  <th class="b1">জমির শ্রেণী</th>
                                  <th class="b1">জমির পরিমাণ (শতক)</th>
                                </tr>
                              </thead>
                              <tbody style="height: 21px;">
                               
                                <?php $total = 0; ?>
                                
                            @foreach ( json_decode($data['jomi_info'],true) as $key=> $jomi )
                              <?php $total += $jomi['jomi_poriman']; ?>
                                <tr>
                                  <td class="b1 input_bangla"><?php echo bn_number($key+1); ?></td>
                                  <td class="b1 input_bangla"><?php echo bn_number($jomi['dag_no']); ?></td>
                                  <td class="b1"><?php echo $jomi['jomi_type']; ?></td>
                                  <td class="b1 input_bangla"><?php echo bn_number($jomi['jomi_poriman']); ?></td>
                                </tr>
                               @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <table style="width: 100%;">
                          <tbody>
                            <tr>
                              <td class="b1 text-center" style="width: 50%;">সর্বমোট জমি (শতক)</td>
                              <td class="b1 input_bangla" style="width: 50%;"><?php echo bn_number(sprintf('%g',$total)); ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-striped table-bordered table-hover" style="width:100% !important;">
                          <tbody>
                            <tr>
                              <th style="text-align: center;" colspan="8">আদায়ের বিবরণ </th>
                            </tr>
                            <tr>
                              <th style="text-align: center;">তিন বৎসরের ঊর্ধ্বের বকেয়া</th>
                              <th style="text-align: center;">গত তিন বৎসরের বকেয়া </th>
                              <th style="text-align: center;">বকেয়ার সুদ ও ক্ষতিপূরণ </th>
                              <th style="text-align: center;">হাল দাবি </th>
                              <th style="text-align: center;">মোট দাবি</th>
                              <th style="text-align: center;">মোট আদায় </th>
                              <th style="text-align: center;">মোট বকেয়া</th>
                              <th style="text-align: center;">মন্তব্য</th>
                            </tr>
                            <tr>
                              <td align="center"><?php echo bn_number($data['tin_bokaya']); ?></td>
                              <td align="center"><?php echo bn_number($data['goto_bokaya']); ?></td>
                              <td align="center"><?php echo bn_number($data['bokayar_khoti']); ?></td>
                              <td align="center"><?php echo bn_number($data['hall_dabi']); ?></td>
                              <td align="center"><?php echo bn_number($data['mot_dabi']); ?></td>
                              <td align="center"><?php echo bn_number($data['mot_aday']); ?></td>
                              <td align="center"><?php echo bn_number($data['mot_bokaya']); ?></td>
                              <td align="center"><?php echo bn_number($data['montobo']); ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <div style="width:100% !important;">
                          <p class="dotted_botton">সর্বমোট (কথায়):
                          <?php echo bn_in_word($data['mot_aday']); ?> টাকা মাত্র। </p>
                        </div>
                        <div class="row" style="width:100% !important; justify-content: center;">
                          <div class="col-md-12">
                            <div style="width: 290px; float: left;" align="left">
                              <p style="margin: 0 !important;"></p>
                              <p style="margin: 0 !important;">নোট: সর্বশেষ কর পরিশোধের সাল - <?php echo bn_number($data['porishud']); ?></p>
                              <p></p>
                              <p class="input_bangla"> চালান নং : <?php echo bn_number($data['chalan_no']); ?></p>
                              <p> তারিখ : </p>
                              <div style="margin-top: -37px;margin-left: 10px;">
                                <p style="width: 115px;padding: 0;margin: 0;margin-left: 38px;margin-bottom: 2px;"><?php  echo $data['bn_date']; ?>
                              </p>
                                <span style="border-top:1px solid; margin-left:36px;"><?php
                                 echo en_to_bn_date(date('j F, Y',strtotime($data['publish_date']))); ?></span>
                                <p></p>
                              </div>
                              <p></p>
                            </div>
                            <div style="width: 125px; float: left;" align="center">
                              <!-- <img style="-webkit-print-color-adjust: exact; max-width: 100%; height: auto; " src="https://ldtax.gov.bd/img/qrimg/76028956.png" width="100" height="100"> -->
                              <div class="qrcode-print"></div>
                            </div>
                            <div style="width: 265px; float: right; text-align: right;font-size: 12px;font-family: &#39;kalpurush&#39;,Arial,sans-serif;">
                              <p class="text-center" style="padding: 5px; ">এই দাখিলা ইলেক্ট্রনিকভাবে তৈরি করা হয়েছে, <br> কোন স্বাক্ষর প্রয়োজন নেই। </p>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12 text-right">
                            <div style="width: 100%; border-top: 1px dotted gray; margin-top:15px;"></div>
                            <div class="from-controll">1/1</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- // -->
                  <div class="row">
                    <div class="col-md-12">
                      <div style="text-align: center !important; display: block !important;">
                        <input style="margin-top: 10px; padding: 10px;font-family: 'kalpurush';" id="print" class="btn btn-md blue" type="button" onclick="printDiv(&#39;printArea&#39;)" value="প্রিন্ট">
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
    <div class="page-footer">
      <div class="page-footer-inner">
        <a href="http://www.bangladesh.gov.bd/" target="_blank">
          <img src="<?php echo $root; ?>bd.png" alt="">
        </a>
        <span class="title">ভূমি সংস্কার বোর্ড, ভূমি মন্ত্রণালয়, গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</span>
        <!--   <a href="http://www.a2i.pmo.gov.bd/" target="_blank"><img src="https://ldtax.gov.bd/assets/admin/layout4/img/a2i.png" alt=""/></a> --> &nbsp;&nbsp;
      </div>
      <div class="page-footer-inner pull-right">
        <span class="title">কারিগরি সহায়তায়</span>
        <a href="http://mysoftheaven.com/" target="_blank">
          <img src="<?php echo $root; ?>auto.png" alt="" style="width: 140px;">
        </a> &nbsp;&nbsp;
      </div>
    </div>
  </body>
</html>