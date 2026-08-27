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

            

            .b1 {
                border: 1px dotted;
                padding: 2px;
            }
        </style>

        <style type="text/css" media="print">
            @page {
                size: A4;
                margin: 0mm; /* this affects the margin in the printer settings */
            }

            html {
                background-color: #FFFFFF;
                margin: 0px; /* this affects the margin on the html before sending to printer */
            }

            body {
                border: solid 0px blue;
                margin: 0mm; /* margin you want for the content */
            }

            /* Hide non-printable elements */
            .no-print {
                display: none;
            }

            /* Ensure table styles are appropriate for print */
            .table-bordered {
                border: 1px solid #000; /* stronger border for visibility in print */
            }
        </style>
        <?php
        // Generate QR Code
        $chl = str_replace(url('/'), 'https://dakhila.ldtax.gov.bdi.ink', route('user.land.verify', $data['uid']));
        $qrcode = 'data:image/png;base64,' . base64_encode(QrCode::format('png')->size(150)->margin(0)->generate($chl));
        ?>
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
                                    <td style="width: 180px;">মৌজার নাম ও জে. এল. নং:</td>
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
                              <div style="text-align: center;">
  
                                <tr>
                                  <td>
                                    <span style="font-weight: bold; text-decoration: underline; font-size: 13px;">মালিকের বিবরণ</span>

                                  </td>
                                </tr>
                             
                            </div>
                              
                              
                              
                            @php
                            $mdatas = json_decode($data['malik_name']);
                            $mdatas = !blank($mdatas) ? $mdatas : array();
                            $mcount = count($mdatas);
                            $mhalf = round($mcount/2);
                            $twidth = ( $mcount == '1' ) ? '99' : '49';
                            $nexthalf = ( $mcount == '1' ) ? 0 : $mcount - $mhalf;
                            @endphp
                            
                                                
                           
                            <table class="b1" style="border-collapse: collapse; margin:10px 2px ; width: {{$twidth}}%; font-size: 11px; float: left;">
                              <thead>
                                <tr>
                                  <th class="b1" style="text-align: center;">ক্রমঃ</th>
      <th class="b1" style="text-align: center;">মালিকের নাম</th>
      <th class="b1" style="text-align: center;">মালিকের অংশ</th></tr>
                              </thead>
                              <tbody style="height: 21px;">
                                  
                                @for($i = 1; $i<=$mhalf; $i++)
                                 
                                <tr>
                                  <td class="b1 input_bangla"><?php echo bn_number($i); ?></td>
                                  <td class="b1">{{ $mdatas[$i-1]->name }}</td>
                                  <td class="b1 input_bangla" style="text-align: center;">{{ $mdatas[$i-1]->total }}</td>
                                </tr>
                                
                                @endfor
                                
                              </tbody>
                            </table>
                            
                            @if ( $nexthalf > 0 )
                           
                            
                            <table class="b1" style="border-collapse: collapse; margin:10px 2px ; width: {{$twidth}}%; font-size: 11px; float: left;">
                              <thead>
                                <tr>
                                  <th class="b1" style="text-align: center;">ক্রমঃ</th>
      <th class="b1" style="text-align: center;">মালিকের নাম</th>
      <th class="b1" style="text-align: center;">মালিকের অংশ</th> </tr>
                              </thead>
                              <tbody style="height: 21px;">
                                  
                                @for($v = 1; $v<=$nexthalf; $v++)
                                @php
                                $i++;
                                @endphp
                                 
                                <tr>
                                  <td class="b1 input_bangla"><?php echo bn_number($i-1); ?></td>
                                  <td class="b1">{{ $mdatas[$i-2]->name }}</td>
                                  <td class="b1 input_bangla" style="text-align: center;">{{ $mdatas[$i-2]->total }}</td>

                                </tr>
                                
                                @endfor
                                
                              </tbody>
                            </table>
                          
                            @endif
                              
                              {{--<table style="margin-top:5px; width:100%;">
                                <tbody>
                                  <tr>
                                    <td style="width: 90px">মালিকের নাম :</td>
                                    <td class="dotted_botton" style="padding-left: 10px;"> <?php echo $data['malik_name']; ?></td>
                                  </tr>
                                </tbody>
                              </table>--}}
                              
                              <div style="text-align: center;clear:both">
  
                                <tr>
                                  <td>
                                    <span style="font-weight: bold; text-decoration: underline; font-size: 13px;">জমির বিবরণ</span>

                                  </td>
                                </tr>
                             
                            </div>
                              @php
    $jomi_infos = json_decode($data['jomi_info'], true);
    $jomi_count = count($jomi_infos);
    $jomi_half = ceil($jomi_count / 2);
    $jomi_table_width = ($jomi_count == 1) ? '99%' : '49%';
    $jomi_next_half = ($jomi_count == 1) ? 0 : $jomi_count - $jomi_half;
