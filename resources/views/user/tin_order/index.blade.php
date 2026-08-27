@extends('user.layouts.app')

@section('title')
    টিন সার্ভিস
@endsection

@push('style')
<style>
    .classic-card {
        background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
    }
    
    .form-container {
        display: none;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 20px;
    }

    .form-container.active {
        display: block !important;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-option {
        position: relative;
        padding: 10px 15px;
        font-size: 0.95rem;
        text-align: left;
        margin-bottom: 5px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
        width: 100%;
        height: 100%;
        min-height: 60px;
        background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
        color: #2c3e50;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        cursor: pointer;
    }
    
    .btn-option .btn-text {
        font-size: 0.92rem;
        color: #2c3e50;
        font-weight: 500;
    }
    
    .btn-option .text-block {
        flex: 1;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .option-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 20px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
        padding: 0 15px;
    }
    
    .option-column {
        display: grid;
        grid-template-rows: repeat(1, 1fr);
        gap: 12px;
    }

    .btn-option i {
        font-size: 1.1rem;
        margin-right: 12px;
        color: #3498db;
        width: 24px;
        text-align: center;
    }

    .btn-option .badge {
        font-size: 0.9rem;
        padding: 5px 12px;
        background: #3498db;
        color: white;
        border-radius: 20px;
        margin-left: auto;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .btn-option:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        border-color: #3498db;
        background: linear-gradient(to bottom, #ffffff 0%, #e9f2ff 100%);
    }

    .btn-option.active {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        border-color: #2980b9;
    }

    .btn-option.active i {
        color: white;
    }
    
    .btn-option.active .btn-text {
        color: white;
    }
    
    .btn-option.active .badge {
        background: white;
        color: #2980b9;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 20px;
        margin-bottom: 25px;
        border-bottom: 2px solid #e9ecef;
    }

    .modal-header .modal-title {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.8rem;
        cursor: pointer;
        color: #6c757d;
        padding: 5px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s;
    }

    .close-modal:hover {
        color: #dc3545;
        background: #f8f9fa;
    }

    .mobile-order-row {
        background: #fff;
        border: 1px solid #e6e6e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 8px;
        display: flex;
        align-items: flex-start;
        font-size: 0.9rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .row-number {
        font-weight: 600;
        color: #1e4c78;
        margin-right: 15px;
        min-width: 28px;
        text-align: left;
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .row-content {
        flex: 1;
        color: #333;
        display: grid;
        grid-gap: 8px;
    }

    .row-content .info-line {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .row-content .text-muted {
        color: #6c757d;
        font-size: 0.85rem;
    }
    
    .row-content .badge {
        padding: 6px 10px;
        font-size: 0.8rem;
        border-radius: 4px;
        font-weight: 500;
    }

    .row-content .btn-sm {
        padding: 5px 10px;
        font-size: 0.8rem;
        border-radius: 4px;
        margin-left: auto;
    }

    .row-content .badge.bg-warning {
        background: #ffc107 !important;
        color: #000;
    }
    
    .row-content .badge.bg-info {
        background: #0dcaf0 !important;
    }
    
    .row-content .badge.bg-success {
        background: #198754 !important;
    }
    
    .row-content .badge.bg-danger {
        background: #dc3545 !important;
    }

    @media (max-width: 768px) {
        .option-grid {
            gap: 6px;
            padding: 8px;
        }
        
        .btn-option {
            height: 60px;
            min-height: 60px;
            max-height: 60px;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .btn-option .btn-text {
            font-size: 0.7rem;
            line-height: 1.2;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-word;
            margin: 0;
        }

        .btn-option i {
            font-size: 0.85rem;
            margin-right: 4px;
            width: 12px;
            flex-shrink: 0;
        }

        .btn-option .badge {
            font-size: 0.65rem;
            padding: 2px 4px;
            margin-left: 3px;
            flex-shrink: 0;
            min-width: 35px;
            text-align: center;
        }

        .text-block {
            flex: 1;
            min-width: 0;
            padding-right: 4px;
            display: flex;
            align-items: center;
        }

        .mobile-order-row {
            font-size: 0.8rem;
        }
    }
</style>

<script>
// Define functions in global scope BEFORE the page loads
window.toggleForm = function(formType) {
    console.log('Toggle form called for:', formType);
    
    // Hide all forms first
    hideAllForms();
    
    // Show the selected form
    var targetForm = document.getElementById(formType);
    var selectedButton = document.querySelector(`button[onclick*="toggleForm('${formType}')"]`);
    
    if (targetForm) {
        targetForm.classList.add('active');
        console.log('Form activated:', formType);
        
        if (selectedButton) {
            selectedButton.classList.add('active');
        }
        
        // Scroll to form
        setTimeout(function() {
            targetForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    } else {
        console.error('Form not found:', formType);
    }
};

window.hideAllForms = function() {
    var forms = document.querySelectorAll('.form-container');
    var buttons = document.querySelectorAll('.btn-option');
    
    forms.forEach(function(form) {
        form.classList.remove('active');
    });
    
    buttons.forEach(function(btn) {
        btn.classList.remove('active');
    });
};

window.submitForm = function(formType) {
    console.log('Submit form called for:', formType);
    
    const form = document.getElementById(formType + 'Form');
    if (!form) {
        console.error('Form not found:', formType + 'Form');
        alert('ফর্মে সমস্যা হয়েছে');
        return false;
    }
    
    // Get the type number from the form type
    let typeNum = 0;
    switch(formType) {
        case 'tin_certificate': typeNum = 1; break;
        case 'new_tin': typeNum = 2; break;
        case 'zero_return': typeNum = 3; break;
        case 'tin_correction': typeNum = 4; break;
        case 'tin_password': typeNum = 5; break;
    }
    
    // Get the textarea
    const textarea = document.getElementById('info_' + typeNum);
    if (!textarea) {
        console.error('Textarea not found for:', formType);
        alert('ফর্মে সমস্যা হয়েছে');
        return false;
    }
    
    const lines = textarea.value.split('\n');
    let extractedData = {};
    
    // Parse textarea based on form type
    lines.forEach(line => {
        line = line.trim();
        if (!line) return;
        
        // Type 1: টিন সার্টিফিকেট অর্ডার
        if (typeNum === 1) {
            if (line.includes('নাম্বার:')) {
                extractedData.nid_tin_mobile = line.split('নাম্বার:')[1].trim();
            }
        }
        
        // Type 2: নিউ টিন আবেদন
        if (typeNum === 2) {
            if (line.includes('Nid No:')) {
                extractedData.nid_no = line.split('Nid No:')[1].trim();
            } else if (line.includes('Mobile No:')) {
                extractedData.mobile_no = line.split('Mobile No:')[1].trim();
            } else if (line.includes('Father Nid:')) {
                extractedData.father_nid = line.split('Father Nid:')[1].trim();
            } else if (line.includes('Mother Nid:')) {
                extractedData.mother_nid = line.split('Mother Nid:')[1].trim();
            }
        }
        
        // Type 3: জিরো রিটার্ন আবেদন
        if (typeNum === 3) {
            if (line.includes('Nid Number:')) {
                extractedData.nid_number = line.split('Nid Number:')[1].trim();
            } else if (line.includes('Tin Number:')) {
                extractedData.tin_number = line.split('Tin Number:')[1].trim();
            } else if (line.includes('Mobile Number:')) {
                extractedData.mobile_number = line.split('Mobile Number:')[1].trim();
            }
        }
        
        // Type 4: টিন সার্টিফিকেট কারেকশন
        if (typeNum === 4) {
            if (line.includes('User Id:')) {
                extractedData.user_id = line.split('User Id:')[1].trim();
            } else if (line.includes('Pass:')) {
                extractedData.pass = line.split('Pass:')[1].trim();
            } else if (line.includes('Correction Info:')) {
                extractedData.correction_info = line.split('Correction Info:')[1].trim();
            }
        }
        
        // Type 5: টিন আইডি পাসওয়ার্ড সেট
        if (typeNum === 5) {
            if (line.includes('Tin No:')) {
                extractedData.tin_no = line.split('Tin No:')[1].trim();
            } else if (line.includes('Id & Pass:')) {
                extractedData.id_pass = line.split('Id & Pass:')[1].trim();
            }
        }
    });
    
    console.log('Extracted data:', extractedData);
    
    // Validate required fields based on type
    let isValid = true;
    let missingField = '';
    
    switch(typeNum) {
        case 1:
            if (!extractedData.nid_tin_mobile) {
                isValid = false;
                missingField = 'নাম্বার';
            }
            break;
        case 2:
            if (!extractedData.nid_no || !extractedData.mobile_no || !extractedData.father_nid || !extractedData.mother_nid) {
                isValid = false;
                missingField = 'সকল ফিল্ড';
            }
            break;
        case 3:
            if (!extractedData.nid_number || !extractedData.tin_number || !extractedData.mobile_number) {
                isValid = false;
                missingField = 'সকল ফিল্ড';
            }
            break;
        case 4:
            if (!extractedData.user_id || !extractedData.pass || !extractedData.correction_info) {
                isValid = false;
                missingField = 'সকল ফিল্ড';
            }
            break;
        case 5:
            if (!extractedData.tin_no) {
                isValid = false;
                missingField = 'Tin No';
            }
            break;
    }
    
    if (!isValid) {
        alert('অনুগ্রহ করে ' + missingField + ' পূরণ করুন');
        return false;
    }
    
    // Set hidden fields
    Object.keys(extractedData).forEach(key => {
        const hiddenField = document.getElementById('hidden_' + key + '_' + typeNum);
        if (hiddenField && extractedData[key]) {
            hiddenField.value = extractedData[key];
        }
    });
    
    console.log('Submitting form...');
    form.submit();
    return true;
};

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing...');
    hideAllForms();
});

// Copy text to clipboard
window.copyText = function(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
    alert('টেক্সট কপি হয়েছে!');
};
</script>
@endpush

@section('content')
<div class="card classic-card m-0 m-md-4 my-4 m-md-0">
    <div class="card-body">
        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Service Buttons -->
        <div class="option-grid">
            <div class="option-column">
                <button type="button" class="btn-option" onclick="toggleForm('tin_certificate')">
                    <i class="fas fa-certificate"></i>
                    <div class="text-block">
                        <span class="btn-text">&nbsp;টিন সার্টিফিকেট অর্ডার</span>
                    </div>
                    <span class="badge">৳{{ $tinTypes[1]->cost ?? 100 }}</span>
                </button>
                
                <button type="button" class="btn-option" onclick="toggleForm('new_tin')">
                    <i class="fas fa-file-alt"></i>
                    <div class="text-block">
                        <span class="btn-text">&nbsp;নিউ টিন আবেদন</span>
                    </div>
                    <span class="badge">৳{{ $tinTypes[2]->cost ?? 150 }}</span>
                </button>
                
                <button type="button" class="btn-option" onclick="toggleForm('zero_return')">
                    <i class="fas fa-undo"></i>
                    <div class="text-block">
                        <span class="btn-text">&nbsp;জিরো রিটার্ন আবেদন</span>
                    </div>
                    <span class="badge">৳{{ $tinTypes[3]->cost ?? 120 }}</span>
                </button>
            </div>
            <div class="option-column">
                <button type="button" class="btn-option" onclick="toggleForm('tin_correction')">
                    <i class="fas fa-edit"></i>
                    <div class="text-block">
                        <span class="btn-text">&nbsp;টিন সার্টিফিকেট কারেকশন</span>
                    </div>
                    <span class="badge">৳{{ $tinTypes[4]->cost ?? 80 }}</span>
                </button>
                
                <button type="button" class="btn-option" onclick="toggleForm('tin_password')">
                    <i class="fas fa-key"></i>
                    <div class="text-block">
                        <span class="btn-text">&nbsp;টিন আইডি পাসওয়ার্ড সেট</span>
                    </div>
                    <span class="badge">৳{{ $tinTypes[5]->cost ?? 50 }}</span>
                </button>
            </div>
        </div>

        <!-- Forms Container -->
        <div class="forms-wrapper mt-4">
            <!-- 1. টিন সার্টিফিকেট অর্ডার Form -->
            <div id="tin_certificate" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">টিন সার্টিফিকেট অর্ডার</h5>
                    <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                </div>
                <form action="{{ route('user.tin.order.store') }}" method="POST" class="needs-validation" id="tin_certificateForm" novalidate>
                    @csrf
                    <input type="hidden" name="type" value="1">
                    
                    <div class="form-group mb-3">
                       
                        <textarea 
                            class="form-control" 
                            id="info_1" 
                            rows="4" 
                            required
                            style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                            placeholder="নাম্বার: ">নাম্বার: </textarea>
                    </div>

                    <input type="hidden" name="nid_tin_mobile" id="hidden_nid_tin_mobile_1">

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                        <button type="button" class="btn btn-primary" onclick="submitForm('tin_certificate')">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- 2. নিউ টিন আবেদন Form -->
            <div id="new_tin" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">নিউ টিন আবেদন</h5>
                    <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                </div>
                <form action="{{ route('user.tin.order.store') }}" method="POST" class="needs-validation" id="new_tinForm" novalidate>
                    @csrf
                    <input type="hidden" name="type" value="2">
                    
                    <div class="form-group mb-3">
                        <textarea 
                            class="form-control" 
                            id="info_2" 
                            rows="6" 
                            required
                            style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                            placeholder="Nid No: 
                            Mobile No:
                            Father Nid:
                            Mother Nid: ">Nid No:
                            Mobile No:
                            Father Nid:
                            Mother Nid: </textarea>
                    </div>

                    <input type="hidden" name="nid_no" id="hidden_nid_no_2">
                    <input type="hidden" name="mobile_no" id="hidden_mobile_no_2">
                    <input type="hidden" name="father_nid" id="hidden_father_nid_2">
                    <input type="hidden" name="mother_nid" id="hidden_mother_nid_2">

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                        <button type="button" class="btn btn-success" onclick="submitForm('new_tin')">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- 3. জিরো রিটার্ন আবেদন Form -->
            <div id="zero_return" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">জিরো রিটার্ন আবেদন</h5>
                  <h2 class="modal-title" style="color: red; font-size: 1.2rem;">(টিন সার্টিফিকেট এ  ব্যবহৃত এনআইডি দ্বারা রেজি: কৃত মোবাইল  নং ওটিপির জন্য)</h2>
                    <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                </div>
                <form action="{{ route('user.tin.order.store') }}" method="POST" class="needs-validation" id="zero_returnForm" novalidate>
                    @csrf
                    <input type="hidden" name="type" value="3">
                    
                    <div class="form-group mb-3">
                        <textarea 
                            class="form-control" 
                            id="info_3" 
                            rows="5" 
                            required
                            style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                            placeholder="Nid Number: 
Tin Number: 
Mobile Number: ">Nid Number: 
Tin Number: 
Mobile Number: </textarea>
                    </div>

                    <input type="hidden" name="nid_number" id="hidden_nid_number_3">
                    <input type="hidden" name="tin_number" id="hidden_tin_number_3">
                    <input type="hidden" name="mobile_number" id="hidden_mobile_number_3">

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                        <button type="button" class="btn btn-info" onclick="submitForm('zero_return')">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- 4. টিন সার্টিফিকেট কারেকশন Form -->
            <div id="tin_correction" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">টিন সার্টিফিকেট কারেকশন</h5>
                    <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                </div>
                <form action="{{ route('user.tin.order.store') }}" method="POST" class="needs-validation" id="tin_correctionForm" novalidate>
                    @csrf
                    <input type="hidden" name="type" value="4">
                    
                    <div class="form-group mb-3">
                        <textarea 
                            class="form-control" 
                            id="info_4" 
                            rows="5" 
                            required
                            style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                            placeholder="User Id: 
Pass: 
Correction Info: ">User Id: 
Pass: 
Correction Info: </textarea>
                    </div>

                    <input type="hidden" name="user_id" id="hidden_user_id_4">
                    <input type="hidden" name="pass" id="hidden_pass_4">
                    <input type="hidden" name="correction_info" id="hidden_correction_info_4">

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                        <button type="button" class="btn btn-warning" onclick="submitForm('tin_correction')">জমা দিন</button>
                    </div>
                </form>
            </div>

            <!-- 5. টিন আইডি পাসওয়ার্ড সেট Form -->
            <div id="tin_password" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">টিন আইডি পাসওয়ার্ড সেট</h5>
                    <button type="button" class="close-modal" onclick="hideAllForms()">&times;</button>
                </div>
                <form action="{{ route('user.tin.order.store') }}" method="POST" class="needs-validation" id="tin_passwordForm" novalidate>
                    @csrf
                    <input type="hidden" name="type" value="5">
                    
                    <div class="form-group mb-3">
                        <textarea 
                            class="form-control" 
                            id="info_5" 
                            rows="4" 
                            required
                            style="font-family: 'SolaimanLipi', Arial, sans-serif; line-height: 1.8;"
                            placeholder="Tin No: 
Id & Pass: (optional)">Tin No: 
Id & Pass: </textarea>
                    </div>

                    <input type="hidden" name="tin_no" id="hidden_tin_no_5">
                    <input type="hidden" name="id_pass" id="hidden_id_pass_5">

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideAllForms()">বাতিল</button>
                        <button type="button" class="btn btn-danger" onclick="submitForm('tin_password')">জমা দিন</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="mt-5">
            <div class="mb-3" style="background: linear-gradient(90deg, #1e4c78 0%, #3498db 100%); color: white; padding: 10px 15px; border-radius: 4px;">
                <h5 class="m-0 text-center">অর্ডার তালিকা</h5>
            </div>

            @if(isset($orders))
                <div class="alert alert-info">
                    সর্বমোট অর্ডার: {{ $orders->count() }} টি
                </div>
            @endif

            <!-- Desktop View -->
            <div class="classic-table d-none d-md-block">
                <table class="table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ক্রমিক</th>
                            <th>সার্ভিস টাইপ</th>
                            <th>তথ্য</th>
                            <th>তারিখ</th>
                            <th>স্ট্যাটাস</th>
                            <th>ডাউনলোড</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $ordersCollection = $orders ?? [];
                            $sortedOrders = $ordersCollection->sortByDesc('id')->values();
                            $totalCount = count($ordersCollection);
                        @endphp
                        @forelse($sortedOrders as $index => $order)
                        <tr>
                            <td>{{ $totalCount - $index }}</td>
                            <td>
                                @switch($order->type)
                                    @case(1) টিন সার্টিফিকেট অর্ডার @break
                                    @case(2) নিউ টিন আবেদন @break
                                    @case(3) জিরো রিটার্ন আবেদন @break
                                    @case(4) টিন সার্টিফিকেট কারেকশন @break
                                    @case(5) টিন আইডি পাসওয়ার্ড সেট @break
                                @endswitch
                            </td>
                            <td>
                                @php
                                    try {
                                        $formData = is_string($order->form_data) ? json_decode($order->form_data, true) : $order->form_data;
                                        if (is_array($formData)) {
                                            echo implode(', ', array_slice($formData, 0, 2));
                                        } else {
                                            echo 'N/A';
                                        }
                                    } catch (\Exception $e) {
                                        echo 'N/A';
                                    }
                                @endphp
                            </td>
                            <td>{{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                @if($order->status == 0)
                                    <span class="text-warning">পেন্ডিং</span>
                                @elseif($order->status == 1)
                                    <span class="text-info">অনুমোদিত</span>
                                @elseif($order->status == 2)
                                    <span class="text-success">সম্পন্ন</span>
                                @else
                                    <span class="text-danger">বাতিল</span>
                                @endif
                            </td>
                            <td>
                                @if($order->status == 3)
                                    <div class="text-danger mb-0 mt-2 py-1 px-2" style="font-size: 0.8rem; width: 100%;">
                                                <strong style="font-size: 0.75rem;">বাতিলের কারণ:</strong><br>
                                                <span style="font-size: 0.75rem;">{{ $order->reject_note ?? 'কোন কারণ উল্লেখ করা হয়নি' }}</span>
                                            </div>
                                @elseif($order->admin_note && strpos($order->admin_note, '.pdf') !== false)
                                    <a href="{{ route('user.tin.order.download', $order->id) }}" class="btn btn-sm btn-success" title="পিডিএফ ডাউনলোড করুন">
                                        <i class="fas fa-download"></i> ডাউনলোড
                                    </a>
                                @elseif($order->status == 2 && $order->text)
                                    <div class="text-info mb-0" style="padding: 8px 12px; font-size: 0.9rem; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <strong>অ্যাডমিনের নোট:</strong><br>
                                            {{ $order->text }}
                                        </div>
                                        <button onclick="copyText('{{ addslashes($order->text) }}')" class="btn btn-sm" style="background-color: #3498db; color: white; border: none; padding: 6px 12px; border-radius: 4px; margin-left: 10px; flex-shrink: 0;" title="কপি করুন">
                                            <i class="fas fa-copy"></i> কপি
                                        </button>
                                    </div>
                                @else
                                    <span class="badge bg-secondary" style="font-size: 0.75rem;">নেই</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">কোন অর্ডার নেই</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="d-md-none">
                @php
                    $ordersCollection = $orders ?? [];
                    $sortedOrders = $ordersCollection->sortByDesc('id')->values();
                    $totalCount = count($ordersCollection);
                @endphp
                @forelse($sortedOrders as $index => $order)
                <div class="mobile-order-row">
                    <div class="row-number">{{ $totalCount - $index }}</div>
                    <div class="row-content">
                        <div class="info-line">
                            <strong>
                                @switch($order->type)
                                    @case(1) টিন সার্টিফিকেট @break
                                    @case(2) নিউ টিন @break
                                    @case(3) জিরো রিটার্ন @break
                                    @case(4) টিন কারেকশন @break
                                    @case(5) টিন পাসওয়ার্ড @break
                                @endswitch
                            </strong>
                        </div>
                        <div class="info-line">
                            <span class="text-muted">
                                @php
                                    try {
                                        $formData = is_string($order->form_data) ? json_decode($order->form_data, true) : $order->form_data;
                                        if (is_array($formData)) {
                                            echo implode(', ', array_slice($formData, 0, 1));
                                        } else {
                                            echo 'N/A';
                                        }
                                    } catch (\Exception $e) {
                                        echo 'N/A';
                                    }
                                @endphp
                            </span>
                        </div>
                        <div class="info-line">
                            <span>{{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</span>
                            @if($order->status == 0)
                                <span class="badge bg-warning">পেন্ডিং</span>
                            @elseif($order->status == 1)
                                <span class="badge bg-info">অনুমোদিত</span>
                            @elseif($order->status == 2)
                                <span class="badge bg-success">সম্পন্ন</span>
                            @else
                                <span class="badge bg-danger">বাতিল</span>
                            @endif
                        </div>
                        <div class="info-line">
                           @if($order->status == 3)
                                <div class="info-line">
                                    <div class="p-2 bg-light border-start border-3 border-danger rounded reason-box">
                                        <strong>কারণ:</strong> {{ $order->reject_note ?? 'কোন কারণ উল্লেখ করা হয়নি' }}
                                    </div>
                                </div>
                                @elseif($order->admin_note && strpos($order->admin_note, '.pdf') !== false)
                                    <a href="{{ route('user.tin.order.download', $order->id) }}" class="btn btn-sm btn-success" title="পিডিএফ ডাউনলোড করুন">
                                        <i class="fas fa-download"></i> ডাউনলোড
                                    </a>
                                @elseif($order->status == 2 && $order->text)
                                    <div class="text-info mb-0" style="padding: 8px 12px; font-size: 0.9rem; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <strong>অ্যাডমিনের নোট:</strong><br>
                                            {{ $order->text }}
                                        </div>
                                        <button onclick="copyText('{{ addslashes($order->text) }}')" class="btn btn-sm" style="background-color: #3498db; color: white; border: none; padding: 6px 12px; border-radius: 4px; margin-left: 10px; flex-shrink: 0;" title="কপি করুন">
                                            <i class="fas fa-copy"></i> কপি
                                        </button>
                                    </div>
                                @else
                                    <span class="badge bg-secondary" style="font-size: 0.75rem;">নেই</span>
                                @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center p-3">
                    কোন অর্ডার নেই
                </div>
                @endforelse
            </div>

            @if(isset($orders) && $orders->hasPages())
                {{ $orders->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
