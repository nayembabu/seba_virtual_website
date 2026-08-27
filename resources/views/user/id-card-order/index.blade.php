@extends('user.layouts.app')
@section('title')
    এনআইডি অর্ডার
@endsection

@push('style')
    <style>
        /* Classic theme styles */
        .classic-card {
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .classic-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            margin: -1.25rem -1.25rem 1rem -1.25rem;
        }

        .btn-classic {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-classic:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .classic-form .form-control {
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            padding: 12px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .classic-form .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.1);
            background-color: #ffffff;
        }

        /* Table header now plain white bg with black text (was blue gradient/white text) */
        .classic-table {
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            overflow: hidden;
        }

        .classic-table thead {
            background: #ffffff;
            border-bottom: 2px solid #dee2e6;
        }

        .classic-table thead th {
            color: #000000 !important;
            font-weight: 600;
            vertical-align: middle;
        }

        /* Mobile Order Row Styles */
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
            text-align: center;
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

        .row-content .service-type {
            font-weight: 500;
            color: #1e4c78;
        }

        .row-content .text-muted {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .row-content .btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
            border-radius: 4px;
            margin-left: auto;
        }

        .option-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 12px auto;
            padding: 0 8px;
            max-width: 978px;
        }

        .btn-option {
            position: relative;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            min-height: 36px;
            font-size: 0.9rem;
            text-align: left;
            border: 1.5px solid #e6e6e6;
            border-radius: 6px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            min-height: 45px;
            background: white;
            color: #333;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            overflow: hidden;
            backdrop-filter: blur(0);
            -webkit-backdrop-filter: blur(0);
        }

        .btn-option:hover {
            border-color: #2196f3;
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.15);
        }

        .btn-option::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(33, 150, 243, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .btn-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, #2196f3, #64b5f6);
            opacity: 0;
            transition: opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }

        .btn-option .content-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .btn-option i {
            font-size: 0.9rem;
            color: #2196f3;
            width: 20px;
            text-align: center;
            transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0;
            flex-shrink: 0;
        }

        .btn-option .text-wrapper {
            display: flex;
            flex-direction: column;
            gap: 0px;
            position: relative;
            z-index: 1;
            font-size: 0.85rem;
            flex: 1;
            margin-right: auto;
        }

        .btn-option .title {
            font-weight: 500;
            color: #333;
            margin: 0;
            transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.9rem;
        }

        .btn-option .subtitle {
            font-size: 0.8rem;
            color: #666;
            margin: 0;
            transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-option .badge {
            background: #2196f3;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-left: auto;
            position: relative;
            z-index: 1;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 2px rgba(33, 150, 243, 0.2);
        }

        .btn-option.active {
            background: #2196f3;
            border-color: #2196f3;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(33, 150, 243, 0.25);
        }

        .btn-option.active::after {
            opacity: 1;
        }

        .btn-option.active i {
            color: white;
            position: relative;
            z-index: 2;
        }

        .btn-option.active .text-wrapper span {
            color: white;
            position: relative;
            z-index: 2;
        }

        .btn-option.active .badge {
            background: white;
            color: #2196f3;
            box-shadow: 0 2px 8px rgba(33, 150, 243, 0.15);
            position: relative;
            z-index: 2;
        }

        .btn-option.active .content-wrapper {
            position: relative;
            z-index: 2;
        }

        .btn-option.active i,
        .btn-option.active .title,
        .btn-option.active .subtitle {
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .option-grid button:nth-child(odd).active {
            background: linear-gradient(45deg, #2196f3, #64b5f6);
        }

        .option-grid button:nth-child(even).active {
            background: linear-gradient(45deg, #1976d2, #2196f3);
        }

        @media (max-width: 992px) {
            .option-grid {
                max-width: 700px;
            }
        }

        @media (max-width: 768px) {
            .option-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 6px;
                padding: 0 6px;
                margin: 10px auto;
            }

            .btn-option {
                padding: 5px 12px;
                min-height: 34px;
            }

            .btn-option i {
                font-size: 0.85rem;
                width: 18px;
                margin-right: 10px;
            }

            .btn-option .text-wrapper {
                font-size: 0.8rem;
                gap: 0;
            }

            .btn-option .title {
                font-size: 0.85rem;
            }

            .btn-option .subtitle {
                font-size: 0.75rem;
            }

            .btn-option .badge {
                padding: 2px 6px;
                font-size: 0.75rem;
                margin-left: auto;
                border-radius: 3px;
            }
        }

        @media (max-width: 480px) {
            .option-grid {
                gap: 5px;
                padding: 0 5px;
                margin: 8px auto;
            }

            .btn-option {
                padding: 4px 10px;
                min-height: 32px;
            }
        }

        @media (max-width: 480px) {
            .option-grid {
                gap: 8px;
                padding: 0 8px;
            }
        }

        .form-container {
            width: 100%;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: none;
            margin-top: 20px;
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        .form-container.active {
            opacity: 1;
            display: block;
        }

        form[id^="form"] {
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        form[id^="form"].active {
            opacity: 1;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #666;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .close-modal:hover {
            background: #f8f9fa;
            color: #333;
        }

        .btn-option.active {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .form-container {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .list-group-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px !important;
            background: #fff;
        }

        .list-group-item:hover {
            background: #f8f9fa;
        }

        .btn-outline-primary {
            border-color: #1976d2;
            color: #1976d2;
        }

        .btn-outline-primary:hover {
            background: #1976d2;
            color: white;
        }
    </style>
@endpush

@push('js')
    <script>
        // Function to copy admin note
        function copyAdminNote(elementId) {
            const element = document.getElementById(elementId);
            if (!element) return;

            const text = element.textContent || element.innerText;

            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('কপি করা হয়েছে!');
                }).catch(() => {
                    fallbackCopy(text);
                });
            } else {
                fallbackCopy(text);
            }
        }

        function fallbackCopy(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            alert('কপি করা হয়েছে!');
        }

        document.addEventListener('DOMContentLoaded', function() {
            window.console.error = function() {};
            window.console.warn = function() {};
            window.console.log = function() {};

            const forms = document.querySelectorAll('.form-container');

            function saveActiveForm(formId) {
                localStorage.setItem('activeNIDForm', formId);
            }

            function getActiveForm() {
                return localStorage.getItem('activeNIDForm');
            }

            function showForm(formId) {
                hideForm();
                saveActiveForm(formId);

                const form = document.getElementById('form' + formId);
                if (form) {
                    form.style.display = 'block';
                    setTimeout(() => form.classList.add('active'), 10);
                }

                updateButtonStates(formId);
            }

            function hideForm() {
                document.querySelectorAll('.form-container').forEach(form => {
                    form.style.display = 'none';
                    form.classList.remove('active');
                });
                localStorage.removeItem('activeNIDForm');
            }

            function updateButtonStates(activeFormId) {
                document.querySelectorAll('.btn-option').forEach(btn => {
                    const btnFormId = btn.getAttribute('data-form');
                    if (btnFormId === activeFormId) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });
            }

            document.querySelectorAll('.btn-option').forEach(button => {
                button.onclick = function() {
                    const formId = this.getAttribute('data-form');
                    showForm(formId);
                };
            });

            localStorage.removeItem('activeNIDForm');

            window.showForm = function(formNumber) {
                hideForm();
                saveActiveForm(formNumber);

                const selectedForm = document.getElementById('form' + formNumber);
                if (selectedForm) {
                    selectedForm.style.display = 'block';
                    selectedForm.offsetHeight;
                    setTimeout(() => {
                        selectedForm.classList.add('active');
                    }, 10);
                }

                updateButtonStates(formNumber);
            };

            window.hideForm = function() {
                document.querySelectorAll('.form-container').forEach(form => {
                    form.style.display = 'none';
                    form.classList.remove('active');
                });

                document.querySelectorAll('.btn-option').forEach(btn => {
                    btn.classList.remove('active');
                });
            };

            document.querySelectorAll('.close-modal').forEach(button => {
                button.onclick = hideForm;
            });

            window.showForm = showForm;
            window.hideForm = hideForm;

            document.querySelectorAll('.needs-validation').forEach(form => {
                form.addEventListener('submit', function(event) {
                    if (!this.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    this.classList.add('was-validated');
                });
            });
        });
    </script>
@endpush

@section('content')
    <div class="card classic-card m-0 m-md-4 my-4 m-md-0">
        <div class="card-body bn-layout classic-form">

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

            <!-- Option Buttons -->
            <div class="option-grid">
                <button type="button" class="btn-option" data-form="1">
                    <div class="content-wrapper">
                        <i class="fas fa-check-circle"></i>
                        <div class="text-wrapper">
                            <span>&nbsp;১০/১২/১৭ দিয়ে এনআইডি</span>
                        </div>
                        <span class="badge">৳{{ $nidTypes[1]->cost ?? 10 }}</span>
                    </div>
                </button>
                <button type="button" class="btn-option" data-form="2">
                    <i class="fas fa-check-circle"></i>
                    <div class="text-wrapper">
                        <div class="title">&nbsp;ফরম/নিবন্ধন নং/১৩ডিজিট দিয়ে এনআইডি</div>
                    </div>
                    <span class="badge">৳{{ $nidTypes[2]->cost ?? 20 }}</span>
                </button>
                <button type="button" class="btn-option" data-form="3">
                    <i class="fas fa-check-circle"></i>
                    <div class="text-wrapper">
                        <div class="title">&nbsp;ইউজার আইডি পাস সেট</div>
                    </div>
                    <span class="badge">৳{{ $nidTypes[3]->cost ?? 30 }}</span>
                </button>
                <button type="button" class="btn-option" data-form="4">
                    <i class="fas fa-check-circle"></i>
                    <div class="text-wrapper">
                        <div class="title">&nbsp;হারানো ফরম উত্তোলন</div>
                    </div>
                    <span class="badge">৳{{ $nidTypes[4]->cost ?? 40 }}</span>
                </button>
            </div>

            <!-- Form 1: ১০/১২/১৭ দিয়ে এনআইডি -->
            <div id="form1" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">১০/১২/১৭ দিয়ে এনআইডি</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.nid.order.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="1">

                    <div class="form-group mb-3">
            <textarea class="form-control" rows="5" id="form1Input" required>নাম:
এনআইডি নম্বর:</textarea>
                        <input type="hidden" name="name" id="form1Name">
                        <input type="hidden" name="nid" id="form1Nid">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success" onclick="parseForm1Data(event)">জমা দিন</button>
                    </div>
                </form>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const textarea = document.getElementById('form1Input');
                    if (textarea) {
                        textarea.focus();
                        textarea.setSelectionRange(4, 4);
                    }
                });

                function parseForm1Data(event) {
                    event.preventDefault();

                    const textarea = document.getElementById('form1Input');
                    const lines = textarea.value.split('\n');

                    let name = '';
                    let nid = '';

                    lines.forEach(line => {
                        line = line.trim();
                        if (line.startsWith('নাম:')) {
                            name = line.replace('নাম:', '').trim();
                        } else if (line.startsWith('এনআইডি নম্বর:')) {
                            nid = line.replace('এনআইডি নম্বর:', '').trim();
                        }
                    });

                    document.getElementById('form1Name').value = name;
                    document.getElementById('form1Nid').value = nid;

                    event.target.closest('form').submit();
                }
            </script>
            <!-- Form 2: ফরম/নিবন্ধন নং/১৩ডিজিট -->
            <div id="form2" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">ফরম/নিবন্ধন নং/১৩ডিজিট দিয়ে এনআইডি</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.nid.order.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="2">

                    <div class="form-group mb-3">
            <textarea class="form-control" rows="5" id="form2Input" required>নাম:
এনআইডি নম্বর:</textarea>
                        <input type="hidden" name="name" id="form2Name">
                        <input type="hidden" name="nid" id="form2Nid">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success" onclick="parseForm2Data(event)">জমা দিন</button>
                    </div>
                </form>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const textarea2 = document.getElementById('form2Input');
                    if (textarea2) {
                        textarea2.addEventListener('focus', function() {
                            this.setSelectionRange(4, 4);
                        });
                    }
                });

                function parseForm2Data(event) {
                    event.preventDefault();

                    const textarea = document.getElementById('form2Input');
                    const lines = textarea.value.split('\n');

                    let name = '';
                    let nid = '';

                    lines.forEach(line => {
                        line = line.trim();
                        if (line.startsWith('নাম:')) {
                            name = line.replace('নাম:', '').trim();
                        } else if (line.startsWith('এনআইডি নম্বর:')) {
                            nid = line.replace('এনআইডি নম্বর:', '').trim();
                        }
                    });

                    document.getElementById('form2Name').value = name;
                    document.getElementById('form2Nid').value = nid;

                    event.target.closest('form').submit();
                }
            </script>

            <!-- Form 3: ইউজার আইডি পাস সেট -->
            <div id="form3" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">ইউজার আইডি পাস সেট</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.nid.order.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="3">

                    <div class="form-group mb-3">
            <textarea class="form-control" rows="5" id="form3Input" required>এনআইডি নম্বর:
