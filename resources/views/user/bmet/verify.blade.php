<!DOCTYPE html>
<html>
<head>
    <title>BMET Card Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { 
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .verified {
            color: green;
            font-weight: bold;
        }
        .info {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>BMET Card Verification</h1>
        
        <div class="info">
            <p class="verified">✓ This BMET card is verified</p>
            
            <h3>Card Details:</h3>
            <p>Name: {{ $bmet->name }}</p>
            <p>Passport No: {{ $bmet->passport_no }}</p>
            <p>Clearance ID: {{ $bmet->clearance_id }}</p>
            <p>Issue Date: {{ $bmet->clearance_date }}</p>
        </div>
    </div>
</body>
</html>
