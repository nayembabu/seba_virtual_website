<!DOCTYPE html>
<html>
<head>
    <title>Verify Certificate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
            min-height: 100vh;
            background: linear-gradient(145deg, #f4f4f4, #e8e8e8);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: #fff;
            padding: 25px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            text-align: center;
        }
        h1 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .verification-badge {
            background: #e8f5e9;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #4caf50;
        }
        .icon {
            color: #4caf50;
            font-size: 40px;
        }
        .certificate-number {
            background: #f8f9fa;
            border: 2px dashed #4caf50;
            padding: 12px;
            border-radius: 8px;
            margin: 15px 0;
            font-weight: bold;
            color: #2c3e50;
        }
        .status {
            background: #4caf50;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            margin-top: 10px;
        }
        .certificate-details {
            text-align: left;
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .detail-row {
            display: flex;
            margin: 10px 0;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 8px;
        }
        .detail-label {
            font-weight: bold;
            width: 140px;
            color: #2c3e50;
        }
        .detail-value {
            flex: 1;
            color: #34495e;
        }
        .profile-photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin: 15px auto;
            border: 3px solid #4caf50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Certificate Verification</h1>
        <div class="verification-badge">
            <div class="icon">&#10004;</div>
        </div>
        @if($certificate->photo_path)
            <img src="{{ asset('storage/' . $certificate->photo_path) }}" alt="Profile Photo" class="profile-photo">
        @endif
        <div class="certificate-number">
            Certificate #: {{ $certificate->certificate_number }}
        </div>
        <div class="certificate-details">
            <div class="detail-row">
                <div class="detail-label">Name:</div>
                <div class="detail-value">{{ $certificate->name }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Father's Name:</div>
                <div class="detail-value">{{ $certificate->father_name }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Mother's Name:</div>
                <div class="detail-value">{{ $certificate->mother_name }}</div>
            </div>
            @if($certificate->husband_name)
            <div class="detail-row">
                <div class="detail-label">Spouse Name:</div>
                <div class="detail-value">{{ $certificate->husband_name }}</div>
            </div>
            @endif
            <div class="detail-row">
                <div class="detail-label">Address:</div>
                <div class="detail-value">{{ $certificate->address }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Ward No:</div>
                <div class="detail-value">{{ $certificate->ward_no }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">NID Number:</div>
                <div class="detail-value">{{ $certificate->nid_number }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Date of Birth:</div>
                <div class="detail-value">{{ date('d M Y', strtotime($certificate->birth_date)) }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Issue Date:</div>
                <div class="detail-value">{{ date('d M Y', strtotime($certificate->issue_date)) }}</div>
            </div>
        </div>
        <div class="status">✓ Valid Certificate</div>
    </div>
</body>
</html>