জন্ম তারিখ:</textarea>
                        <input type="hidden" name="nid" id="form3Nid">
                        <input type="hidden" name="dob" id="form3Dob">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success" onclick="parseForm3Data(event)">জমা দিন</button>
                    </div>
                </form>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const textarea3 = document.getElementById('form3Input');
                    if (textarea3) {
                        textarea3.addEventListener('focus', function() {
                            this.setSelectionRange(13, 13);
                        });
                    }
                });

                function parseForm3Data(event) {
                    event.preventDefault();

                    const textarea = document.getElementById('form3Input');
                    const lines = textarea.value.split('\n');

                    let nid = '';
                    let dob = '';

                    lines.forEach(line => {
                        line = line.trim();
                        if (line.startsWith('এনআইডি নম্বর:')) {
                            nid = line.replace('এনআইডি নম্বর:', '').trim();
                        } else if (line.startsWith('জন্ম তারিখ:')) {
                            dob = line.replace('জন্ম তারিখ:', '').trim();
                        }
                    });

                    document.getElementById('form3Nid').value = nid;
                    document.getElementById('form3Dob').value = dob;

                    event.target.closest('form').submit();
                }
            </script>
            <!-- Form 4: হারানো ফরম উত্তোলন -->
            <div id="form4" class="form-container">
                <div class="modal-header">
                    <h5 class="modal-title">হারানো ফরম উত্তোলন</h5>
                    <button type="button" class="close-modal" onclick="hideForm()">&times;</button>
                </div>
                <form action="{{ route('user.nid.order.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="form_type" value="4">

                    <div class="form-group mb-3">
            <textarea class="form-control" rows="5" id="form4Input" required>আপনার আইডি:
