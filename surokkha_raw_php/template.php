@extends('layouts.app') {{-- Assuming a master layout, adjust if different --}}

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>Template Page Title</h3>
            </div>
            <div class="card-body">
                <!-- Your template content goes here -->
                <p>This is the content area for the Surokkha template.</p>
                <p>It should mimic the structure of create.php for consistency.</p>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Placeholder for any specific JavaScript for this template
        // Based on create.php, this section would contain dynamic form logic
        // For example, the show/hide logic for NID/Birth No. fields
        let val = $('input[type=radio][name=type]').val();
        if (val == 'One') {
                $('#nid_show').show();
                $('#bn_show').hide();
        } else if ( val == 'Two' ) {
                $('#nid_show').hide();
                $('#bn_show').show();
        } else {
                $('#nid_show').hide();
                $('#bn_show').hide();
        }
        
        
        $('input[type=radio][name=type]').change(function() {
            if (this.value == 'One') {
                $('#nid_show').show();
                $('#bn_show').hide();
            } else if ( this.value == 'Two' ) {
                $('#nid_show').hide();
                $('#bn_show').show();
            } else {
                $('#nid_show').hide();
                $('#bn_show').hide();
            }
            
        });
        
        function center(that) {
        if (that.value == "other") {
            alert("Please enter the vaccination Center Name");
            document.getElementById("ifYes").style.display = "block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
        }

        function vc1(that) {
        if (that.value == "other1") {
            alert("Please enter the vaccination Center Name");
            document.getElementById("ifYesv1").style.display = "block";
        } else {
            document.getElementById("ifYesv1").style.display = "none";
        }
        }

        function vc2(that) {
        if (that.value == "other2") {
            alert("Please enter the vaccine Name");
            document.getElementById("ifYesv2").style.display = "block";
        } else {
            document.getElementById("ifYesv2").style.display = "none";
        }
        }

        function vc3(that) {
        if (that.value == "other3") {
            alert("Please enter the vaccine Name");
            document.getElementById("ifYesv3").style.display = "block";
        } else {
            document.getElementById("ifYesv3").style.display = "none";
        }
        }
        $(document).on('change','body #photo',function(){
                let file = $(this)[0].files[0];
                let src = URL.createObjectURL(file);
                $('#img').attr('src',src);
        });
    </script>
@endpush
