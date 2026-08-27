<!DOCTYPE html>
<html>
<head>
    <title>Education Board Bangladesh - {{ $markSheet->student_name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="">
    <link href="{{ asset('assets/bn-font.css') }}" rel="stylesheet">
    <style>
        /* CSS for Education Board Bangladesh Marksheet */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }

        /* Table styles */
        table {
            border-collapse: collapse;
        }

        /* Text color classes */
        .black12 {
            font-size: 12px;
            color: #000000;
        }

        .black12bold {
            font-size: 12px;
            color: #000000;
            font-weight: bold;
        }

        .black16bold {
            font-size: 16px;
            color: #000000;
            font-weight: bold;
        }

        /* Link styles */
        .links {
            color: #0066CC;
            text-decoration: none;
        }

        .links:hover {
            text-decoration: underline;
        }

        .links02 {
            color: #FFFFFF;
            text-decoration: none;
        }

        .links02:hover {
            text-decoration: underline;
        }

        /* Background color classes */
        .bar_bk {
            background-color: #86C775;
        }

        .left_round {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .footer_text {
            font-size: 11px;
            color: #666666;
        }

        /* Print styles */
        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .print-container {
                width: 100% !important;
                margin: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }

            @page {
                margin: 0;
                size: auto;
            }
        }

        /* Container for the marksheet */
        .print-container {
            width: 650px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Button styles for non-print elements */
        .print-button {
            background-color: #1e4db7;
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-button:hover {
            background-color: #153a8a;
        }

        .close-button {
            background-color: #fc4b6c;
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'SolaimanLipi', sans-serif;
            font-size: 14px;
        }

        .close-button:hover {
            background-color: #e63e5c;
        }
    </style>
</head>
<body>
<div class="no-print" style="text-align: center; margin: 20px 0;">
    <a href="{{ route('user.mark_sheet.index') }}" class="close-button" style="margin-right: 10px; text-decoration: none; display: inline-block;">
        à¦ªà¦¿à¦›à¦¨à§‡
    </a>
    <button onclick="window.print()" class="print-button">
        Print Marksheet
    </button>
</div>

<div class="print-container">
<!-- Main Table Structure -->
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <!-- Top Border Row -->
  <tr>
    <td width="12" align="left" valign="top" background="{{ asset('assets/marksheet_images/back_cor_left_top.gif') }}"><img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="12" height="12"></td>
    <td valign="top" background="{{ asset('assets/marksheet_images/back_top.gif') }}"><img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="626" height="12"></td>
    <td width="12" align="right" valign="top" background="{{ asset('assets/marksheet_images/back_cor_right_top.gif') }}"><img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="12" height="12"></td>
  </tr>

  <!-- Main Content Row -->
  <tr>
    <td align="left" valign="top" background="{{ asset('assets/marksheet_images/back_left.gif') }}">&nbsp;</td>
    <td valign="top" bgcolor="#FFFFFF">

      <!-- Header Section -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <!-- Logo Cell -->
          <td width="142" height="121" align="center" valign="middle" bgcolor="#EEEEEE" class="left_round">
            <img src="{{ asset('assets/marksheet_images/bd_logo.png') }}" width="82" height="82" alt="Bangladesh Logo">
          </td>
          <td width="2"><img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="2" height="1"></td>

          <!-- Ministry Info Cell -->
          <td valign="top" bgcolor="#007814">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="bottom">
                        <h1 id="site_title_des" style="color: white; font-size: 18px; margin: 10px 0 0 10px; padding: 0; font-weight: bold;">
                          Ministry of Education
                        </h1>
                      </td>
                      <td align="right" valign="top">
                        <img src="{{ asset('assets/marksheet_images/banner_flag.jpg') }}" width="220" height="41" alt="Banner Flag">
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td align="left" bgcolor="#479e55"><img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="1" height="1"></td>
              </tr>
              <tr>
                <td height="55" align="left">
                  <h1 id="site_title" style="color: white; font-size: 16px; margin: 5px 0 0 10px; padding: 0; font-weight: bold;">
                    Intermediate and Secondary Education Boards Bangladesh
                  </h1>
                </td>
              </tr>
              <tr>
                <td align="right" bgcolor="#FFFFFF"><img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="1" height="1"></td>
              </tr>
              <tr>
                <td height="23" align="right" bgcolor="#86C775" class="bar_bk">
                  <a href="http://www.educationboard.gov.bd" class="links02" style="padding-right: 10px; font-size: 14px;">
                    Official Website of Education Board
                  </a>&nbsp;
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

      <!-- Main Content Area -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="50" align="center" valign="middle" class="black16bold">
            {{ $markSheet->exam_name }} {{ $markSheet->year }}
          </td>
        </tr>

        <!-- Student Information Table -->
        <tr>
          <td align="center" valign="middle">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="middle">
                  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="black12">
                    <!-- Row 1: Roll No and Name -->
                    <tr>
                      <td width="12%" align="left" valign="middle" bgcolor="#EEEEEE">Roll No</td>
                      <td width="27%" align="left" valign="middle" bgcolor="#EEEEEE">{{ $markSheet->roll_no }}</td>
                      <td width="22%" align="left" valign="middle" bgcolor="#EEEEEE">Name</td>
                      <td width="39%" align="left" valign="middle" bgcolor="#EEEEEE">{{ $markSheet->student_name }}</td>
                    </tr>

                    <!-- Row 2: Board and Father's Name -->
                    <tr>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">Board</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">{{ $markSheet->board }}</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">Father's Name</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">{{ $markSheet->father_name }}</td>
                    </tr>

                    <!-- Row 3: Group and Mother's Name -->
                    <tr>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">Group</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">{{ $markSheet->group_name ? ucwords(strtolower($markSheet->group_name)) : 'N/A' }}</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">Mother's Name</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">{{ $markSheet->mother_name }}</td>
                    </tr>

                    <!-- Row 4: Type and Date of Birth -->
                    <tr>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">Type</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">{{ $markSheet->student_type == 'REGULAR' ? 'REGULAR' : 'IRREGULAR' }}</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">Date of Birth</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">{{ $markSheet->date_of_birth ? $markSheet->date_of_birth->format('d-m-Y') : 'N/A' }}</td>
                    </tr>

                    <!-- Row 5: Result and Institute -->
                    <tr>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">Result</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE" class="black12bold">{{ $markSheet->result }}</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">Institute</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">{{ $markSheet->institute_name }}</td>
                    </tr>

                    <!-- Row 6: GPA -->
                    <tr>
                      <td align="left" valign="middle" bgcolor="#EEEEEE">GPA</td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE" class="black12bold" colspan="3">{{ $markSheet->gpa }}</td>
                    </tr>
                  </table>
                </td>
              </tr>

              <!-- Grade Sheet Title -->
              <tr>
                <td height="40" align="center" valign="middle">
                  <span class="black16bold">Grade Sheet</span>
                </td>
              </tr>

              <!-- Subjects Table -->
              <tr>
                <td align="center" valign="middle">
                  @php $subjects = is_string($markSheet->subjects) ? json_decode($markSheet->subjects, true) : $markSheet->subjects; @endphp
                  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="black12">
                    <!-- Table Header -->
                    <tr class="black12bold">
                      <td width="19%" align="left" valign="middle" bgcolor="#AFB7BE">Code</td>
                      <td width="66%" align="left" valign="middle" bgcolor="#AFB7BE">Subject</td>
                      <td width="15%" align="left" valign="middle" bgcolor="#AFB7BE">Grade</td>
                    </tr>

                    <!-- Subjects List -->
                    @foreach($subjects as $idx => $subject)
                    <tr>
                      <td align="left" valign="middle" bgcolor="{{ $idx % 2 == 0 ? '#EEEEEE' : '#DEE1E4' }}">{{ $subject['code'] ?? '---' }}</td>
                      <td align="left" valign="middle" bgcolor="{{ $idx % 2 == 0 ? '#EEEEEE' : '#DEE1E4' }}">{{ $subject['name'] ?? '' }}</td>
                      <td align="left" valign="middle" bgcolor="{{ $idx % 2 == 0 ? '#EEEEEE' : '#DEE1E4' }}" class="black12bold">{{ $subject['grade'] ?? '---' }}</td>
                    </tr>
                    @endforeach
                  </table>
                </td>
              </tr>

              <!-- Search Again Link -->
              <tr>
                <td align="center" valign="middle" height="40">
                  <a href="#" onclick="window.print()" class="links">Print Marksheet</a>
                </td>
              </tr>

              <!-- Footer Section -->
              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="#86c775">
                      <td colspan="5"><img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="1" height="5"></td>
                    </tr>
                    <tr>
                      <td colspan="5"><img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="1" height="1"></td>
                    </tr>
                    <tr>
                      <td width="5" align="left" valign="bottom" bgcolor="#F2F2F2" class="footer_text">
                        <img src="{{ asset('assets/marksheet_images/footer_corner_left.gif') }}" width="5" height="5">
                      </td>
                      <td width="356" height="70" align="left" valign="middle" bgcolor="#F2F2F2" class="footer_text">
                        &copy;2005-2025 Ministry of Education, All rights reserved.
                      </td>
                      <td width="150" height="70" align="right" valign="middle" bgcolor="#F2F2F2" class="footer_text">
                        Powered by
                      </td>
                      <td width="110" height="70" align="center" valign="middle" bgcolor="#F2F2F2">
                        <img src="{{ asset('assets/marksheet_images/tbl_logo.png') }}" width="83" height="44" alt="TBL Logo">
                      </td>
                      <td width="5" align="left" valign="bottom" bgcolor="#F2F2F2" class="footer_text">
                        <img src="{{ asset('assets/marksheet_images/footer_corner_right.gif') }}" width="5" height="5">
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td align="right" valign="top" background="{{ asset('assets/marksheet_images/back_right.gif') }}">&nbsp;</td>
  </tr>

  <!-- Bottom Border Row -->
  <tr>
    <td align="left" valign="top" background="{{ asset('assets/marksheet_images/back_cor_left_bot.gif') }}">
      <img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="12" height="12">
    </td>
    <td valign="top" background="{{ asset('assets/marksheet_images/back_bot.gif') }}">
      <img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="626" height="12">
    </td>
    <td align="right" valign="top" background="{{ asset('assets/marksheet_images/back_cor_right_bot.gif') }}">
      <img src="{{ asset('assets/marksheet_images/trans.gif') }}" width="12" height="12">
    </td>
  </tr>
</table>
</div>

</body>
</html>
