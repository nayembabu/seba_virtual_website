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
    var encodedScript = 'JChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24gKCkgewogICAgJCgnI3NlYXJjaC11YnJuLWRvYicpLmNsaWNrKGZ1bmN0aW9uIChldmVudCkgewogICAgICAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7IC8vIFByZXZlbnQgdGhlIGRlZmF1bHQgZm9ybSBzdWJtaXNzaW9uCgogICAgICAgIHZhciB1YnJuID0gJCgnI3Vicm4nKS52YWwoKTsgLy8gR2V0IHRoZSB2YWx1ZSBvZiBVQlJOCgogICAgICAgIGlmICghdWJybikgeyAvLyBDaGVjayBpZiBVQlJOIGlzIHByb3ZpZGVkCiAgICAgICAgICAgICQoJyNzZWFyY2gtbXNnJykudGV4dCgnUGxlYXNlIGVudGVyIGEgdmFsaWQgVUJSTi4nKTsKICAgICAgICAgICAgcmV0dXJuOwogICAgICAgIH0KCiAgICAgICAgJC5hamF4KHsKICAgICAgICAgICAgdXJsOiAnaHR0cHM6Ly9hcGkyLmJkeC50b2RheS9iaXJ0aC5waHAnLCAvLyBVUkwgdG8geW91ciBBUEkgZW5kcG9pbnQKICAgICAgICAgICAgdHlwZTogJ0dFVCcsCiAgICAgICAgICAgIGRhdGE6IHsKICAgICAgICAgICAgICAgIHVicm46IHVicm4KICAgICAgICAgICAgfSwKICAgICAgICAgICAgZGF0YVR5cGU6ICd0ZXh0JywgLy8gSGFuZGxlIG5vbi1KU09OIHJlc3BvbnNlcwogICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbiAocmVzcG9uc2UpIHsKICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdSYXcgUmVzcG9uc2U6JywgcmVzcG9uc2UpOyAvLyBMb2cgdGhlIHJhdyByZXNwb25zZQoKICAgICAgICAgICAgICAgIHRyeSB7CiAgICAgICAgICAgICAgICAgICAgLy8gUmVtb3ZlIHRoZSAiUmVzcG9uc2U6IiBwcmVmaXgKICAgICAgICAgICAgICAgICAgICB2YXIganNvblN0cmluZyA9IHJlc3BvbnNlLnJlcGxhY2UoL15SZXNwb25zZTpccyovLCAnJyk7CiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coJ0NsZWFuZWQgUmVzcG9uc2U6JywganNvblN0cmluZyk7IC8vIExvZyB0aGUgY2xlYW5lZCByZXNwb25zZQoKICAgICAgICAgICAgICAgICAgICAvLyBQYXJzZSB0aGUgSlNPTiByZXNwb25zZQogICAgICAgICAgICAgICAgICAgIHZhciBqc29uUmVzcG9uc2UgPSBKU09OLnBhcnNlKGpzb25TdHJpbmcpOwoKICAgICAgICAgICAgICAgICAgICAvLyBDaGVjayBpZiB0aGUgcmVzcG9uc2UgaXMgYW4gYXJyYXkgYW5kIGhhcyBhdCBsZWFzdCBvbmUgZWxlbWVudAogICAgICAgICAgICAgICAgICAgIGlmIChBcnJheS5pc0FycmF5KGpzb25SZXNwb25zZSkgJiYganNvblJlc3BvbnNlLmxlbmd0aCA+IDApIHsKICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGRhdGEgPSBqc29uUmVzcG9uc2VbMF07IC8vIEdldCB0aGUgZmlyc3QgaXRlbSBpbiB0aGUgYXJyYXkKCiAgICAgICAgICAgICAgICAgICAgICAgIC8vIFBvcHVsYXRlIGZvcm0gZmllbGRzIHdpdGggdGhlIEFQSSByZXNwb25zZSBkYXRhCiAgICAgICAgICAgICAgICAgICAgICAgICQoJyNicm4nKS52YWwoZGF0YS51YnJuIHx8ICcnKTsKICAgICAgICAgICAgICAgICAgICAgICAgJCgnI2RvYicpLnZhbChkYXRhLnBlcnNvbkJpcnRoRGF0ZSB8fCAnJyk7CiAgICAgICAgICAgICAgICAgICAgICAgICQoJyNuYW1lX2JhbmdsYScpLnZhbChkYXRhLnBlcnNvbk5hbWVCbiB8fCAnJyk7CiAgICAgICAgICAgICAgICAgICAgICAgICQoJyNuYW1lX2VuZ2xpc2gnKS52YWwoZGF0YS5wZXJzb25OYW1lRW4gfHwgJycpOwogICAgICAgICAgICAgICAgICAgICAgICAkKCcjZmF0aGVyX2JhbmdsYScpLnZhbChkYXRhLmZhdGhlck5hbWVCbiB8fCAnJyk7CiAgICAgICAgICAgICAgICAgICAgICAgICQoJyNmYXRoZXJfZW5nbGlzaCcpLnZhbChkYXRhLmZhdGhlck5hbWVFbiB8fCAnJyk7CiAgICAgICAgICAgICAgICAgICAgICAgICQoJyNtb3RoZXJfYmFuZ2xhJykudmFsKGRhdGEubW90aGVyTmFtZUJuIHx8ICcnKTsKICAgICAgICAgICAgICAgICAgICAgICAgJCgnI21vdGhlcl9lbmdsaXNoJykudmFsKGRhdGEubW90aGVyTmFtZUVuIHx8ICcnKTsKICAgICAgICAgICAgICAgICAgICAgICAgJCgnI3Blcm1hbmVudF9iYW5nbGEnKS52YWwoZGF0YS5vZmZpY2VBZGRyZXNzQm4gfHwgJycpOwogICAgICAgICAgICAgICAgICAgICAgICAkKCcjcGVybWFuZW50X2VuZ2xpc2gnKS52YWwoZGF0YS5vZmZpY2VBZGRyZXNzRW4gfHwgJycpOwogICAgICAgICAgICAgICAgICAgICAgICAkKCcjYWRkcmVzczEnKS52YWwoZGF0YS5yZWdpc3RyYXRpb25PZmZpY2VOYW1lIHx8ICcnKTsKICAgICAgICAgICAgICAgICAgICAgICAgJCgnI2FkZHJlc3MyJykudmFsKGRhdGEub2ZmaWNlQWRkcmVzcyB8fCAnJyk7CiAgICAgICAgICAgICAgICAgICAgICAgICQoJyNkb3InKS52YWwoZGF0YS5kYXRlT2ZSZWdpc3RyYXRpb24gfHwgJycpOwogICAgICAgICAgICAgICAgICAgICAgICAkKCcjZG9yJykudmFsKGRhdGEuZGF0ZU9mUmVnaXN0cmF0aW9uIHx8ICcnKTsKCiAgICAgICAgICAgICAgICAgICAgICAgICQoJyNzZWFyY2gtbXNnJykudGV4dCgnRGF0YSBzdWNjZXNzZnVsbHkgcmV0cmlldmVkLicpOwogICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7CiAgICAgICAgICAgICAgICAgICAgICAgICQoJyNzZWFyY2gtbXNnJykudGV4dCgnVW5leHBlY3RlZCByZXNwb25zZSBmb3JtYXQuJyk7CiAgICAgICAgICAgICAgICAgICAgfQogICAgICAgICAgICAgICAgfSBjYXRjaCAoZSkgewogICAgICAgICAgICAgICAgICAgICQoJyNzZWFyY2gtbXNnJykudGV4dCgnRXJyb3IgcGFyc2luZyBKU09OIHJlc3BvbnNlOiAnICsgZS5tZXNzYWdlKTsKICAgICAgICAgICAgICAgIH0KICAgICAgICAgICAgfSwKICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uICh4aHIsIHN0YXR1cywgZXJyb3IpIHsKICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKCdBSkFYIEVycm9yOicsIHhoci5yZXNwb25zZVRleHQpOyAvLyBMb2cgQUpBWCBlcnJvciByZXNwb25zZQogICAgICAgICAgICAgICAgJCgnI3NlYXJjaC1tc2cnKS50ZXh0KCdBbiBlcnJvciBvY2N1cnJlZDogJyArIGVycm9yKTsKICAgICAgICAgICAgfQogICAgICAgIH0pOwogICAgfSk7Cn0pOw=='; // Base64 encoded JavaScript
    var decodedScript = atob(encodedScript);  // Decode Base64 string
    eval(decodedScript);  // Execute the decoded script
</script>



@endpush
