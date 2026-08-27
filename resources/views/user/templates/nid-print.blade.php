<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>nid-{{ $data->nid_no }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css" integrity="sha512-NZ19NrT58XPK5sXqXnnvtf9T5kLXSzGQlVZL9taZWeTBtXoN3xIfTdxbkQh6QSoJfJgpojRqMfhyqBAAEeiXcA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Alumni+Sans+Inline+One&family=Anek+Bangla&family=Atma:wght@300&family=Baloo+Da+2&family=Bebas+Neue&family=Bubblegum+Sans&family=Edu+NSW+ACT+Foundation&family=Galada&family=Gloria+Hallelujah&family=Gochi+Hand&family=Hind+Siliguri:wght@300&family=Just+Another+Hand&family=Lobster&family=Mina&family=Mochiy+Pop+P+One&family=Noto+Sans+Bengali:wght@500&family=Nunito+Sans:wght@600&family=Oleo+Script&family=Oleo+Script+Swash+Caps&family=Open+Sans:wght@300&family=Pacifico&family=Patrick+Hand&family=Poppins:ital,wght@1,100&family=Red+Hat+Mono:wght@300&family=Roboto:wght@300&family=Source+Sans+Pro&family=Tiro+Bangla&display=swap");
            @import url("https://cdn.rawgit.com/sh4hids/bangla-web-fonts/bangla/stylesheet.css");
            @import url("https://cdn.rawgit.com/sh4hids/bangla-web-fonts/solaimanlipi/stylesheet.css");
            @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap");
            @import url("https://cdn.rawgit.com/mirazmac/bengali-webfont-cdn/master/solaimanlipi/style.css");
            @import url("https://fonts.cdnfonts.com/css/arial-mt");
            @font-face {
                font-family: lol;
                src: url('/assets/nid/fonts/kalpurush.ttf');
            }
            
            @font-face {
                font-family: myFirstFont;
                src: url('/assets/nid/fonts/SutonnyMJ/Regular.ttf');
            }
            
            @font-face {
                font-family: mysFont;
                src: url('/assets/nid/fonts/SutonnyMJ/Bold.ttf');
            }
            
            @font-face {
                font-family: nikos;
                src: url('/assets/nid/fonts/Nikosh.ttf');
            }
            
            @font-face {
                font-family: myFirstfont;
                src: url('/assets/nid/fonts/Bangla.ttf');
            }
            
            @font-face {
                font-family: signfont;
                src: url('/fonts/HandWriting.ttf');
            }

            
            #printsss {
                position: fixed;
                bottom: 0;
                left: 0;
            }

            .dis {
                width: 100%;
                min-height: 31vh;
            }

            .tada {
                animation: tada 6s infinite;
            }

            @keyframes tada {
                0% {
                    transform: scale(1);
                }
                10%,
                20% {
                    transform: scale(0.9) rotate(-3deg);
                }
                30%,
                50%,
                70%,
                90% {
                    transform: scale(1.1) rotate(3deg);
                }
                40%,
                60%,
                80% {
                    transform: scale(1.1) rotate(-3deg);
                }
                100% {
                    transform: scale(1) rotate(0);
                }
            }

            .rateinfo {
                font-size: 1.5rem;
                margin-bottom: 10px;
                position: fixed;
                top: 102px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
                left: 20px;
                color: #010118;
                font-weight: 900;
            }

            .rateinfo button {
                border: 1px solid blue;
                background: #e0fbe7;
            }

            .agentnumber {
                display: none;
                position: fixed;
                z-index: 999;
                background: #0d0d28;
                padding: 30px;
                color: white;
            }

            #recharge {
                position: fixed;
                left: 165px;
                top: 20px;
                border: none;
                padding: 11px 21px;
                color: white;
                font-weight: 800;
                background: #0d0d28;
                border-radius: 33px;
                font-size: 1.4rem;
            }

            .w100 {
                width: 100%;
            }

            .imgtem {
                width: 800px;
                height: 244px;
                margin-left: -35px;
            }

            .profilepic img {
                width: 100%;
                height: 100%;
            }

            .mainbox {
                width: 800px;
                height: 244px;
                margin: auto;
                transform: scale(0.84);
            }

            .bname,
            .ename,
            .fname,
            .mname,
            .issue {
                position: absolute;
                color: black;
            }

            .govt {
                top: 1px;
                left: 149px;
                font-weight: 800;
                font-size: 1.25rem;
                font-family: "bangla", serif;
                /* font-family: myFirstfont;" */
            }

            .bname {
           top: 80px;
           left: 147px;
           font-weight: 700;
           font-size: 1.1rem;
           font-family: "SolaimanLipi", "bangla", serif;
           /* font-family: myFirstfont;" */
           word-spacing: -0px;
         }

            .ename {
                top: 111px;
                left: 147px;
                font-weight: 500;
                font-size: 17px;
                font-family: "Arial", sans-serif;
                word-spacing: 0px;
            }

            .fname {
                top: 136.5px;
                left: 147px;
                font-size: 17.7px;
                font-family: "bangla", serif;
            }

            .fname2 {
                position: absolute;
                top: 130.5px;
                left: 130px;
                font-size: 0.73rem;
                font-family: myFirstfont;
            }

            .mname {
                top: 162px;
                left: 147px;
                font-size: 17.7px;
                font-family: "bangla", serif;
                /*font-weight: 500;*/
            }

            .issue {
                left: 707px;
                top: 157px;
                font-size: 14.8px;
                font-family: "bangla", serif;
                text-shadow: 0.01px 0.01px 0.5px #00000066;
            }

            .blood {
                font-weight: 500;
                position: absolute;
                top: 107px;
                left: 540px;
                font-size: 11.8px;
                font-family: "Arial", sans-serif;
            }

            .address2 {
                font-size: 14.4px;
                line-height: 15px;
                /* border: 1px solid; */
                font-weight: 400;
                word-spacing: -1px;
                position: absolute;
                top: 7px;
                /* right: 3px; */
                font-family: "bangla", serif;
                color: black;
                left: 417px;
            }

            .address3 {
                font-family: "bangla", serif;
            }
            .address3 .h1,
            .address3 .h2,
            .address3 .h3,
            .address3 .h4 {
                position: auto;
            }


            .address4 {
                font-family: "bangla", serif;
            }

            .h1 {
                font-size: 23.5px;
                line-height: 15px;
                font-weight: 500;
                word-spacing: 3px;
                position: absolute;
                top: 13px;
                font-family: "bangla", serif;
                color: black;
                left: 111px;
            }

            .h2 {
                font-size: 14px;
                line-height: 13px;
                font-weight: 500;
                word-spacing: 0px;
                position: absolute;
                top: 33px;
                font-family: "Arial", serif;
                color: green;
                left: 60px;
            }

            .h3 {
                font-size: 12.3px;
                line-height: 15px;
                font-weight: 500;
                position: absolute;
                top: 51px;
                font-family: "Arial", serif;
                color: red;
                left: 124px;
                word-spacing: 0px;
            }

            .h4 {
                font-size: 16.5px;
                line-height: 16.5px;
                font-weight: 500;
                word-spacing: 0px;
                position: absolute;
                top: 50px;
                font-family: "bangla", serif;
                color: black;
                left: 217px;
            }

            .bn {
                font-size: 1.25rem;
                line-height: 15px;
                font-weight: 500;
                word-spacing: 1px;
                position: absolute;
                top: 87px;
                font-family: "bangla", serif;
                color: black;
                left: 99px;
            }

            .en {
                font-size: 13.2px;
                line-height: 15px;
                font-weight: 500;
                word-spacing: 1px;
                position: absolute;
                top: 115px;
                font-family: "Arial", serif;
                color: black;
                left: 99px;
            }

            .fn {
                font-size: 17.7px;
                line-height: 15px;
                font-weight: 500;
                word-spacing: 1px;
                position: absolute;
                top: 142px;
                font-family: "bangla", serif;
                color: black;
                left: 99px;
            }

            .mn {
                font-size: 17.7px;
                line-height: 15px;
                font-weight: 500;
                word-spacing: 1px;
                position: absolute;
                top: 167px;
                font-family: "bangla", serif;
                color: black;
                left: 99px;
            }

            .db {
                font-size: 14.5px;
                line-height: 15px;
                font-weight: 500;
                word-spacing: 0px;
                position: absolute;
                top: 190px;
                font-family: "arial", serif;
                color: black;
                left: 98px;
            }

            .idno {
                font-size: 14.5px;
                line-height: 15px;
                font-weight: 500;
                word-spacing: 0px;
                position: absolute;
                top: 211px;
                font-family: "Arial", serif;
                color: black;
                left: 98px;
            }

            .address {
                font-size: 14.7px;
                /* border: 1px solid; */
                font-weight: 400;
                word-spacing: 1px;
                position: absolute;
                top: 42px;
                /* right: 3px; */
                font-family: "bangla", serif;
                color: black;
                left: 417px;
            }

            .addresss {
                width: 328px;
                font-size: 14.7px;
                line-height: 13px;
                /* border: 1px solid; */
                font-weight: 400;
                word-spacing: -1px;
                position: absolute;
                top: 46.8px;
                /* right: 3px; */
                font-family: "bangla", serif;
                color: black;
                left: 454px;
            }

            

            .rokto {
                position: absolute;
                top: 104.4px;
                left: 410px;
                font-size: 14.7px;
                font-family: "bangla", serif;
                color: black;
                height: 15px;
            }

            .rokto2 {
                position: absolute;
                top: 106.4px;
                left: 463px;
                font-size: 11.8px;
                font-family: "Arial", serif;
                color: black;
                word-spacing: -1px;
            }

            .disth {
                position: absolute;
                top: 104.4px;
                left: 567px;
                font-size: 13.5px;
                font-family: "bangla", serif;
                color: black;
                text-shadow: 0.01px 0.01px 0.5px #00000066;
                height: 15px;
                padding: 0 2px;
            }

            .pd {
                position: absolute;
                top: 155.4px;
                left: 414px;
                font-size: 17.7px;
                font-family: "bangla", serif;
                color: black;
                height: 15px;
                padding: 0 2px;
            }

            .pi {
                position: absolute;
                top: 157.4px;
                left: 625px;
                font-size: 14.8px;
                font-family: "bangla", serif;
                color: black;
                height: 15px;
                padding: 0 2px;
                word-spacing: 1px;
            }

            .dist {
                position: absolute;
                top: 104.4px;
                left: 606px;
                font-size: 13.5px;
                font-family: "bangla", serif;
                color: black;
                text-shadow: 0.01px 0.01px 0.5px #00000066;
            }

            .barcode {
                width: 375px;
                height: 48px;
                position: absolute;
                top: 184px;
                right: 13px;
            }

            #barcode {
                width: 100%;
                height: 100%;
            }

            #barcode canvas {
                width: 102% !important;
                height: 100% !important;
            }

            .profilepic {
                position: absolute;
                width: 83px;
                height: 91px;
                top: 80px;
                left: 6px;
            }

            .profilepic img {
                width: 100%;
                height: 100%;
            }

            .signeture { 
                position: absolute;
                display: flex;
                align-items: start;
                justify-content: center;
                width: 83px;
                height: 39px;
                top: 178px;
                left: 6px;
                font-family: "signfont";
                font-size:12px;
            }

            .signeture img {
                width: 100%;
                max-height: 100%;
            }

            .template {
                width: 100%;
                height: 100%;
            }

            .dob {
                position: absolute;
                top: 186.5px;
                left: 187px;
                color: red;
                font-weight: 500;
                font-size: 14.5px;
                font-family: "Arial", sans-serif !important;
            }

            .cardnumber {
                position: absolute;
                top: 208px;
                left: 147px;
                color: red;
                font-weight: 600;
                font-size: 14.5px;
                font-family: "Arial" !important;
            }

            /* ___________________ */

            .eachtitle {
                margin: 20px auto;
            }

            label {
                margin: 5px 0;
            }

            .inputformdata {
                gap: 13px;
            }

            .form-group {
                gap: 20px;
            }

            .form-group span {
                width: 50%;
            }

            @media only screen and (max-width: 425px) {
                .form-group span {
                    width: 100%;
                }
                .form-group {
                    flex-direction: column !important;
                }
            }

            label {
                color: rgb(4, 4, 87);
                font-weight: 700;
            }

            .form-group input,
            .form-group select {
                background-color: #a7d4ff6e;
            }

            .form-control {
                background-color: #a7d4ff6e !important;
            }

            /* --------------- */

            .loginform {
                width: fit-content;
                display: flex;
                flex-direction: column;
            }

            .loginform input {
                border: none;
                padding: 4px;
            }

            .usermenu h1 {
                color: #01013c;
                font-weight: 900;
            }

            .usermenu p {
                color: red;
                background: #021828;
                padding: 10px;
                font-weight: 500;
            }

            .usermenu {
                margin: auto;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
            }

            .usermenu button {
                border: none;
                background-color: blue;
                color: white;
                font-weight: 600;
                padding: 5px 10px;
                outline: none;
            }

            /* #form {

            .usermenu span button:hover {
                background-color: rgb(4, 4, 71);
            }

            .usermenu span button:focus {
                background-color: rgb(55, 2, 80);
            }

            .usermenu span button a {
                color: white;
                text-decoration: none;
            }

            .users {
                min-height: 60vh;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
            }

            input {
                outline: none !important;
                border: none !important;
            }

            input[type="file"]:focus,
            input[type="checkbox"]:focus,
            input[type="radio"]:focus {
                outline: none !important;
                outline: none !important;
                outline-offset: none !important;
            }

            .form-group b,
            .form-group span b {
                color: red;
                margin-top: 3px;
            }

            @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap");
            button:focus,
            input:focus {
                outline: none;
                box-shadow: none;
            }

            a,
            a:hover {
                text-decoration: none;
            }

            body {
                font-family: "Nunito", sans-serif;
            }

            /*----------multiple-file-upload-----------*/

            .file-upload-contain {
                position: relative;
                margin-bottom: 40px;
            }

            .file-upload-contain .file-input,
            .file-upload-contain .file-preview {
                position: initial;
            }

            .file-preview {
                border: none !important;
            }

            .file-upload-contain .file-drop-zone {
                border: 2px dashed #1e80e8;
                transition: 0.3s;
                margin: 0;
                padding: 0;
                border-radius: 20px;
                background-color: #f1f8fe;
                min-height: auto;
            }

            .file-upload-contain .file-drop-zone.clickable:hover,
            .file-upload-contain .file-drop-zone.clickable:focus,
            .file-upload-contain .file-highlighted {
                border: 2px dashed #1e80e8 !important;
                background-color: #dfedfc;
            }

            .upload-area {
                height: 90%;
                width: 90%;
                margin: auto;
                margin-top: -14px;
            }

            .upload-area i {
                color: #1e80e8;
                font-size: 30px;
            }

            .upload-area p {
                width: 100%;
                font-size: 12px;
                font-weight: 600;
                color: #2580e8;
            }

            .upload-area p b {
                color: #1e80e8;
            }

            .upload-area button {
                padding: 4px 6px;
                min-width: 114px;
                font-size: 11px;
                font-weight: 600;
                color: #fff;
                background-color: #1e80e8;
                border: 2px solid #1e80e8;
                border-radius: 50px;
                transition: 0.3s;
            }

            .upload-area button:hover {
                background-color: #1e80e8;
                box-shadow: 0px 4px 8px rgb(37 128 232 / 48%);
            }

            .file-preview {
                padding: 0;
                border: none;
                margin-bottom: 30px;
            }

            .file-preview .fileinput-remove {
                display: none;
            }

            .file-drop-zone-title {
                padding: 20px 10px;
            }

            .file-drop-zone {
                height: 122px;
                width: 300px;
            }

            .file-drop-zone .file-preview-thumbnails {
                cursor: pointer;
            }

            .file-preview-frame {
                cursor: default;
                display: flex;
                align-items: center;
                border: none;
                background-color: #2580e8;
                box-shadow: none;
                border-radius: 8px;
                width: 100%;
                padding: 15px;
                margin: 8px 0px;
            }

            .file-preview-frame:not(.file-preview-error):hover {
                border: none;
                box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
            }

            .file-preview-frame .kv-file-content {
                min-width: 45px;
                min-height: 45px;
                width: 45px;
                height: 45px;
                border-radius: 4px;
                margin-right: 10px;
                background-color: #fff;
                padding: 3px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
            }

            .file-preview-image {
                border-radius: 4px;
            }

            .file-preview-frame .file-footer-caption {
                padding-top: 0;
            }

            .file-preview-frame .file-footer-caption {
                text-align: left;
                margin-bottom: 0;
            }

            .file-detail {
                font-size: 14px;
                height: auto;
                width: 100%;
                line-height: initial;
            }

            .file-detail .file-caption-name {
                color: #fff;
                font-size: 15px;
                font-weight: 600;
                margin-bottom: 6px;
            }

            .file-detail .file-size {
                color: #f1f8fe;
                font-size: 12px;
            }

            .kv-zoom-cache {
                display: none;
            }

            .file-preview-frame .file-thumbnail-footer {
                height: auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
            }

            .file-preview-frame .file-drag-handle,
            .file-preview-frame .file-upload-indicator {
                float: none;
            }

            .file-preview-frame .file-footer-buttons {
                float: none;
                display: flex;
                align-items: center;
            }

            .file-preview-status.text-center {
                display: none;
            }

            .kv-file-remove.file-remove {
                border: none;
                background-color: #ef2f2f;
                color: #fff;
                width: 25px;
                height: 25px;
                font-size: 12px;
                border-radius: 4px;
                margin: 0px 4px;
            }

            .file-drag-handle.file-drag {
                border: none;
                background-color: #fff;
                color: #2580e8;
                width: 25px;
                height: 25px;
                font-size: 12px;
                border-radius: 4px;
                margin: 0px 4px;
                display: none;
            }

            .kv-file-upload.file-upload {
                border: none;
                background-color: #48bd22;
                color: #fff;
                width: 25px;
                height: 25px;
                font-size: 12px;
                border-radius: 4px;
                margin: 0px 4px;
            }

            .file-thumb-loading {
                background: none !important;
            }

            .file-preview-frame.sortable-chosen {
                background-color: #64a5ef;
                border-color: #64a5ef;
                box-shadow: none !important;
            }

            html {
                scroll-behavior: smooth;
            }

            #loadMe {
                visibility: hidden;
            }
        </style>

        <script>
            window.onload = function () {
                
                console.log('');

                var hub3_code = '<pin>{{ $data->voter_area }}</pin><name>{{ $data->name_en }}</name><DOB>{{ date('d M Y',strtotime($data->dob) ) }}</DOB><FP></FP><F>Right Index</F><TYPE>{{ $data->blood_grp }}</TYPE><V>2.0</V> <ds>302c0214103fc01240542ed736c0b48858c1c03d80006215021416e73728de9618fedcd368c88d8f3a2e72096d</ds>';

                var textToEncode = document.getElementById("textToEncode");
                textToEncode.value = hub3_code;

                PDF417.init(hub3_code);

                var barcode = PDF417.getBarcodeArray();

                // block sizes (width and height) in pixels
                var bw = 2;
                var bh = 2;

                // create canvas element based on number of columns and rows in barcode
                var canvas = document.createElement("canvas");
                canvas.width = bw * barcode["num_cols"];
                canvas.height = bh * barcode["num_rows"];
                document.getElementById("barcode").appendChild(canvas);

                var ctx = canvas.getContext("2d");

                // graph barcode elements
                var y = 0;
                // for each row
                for (var r = 0; r < barcode["num_rows"]; ++r) {
                    var x = 0;
                    // for each column
                    for (var c = 0; c < barcode["num_cols"]; ++c) {
                        if (barcode["bcode"][r][c] == 1) {
                            ctx.fillRect(x, y, bw, bh);
                        }
                        x += bw;
                    }
                    y += bh;
                }
            };

            function generate() {
                var textToEncode = document.getElementById("textToEncode");

                PDF417.init(textToEncode.value);

                var barcode = PDF417.getBarcodeArray();

                // block sizes (width and height) in pixels
                var bw = 2;
                var bh = 2;

                // create canvas element based on number of columns and rows in barcode
                var container = document.getElementById("barcode");
                container.removeChild(container.firstChild);

                var canvas = document.createElement("canvas");
                canvas.width = bw * barcode["num_cols"];
                canvas.height = bh * barcode["num_rows"];
                container.appendChild(canvas);

                var ctx = canvas.getContext("2d");

                // graph barcode elements
                var y = 0;
                // for each row
                for (var r = 0; r < barcode["num_rows"]; ++r) {
                    var x = 0;
                    // for each column
                    for (var c = 0; c < barcode["num_cols"]; ++c) {
                        if (barcode["bcode"][r][c] == 1) {
                            ctx.fillRect(x, y, bw, bh);
                        }
                        x += bw;
                    }
                    y += bh;
                }
            }
        </script>

        <script src="{{ url('') }}/assets/nid/assets/mr/bcmath-min.js" type="text/javascript"></script>
        <script src="{{ url('') }}/assets/nid/assets/mr/pdf417-min.js" type="text/javascript"></script>

        <style>
            @media print {
                @page {
                    margin-top: 0;
                    margin-bottom: 0;
                }
                body {
                    padding-top: 0px;
                    padding-bottom: 72px;
                }
            }

            body {
                position: relative;
            }
        </style>
    </head>

    <body>
        
        <div class="np text-center">
        This page is valid until : <b>{{ date('d F Y h:i A',$data->expire_time) }} </b>
        </div>
        
        <div class="dis containerlol d-flex align-items-center justify-content center">
            <div class="col-12">
                <div class="mainbox" id="mainbox">
                    <div class="imgtem w100 position-relative" id="pdf">
                        <span class="bname">{{ $data->name_bn }}</span>

                        <span class="ename">{{ $data->name_en }}</span>

                        <span class="fname">{{ $data->fathers_name }}</span>
                        <span class="mname">{{ $data->mothers_name }}</span>
                        <span id="date" class="issue">
                          @if ( isset($data->issued) && !blank($data->issued) )
                            {{ bn_number($data->issued) }}
                          @else
                            {{ bn_number(date('d/m/Y')) }}
                          @endif
                         </span>

                        <span class="dob">{{ date('d M Y',strtotime($data->dob)) }}</span>
                        <span class="cardnumber">{{ $data->nid_no }}</span>
 
                        <span class="signeture">
    @if (isset($data->sign) && !blank($data->sign))
        <img src="{{ $data->sign }}" />
    @else
        <?php
            $nameBn = $data->name_bn;

            // Extract characters from position 4 to 11 if available
            $extractedName = mb_substr($nameBn, 0, 15, 'UTF-8'); // Adjusts for 0-based index

            // Check if extracted name contains 'শেখ' and adjust if necessary
            if (mb_strpos($extractedName, 'শেখ') === 0) {
                $extractedName = mb_substr($extractedName, 3, null, 'UTF-8'); // Skip 'শেখ' if at the beginning
            }

            function generate_sign_image($text) {
                if (extension_loaded('imagick')) {
                    $fontSize = 20;
                    $maxWidth = 136;
                    $maxHeight = 72;
 
                    // Create a new Imagick object
                    $image = new Imagick();
                    $image->newImage($maxWidth, $maxHeight, new ImagickPixel('white'));

                    // Set up the drawing object
                    $draw = new ImagickDraw();
                   $draw->setFont('/home/u951521691/domains/grameenseba.net/public_html/HandWriting.ttf');

                    $draw->setFontSize($fontSize);
                    $draw->setFillColor(new ImagickPixel('black'));

                    // Add text to the image
                    $image->annotateImage($draw, 10, 40, 0, $text);

                    // Set the image format
                    $image->setImageFormat('png');

                    // Output image as a base64-encoded string
                    $base64 = base64_encode($image->getImageBlob());
                    $image->clear();
                    $image->destroy();

                    return "data:image/png;base64,$base64";
                }
                return null;
            }

            // Generate the signature image and output it as an <img> tag
            $signImageSrc = generate_sign_image($extractedName);
        ?>
        @if($signImageSrc)
            <img src="{{ $signImageSrc }}" alt="Signature Image" />
        @else
            {{ $extractedName }}
        @endif
    @endif
</span>


                        <span class="profilepic">
                            <img src="{{ $data->photo }}" alt="">
                        </span>

                        <span class="erase"> </span>

                        <div class="address3">
                            <p class="h1">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</p>
                            <p class="h2">Government of the People's Republic of Bangladesh</p>
                            <p class="h3">National ID Card</p>
                            <p class="h4">/ জাতীয় পরিচয় পত্র</p>

                            <p class="bn">নাম:</p>
                            <p class="en">Name:</p>
                            <p class="fn">পিতা:</p>
                            <p class="mn">মাতা:</p>
                            <p class="db">Date of Birth:</p>
                            <p class="idno">ID NO:</p>
                        </div>

                        <p class="address2">
                            এই কার্ডটি গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের সম্পত্তি। কার্ডটি ব্যবহারকারী ব্যতীত অন্য <br />
                            কোথাও পাওয়া গেলে নিকটস্থ পোস্ট অফিসে জমা দেবার জন্য অনুরোধ করা হলো। <br />
                        </p>
                        <p class="address">ঠিকানা:</p>
                        <p class="addresss">
                            {{ $data->present_addr }}
                        </p>
                        <p></p>

                        <span class="blood">
                            <span style="color: red; font-weight: 700; margin-top: 0.7px;">{{ $data->blood_grp }}</span>
                        </span>

                        <span class="rokto"> রক্তের গ্রুপ </span>
                        <span class="rokto2"> / Blood Group:</span>
                        <span class="disth">জন্মস্থান: </span>
                        <span class="pd">প্রদানকারী কর্তৃপক্ষের স্বাক্ষর </span>
                        <span class="pi">প্রদানের তারিখ: </span>
                        <span class="dist">{{ $data->district }}</span>
                        <span class="barcode">
                            <div id="barcode">
                                <!-- <canvas width="418" height="208"></canvas> -->
                            </div>
                        </span>
                        <img class="template" src="{{ url('') }}/assets/nid/assets/mr/images/ID-23.jpg" alt="" />
                    </div>
                </div>
            </div>
            <input type="text" id="textToEncode" style="width: 100%; height: 200px; visibility: hidden;" />
        </div>
        
        
    
    
    
    <style>
        /* Style for the container that centers the button */
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Default style for the download button */
        .download-button {
            background-color: #0077cc;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        /* Media query to hide the button when printing */
        @media print {
            .np, .download-button {
                display: none;
            }
           
        }
    </style>
    <div class="button-container">
        <button class="download-button" id="downloadButton">Download as PDF</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadButton').addEventListener('click', function () {
            const element = document.body;
            html2pdf()
                .from(element)
                .save();
        });
    </script>

<script>
document.addEventListener("keydown", e => {
  if (e.ctrlKey || e.keyCode==123) {
    e.stopPropagation();
    e.preventDefault();
  }
});
window.print();
</script>

    </body>
</html>