@endphp

                           @if (count(json_decode($data['jomi_info'], true)) > 1)
    <table class="b1" style="border-collapse: collapse; margin:10px 2px ; width: {{$jomi_table_width}}; font-size: 11px; float: left;">
@else
    <table class="b1" style="border-collapse: collapse; margin:10px 2px; width: 100%; font-size: 11px; float: left;">
@endif
    <thead>
        <tr>
            <th class="b1" style="text-align: center;">ক্রমঃ</th>
            <th class="b1" style="text-align: center;">দাগ নং</th>
            <th class="b1" style="text-align: center;">জমির শ্রেণী</th>
            <th class="b1" style="text-align: center;">জমির পরিমাণ (শতাংশ)</th>
        </tr>
    </thead>
    <tbody style="height: 21px;">
        <?php $total = 0; $half = ceil(count(json_decode($data['jomi_info'], true)) / 2); ?>
        @foreach (array_slice(json_decode($data['jomi_info'], true), 0, $half) as $key => $jomi)
        <?php $total += $jomi['jomi_poriman']; ?>
        <tr>
            <td class="b1 input_bangla"><?php echo bn_number($key + 1); ?></td>
            <td class="b1 input_bangla"><?php echo bn_number($jomi['dag_no']); ?></td>
            <td class="b1"><?php echo $jomi['jomi_type']; ?></td>
            <td class="b1 input_bangla"><?php echo bn_number($jomi['jomi_poriman']); ?></td>
        </tr>
        @endforeach
    </tbody>
</table>

                        
                            @if(count(json_decode($data['jomi_info'], true)) > 1)
    <!-- Right Table -->
    <table class="b1" style="border-collapse: collapse; margin:10px 2px ; width: {{$jomi_table_width}}; font-size: 11px; float: left;">
        <thead>
            <tr>
                <th class="b1" style="text-align: center;">ক্রমঃ</th>
                <th class="b1" style="text-align: center;">দাগ নং</th>
                <th class="b1" style="text-align: center;">জমির শ্রেণী</th>
                <th class="b1" style="text-align: center;">জমির পরিমাণ (শতাংশ)</th>
            </tr>
        </thead>
        <tbody style="height: 21px;">

            @foreach (array_slice(json_decode($data['jomi_info'], true), $half) as $key => $jomi)
            <?php $total += $jomi['jomi_poriman']; ?>
            <tr>
                <td class="b1 input_bangla"><?php echo bn_number($key + 1 + $half); ?></td>
                <td class="b1 input_bangla"><?php echo bn_number($jomi['dag_no']); ?></td>
                <td class="b1"><?php echo $jomi['jomi_type']; ?></td>
                <td class="b1 input_bangla"><?php echo bn_number($jomi['jomi_poriman']); ?></td>
            </tr>
            @endforeach

        </tbody>
    </table>
