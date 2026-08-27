@extends('user.layouts.app')

@section('title')
   New Birth Certificate
@endsection


@section('content')
<style>
  
</style>

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                   
                      
                      
              <center>
                  <h3 class="text-info"> 
                  Charge : {{ inum(get_settings()->new_birth_fee) }}
                  </h3>
              
              </center>
              
              
                                
                                          
           
           
            @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger">{{ $error }}</div>
     @endforeach
     @endif
                 
                 <h3 style="text-align: center; border: 1px solid darkblue; padding: 18px 5px; font-size: 22px; min-width: 285px; margin: 5px; margin-bottom: 32px; border-radius: 10px; background: darkblue; color: #fff;">
                     সঠিক তথ্য সাবমিট করুন পিডিএফ ডাউনলোড করার জন্য
                    </h3>
                   
                                    
                                    
               <!-- Form for searching UBRN and DOB -->
                    <div class="form-group">
                        <label for="ubrn">UBRN</label>
                        <input type="text" id="ubrn" class="form-control" placeholder="Enter UBRN">
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="text" id="dob" class="form-control" placeholder="Enter Date of Birth (dd/mm/yyyy)">
                    </div>
                    <button id="search-ubrn-dob" class="btn btn-primary">Search</button>
                    <div id="search-msg"></div>

                    <form action="" method="post">
                        @csrf
                        <div id="formdata">

                                    <div class="row mt-5">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Address 1</label>
                                                <input type="text" name="address1" id="address1" class="form-control" placeholder="Address 1" value="" />
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Address 2</label>
                                                <input type="text" name="address2" id="address2" class="form-control" placeholder="Address 2" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="form-group">
                                                <label for="first">Birth Registration Number</label>
                                                <input type="text" name="brn" id="brn" class="form-control" placeholder="Ex : 20005467654345678"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
    <div class="col-md-6 mb-4">
        <div class="form-group">
            <label for="first">Date of Registration</label>
            <input type="text" name="dor" id="dor" class="form-control" placeholder="Ex : 13/12/2023" pattern="\d{2}/\d{2}/\d{4}" required/>
            <div class="invalid-feedback">
                Please enter the date in the format dd/mm/yyyy.
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="form-group">
            <label for="first">Date of Issuance</label>
            <input type="text" name="doi" id="doi" class="form-control" value="13/12/2023" pattern="\d{2}/\d{2}/\d{4}" required/>
            <div class="invalid-feedback">
                Please enter the date in the format dd/mm/yyyy.
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="form-group">
            <label for="first">Date of Birth</label>
            <input type="text" name="dob" id="dob" class="form-control" placeholder="13/12/2023" pattern="\d{2}/\d{2}/\d{4}" required/>
            <div class="invalid-feedback">
                Please enter the date in the format dd/mm/yyyy.
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInputs = ['dor', 'doi', 'dob'];

    dateInputs.forEach(function(inputId) {
        const inputElement = document.getElementById(inputId);

        inputElement.addEventListener('input', function () {
            const pattern = /^\d{2}\/\d{2}\/\d{4}$/;
            if (!pattern.test(inputElement.value)) {
                inputElement.setCustomValidity('Invalid date format. Please use dd/mm/yyyy.');
                inputElement.classList.add('is-invalid');
            } else {
                inputElement.setCustomValidity('');
                inputElement.classList.remove('is-invalid');
            }
        });
    });
});
</script>


                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Sex</label>
                                                <select name="sex" id="sex" class="form-control">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">নাম(বাংলা)</label>
                                                <input type="text" name="name_bangla" id="name_bangla" class="form-control" placeholder="নাম লেখুন..."/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Name(English)</label>
                                                <input type="text" name="name_english" id="name_english" class="form-control" placeholder="Inter your name..."/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">পিতা নাম(বাংলা)</label>
                                                <input type="text" name="father_bangla" id="father_bangla" class="form-control" placeholder="পিতা নাম লেখুন..."/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Father Name(English)</label>
                                                <input type="text" name="father_english" id="father_english" class="form-control" placeholder="Inter your father name..."/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">মাতার নাম(বাংলা)</label>
                                                <input type="text" name="mother_bangla" id="mother_bangla" class="form-control" placeholder="মাতার নাম লেখুন..."/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Mother Name(English)</label>
                                                <input type="text" name="mother_english" id="mother_english" class="form-control" placeholder="Inter your mother name..."/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">জন্মস্থান(বাংলা)</label>
                                                <input type="text" name="pob_bangla" id="pob_bangla" class="form-control" value="" placeholder="জন্মস্থান লেখুন..."/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Place of Birth(English)</label>
                                                <input type="text" name="pob_english" id="pob_english" class="form-control" value="" placeholder="Inter your place of birth..."/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">স্থায়ী ঠিকানা(বাংলা)</label>
                                                <textarea name="permanent_bangla" id="permanent_bangla" cols="30" rows="2" class="form-control" placeholder="স্থায়ী ঠিকানা লেখুন..."></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Permanent(English)</label>
                                                <textarea name="permanent_english" id="permanent_english" cols="30" rows="2" class="form-control" placeholder="Inter your permanent..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">পিতার জাতীয়তা(বাংলা)</label>
                                                <input type="text" name="father_n_bangla" id="father_n_bangla" class="form-control" value="বাংলাদেশ" placeholder="পিতার জাতীয়তা লেখুন..."/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Father Nationality(English)</label>
                                                <input type="text" name="father_n_english" id="father_n_english" class="form-control" value="Bangladesh" placeholder="Inter your father nationality..."/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">মাতার জাতীয়তা(বাংলা)</label>
                                                <input type="text" name="mother_n_bangla" id="mother_n_bangla" class="form-control" value="বাংলাদেশ" placeholder="মাতার জাতীয়তা লেখুন..."/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Mother Nationality(English)</label>
                                                <input type="text" name="mother_n_english" id="mother_n_english" class="form-control" value="Bangladesh" placeholder="Inter your mother nationality..."/>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="display: flex; justify-content: center; margin-bottom: 50px;">
                                        
                                        <button class="btn btn-primary" id="next_page" type="submit">
                                             ডাউনলোড  পিডিএফ          
                                        </button>
                                                                              </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
      </form>
             
               
               
                
                
     



