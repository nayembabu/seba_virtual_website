<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immigraton Tab View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://clearance.amiprobashi.com/css/tab-css/style.css">
    <style>
        .customIframe{
            min-height: 500px;
            width: 100%;
        }
        p.manual_clearance {
            background: #5764fe;
            color: #fff!important;
            display: inline-block;
            padding: 3px 5px;
            border-radius: 3px;
        }
        p.online_clearance{
            background: #407f7c;
            color: #fff!important;
            display: inline-block;
            padding: 3px 5px;
            border-radius: 3px;
        }
        @media(max-width: 576px){
            .imigration-item-common {
                width: 100%;
            }
            .imigration-item1 {
                display: block!important;
            }
            .imigration-item1 .imileft img {
                width: 100px;
                height: 100px;
                border-radius: 5px;
            }
            .imiright h2 {
                font-size: 20px!important;
                line-height: 30px;
                text-align: center;
            }
            .imigration-item1 .imileft {
                width: 100%;
                margin-bottom: 15px;
            }
            .imigration-item1 .imiright {
                width: 100%;
                margin-left: 0;
            }
            td span{
                word-break: break-all;
            }
            .imiright table td{
                font-size: 16px!important;
            }
            .bmet-smart-card .bsc-top h4, .pdo-certificate .bsc-top h4, .bmet-registration .bsc-top h4, .passport .bsc-top h4{
                font-size: 16px!important;
            }
            .bsc-middle td {
                font-size: 14px!important;
                padding: 5px 0;
            }

        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- start candidate info -->
        <div class="imigration-item-common">
            <div class="imigration-item1">
                <div class="imileft">
                    <div class="topimg">
                        <img src="{{ $photoUrl }}" alt="Candidate Photo">
                    </div>
                    <div class="bottom-content">
                    </div>
                </div>
                <div class="imiright">
                    <h2 style="word-break: break-all;">{{ $name }}</h2>
                    <table>
                        <tr>
                            <td>Passport No</td>
                            <td class="text-end"><span>{{ $passport_no }}</span></td>
                        </tr>
                        <tr>
                            <td>P. Issue Date</td>
                            <td class="text-end"><span>{{ $p_issue_date }}</span></td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td class="text-end"><span>{{ $dob }}</span></td>
                        </tr>
                        <tr>
                            <td class="border-bottom-none">Visa No.</td>
                            <td class="text-end border-bottom-none"><span>{{ $visa_no }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- end candidate info -->
        <!-- start bmet smart card  -->
        <div class="bmet-smart-card imigration-item-common">
            <div class="bsc-top">
                <table class="w-100">
                    <tr>
                        <td><h4>BMET Smart Card</h4></td>
                        <td class="text-end"><img height="32px" src="http://amiprobashi-download.42web.io/wp-content/uploads/2024/12/govt.png" alt=""> <img class="ms-md-3" height="32px" src="http://amiprobashi-download.42web.io/wp-content/uploads/2024/12/bmet.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <div class="bsc-middle">
                <div class="p-2 p-md-4">
                    <table class="w-100">
                        <tr class="sep-border-dark">
                            <td class="w-50">Name</td>
                            <td class="text-end w-50"><span>{{ $name }}</span></td>
                        </tr>
                        <tr class="sep-border-dashed">
                            <td class="w-50">Clearance ID</td>
                            <td class="text-end w-50"><span>{{ $clearance_id }}</span></td>
                        </tr>
                        <tr class="sep-border-dashed">
                            <td class="w-50">Visa No</td>
                            <td class="text-end w-50"><span>{{ $visa_no }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Employer</td>
                            <td class="text-end w-50"><span>{{ $employer }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Country</td>
                            <td class="text-end w-50"><span>{{ $country }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- end bmet smart card  -->
        <!-- start pdo certificate  -->
        <div class="pdo-certificate imigration-item-common">
            <div class="bsc-top">
                <table class="w-100">
                    <tr>
                        <td><h4>PDO Certificate</h4></td>
                        <td class="text-end"><img height="32px" src="http://amiprobashi-download.42web.io/wp-content/uploads/2024/12/govt.png" alt=""> <img class="ms-md-3" height="32px" src="http://amiprobashi-download.42web.io/wp-content/uploads/2024/12/bmet.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <div class="bsc-middle">
                <div class="p-2 p-md-4">
                    <table class="w-100">
                        <tr class="sep-border-dark">
                            <td class="w-50">Name</td>
                            <td class="text-end w-50"><span>{{ $name }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Certificate No</td>
                            <td class="text-end w-50"><span>{{ $certificate_no ?? '7301677' }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Country</td>
                            <td class="text-end w-50"><span>{{ $country }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">TTC</td>
                            <td class="text-end w-50"><span>{{ $ttc ?? 'Sylhet mohila technical training center' }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Issue Date</td>
                            <td class="text-end w-50"><span>{{ $issue_date ?? date('Y-m-d') }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- end pdo certificate -->
        <!-- start BMET Registration  -->
        <div class="bmet-registration imigration-item-common">
            <div class="bsc-top">
                <table class="w-100">
                    <tr>
                        <td><h4>BMET Registration</h4></td>
                        <td class="text-end"><img height="32px" src="http://amiprobashi-download.42web.io/wp-content/uploads/2024/12/govt.png" alt=""> <img class="ms-md-3" height="32px" src="http://amiprobashi-download.42web.io/wp-content/uploads/2024/12/bmet.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <div class="bsc-middle">
                <div class="p-2 p-md-4">
                    <table class="w-100">
                        <tr class="sep-border-dark">
                            <td class="w-50">Name</td>
                            <td class="text-end w-50"><span>{{ $name }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">BMET No</td>
                            <td class="text-end w-50"><span>{{ $bmet_no }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Birth Date</td>
                            <td class="text-end w-50"><span>{{ $dob }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Issue Date</td>
                            <td class="text-end w-50"><span>{{ $issue_date }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- end BMET Registration -->
        <!-- start Passport  -->
        <div class="passport imigration-item-common">
            <div class="bsc-top">
                <table class="w-100">
                    <tr>
                        <td><h4>Passport</h4></td>
                        <td class="text-end"><img height="32px" src="http://amiprobashi-download.42web.io/wp-content/uploads/2024/12/govt.png" alt=""> <img class="ms-md-3" height="32px" src="http://amiprobashi-download.42web.io/wp-content/uploads/2024/12/bmet.png" alt=""></td>
                    </tr>
                </table>
            </div>
            <div class="bsc-middle">
                <div class="p-2 p-md-4">
                    <table class="w-100">
                        <tr class="sep-border-dark">
                            <td class="w-50">Name</td>
                            <td class="text-end w-50"><span>{{ $name }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Passport No</td>
                            <td class="text-end w-50"><span>{{ $passport_no }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Passport Issue Date</td>
                            <td class="text-end w-50"><span>{{ $p_issue_date }}</span></td>
                        </tr>
                        <tr class="sep-border-dark">
                            <td class="w-50">Passport Expiry Date</td>
                            <td class="text-end w-50"><span>{{ $p_expiry_date }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="bsc-bottom text-center p-4">
            </div>
        </div>
        <!-- end Passport -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="rejectReason" tabindex="-1" aria-labelledby="rejectReasonLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="rejectReasonLabel">Reject Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea aria-label="" class="form-control" id="remark" rows="4" placeholder="Type here reason"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button id="reject-btn" type="button" class="btn btn-primary">
                    Submit
                    <span class="spinner-border d-none" id="reject-spin" style="width: 1rem; height: 1rem"></span>
                </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Passport Modal Start -->
    <div class="modal fade" id="passportModal" tabindex="-1" aria-labelledby="pdoCertificate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="rejectReasonLabel">Passport Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="https://amiprobashis3.s3.ap-southeast-1.amazonaws.com/images/document_wallet/passport/1bde7fa883c5354b9d71dcb8466efdf0.jpg?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&amp;X-Amz-Algorithm=AWS4-HMAC-SHA256&amp;X-Amz-Credential=AKIARRB2LOLRBWLVRTMS%2F20241026%2Fap-southeast-1%2Fs3%2Faws4_request&amp;X-Amz-Date=20241026T142411Z&amp;X-Amz-SignedHeaders=host&amp;X-Amz-Expires=1200&amp;X-Amz-Signature=86f18a54ec5520b51452a3d872fea1db63e8a61fdd1562c473bfb0a5b76e15b0" />
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://clearance.amiprobashi.com/js/jquery-3.6.1.min.js"></script>
    <script src="https://clearance.amiprobashi.com/js/bootstrap.min.js"></script>
</body>
</html>