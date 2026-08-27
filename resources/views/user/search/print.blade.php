<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>{{ $record->search_by ?? 'NID Copy' }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/snn.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">

    <style type="text/css">
        @font-face {
            font-family: 'my-Nirmala';
            src: url('{{ public_path("fonts/Nirmala.ttf") }}') format('truetype');
        }

        body {
            font-family: "my-Nirmala", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            width: 297.3mm;
            height: 420mm;
        }

        .border {
            border: 1px solid #DEE2E6;
        }

        .row.border {
            font-size: 17px;
        }

        .row.border .border {
            padding-top: 2px;
            padding-bottom: 2px;
        }

        @page {
            size: 297.3mm 420mm; /* A3 portrait */
            margin: 5mm !important;
        }

        div#myPage {
            margin-top: 40px;
            margin-left: 50px;
        }
    </style>
</head>
<body>

<div id="myPage">
    <div class="row mx-2 mb-3">
        <input type="hidden" value="0" id="smart-card-status-called" />

        <div class="col-9">
            <div class="row border">
                <div class="col-3 border">National ID</div>
                <div class="col-9 border">{{ $data['National_ID'] ?? '' }}</div>

                <div class="col-3 border">Pin</div>
                <div class="col-9 border">{{ $data['Pin'] ?? '' }}</div>

                <div class="col-3 border">Status</div>
                <div class="col-9 border">{{ $data['Status'] ?? '' }}</div>

                <div class="col-3 border">Afis Status</div>
                <div class="col-9 border" style="font-weight:bold; color: {{ ($data['Afis_Status'] ?? '') === 'NO_MATCH' ? 'green' : 'red' }};">
                    {{ $data['Afis_Status'] ?? '' }}
                </div>

                <div class="col-3 border">Lock Flag</div>
                <div class="col-9 border" style="font-weight:bold; color: {{ ($data['Lock_Flag'] ?? '') === 'N' ? 'green' : 'red' }};">
                    {{ $data['Lock_Flag'] ?? '' }}
                </div>

                <div class="col-3 border">Voter No</div>
                <div class="col-9 border">{{ $data['Voter_No'] ?? '' }}</div>

                <div class="col-3 border">Form No</div>
                <div class="col-9 border">{{ $data['Form_No'] ?? '' }}</div>

                <div class="col-3 border">Sl No</div>
                <div class="col-9 border">{{ $data['Sl_No'] ?? '' }}</div>

                <div class="col-3 border">Tag</div>
                <div class="col-9 border">{{ $data['Tag'] ?? '' }}</div>

                <div class="col-3 border">Name(Bangla)</div>
                <div class="col-9 border">{{ $data['NameBangla'] ?? $data['Name_Bangla_'] ?? '' }}</div>

                <div class="col-3 border">Name(English)</div>
                <div class="col-9 border">{{ $data['NameEnglish'] ?? $data['Name_English_'] ?? '' }}</div>

                <div class="col-3 border">Date of Birth</div>
                <div class="col-9 border">{{ $data['Date_of_Birth'] ?? '' }}</div>

                <div class="col-3 border">Birth Place</div>
                <div class="col-9 border">{{ $data['Birth_Place'] ?? '' }}</div>

                @unless($verified ?? false)
                    <div class="col-3 border">Birth Other</div>
                    <div class="col-9 border">{{ $data['Birth_Other'] ?? '' }}</div>
                @endunless

                @unless($verified ?? false)
                    <div class="col-3 border">Birth Registration No</div>
                    <div class="col-9 border">{{ $data['Birth_Registration_No'] ?? '' }}</div>
                @endunless

                <div class="col-3 border">Father Name</div>
                <div class="col-9 border">{{ $data['Father_Name'] ?? '' }}</div>

                <div class="col-3 border">Mother Name</div>
                <div class="col-9 border">{{ $data['Mother_Name'] ?? '' }}</div>

                <div class="col-3 border">Spouse Name</div>
                <div class="col-9 border">{{ $data['Spouse_Name'] ?? '' }}</div>

                <div class="col-3 border">Gender</div>
                <div class="col-9 border">{{ $data['Gender'] ?? '' }}</div>

                @unless($verified ?? false)
                    <div class="col-3 border">Marital</div>
                    <div class="col-9 border">{{ $data['Marital'] ?? '' }}</div>

                    <div class="col-3 border">Occupation</div>
                    <div class="col-9 border">{{ $data['Occupation'] ?? '' }}</div>

                    <div class="col-3 border">Disability</div>
                    <div class="col-9 border">{{ $data['Disability'] ?? '' }}</div>

                    <div class="col-3 border">Disability Other</div>
                    <div class="col-9 border">{{ $data['Disability_Other'] ?? '' }}</div>
                @endunless

                {{-- Present Address Sub-table --}}
                @php
                    $present = $data['present_address'] ?? $data['Present_Address'] ?? [];
                @endphp
                <div class="col-3 border">Present Address</div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-3 border">Division</div>
                        <div class="col-3 border">{{ $present['Division'] ?? '' }}</div>
                        <div class="col-3 border">District</div>
                        <div class="col-3 border">{{ $present['District'] ?? '' }}</div>
                        <div class="col-3 border">RMO</div>
                        <div class="col-3 border">{{ $present['RMO'] ?? '' }}</div>
                        <div class="col-3 border">City Corporation / Municipality</div>
                        <div class="col-3 border">{{ $present['City_Corporation_Or_Municipality'] ?? '' }}</div>
                        <div class="col-3 border">Upozila</div>
                        <div class="col-3 border">{{ $present['Upozila'] ?? '' }}</div>
                        <div class="col-3 border">Union/Ward</div>
                        <div class="col-3 border">{{ $present['Union_Ward'] ?? '' }}</div>
                        <div class="col-3 border">Mouza/Moholla</div>
                        <div class="col-3 border">{{ $present['Mouza_Moholla'] ?? '' }}</div>
                        <div class="col-3 border">Additional Mouza/Moholla</div>
                        <div class="col-3 border">{{ $present['Additional_Mouza_Moholla'] ?? '' }}</div>
                        <div class="col-3 border">Ward For Union Porishod</div>
                        <div class="col-3 border">{{ $present['Ward_For_Union_Porishod'] ?? '' }}</div>
                        <div class="col-3 border">Village/Road</div>
                        <div class="col-3 border">{{ $present['Village_Road'] ?? '' }}</div>
                        <div class="col-3 border">Additional Village/Road</div>
                        <div class="col-3 border">{{ $present['Additional_Village_Road'] ?? '' }}</div>
                        <div class="col-3 border">Home/Holding No</div>
                        <div class="col-3 border">{{ $present['Home_Holding_No'] ?? '' }}</div>
                        <div class="col-3 border">Post Office</div>
                        <div class="col-3 border">{{ $present['Post_Office'] ?? '' }}</div>
                        <div class="col-3 border">Postal Code</div>
                        <div class="col-3 border">{{ $present['Postal_Code'] ?? '' }}</div>
                        <div class="col-3 border">Region</div>
                        <div class="col-3 border">{{ $present['Region'] ?? '' }}</div>
                    </div>
                </div>

                {{-- Permanent Address Sub-table --}}
                @php
                    $permanent = $data['permanent_address'] ?? $data['Permanent_Address'] ?? [];
                @endphp
                <div class="col-3 border">Permanent Address</div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-3 border">Division</div>
                        <div class="col-3 border">{{ $permanent['Division'] ?? '' }}</div>
                        <div class="col-3 border">District</div>
                        <div class="col-3 border">{{ $permanent['District'] ?? '' }}</div>
                        <div class="col-3 border">RMO</div>
                        <div class="col-3 border">{{ $permanent['RMO'] ?? '' }}</div>
                        <div class="col-3 border">City Corporation / Municipality</div>
                        <div class="col-3 border">{{ $permanent['City_Corporation_Or_Municipality'] ?? '' }}</div>
                        <div class="col-3 border">Upozila</div>
                        <div class="col-3 border">{{ $permanent['Upozila'] ?? '' }}</div>
                        <div class="col-3 border">Union/Ward</div>
                        <div class="col-3 border">{{ $permanent['Union_Ward'] ?? '' }}</div>
                        <div class="col-3 border">Mouza/Moholla</div>
                        <div class="col-3 border">{{ $permanent['Mouza_Moholla'] ?? '' }}</div>
                        <div class="col-3 border">Additional Mouza/Moholla</div>
                        <div class="col-3 border">{{ $permanent['Additional_Mouza_Moholla'] ?? '' }}</div>
                        <div class="col-3 border">Ward For Union Porishod</div>
                        <div class="col-3 border">{{ $permanent['Ward_For_Union_Porishod'] ?? '' }}</div>
                        <div class="col-3 border">Village/Road</div>
                        <div class="col-3 border">{{ $permanent['Village_Road'] ?? '' }}</div>
                        <div class="col-3 border">Additional Village/Road</div>
                        <div class="col-3 border">{{ $permanent['Additional_Village_Road'] ?? '' }}</div>
                        <div class="col-3 border">Home/Holding No</div>
                        <div class="col-3 border">{{ $permanent['Home_Holding_No'] ?? '' }}</div>
                        <div class="col-3 border">Post Office</div>
                        <div class="col-3 border">{{ $permanent['Post_Office'] ?? '' }}</div>
                        <div class="col-3 border">Postal Code</div>
                        <div class="col-3 border">{{ $permanent['Postal_Code'] ?? '' }}</div>
                        <div class="col-3 border">Region</div>
                        <div class="col-3 border">{{ $permanent['Region'] ?? '' }}</div>
                    </div>
                </div>

                <div class="col-3 border">Education</div>
                <div class="col-9 border">{{ $data['Education'] ?? '' }}</div>

                @unless($verified ?? false)
                    <div class="col-3 border">Education Other</div>
                    <div class="col-9 border">{{ $data['Education_Other'] ?? '' }}</div>

                    <div class="col-3 border">Education Sub</div>
                    <div class="col-9 border">{{ $data['Education_Sub'] ?? '' }}</div>

                    <div class="col-3 border">Identification</div>
                    <div class="col-9 border">{{ $data['Identification'] ?? '' }}</div>
                @endunless

                <div class="col-3 border">Blood Group</div>
                <div class="col-9 border">{{ $data['Blood_Group'] ?? '' }}</div>

                @unless($verified ?? false)
                    <div class="col-3 border">TIN</div>
                    <div class="col-9 border">{{ $data['TIN'] ?? '' }}</div>
                    <div class="col-3 border">Driving</div>
                    <div class="col-9 border">{{ $data['Driving'] ?? '' }}</div>
                    <div class="col-3 border">Passport</div>
                    <div class="col-9 border">{{ $data['Passport'] ?? '' }}</div>
                    <div class="col-3 border">Laptop ID</div>
                    <div class="col-9 border">{{ $data['Laptop_ID'] ?? '' }}</div>
                    <div class="col-3 border">NID Father</div>
                    <div class="col-9 border">{{ $data['NID_Father'] ?? '' }}</div>
                    <div class="col-3 border">NID Mother</div>
                    <div class="col-9 border">{{ $data['NID_Mother'] ?? '' }}</div>
                    <div class="col-3 border">Nid Spouse</div>
                    <div class="col-9 border">{{ $data['Nid_Spouse'] ?? '' }}</div>
                    <div class="col-3 border">Voter No Father</div>
                    <div class="col-9 border">{{ $data['Voter_No_Father'] ?? '' }}</div>
                    <div class="col-3 border">Voter No Mother</div>
                    <div class="col-9 border">{{ $data['Voter_No_Mother'] ?? '' }}</div>
                    <div class="col-3 border">Voter No Spouse</div>
                    <div class="col-9 border">{{ $data['Voter_No_Spouse'] ?? '' }}</div>
                    <div class="col-3 border">Phone</div>
                    <div class="col-9 border">{{ $data['Phone'] ?? '' }}</div>
                    <div class="col-3 border">Mobile</div>
                    <div class="col-9 border">{{ $data['Mobile'] ?? '' }}</div>
                    <div class="col-3 border">Email</div>
                    <div class="col-9 border">{{ $data['Email'] ?? '' }}</div>
                @endunless

                @unless($verified ?? false)
                    <div class="col-3 border">Religion Other</div>
                    <div class="col-9 border">{{ $data['Religion_Other'] ?? '' }}</div>
                    <div class="col-3 border">Death Date Of Father</div>
                    <div class="col-9 border">{{ $data['Death_Date_Of_Father'] ?? '' }}</div>
                    <div class="col-3 border">Death Date Of Mother</div>
                    <div class="col-9 border">{{ $data['Death_Date_Of_Mother'] ?? '' }}</div>
                    <div class="col-3 border">Death Date Of Spouse</div>
                    <div class="col-9 border">{{ $data['Death_Date_Of_Spouse'] ?? '' }}</div>
                    <div class="col-3 border">No Finger</div>
                    <div class="col-9 border">{{ $data['No_Finger'] ?? '' }}</div>
                    <div class="col-3 border">No Finger Print</div>
                    <div class="col-9 border">{{ $data['No_Finger_Print'] ?? '' }}</div>
                @endunless


                <div class="col-3 border">Voter Area</div>
                <div class="col-9 border">{{ $data['Voter_Area'] ?? '' }}</div>

                @unless($verified ?? false)
                    <div class="col-3 border">Voter At</div>
                    <div class="col-9 border">{{ $data['Voter_At'] ?? '' }}</div>
                @endunless
            </div>
        </div>

        <div class="col-3">
            <div class="row">
                <div class="col-12">
                    @if($photoDataUri)
                        <img src="{{ $photoDataUri }}" width="160px" class="border border-secondary" alt="Photo">
                    @endif
                </div>
            </div>
            @unless($verified ?? false)
            <div class="row mt-5">
                <div class="col-12">
                    @if($signDataUri)
                        <img src="{{ $signDataUri }}" width="160px" class="border border-secondary" alt="Signature">
                    @endif
                </div>
            </div>
            @endunless
        </div>
    </div>
</div>

</body>
</html>
