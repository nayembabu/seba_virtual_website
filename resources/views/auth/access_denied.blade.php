<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Access Denied</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: red;
        }

        h6 {
            color: red;
            text-decoration: underline;
        }

        .w3-display-middle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .w3-border-white {
            border-color: white !important;
        }

        .w3-animate-left {
            animation: animateleft 0.5s;
        }

        .w3-animate-right {
            animation: animateright 0.5s;
        }

        .w3-animate-top {
            animation: animatetop 0.5s;
        }

        .w3-animate-zoom {
            animation: animatezoom 0.5s;
        }

        @keyframes animateleft {
            from {transform: translateX(-100%);}
            to {transform: translateX(0);}
        }

        @keyframes animateright {
            from {transform: translateX(100%);}
            to {transform: translateX(0);}
        }

        @keyframes animatetop {
            from {transform: translateY(-100%);}
            to {transform: translateY(0);}
        }

        @keyframes animatezoom {
            from {transform: scale(0);}
            to {transform: scale(1);}
        }
    </style>
</head>
<body>
    <div class="w3-display-middle">
        <h1 class="w3-jumbo w3-animate-top"><code>Access Denied</code></h1>
        <hr class="w3-border-white w3-animate-left" style="margin:auto;width:50%">
        <h3 class="w3-center w3-animate-right">You don't have permission to view this site.</h3>
        <h3 class="w3-center w3-animate-zoom">🚫🚫🚫🚫</h3>
        <h6 class="w3-center w3-animate-zoom">error code: 403 forbidden</h6>
    </div>
</body>
</html>
