<html lang="en">
<head>
    <title>Smart NID Card - {{ $nidNumber }}@isset($viewLayout) ({{ $viewLayout }})@endisset</title>
    <meta charSet="utf-8"/>
    <style>
        @page {
            size: letter;
            margin: 0;
        }

        .f_line_icon.for_last, .f_line_icon {
            font-family: "Roboto Mono", serif;
        }

        .hidden_when_print{
            padding-left:70px !important;
            padding-right:70px !important;
            margin-left: 70px !important;
            margin-top: 10px;
            max-width: 600px !important;
        }
    </style>
    <meta name="viewport" content="initial-scale=1.0, width=device-width"/>
    <meta name="next-head-count" content="3"/>
    </style>
    <link rel="stylesheet" href="{{ asset('assets/smart_card/nid_css.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/smart_card/e521caf613e4ad87.css') }}" data-n-g=""/>
    <link rel="stylesheet" href="{{ asset('assets/smart_card/card_testss.php') }}" data-n-g=""/>

    <link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto+Slab:wght@100..900&display=swap"
          rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('assets/favicon.png') }}" type="image/png">
    <style>
        @media print, screen and (max-width: 990px) {
            #nid_wrapper {
                transform: scale(1);
            }
        }


        img#overflow_img {
            left: 1.7px;
        }
    </style>
</head>
<style>
    /* Font install */
    @font-face {
        font-family: 'Cambria Math';
        src: url("{{ asset('assets/smart_card/cambria-math.woff') }}") format('woff');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'TonnyBanglaMJ';
        src: url('{{ asset('assets/smart_card/TonnyBanglaMJ-Bold.woff') }}') format('woff');
        font-weight: bold;
        font-style: normal;
    }

    @font-face {
        font-family: 'TonnyBanglaMJ';
        src: url('{{ asset('assets/smart_card/TonnyBanglaMJ-Regular.woff') }}') format('woff');
        font-weight: normal;
        font-style: normal;
    }

    span.result_one.bloodGroup {
        position: fixed;
        width: 100%;
        top: -1.5px;
        left: 37px;

    }

    .f_line_icon {
        transform: scaleY(1.1);
    }
</style>
<style>
    /* Override styles */
    .title.font_family {
        font-size: 8.5px;
        font-weight: bold;
        transform: scale(1, 1.05);
    }

    .nameBan.main_text.font_family {
        margin-bottom: 3px;
        text-shadow: 0 0 black;
        font-weight: bold;
    }

    .main_text.font_family {
        font-size: 10.5px;
        line-height: 10px;
        transform: scale(1, 1.05);
        font-family: 'SolaimanLipi', sans-serif;
    }

    .nameEn.title {
        font-size: 6.5px;
        font-family: arial;
        font-weight: 600;
        line-height: 8px;
        transform: scale(1, 1.1);
    }

    .nameEn.main_text {
        font-size: 7.8px;
        font-weight: 600;
        line-height: 15px;
        transform: scale(1, 1.1);
    }

    .fatherName.title.font_family {
        line-height: 5px;
        margin-top: 2px;
    }

    .fatherName.main_text.font_family {
        line-height: 18px;
    }

    .motherName.title.font_family {
        line-height: 1px;
        margin-top: 3px;
    }

    .motherName.main_text.font_family {
        line-height: 22px;
    }

    .dateOfBirth {
        margin-top: 0px;
    }

    .nid {
        line-height: 6px;
        margin-top: -10px;
    }

    * {
        font-family: Bangla, arial;
    }
</style>
</head>
<body id="design" style="background: white; color: black!important">

@isset($viewLayout)
    <div class="hidden_when_print" style="margin:8px 0;padding:8px 12px;background:#eef;border-radius:6px;font-size:13px;">
        ভিউ মোড: <strong>{{ $viewLayout }}</strong> (সংরক্ষিত ধরন: {{ $nid->type ?? '—' }})
    </div>
@endisset

