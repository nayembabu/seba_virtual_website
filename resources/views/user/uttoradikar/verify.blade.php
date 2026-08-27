<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />

    <!--[if lt IE 7]><html class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
    <!--[if IE 7]><html class="no-js lt-ie10 lt-ie9 lt-ie8" lang="en"> <![endif]-->
    <!--[if IE 8]><html class="no-js lt-ie10 lt-ie9" lang="en"> <![endif]-->
    <!--[if IE 9]><html class="no-js lt-ie10" lang="en"> <![endif]-->
    <!--[if gt IE 9]><!-->
    <!--<![endif]-->

    <title>Certificate</title>
    <link rel="stylesheet" href="{{ url('assets/police') }}/css/Core.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets/police') }}/css/Theme-Standard.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets/police') }}/css/font-apex.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets/police') }}/css/Core.min(1).css" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets/police') }}/css/Vita.min.css" type="text/css" />

    <style type="text/css">
    .articlenumber {
        color: red;
    }

    #t_Body_nav {
        display: none;
    }
    </style>
    <link rel="shortcut icon" href="https://pcc.police.gov.bd/ords/pcc2/r/500/files/static/v41/police.jpg" />
    <link rel="icon" sizes="16x16" href="https://pcc.police.gov.bd/ords/pcc2/r/500/files/static/v41/police.jpg" />
    <link rel="icon" sizes="32x32" href="https://pcc.police.gov.bd/ords/pcc2/r/500/files/static/v41/police.jpg" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://pcc.police.gov.bd/ords/pcc2/r/500/files/static/v41/police.jpg" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>