@endif

                        
                            <div style="clear: both;"></div> <!-- Clear float to prevent overlap -->
                        
                        </div>
                        </div>
                        <table style="width: 100%;">
                          <tbody>
                            <tr>
                              <td class="b1 text-center" style="width: 50%;">সর্বমোট জমি (শতাংশ)</td>
                              <td class="b1 input_bangla" style="width: 50%;"><?php echo bn_number(sprintf('%g',$total)); ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-striped table-bordered table-hover" style="width:100% !important;">
                          <tbody>
                            <table class="table table-striped table-bordered table-hover" style="width:100% !important;">
  <tbody>
    <tr>
      <th style="text-align: center;" colspan="8">আদায়ের বিবরণ </th>
    </tr>
    <tr>
      <td style="text-align: center;">তিন বৎসরের ঊর্ধ্বের বকেয়া</td>
      <td style="text-align: center;">গত তিন বৎসরের বকেয়া </td>
      <td style="text-align: center;">বকেয়ার জরিমানা ও ক্ষতিপূরণ </td>
      <td style="text-align: center;">হাল দাবি </td>
      <td style="text-align: center;">মোট দাবি</td>
      <td style="text-align: center;">মোট আদায় </td>
      <td style="text-align: center;">মোট বকেয়া</td>
      <td style="text-align: center;">মন্তব্য</td>
    </tr>
    <tr>
      <?php 
        // Function to format numbers in Bengali style
        function format_bengali_number($number) {
            // Remove non-numeric characters except decimal points
            $cleaned_number = preg_replace('/[^0-9.]/', '', $number);
            
            // Convert to float for formatting
            $numeric_value = floatval($cleaned_number);

            // Format with commas and convert to Bengali digits
            $formatted = number_format($numeric_value, 0, '.', ',');
            return str_replace(
                ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], 
                ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'], 
                $formatted
            );
        }
      ?>
      <td align="center"><?php echo format_bengali_number($data['tin_bokaya']); ?></td>
      <td align="center"><?php echo format_bengali_number($data['goto_bokaya']); ?></td>
      <td align="center"><?php echo format_bengali_number($data['bokayar_khoti']); ?></td>
      <td align="center"><?php echo format_bengali_number($data['hall_dabi']); ?></td>
      <td align="center"><?php echo format_bengali_number($data['mot_dabi']); ?></td>
      <td align="center"><?php echo format_bengali_number($data['mot_aday']); ?></td>
      <td align="center"><?php echo format_bengali_number($data['mot_bokaya']); ?></td>
      <td align="center"><?php echo htmlspecialchars($data['montobo']); ?></td> <!-- No formatting needed for text -->
    </tr>
  </tbody>
</table>
<div style="width:100% !important;">

    <p class="dotted_botton">সর্বমোট (কথায়):
    <?php 
        // Check if mot_aday exists
        if (isset($data['mot_aday'])) {
            // Remove commas and non-numeric characters
            $clean_mot_aday = preg_replace('/[^0-9.]/', '', $data['mot_aday']);
            
            // Ensure the cleaned value is numeric
            if (is_numeric($clean_mot_aday)) {
                echo bn_in_word($clean_mot_aday); 
            } else {
                echo 'Invalid amount'; // Fallback if it's still not numeric
            }
        } else {
            echo 'No amount available';
        }
    ?>  টাকা মাত্র। </p>
</div>

                        <div class="row" style="width:100% !important; justify-content: center;">
                          <div class="col-md-12">
                            <div style="width: 355px; float: left;" align="left">
                              <p style="margin: 0 !important;"></p>
                              <p style="margin: 0 !important;">নোট: সর্বশেষ কর পরিশোধের সাল - <?php echo $data['porishud']; ?> </p>
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
                            <div style="width: 100px; float: left;" align="center">
                              <div class="qrcode-print">
            <img src="<?php echo $qrcode; ?>" alt="QR Code" style="width: 80%; height: auto;" />
        </div>
                             
                            </div>
                            <div style="width: 240px; float: right; text-align: right;font-size: 12px;font-family: &#39;kalpurush&#39;,Arial,sans-serif;">
                              <p class="text-center" style="padding: 5px; ">এই দাখিলা ইলেক্ট্রনিকভাবে তৈরি করা হয়েছে, <br> কোন স্বাক্ষর প্রয়োজন নেই। </p>
                            </div>
                          </div>
                        </div>


                    <div style="height: 250px;"></div
                <div style="text-align: center; clear: both; margin-top: 20px;">
                  <div class="row">
                  <div class="col-md-12 text-right">
                    <div style="width: 100%; border-top: 1px dotted gray; margin-top: 15px;"></div>
                    <div class="from-controll">1/1</div>
                  </div>
                        </div>
                      </div>
                    </div>
                  </div>
