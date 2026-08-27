<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>উত্তরাধিকার সনদ যাচাই</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'SolaimanLipi', Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .verification-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .certificate-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .certificate-details {
            margin-top: 20px;
        }
        .verification-status {
            text-align: center;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .details-row {
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .details-label {
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="verification-container">
            <div class="certificate-header">
                <h2>উত্তরাধিকার সনদ যাচাই</h2>
                <h4>{{ $certificate->union_name }}</h4>
                <p>{{ $certificate->union_address }}</p>
            </div>

            <div class="verification-status success">
                <h4>সনদ যাচাই সফল হয়েছে</h4>
                <p>সার্টিফিকেট নং: {{ $certificate->certificate_number }}</p>
            </div>

            <div class="certificate-details">
                <div class="details-row">
                    <span class="details-label">ব্যক্তির নাম:</span>
                    <span>{{ $certificate->person_bn }}</span>
                </div>

                <div class="details-row">
                    <span class="details-label">অভিভাবকের নাম:</span>
                    <span>{{ $certificate->guardian_bn }}</span>
                </div>

                <div class="details-row">
                    <span class="details-label">লিঙ্গ:</span>
                    <span>{{ $certificate->gender == 'male' ? 'পুরুষ' : ($certificate->gender == 'female' ? 'মহিলা' : 'অন্যান্য') }}</span>
                </div>

                <div class="details-row">
                    <span class="details-label">অবস্থা:</span>
                    <span>{{ $certificate->he_she_is == 'live' ? 'জীবিত' : 'মৃত' }}</span>
                </div>

                @if($certificate->he_she_is == 'death')
                <div class="details-row">
                    <span class="details-label">মৃত্যু সনদ নং:</span>
                    <span>{{ $certificate->death_certificates_id }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">মৃত্যুর তারিখ:</span>
                    <span>{{ $certificate->dod }}</span>
                </div>
                @endif

                <div class="details-row">
                    <span class="details-label">ঠিকানা:</span>
                    <p>
                        ওয়ার্ড নং: {{ $certificate->word_no }}<br>
                        গ্রাম: {{ $certificate->village_name }}<br>
                        ডাকঘর: {{ $certificate->post_office }}<br>
                        থানা: {{ $certificate->thana }}<br>
                        উপজেলা: {{ $certificate->upozila }}<br>
                        জেলা: {{ $certificate->zila }}
                    </p>
                </div>

                @if(!empty($certificate->relatives))
                <div class="details-row">
                    <span class="details-label">উত্তরাধিকারীগণ:</span>
                    <ul class="list-unstyled">
                        @foreach($certificate->relatives as $relative)
                        <li>{{ $relative['name_bn'] }} ({{ $relative['relation'] }})</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
