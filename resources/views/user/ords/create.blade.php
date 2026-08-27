@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
   
    
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">


 <center>
                  <h3 class="text-info"> 
                  Charge : {{ inum(get_settings()->police_fee) }}
                  </h3>
                
              </center>


        
     @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger">{{ $error }}</div>
     @endforeach
     @endif
     
     
     
      <form action="" method="post" enctype="multipart/form-data">
          @csrf

                            <div class="row">


                                <div class="col-md-10">


                                    <div class="row">


                                        <div class="col-md-12">


                                            <h3>General Details</h3>


                                            <hr>


                                            <div class="form-group">


                                                <label class="control-label">Ref No:</label>


                                                <input type="text" class="form-control" name="police_reg"


                                                    value="12{{ strtoupper(generateRandomString(5)) }}"


                                                    required>


                                            </div>


                                        </div>


                                    </div>


                                    <div class="row">


                                        <div class="col-md-2">


                                            <div class="form-group">


                                                <label>Designation:</label>


                                                <select class="form-control" name="designation" required>


                                                    <option value="">(Select)</option>


                                                    <option 

                                                        value="Mr.">


                                                        Mr.</option>


                                                    <option 

                                                        value="Ms.">


                                                        Ms.</option>


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <label class="control-label">Applicant's Name:</label>


                                                <input type="text" class="form-control" name="applicant_name"


                                                    value=""


                                                    required>


                                            </div>


                                        </div>


                                        <div class="col-md-2">


                                            <div class="form-group">


                                                <label>What of:</label>


                                                <select class="form-control" name="what_of" required>


                                                    <option value="">(Select)</option>


                                                    <option 

                                                        value="son">


                                                        Son</option>


                                                    <option 

                                                        value="daughter">


                                                        Daughter</option>


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-4">


                                            <div class="form-group">


                                                <label class="control-label">Father's Name:</label>


                                                <input type="text" class="form-control" name="father_name"


                                                    value="">


                                            </div>


                                        </div>


                                    </div>


                                    <div class="row">


                                        <div class="col-md-3">


                                            <div class="form-group">


                                                <label class="control-label">Village Area</label>


                                                <input type="text" class="form-control" name="village_area"


                                                    value=""


                                                    required>


                                            </div>


                                        </div>


                                        <div class="col-md-3">


                                            <div class="form-group">


                                                <label class="control-label">Post Office</label>


                                                <input type="text" class="form-control" name="post_office"


                                                    value=""


                                                    required>


                                            </div>


                                        </div>


                                        <div class="col-md-3">


                                            <div class="form-group">


                                                <label class="control-label">Police Station:</label>


                                                <input type="text" class="form-control" name="police_station"


                                                    value=""


                                                    required>


                                            </div>


                                        </div>


                                        <div class="col-md-3">


                                            <div class="form-group">


                                                <label class="control-label">District:</label>


                                                <input type="text" class="form-control" name="district"


                                                    value="" required>


                                            </div>


                                        </div>


                                    </div>


                                    <div class="row">


                                        <div class="col-md-12">


                                            <h3>Passport Details</h3>


                                            <hr>


                                        </div>


                                        <div class="col-md-3">


                                            <div class="form-group">


                                                <label>Document Type:</label>


                                                <select class="form-control" name="document_type" required>


                                                    <option value="">(Select)</option>


                                                    <option


                                                        

                                                        value="Passport">


                                                        Passport</option>


                                                    <option 

                                                        value="NID">


                                                        NID</option>


                                                </select>


                                            </div>


                                        </div>


                                        <div class="col-md-3">


                                            <div class="form-group">


                                                <label class="control-label">Passport No/NID No:</label>


                                                <input type="text" class="form-control" name="passport_no"


                                                    value="">


                                            </div>


                                        </div>


                                        <div class="col-md-3">


                                            <div class="form-group">


                                                <label class="control-label">Issued at:</label>


                                                <input type="text" class="form-control" name="issued_location"


                                                    value="">


                                            </div>


                                        </div>


                                        <div class="col-md-3">


                                            <div class="form-group">


                                                <label class="control-label">Issued Date:</label>


                                                <input type="date" required class="form-control date" name="issued_date"


                                                    value="">


                                            </div>


                                        </div>


                                    </div>


                                </div>


                                <div class="col-md-2">


                                    <div class="row">


                                        <div class="col">


                                            <h3>Publish</h3>


                                            <hr>


                                            <div class="form-group">


                                                <label class="control-label">Certificate Date:</label>


                                                <input type="date" required class="form-control date"


                                                    name="certificate_date"


                                                    value="">


                                            </div>


                                            <div class="form-group">


                                                <label>Status:</label>


                                                <select class="form-control" name="status" required>


                                                    <option value="">Select</option>


                                                    <option  value="1">


                                                        Active</option>


                                                    <option  value="0">


                                                        Inactive</option>


                                                </select>


                                            </div>


                                        </div>


                                    </div>


                                    <div class="row">


                                        <button type="submit" class="btn btn-primary" value="Publish" name="publish"
                                            style="margin: 0 auto; display: block;"><i class="fa fa-check"></i> Publish


                                            Certificate</button>


                                        <input type="hidden" name="user_token" value="1756">


                                    </div>


                                </div>


                            </div>


                        </form>

     
            
       
          
            
            
        </div>
    </div>
    
    
    
   
   

@endsection


@push('js')
     <script>
    $(document).on('change','body #photo',function(){
            let file = $(this)[0].files[0];
            let src = URL.createObjectURL(file);
            $('#img').attr('src',src);
    });
    
    </script>
@endpush