<body
    class="t-PageBody t-PageBody--hideLeft t-PageBody--hideActions apex-top-nav apex-icons-fontapex apex-theme-vita ecommerce_nomal_version js-HeaderExpanded t-PageBody--topNav"
    id="t_PageBody">

    <header class="t-Header" id="t_Header">
        <div id="R1518529264873173220" class="">
            <script type="text/javascript" src="{{ url('assets/police') }}/js/jquery1.8.3.min.js"></script>
            <script type="text/javascript">
            $("#btnPrint").live("click", function() {
                var divContents = $("#printID").html();
                var divHeader = $("#report_header_comon").html();
                var printWindow = window.open("", "", "height=400,width=800");
                printWindow.document.write("<html><body>");
                //printWindow.document.write(divHeader);
                //divHeader +
                //<head><title>DIV Contents</title></head>
                printWindow.document.write(divContents);
                printWindow.document.write("</body></html>");
                printWindow.document.close();
                printWindow.print();
            });
            </script>

            <style>
            #22_menubar_6i {
                color: #164678 !important;
            }

            .body {
                background-color: #e4e1dd;
                background-image: url("{{ url('assets/police') }}/img/body_bg.png");

                max-width: 1170px;
                margin: 0 auto;
            }

            #t_Body_title,
            .t_Body_title {
                max-width: 1162px !important;
                margin: 0 auto;
            }

            .t-Header,
            #t_Body_title,
            .t_Body_title {
                max-width: 1162px !important;
                margin: 0 auto;
            }

            .t-Form-checkboxLabel,
            .t-Form-inputContainer .checkbox_group label,
            .t-Form-inputContainer .radio_group label,
            .t-Form-label,
            .t-Form-radioLabel {
                color: #000;
            }

            form#wwvFlowForm {
                max-width: 1170px;
                margin: 0 auto;
            }

            .t-BreadcrumbRegion,
            .t-ButtonRegion {
                max-width: 1170px !important;
                margin: 0px auto;
            }

            body {
                background: #e8fff3;
                background-image: url("{{ url('assets/police') }}/img/body_bg.png");

                max-width: 1170px;
                margin: 0 auto;
            }

            .t-Body {
                background: #e4e1e1;
            }

            .t-Region {
                border: 1px solid rgba(0, 0, 0, 0.2);
                box-shadow: 0 2px 2px rgba(0, 0, 0, 0.21);
            }

            .t-Region-headerItems--title {
                text-align: left;
                padding: 1.3rem 1.2rem;
            }

            .t-Header .t-Button.t-Button--header.t-Button--header,
            .t-Header-logo-link {
                color: #d71c1c;
            }

            .t-Region--scrollBody>.t-Region-bodyWrap>.t-Region-body {
                /* background: linear-gradient(#fff 30%,rgba(255,255,255,0)),linear-gradient(rgba(255,255,255,0),#fff 70%) 0 100%,linear-gradient(rgba(0,0,0,.025),rgba(0,0,0,0)),linear-gradient(rgba(0,0,0,0),rgba(0,0,0,.025)) 0 100% #fff;*/
                background: #fff;
            }

            .t-Header-logo-link img {
                max-height: 60px;
            }

            #btnPrint {
                top: 7px;
                left: 316px;
            }

            #btnPrint:hover {
                cursor: pointer;
            }

            #header {
                padding-top: 150px;
            }

            .t-WizardSteps {
                height: 65px;
            }

            .t-Footer {
                display: none;
            }

            .t-Body-content {
                padding-bottom: 25px !important;
            }

            /*
#report_footer_comon{
display:none;
}
*/
            .t-Header-navBar {
                height: 50px !important;
            }

            .t-Header-branding {
                background-color: #fff;
                height: 65px;
            }

            .apex-side-nav .t-Body-actions,
            .apex-side-nav .t-Body-nav,
            .apex-side-nav .t-Body-title {
                top: 10px;
            }

            .a-IRR-toolbar {
                background: linear-gradient(#d3d8de, #d3d8de);
                border-color: #e2e2e2;
            }

            body .ui-dialog .ui-dialog-titlebar {
                background-color: #4696fc;
                border-bottom: 1px solid #0b2e52;
            }

            body .ui-dialog .ui-dialog-content {
                background-color: #fff;
                color: #404040;
                font-size: 16px;
                padding: 10px;
            }

            .ui-dialog-title {
                color: #f6f9fd !important;
            }

            .t-Region-title {
                font-weight: 500;
                letter-spacing: 1px;
                color: #000 !important;
            }

            .t-Region-header {
                background: linear-gradient(#f3f3f3, #d2d2d2);
            }

            #filterRegionID {
                max-width: 700px;
                margin: auto;

                padding-bottom: 7px;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            td,
            p,
            div,
            span,
            li {
                font-family: "SolaimanLipi", Helvetica Neue, Helvetica, Arial,
                    sans-serif;
            }

            .t-Form-field,
            .t-Form-inputContainer input.datepicker,
            .t-Form-inputContainer input.password,
            .t-Form-inputContainer input.popup_lov,
            .t-Form-inputContainer input.text_field,
            .t-Form-inputContainer input[type="text"],
            .t-Form-inputContainer select.selectlist,
            .t-Form-inputContainer select.yes_no,
            .t-Form-inputContainer select[multiple],
            .t-Form-inputContainer span.display_only,
            .t-Form-inputContainer textarea.textarea,
            .t-Form-select,
            .t-Form-textarea,
            .u-TF-item--datepicker,
            .u-TF-item--select,
            .u-TF-item--text,
            .u-TF-item--textarea {
                border-radius: 2px;
                padding: 3px 8px;
                height: 32px;
                max-width: 340px;
                font-size: 15px;
                color: #333;
                background-color: #f0f0f0;
                border-color: #e0e0e0;
            }

            .t-Form-label {
                padding: 0.4rem 0;
                line-height: 1.4rem;
                display: inline-block;
                -webkit-hyphens: auto;
                -moz-hyphens: auto;
                -ms-hyphens: auto;
                hyphens: auto;
                font-size: 15px;
            }
            </style>
        </div>
        <div class="t-Header-branding">
            <div class="t-Header-controls">
                <button class="t-Button t-Button--icon t-Button--header t-Button--headerTree" id="t_Button_navControl"
                    type="button">
                    <span class="t-Icon fa-bars" aria-hidden="true"></span>
                </button>
            </div>
            <div class="t-Header-logo">
                <a href="#" class="t-Header-logo-link"><img src="{{ url('assets/police') }}/img/PCMS_app_logo.png" style="height: 100px" /></a>
            </div>
            <div class="t-Header-navBar"></div>
        </div>
        <div class="t-Header-nav">
            <div class="t-Header-nav-list js-tabLike js-tabLike a-MenuBar a-MenuBar--overflow a-MenuBar--tabs"
                id="50_menubar" role="menubar" style="min-height: 40px">
                <ul role="none">
                    <li id="50_menubar_0" class="a-MenuBar-item">
                        <a role="menuitem" class="a-MenuBar-label" id="50_menubar_0i" href="#">Home</a>
                    </li>
                    <li id="50_menubar_1" class="a-MenuBar-item">
                        <a role="menuitem" class="a-MenuBar-label" id="50_menubar_1i" href="#" tabindex="-1">Apply</a>
                    </li>
                    <li id="50_menubar_2" class="a-MenuBar-item">
                        <a role="menuitem" class="a-MenuBar-label" id="50_menubar_2i" href="#" tabindex="-1">My
                            Account</a>
                    </li>
                    <li id="50_menubar_3" class="a-MenuBar-item">
                        <a role="menuitem" class="a-MenuBar-label" id="50_menubar_3i" href="#" tabindex="-1">Contact
                            us</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="t-Body">
        <div class="t-Body-main" style="margin-top: 0px">
            <div class="t-Body-title" id="t_Body_title" style="top: 105px"></div>
            <div class="t-Body-content" id="t_Body_content" style="margin-top: 102px">
                <span id="APEX_SUCCESS_MESSAGE" data-template-id="1602607964183329768_S"
                    class="apex-page-success u-hidden"></span><span id="APEX_ERROR_MESSAGE"
                    data-template-id="1602607964183329768_E" class="apex-page-error u-hidden"></span>
                <div class="t-Body-contentInner">
                    <div class="container">
                        <div class="row">
                            <div class="col col-1">
                                <span class="apex-grid-nbsp">&nbsp;</span>
                            </div>
                            <div class="col col-10">
                                <div class="t-Region t-Region--hideHeader t-Region--scrollBody" id="R74827237013510708"
                                    role="group" aria-labelledby="R74827237013510708_heading">
                                    <div class="t-Region-header">
                                        <div class="t-Region-headerItems t-Region-headerItems--title">
                                            <h2 class="t-Region-title" id="R74827237013510708_heading">
                                                print button
                                            </h2>
                                        </div>
                                        <div class="t-Region-headerItems t-Region-headerItems--buttons">
                                            <span class="js-maximizeButtonContainer"></span>
                                        </div>
                                    </div>
                                    <div class="t-Region-bodyWrap">
                                        <div class="t-Region-buttons t-Region-buttons--top">
                                            <div class="t-Region-buttons-left"></div>
                                            <div class="t-Region-buttons-right"></div>
                                        </div>
                                        <div class="t-Region-body">
                                            <a href="#" id="btnPrint"><img style="margin-right: 15px; width: 40px"
                                                    src="{{ url('assets/police') }}/img/printer_64.gif" /></a>
                                        </div>
                                        <div class="t-Region-buttons t-Region-buttons--bottom">
                                            <div class="t-Region-buttons-left"></div>
                                            <div class="t-Region-buttons-right"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        </div>
                        <div class="row">
                            <div class="col col-12 apex-col-auto">
                                <div id="printID" class="">
                                    <style>
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
                                            font-family: 'arial' !important;
                                        }
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
                                    <div class="main">
                                        <div id="img">
                                            <img src="{{ url('assets/police') }}/img/bangladesh_govt_logo.png">
                                        </div>

                                        <div class="text_p">
                                            <p style="font-size: 22px">
                                                <b>GOVERNMENT OF THE PEOPLE'S REPUBLIC OF <br />BANGLADESH</b>
                                            </p>
                                        </div>

                                        <!--This QR is not for verify purpus -->

                                        <!--img style="float: left; margin-top: 5px"
                                            src="https://chart.googleapis.com/chart?chs=190x190&amp;cht=qr&amp;chl=<?php //echo DOMAIN; ?>ords/f?p=<?php //echo base64_encode($id); ?>&501:155:::NO:RP:P155_PID:3155350"
                                            alt="" title="PCC" width="80" height="80" /-->
                                        <img style="float: left; margin-top: 5px"
                                            src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(80)->generate(route('user.police.verify',$data['id']))) !!}" alt="" title="PCC"
                                            width="80" height="80" />

                                        <div style="
                            text-align: center;
                            /* float: left; */
                            margin-right: 80px;
                          ">
                                            <p class="font_size"><?php echo $data['police_station']; ?> Police Station
                                            </p>
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
                                                <b><?php echo $data['applicant_name']; ?></b>
                                                <?php echo $data['what_of']; ?> of
                                                <b><?php echo $data['father_name']; ?></b> Village/ Area:
                                                <b><?php echo $data['village_area']; ?></b>,
                                                P/O:
                                                <b><?php echo $data['post_office']; ?></b>, P/S:
                                                <b><?php echo $data['police_station']; ?></b>, District:
                                                <b><?php echo $data['district']; ?></b> holder of Bangladesh
                                                International <?php echo $data['document_type']; ?> No.
                                                <b><?php echo $data['passport_no']; ?></b> Issued at <b>
                                                    <?php echo $data['issued_location']; ?></b> on
                                                <b><?php echo strtoupper(date('d-M-Y',strtotime($data['issued_date']))); ?></b> have
                                                been verified and there is no adverse information against him/her on
                                                record.
                                            </p>
                                            <p class="font_size" style="text-align: justify">
                                                This certificate is issued in pursuance of Ministry
                                                of Home Affairs Memo No. Nirdesh-2/75-Pt.
                                                2152-Bohi(1), dated the 19th May, 1977.
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

                                                    <td class="font_size" style="text-align: center">
                                                        Seal.
                                                    </td>
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
                                            This is a digital copy of the unsigned certificate
                                            issued by Bangladesh Police Online Police Clearance
                                            Management System. The printed original must contain
                                            seal and signature of the designated officials.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#" class="t-Body-topButton" style="display: none"><span
                        class="a-Icon icon-up-chevron"></span></a>
            </div>
            <footer class="t-Footer">
                release 1.0

                <a href="#">Set Screen Reader Mode
                    On</a>
            </footer>
        </div>
    </div>

    <div class="t-Body-inlineDialogs"></div>
    <div class="container">
        <div class="row">
            <div class="col col-12 apex-col-auto">
                <div id="R2338502219503412" class="">
                    <div class="row">
                        <div class="container">
                            <div class="footer" style="text-align: center; color: #fff">
                                Copyright © 2024 all rights reserved by
                                <a href="#" target="_blank">Bangladesh Police</a>
                                &amp;
                                <a href="#" target="_blank">a2i</a>. Developed by
                                <a href="#" target="_blank">Cloud Solution Ltd.</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>