পাসওয়ার্ড:</textarea>
                        <input type="hidden" name="email" id="form4Email">
                        <input type="hidden" name="password" id="form4Password">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="hideForm()">বাতিল</button>
                        <button type="submit" class="btn btn-success" onclick="parseForm4Data(event)">জমা দিন</button>
                    </div>
                </form>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const textarea4 = document.getElementById('form4Input');
                    if (textarea4) {
                        textarea4.addEventListener('focus', function() {
                            this.setSelectionRange(13, 13);
                        });
                    }
                });

                function parseForm4Data(event) {
                    event.preventDefault();

                    const textarea = document.getElementById('form4Input');
                    const lines = textarea.value.split('\n');

                    let email = '';
                    let password = '';

                    lines.forEach(line => {
                        line = line.trim();
                        if (line.startsWith('আপনার আইডি:')) {
                            email = line.replace('আপনার আইডি:', '').trim();
                        } else if (line.startsWith('পাসওয়ার্ড:')) {
                            password = line.replace('পাসওয়ার্ড:', '').trim();
                        }
                    });

                    document.getElementById('form4Email').value = email;
                    document.getElementById('form4Password').value = password;

                    event.target.closest('form').submit();
                }
            </script>

            <!-- Orders Table -->
            <div class="mt-4">
                <div class="mb-3" style="background: linear-gradient(90deg, #1e4c78 0%, #3498db 100%); color: white; padding: 10px 15px; border-radius: 4px;">
                    <h5 class="m-0 text-center">অর্ডার তালিকা</h5>
                </div>
                @if(isset($orders))
                    <div class="alert alert-info">
                        সর্বমোট অর্ডার: {{ $orders->count() }}
                    </div>
                @endif

                <!-- Desktop View -->
                <div class="classic-table d-none d-md-block">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                        <tr>
                            <th>ক্রমিক</th>
                            <th>অর্ডার ধরন</th>
                            <th>এনআইডি নম্বর</th>
                            <th>নাম</th>
                            <th>তারিখ</th>
                            <th>স্ট্যাটাস</th>
                            <th>ডাউনলোড</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $key => $order)
                            <tr>
                                <td>{{ $orders->count() - $key }}</td>
                                <td>{{ $order->getFormTypeTextAttribute() }}</td>
                                <td>{{ $order->nid ?? 'N/A' }}</td>
                                <td>{{ $order->name ?? 'N/A' }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($order->status == 0)
                                        <span class="text-warning fw-bold">⏳ পেন্ডিং</span>
                                    @elseif($order->status == 1)
                                        <span class="text-info fw-bold">✓ অনুমোদিত</span>
                                    @elseif($order->status == 2)
                                        <span class="text-success fw-bold">✔ সম্পন্ন</span>
                                    @else
                                        <span class="text-danger fw-bold">✕ বাতিল</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->status == 3)
                                        <div class="text-danger mb-0 mt-2 py-1 px-2" style="font-size: 0.8rem; width: 100%;">
                                            <strong style="font-size: 0.75rem;">বাতিলের কারণ:</strong><br>
                                            {{ $order->rejection_reason ?? 'কোনো কারণ নির্দিষ্ট নেই' }}
                                        </div>
                                    @elseif($order->admin_note)
                                        <a href="{{ route('admin.id-card-orders.download-pdf', $order->id) }}" class="btn btn-sm btn-success" download>
                                            <i class="fas fa-download"></i> ডাউনলোড
                                        </a>
                                    @elseif($order->status == 2 && !$order->admin_note && $order->text)
                                        <div class="text-info mb-0 mt-2 py-2 px-2" style="font-size: 0.85rem; width: 100%;">
                                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                                <div>
                                                    <strong style="font-size: 0.8rem;">অ্যাডমিনের নোট:</strong><br>
                                                    <span id="adminNote-{{ $order->id }}" style="word-break: break-word;">{{ $order->text }}</span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-info" style="margin-left: 8px; white-space: nowrap;" onclick="copyAdminNote('adminNote-{{ $order->id }}')">
                                                    <i class="fas fa-copy"></i> কপি
                                                </button>
                                            </div>
                                        </div>
                                    @elseif($order->status == 1 || $order->status == 2)
                                        <span class="text-muted fw-bold">শীঘ্রই আপলোড হবে</span>
                                    @else
                                        <span class="text-muted">নেই</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">কোন অর্ডার নেই</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View -->
                <div class="d-md-none">
                    @forelse($orders as $key => $order)
                        <div class="mobile-order-row">
                            <div class="row-number">{{ $orders->count() - $key }}</div>
                            <div class="row-content">
                                <div class="info-line">
                                    <span class="service-type">{{ $order->getFormTypeTextAttribute() }}</span>
                                </div>
                                <div class="info-line">
                                    @if($order->status == 0)
                                        <span class="text-warning fw-bold">⏳ পেন্ডিং</span>
                                    @elseif($order->status == 1)
                                        <span class="text-info fw-bold">✓ অনুমোদিত</span>
                                    @elseif($order->status == 2)
                                        <span class="text-success fw-bold">✔ সম্পন্ন</span>
                                    @else
                                        <span class="text-danger fw-bold">✕ বাতিল</span>
                                    @endif
                                    <span style="margin-left: 8px; font-size: 0.9rem;">{{ $order->created_at->format('d/m/Y') }}</span>
                                </div>
                                @if($order->status == 3)
                                    <div class="info-line">
                                        <div class="p-2 bg-light border-start border-3 border-danger rounded reason-box">
                                            <strong>কারণ:</strong>  {{ $order->rejection_reason ?? 'কোনো কারণ নির্দিষ্ট নেই' }}
                                        </div>
                                    </div>
                                @elseif($order->admin_note)
                                    <div class="info-line" style="margin-top: 8px;">
                                        <a href="{{ route('admin.id-card-orders.download-pdf', $order->id) }}" class="btn btn-sm btn-success" download style="width: 100%;">
                                            <i class="fas fa-download"></i> ডাউনলোড
                                        </a>
                                    </div>
                                @elseif($order->status == 2 && !$order->admin_note && $order->text)
                                    <div class="info-line" style="margin-top: 8px;">
                                        <span style="background: #dbeafe; color: #0c4a6e; padding: 8px 12px; border-radius: 4px; display: block; font-size: 0.9rem; text-align: left; width: 100%;">
                                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                                <div style="flex: 1;">
                                                    <strong>অ্যাডমিনের নোট:</strong><br>
                                                    <span id="adminNoteMobile-{{ $order->id }}" style="word-break: break-word;">{{ $order->text }}</span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-light" style="margin-left: 8px; white-space: nowrap;" onclick="copyAdminNote('adminNoteMobile-{{ $order->id }}')">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </span>
                                    </div>
                                @elseif($order->status == 1 || $order->status == 2)
                                    <div class="info-line" style="margin-top: 8px;">
                                        <span class="text-muted fw-bold" style="width: 100%; display: inline-block;">শীঘ্রই আপলোড হবে</span>
                                    </div>
                                @else
                                    <div class="info-line" style="margin-top: 8px;">
                                        <span class="text-muted">নেই</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-3">
                            কোন অর্ডার নেই
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection