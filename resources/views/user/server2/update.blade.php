@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
   
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">




        
     @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger">{{ $error }}</div>
     @endforeach
     @endif
     
     
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
                                                <input type="text" name="dor" id="dor" class="form-control" placeholder="Ex : 13/12/2023"/>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Date of Issuance</label>
                                                <input type="text" name="doi" id="doi" class="form-control" value="13/12/2023"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="first">Date of Birth</label>
                                                <input type="text" name="dob" id="dob" class="form-control" placeholder="13/12/2023"/>
                                            </div>
                                        </div>

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
             
               
               
                
                
                </div>
            </div>
        </div>
    </div>
</div>







@endsection

@push('js')
    <script>
        $(document).ready(function (e) {
            "use strict";
    
    function formatDate(dateStr) {
        var parts = dateStr.split('-'); // Split the date into parts
        return parts[2] + '/' + parts[1] + '/' + parts[0]; // Rearrange the parts
    }
    function populateFormFields(jsonData) {
                $('#bn_dob_number').val(jsonData.ubrn);
                $("#dob").val(formatDate(jsonData.dob));
                $("#brn").val(jsonData.ubrn);
                $("#sex").val(jsonData.gender);

                $("#name_bangla").val(jsonData.personname);
                $("#name_english").val(jsonData.personnameEn);

                $("#mother_bangla").val(jsonData.mothername);
                $("#mother_english").val(jsonData.mothernameEn);
                $("#mother_n_bangla").val(jsonData.motherNationality);
                $("#mother_n_english").val(jsonData.motherNationalityEn);

                $("#father_bangla").val(jsonData.fathername);
                $("#father_english").val(jsonData.fathernameEn);
                $("#father_n_bangla").val(jsonData.fatherNationality);
                $("#father_n_english").val(jsonData.fatherNationalityEn);
                $("#pob_bangla").val(jsonData.placeofbirth);
                $("#pob_english").val(jsonData.placeofbirthEn);
                if (jsonData.sex == 'F'){
                    $('#sex').val('Female');
                }  else {
                    $('#sex').val('Male');
                }
        }
        
        
                $('#nid-btn').click(function () {
                    let nid = $('#nid-n').val();
                    let dob = $('#nid-d').val();

                    if (nid == '' || dob == '') {
                        alert('Please enter birth reg no and dob');
                        return false;
                    }

                    $('#nid-msg').html('<div class="alert alert-info">Please wait a few moments...</div>');
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('user.new-birth-api') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'ubrn': nid,
                            'dob': dob
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data.success) {
                                $('#nid-msg').html('<div class="alert alert-success">Data fetched successfully.</div>');
                                populateFormFields(data);
                            } else {
                                $('#nid-msg').html('<div class="alert alert-danger">'+data.msg+'.</div>');
                            }
                        },
                        error: function () {
                            $('#nid-msg').html('<div class="alert alert-danger">An error occurred while fetching data. Please try again later.</div>');
                        }
                    });
                });
                
                
                
        });
    </script>
@endpush
