@extends('user.layouts.app')

@section('title')
   LSG PAYMENT
@endsection

@section('content')

    <div class="header">LDTAX Holding ID</div>

    <form id="search-form" method="POST" action="{{ route('ldt.search') }}">
        @csrf
        <label for="division">বিভাগ:</label>
        <select id="division" name="division">
            <option value="">বিভাগ নির্বাচন করুন</option>
            <option value="1">বরিশাল</option>
            <option value="2">চট্টগ্রাম</option>
            <option value="3">ঢাকা</option>
            <option value="4">খুলনা</option>
            <option value="5">রাজশাহী</option>
            <option value="6">রংপুর</option>
            <option value="7">সিলেট</option>
            <option value="8">ময়মনসিংহ</option>
        </select>

        <label for="district">জেলা:</label>
        <select id="district" name="district">
            <option value="">জেলা নির্বাচন করুন</option>
        </select>

        <label for="upazila">উপজেলা:</label>
        <select id="upazila" name="upazila">
            <option value="">উপজেলা নির্বাচন করুন</option>
        </select>

        <label for="moza">মৌজা:</label>
        <select id="moza" name="moza">
            <option value="">মৌজা নির্বাচন করুন</option>
        </select>

        <label for="option_select">সিলেক্ট করুন:</label> 
        <select id="option_select" name="option_select">
            <option value="holding_number">হোল্ডিং নং</option>
            <option value="khotian_no">খতিয়ান নং</option>
        </select>

        <label for="input_value"> লিখুন:</label>
        <input type="text" id="input_value" name="input_value" placeholder=" লিখুন"> 

        <button type="submit">Search</button>
    </form>

    <div id="result"></div>

    <script>
        const divisionSelect = document.getElementById('division');
        const districtSelect = document.getElementById('district');
        const upazilaSelect = document.getElementById('upazila');
        const mozaSelect = document.getElementById('moza');

        divisionSelect.addEventListener('change', function () {
            const divisionId = this.value;
            districtSelect.innerHTML = '<option value="">জেলা নির্বাচন করুন</option>';
            upazilaSelect.innerHTML = '<option value="">উপজেলা নির্বাচন করুন</option>';
            mozaSelect.innerHTML = '<option value="">মৌজা নির্বাচন করুন</option>';

            if (divisionId) {
                axios.get(`/ldt-search/get-districts?division_id=${divisionId}`)
                    .then(response => {
                        response.data.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.id;
                            option.textContent = district.name_bn;
                            districtSelect.appendChild(option);
                        });
                    }).catch(console.error);
            }
        });

        districtSelect.addEventListener('change', function () {
            const districtId = this.value;
            upazilaSelect.innerHTML = '<option value="">উপজেলা নির্বাচন করুন</option>';
            mozaSelect.innerHTML = '<option value="">মৌজা নির্বাচন করুন</option>';

            if (districtId) {
                axios.get(`/ldt-search/get-upazilas?district_id=${districtId}`)
                    .then(response => {
                        response.data.forEach(upazila => {
                            const option = document.createElement('option');
                            option.value = upazila.id;
                            option.textContent = upazila.name_bd;
                            upazilaSelect.appendChild(option);
                        });
                    }).catch(console.error);
            }
        });

        upazilaSelect.addEventListener('change', function () {
            const upazilaId = this.value;
            mozaSelect.innerHTML = '<option value="">মৌজা নির্বাচন করুন</option>';

            if (upazilaId) {
                axios.get(`/ldt-search/get-mozas?upazila_id=${upazilaId}`)
                    .then(response => {
                        response.data.forEach(moza => {
                            const option = document.createElement('option');
                            option.value = moza.id;
                            option.textContent = moza.name_bd;
                            mozaSelect.appendChild(option);
                        });
                    }).catch(console.error);
            }
        });
    </script>

@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        form {
            margin: 20px auto;
            padding: 15px;  /* Reduced padding */
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 40%;  /* Reduced width */
            border-radius: 8px;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        select, input {
            width: 100%;
            padding: 8px;  /* Reduced padding */
            margin-bottom: 12px;  /* Reduced margin */
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        select:focus, input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            width: 100%;
            padding: 8px;  /* Reduced padding */
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        #result {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