<div id="__next" data-reactroot="" style="width: 800px">
    <div class="flex" style="  padding-left:70px;padding-right:70px;">
        <div id="front_side" class="id_side" style="display: inline-block;">
            <div id="font_text" class="absolute">
                <div class="nameBan title  font_family">bvg</div>
                <div class="nameBan main_text font_family">{{ $banglaName }}</div>
                <div class="nameEn title  ">Name</div>
                <div class="nameEn main_text ">{{ $englishName }}</div>
                <div class="fatherName title  font_family">wcZv</div>
                <div class="fatherName main_text font_family">{{ $fatherName }}</div>
                <div class="motherName title  font_family">gvZv</div>
                <div class="motherName main_text font_family">{{ $motherName }}</div>
                <div class="dateOfBirth">
                    <div class="date_title en_title">Date Of Birth</div>
                    <div class="date_number en_title">{{ $formattedDob }}</div>
                </div>
                <div class="nid">
                    <div class="nid_title en_title">NID No.</div>

                    <div class="nid_number en_title">{{ $formattedNid }}</div>

                </div>

            </div>
            <img class="test_img" src="{{ asset('assets/smart_card/test.svg') }}" alt="">

            <div id="user_img">
                <img class="user_img" src="{{ asset($photoBase64) }}" alt="">
                <img id="user_img" class="user_img" src="{{ asset($photoBase64) }}" alt="">
                <div class="overflow_dob">{{ !empty($dateOfBirth) ? Carbon\Carbon::parse($dateOfBirth)->format('d/m/Y') : '' }}</div>


            </div>
            <div id="sing_img_div">
                @if(!empty($signatureBase64))
                    <img id="sign_img" class="sign_img" src="{{ asset(ltrim($signatureBase64, '/')) }}" alt="">
                @else
                    <img id="sign_img" class="sign_img" src="{{ asset('assets/smart_card/test.svg') }}" alt="" style="opacity:0;">
                @endif
            </div>
            <div id="front_img">
                <img id="overflow_img" src="{{ asset('assets/smart_card/overflow.svg') }}" alt="">
                <img class="side_img" src="{{ asset('assets/smart_card/fronts.svg') }}" alt="">

            </div>

        </div>
        <div id="back_side" class="id_side" style="display: inline-block;">
            <img id="user_img_two" class="user_img" src="{{ $photoBase64 }}" alt="">
            <div id="back_img">
                <img class="side_img" src="{{ asset('assets/smart_card/back.svg') }}" alt="">
                <img class="overflow_back" src="{{ asset('assets/smart_card/overflow_back.svg') }}" alt="">
                <div class="address"
                     style="font-size:
     10px!important; line-height: 10px;">{{ $address }}</div>

                <div class="back_text_one">
                    <span class="fist_line_one back_line_one" style="top: 2.5px!important"> Blood Group: <span
                                class="result_one bloodGroup">{{ ($bloodGroup && $bloodGroup !== 'N/A') ? $bloodGroup : ' ' }}</span></span>
                    <span class="second_line_one back_line_one">Place of Birth: <span
                                class="result_one place_of_birth">{{ ($birthPlaceEn && $birthPlaceEn !== 'N/A') ? strtoupper($birthPlaceEn) : ' ' }}</span></span>
                    <span class="third_line_one back_line_one">Issue Date: <span
                                class="result_one date_of_issue">{{ ($issueDate && $issueDate !== 'N/A') ? $issueDate : ' ' }}</span></span>
                </div>
                <div class="back_text">
                    <div class="first_line back_line">
                        <div class="f_line_icon">I</div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon">B</div>
                        <div class="f_line_icon">G</div>
                        <div class="f_line_icon">D</div>
                        <div class="f_line_icon">5</div>
                        <div class="f_line_icon">5</div>
                        <div class="f_line_icon">0</div>
                        <div class="f_line_icon">1</div>
                        <div class="f_line_icon">6</div>
                        <div class="f_line_icon">7</div>
                        <div class="f_line_icon">8</div>
                        <div class="f_line_icon">7</div>
                        <div class="f_line_icon">7</div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon">4</div>
                        <div class="f_line_icon">2</div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>

                    </div>
                    <div class="second_line back_line">
                        <div class="f_line_icon">3</div>
                        <div class="f_line_icon">2</div>
                        <div class="f_line_icon">3</div>
                        <div class="f_line_icon">1</div>
                        <div class="f_line_icon">5</div>
                        <div class="f_line_icon">9</div>
                        <div class="f_line_icon">3</div>
                        <div class="f_line_icon">F</div>
                        <div class="f_line_icon">4</div>
                        <div class="f_line_icon">6</div>
                        <div class="f_line_icon">5</div>
                        <div class="f_line_icon">4</div>
                        <div class="f_line_icon">4</div>
                        <div class="f_line_icon">4</div>
                        <div class="f_line_icon">5</div>
                        <div class="f_line_icon">B</div>
                        <div class="f_line_icon">G</div>
                        <div class="f_line_icon">D</div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon"><img src="{{ asset('assets/smart_card/smart_card_back_icon.png') }}"/>
                        </div>
                        <div class="f_line_icon">7</div>

                    </div>
                    <div class="third_line back_line">
                        <?php
                        // Get name from variables and format it
                        $name = strtoupper($englishName);

                        // Split name into parts
                        $name_parts = explode(' ', $name);

                        // Format name based on number of parts
                        if (count($name_parts) > 1) {
                            // If has both first and last name
                            $formatted_name = end($name_parts) . '<' . $name_parts[0];
                        } else {
                            // If only has one name
                            $formatted_name = $name_parts[0] . '<';
                        }

                        // Add < symbols to pad the rest
                        $max_length = 30;
                        $current_length = strlen($formatted_name);
                        $padding_needed = $max_length - $current_length;

                        if ($padding_needed > 0) {
                            $formatted_name .= str_repeat('<', $padding_needed);
                        }

                        // Output each character
                        for ($i = 0; $i < strlen($formatted_name); $i++) {
                            $char = $formatted_name[$i];
                            if ($char === '<') {
                                echo '<div class="f_line_icon for_last"><img src="' . asset('assets/smart_card/smart_card_back_icon.png') . '"/></div>';
                            } else if ($char === 'I') {
                                echo '<div class="f_line_icon for_last i_letters">' . $char . '</div>';
                            } else {
                                echo '<div class="f_line_icon for_last">' . $char . '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div style="position: absolute;top: 13px;left: 20px; transform: rotate(180deg); width: 290px; height: 38px">
                    <canvas id="barcode"></canvas>
                    <style>
                        canvas {
                            width: 100%;
                            height: 100%;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>

</div>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bwip-js/4.5.2/bwip-js-min.js"></script>  -->


<script src="{{ asset('assets/smart_card/bwip-js-min.js') }}"></script>

<script>


    var hub3_code = `<pin>{{ $pin }}</pin><n>{{ str_replace(' ', '+', strtoupper($englishName)) }}</n><DOB>{{ !empty($dateOfBirth) ? Carbon\Carbon::parse($dateOfBirth)->format('Y-m-d') : '' }}</DOB><FP></FP><F>Right Index</F><TYPE></TYPE><V>2.0</V><ds>302d02150094b24c767848fa594a7fd2e53345eac2747180d8421bf6d7d00b287472b18c0631e2a85aadd76f759188</ds>`;

    const canvas = document.getElementById("barcode");
    const ctx = canvas.getContext("2d");

    // Recommended dimensions
    canvas.width = 300;
    canvas.height = 60;

    try {
        bwipjs.toCanvas(canvas, {
            bcid: "pdf417",
            text: hub3_code,
            scale: 2,
            columns: 13,
            eclevel: 5,
            rowheight: 4,       // Control row spacing (1-10)
            paddingwidth: 0,    // Minimum required horizontal quiet zone
            paddingheight: 0,   // No vertical quiet zone
            includetext: false
        });

        // Optional: Post-processing to enhance edges
        ctx.imageSmoothingEnabled = false;
        ctx.drawImage(canvas, 0, 0);
    } catch (e) {
        console.error("Error:", e);
    }


</script>
<div class="hidden_when_print">
    <label for="topRange"> সিগনেচার উপর নিচঃ </label>
    <input type="range" id="topRange" min="100" max="190" value="175" oninput="applyStyles()"/>
    <span id="topValueLabel">172</span>

    <br/>

    <label for="paddingRange">Padding (px):</label>
    <input type="range" id="paddingRange" min="0" max="25" value="0" oninput="applyStyles()"/>
    <span id="paddingValueLabel">5</span>

    <br/>

    <label for="scaleRange">Zoom (Scale):</label>
    <input type="range" id="scaleRange" min="0.5" max="2" step="0.1" value="1" oninput="applyStyles()"/>
    <span id="scaleValueLabel">1</span>

    <br/>

    <button style="color: white; background: orange" onclick="rotateImage()">সিগনেচার ঘুরান</button>
    <button onclick="window.print()">প্রিন্ট করুন</button>
    <a href="{{ route('user.smartcard.index') }}"
       style="color: white; background: #6c757d; text-decoration: none; padding: 8px 16px; border-radius: 4px; margin-left: 10px; display: inline-block;">তালিকায়
        ফিরুন</a>
</div>


</main>
</div>
</body>

<script>


    let rotationAngle = 0; // Initial rotation angle

    function rotateImage() {
        rotationAngle += 90; // Rotate by 90 degrees
        document.getElementById("sign_img").style.transform = `rotate(${rotationAngle}deg) scale(${document.getElementById('scaleRange').value})`;
    }

    function applyStyles() {
        // Get the slider values
        const topValue = document.getElementById('topRange').value;
        const paddingValue = document.getElementById('paddingRange').value;
        const scaleValue = document.getElementById('scaleRange').value;

        // Update the displayed labels
        document.getElementById('topValueLabel').textContent = topValue;
        document.getElementById('paddingValueLabel').textContent = paddingValue;
        document.getElementById('scaleValueLabel').textContent = scaleValue;

        // Get the div element you want to style
        const div = document.getElementById('sing_img_div');
        const img = document.getElementById("sign_img");

        // Apply the styles dynamically to the div
        div.style.top = `${topValue}px`;
        div.style.padding = `${paddingValue}px`;

        // Apply scale transformation
        img.style.transform = `rotate(${rotationAngle}deg) scale(${scaleValue})`;
    }

    // Initial application of styles when the page loads
    applyStyles();
</script>