@endsection

@push('js')
<script>
$(document).ready(function () {
    $('#search-ubrn-dob').click(function (event) {
        event.preventDefault(); // Prevent the default form submission

        var ubrn = $('#ubrn').val();
        var dob = $('#dob').val();

        if (!ubrn || !dob) {
            $('#search-msg').text('Please enter both UBRN and Date of Birth.');
            return;
        }

        $.ajax({
            url: 'https://bd1.xyz/birth.php', // URL to your API endpoint
            type: 'GET',
            data: {
                ubrn: ubrn,
                dob: dob
            },
            dataType: 'text', // Handle non-JSON responses
            success: function (response) {
                console.log('Raw Response:', response); // Log the raw response

                try {
                    // Remove the "Response:" prefix
                    var jsonString = response.replace(/^Response:\s*/, '');
                    console.log('Cleaned Response:', jsonString); // Log the cleaned response

                    // Parse the JSON response
                    var jsonResponse = JSON.parse(jsonString);

                    // Check if the response is an array and has at least one element
                    if (Array.isArray(jsonResponse) && jsonResponse.length > 0) {
                        var data = jsonResponse[0]; // Get the first item in the array

                        // Populate form fields with the API response data
                        $('#brn').val(data.ubrn || '');
                        $('#dob').val(data.personDob || '');
                        $('#name_bangla').val(data.personNameBn || '');
                        $('#name_english').val(data.personNameEn || '');
                        $('#father_bangla').val(data.fatherNameBn || '');
                        $('#father_english').val(data.fatherNameEn || '');
                        $('#mother_bangla').val(data.motherNameBn || '');
                        $('#mother_english').val(data.motherNameEn || '');
                        $('#permanent_bangla').val(data.officeAddressBn || '');
                        $('#permanent_english').val(data.officeAddressEn || '');
                        $('#address1').val(data.officeAddressEn || '');
                        $('#address2').val(data.registrationOfficeNameEn || '');

                        $('#search-msg').text('Data successfully retrieved.');
                    } else {
                        $('#search-msg').text('Unexpected response format.');
                    }
                } catch (e) {
                    $('#search-msg').text('Error parsing JSON response: ' + e.message);
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', xhr.responseText); // Log AJAX error response
                $('#search-msg').text('An error occurred: ' + error);
            }
        });
    });
});

</script>
@endpush
