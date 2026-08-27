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
     
     
     
     <form action="" method="post" enctype="multipart/form-data">
       @csrf
                        <div class="row">

                            <div class="col-md-9"> 

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="row">

                                            <div class="col-md-5">

                                                <div class="form-group">

                                                    <label class="control-label">Name Title:</label>

                                                    <select class="form-control" name="name_title" required>

                                                        <option value="">Select</option>

                                                        <option  value="Mr">Mr.</option>

                                                        <option  value="Mrs">Mrs.</option>

                                                        <option  value="Ms">Ms.</option>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-md-7">

                                                <div class="form-group">

                                                    <label class="control-label">Full Name:</label>

                                                    <input type="text" class="form-control" name="full_name" placeholder="Full Name" value="{{ $pdo->full_name }}" required oninput="this.value = this.value.toUpperCase();">

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <div class="form-group">

                                                    <label class="control-label">Father's Name:</label>

                                                    <input type="text" class="form-control" name="fathers_name" placeholder="Father's Name" value="{{ $pdo->fathers_name }}" required oninput="this.value = this.value.toUpperCase();">

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <div class="form-group">

                                                    <label class="control-label">Mother's Name:</label>

                                                    <input type="text" class="form-control" name="mothers_name" placeholder="Mother's Name" value="{{ $pdo->mothers_name }}" oninput="this.value = this.value.toUpperCase();">

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">NID No:</label>

                                                    <input type="text" class="form-control" name="nid_no" placeholder="N/A" value="{{ $pdo->nid_no }}" oninput="this.value = this.value.toUpperCase();" required>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">Passport No:</label>

                                                    <input type="text" class="form-control" name="passport_no" placeholder="N/A" value="{{ $pdo->passport_no }}" required oninput="this.value = this.value.toUpperCase();">

                                                </div>

                                            </div>

                                            

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="row">

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">Course Name:</label>

                                                    <input type="text" class="form-control" name="course_name" value="Pre-Departure Orientation">

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">Connected By:</label>

                                                    <select class="form-control basic-single" name="connected_by" required>

                                                        <option value="">-Type to Select Connect-</option>

                                                        <option  value="Bangladesh Institute of Marine Technology, Narayanganj">Bangladesh Institute of Marine Technology, Narayanganj</option>

                                                        <option  value="Bangladesh-German Technical Training Centre, Dhaka">Bangladesh-German Technical Training Centre, Dhaka</option>

                                                        <option  value="Bangladesh-Korea Technical Training Centre, Dhaka">Bangladesh-Korea Technical Training Centre, Dhaka</option>

                                                        <option  value="Bangladesh-Korea Technical Training Centre, Chittagong">Bangladesh-Korea Technical Training Centre, Chittagong</option>

                                                        <option  value="Sheikh Fazilatunnesa Mujib Mohila Technical Training Centre, Dhaka">Sheikh Fazilatunnesa Mujib Mohila Technical Training Centre, Dhaka</option>



                                                        <option  value="Institute of Marine Technology, Faridpur">Institute of Marine Technology, Faridpur</option>

                                                        <option  value="Institute of Marine Technology, Bagherhat">Institute of Marine Technology, Bagherhat</option>

                                                        <option  value="Institute of Marine Technology, Sirajganj">Institute of Marine Technology, Sirajganj</option>

                                                        <option  value="Institute of Marine Technology, Munshiganj">Institute of Marine Technology, Munshiganj</option>

                                                        <option  value="Institute of Marine Technology, Chandpur">Institute of Marine Technology, Chandpur</option>



                                                        <option  value="Rajshahi Mohila Technical Training Centre, Rajahahi">Rajshahi Mohila Technical Training Centre, Rajahahi</option>

                                                        <option  value="Khulna Mohila Technical Training Centre, Khulna">Khulna Mohila Technical Training Centre, Khulna</option>

                                                        <option  value="Sylhet Mohila Technical Training Centre, Sylhet">Sylhet Mohila Technical Training Centre, Sylhet</option>

                                                        <option  value="Chittagong Mohila Technical Training Centre, Chittagong">Chittagong Mohila Technical Training Centre, Chittagong</option>

                                                        <option  value="Barisal Mohila Technical Training Centre, Barisal">Barisal Mohila Technical Training Centre, Barisal</option>



                                                        <option  value="Technical Training Centre, Rajshahi">Technical Training Centre, Rajshahi</option>

                                                        <option  value="Technical Training Centre, Khulna">Technical Training Centre, Khulna</option>

                                                        <option  value="Technical Training Centre, Barisal">Technical Training Centre, Barisal</option>

                                                        <option  value="Technical Training Centre, Mymensingh">Technical Training Centre, Mymensingh</option>

                                                        <option  value="Technical Training Centre, Faridpur">Technical Training Centre, Faridpur</option>

                                                        <option  value="Technical Training Centre, Comilla">Technical Training Centre, Comilla</option>

                                                        <option  value="Technical Training Centre, Rangamati">Technical Training Centre, Rangamati</option>

                                                        <option  value="Technical Training Centre, Bogra">Technical Training Centre, Bogra</option>

                                                        <option  value="Technical Training Centre, Tangail">Technical Training Centre, Tangail</option>

                                                        <option  value="Technical Training Centre, Kushtia">Technical Training Centre, Kushtia</option>

                                                        <option  value="Technical Training Centre, Noakhali">Technical Training Centre, Noakhali</option>

                                                        <option  value="Technical Training Centre, Dinajpur">Technical Training Centre, Dinajpur</option>

                                                        <option  value="Technical Training Centre, Bandarban">Technical Training Centre, Bandarban</option>

                                                        <option  value="Technical Training Centre, Sylhet">Technical Training Centre, Sylhet</option>

                                                        <option  value="Technical Training Centre, Jessore">Technical Training Centre, Jessore</option>

                                                        <option  value="Technical Training Centre, Patuakhali">Technical Training Centre, Patuakhali</option>

                                                        <option  value="Technical Training Centre, Pabna">Technical Training Centre, Pabna</option>

                                                        <option  value="Technical Training Centre, Rangpur">Technical Training Centre, Rangpur</option>

                                                        <option  value="Technical Training Centre, Jamalpur">Technical Training Centre, Jamalpur</option>

                                                        <option  value="Technical Training Centre, Thakurgaon">Technical Training Centre, Thakurgaon</option>

                                                        <option  value="Technical Training Centre, Lalmonirhat">Technical Training Centre, Lalmonirhat</option>

                                                        <option  value="Technical Training Centre, Chapainawabganj">Technical Training Centre, Chapainawabganj</option>

                                                        <option  value="Technical Training Centre, Laxmipur">Technical Training Centre, Laxmipur</option>

                                                        <option  value="Technical Training Centre, Narshingdi">Technical Training Centre, Narshingdi</option>

                                                        <option  value="Technical Training Centre, Natore">Technical Training Centre, Natore</option>

                                                        <option  value="Technical Training Centre, Jhenaidah">Technical Training Centre, Jhenaidah</option>

                                                        <option  value="Technical Training Centre, Keraniganj">Technical Training Centre, Keraniganj</option>

                                                        <option  value="Technical Training Centre, Sherpur">Technical Training Centre, Sherpur</option>

                                                        <option  value="Technical Training Centre, Brahmanbaria">Technical Training Centre, Brahmanbaria</option>

                                                        <option  value="Technical Training Centre, Kurigram">Technical Training Centre, Kurigram</option>

                                                        <option  value="Technical Training Centre, Rajbari">Technical Training Centre, Rajbari</option>

                                                        <option  value="Technical Training Centre, Bhola">Technical Training Centre, Bhola</option>

                                                        <option  value="Technical Training Centre, Nilphamari">Technical Training Centre, Nilphamari</option>

                                                        <option  value="Technical Training Centre, Jhalokathi">Technical Training Centre, Jhalokathi</option>

                                                        <option  value="Technical Training Centre, Chuadanga">Technical Training Centre, Chuadanga</option>

                                                        <option  value="Technical Training Centre, Gopalganj">Technical Training Centre, Gopalganj</option>

                                                        <option  value="Technical Training Centre, Narail">Technical Training Centre, Narail</option>

                                                        <option  value="Technical Training Centre, Panchagarh">Technical Training Centre, Panchagarh</option>

                                                        <option  value="Technical Training Centre, Joypurhat">Technical Training Centre, Joypurhat</option>

                                                        <option  value="Technical Training Centre, Pirojpur">Technical Training Centre, Pirojpur</option>

                                                        <option  value="Technical Training Centre, Kishoreganj">Technical Training Centre, Kishoreganj</option>

                                                        <option  value="Technical Training Centre, Manikganj">Technical Training Centre, Manikganj</option>

                                                        <option  value="Technical Training Centre, Borguna">Technical Training Centre, Borguna</option>

                                                        <option  value="Technical Training Centre, Magura">Technical Training Centre, Magura</option>

                                                        <option  value="Technical Training Centre, Gaibandha">Technical Training Centre, Gaibandha</option>

                                                        <option  value="Technical Training Centre, Madaripur">Technical Training Centre, Madaripur</option>

                                                        <option  value="Technical Training Centre, Satkhira">Technical Training Centre, Satkhira</option>

                                                        <option  value="Technical Training Centre, Moulvibazar">Technical Training Centre, Moulvibazar</option>

                                                        <option  value="Technical Training Centre, Shariatpur">Technical Training Centre, Shariatpur</option>

                                                        <option  value="Technical Training Centre, Naogaon">Technical Training Centre, Naogaon</option>

                                                        <option  value="Technical Training Centre, Netrokona">Technical Training Centre, Netrokona</option>

                                                        <option  value="Technical Training Centre, Meherpur">Technical Training Centre, Meherpur</option>

                                                        <option  value="Technical Training Centre, Sunamganj">Technical Training Centre, Sunamganj</option>

                                                        <option  value="Technical Training Centre, Feni">Technical Training Centre, Feni</option>

                                                        <option  value="Technical Training Centre, Singair">Technical Training Centre, Singair</option>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">Destination Country:</label>

                                                    <input type="text" class="form-control" placeholder="Destination Country" name="destination_country" value="{{ $pdo->destination_country }}" required>

                                                </div>    

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">Certificate No/ASN:</label>

                                                    <input type="text" class="form-control" placeholder="Certificate No" name="certificate_no" value="{{ $pdo->certificate_no }}" required>

                                                </div>    

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">Batch No:</label>

                                                    <input type="text" class="form-control" placeholder="Batch No" name="batch_no" value="{{ $pdo->batch_no }}" required>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">Roll No:</label>

                                                    <input type="text" class="form-control" placeholder="Roll No" name="roll_no" value="{{ $pdo->roll_no }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">Course Date:</label>

                                                    <input type="text" class="form-control" placeholder="dd/mm/yyyy" name="course_date" value="{{ $pdo->course_date }}" maxlength="10" required>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label class="control-label">Issue Date:</label>

                                                    <input type="text" class="form-control" placeholder="dd/mm/yyyy" name="issue_date" value="{{ $pdo->issue_date }}" maxlength="10" required>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="col">

                                    <div class="form-group">
                                        
                                         <img id="img" src="{{ url('storage/uploads/'.$pdo->photo) }}" style="width:100px" /><br/>

                                        <label>Passport Size Photo:</label>
                                        <input type="file" id="photo" name="photo" accept=".png, .jpg,.jpeg">

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12">

                                <button type="submit" class="btn btn-info" value="Publish" name="publish" style="margin: 0 auto;display: block;margin-top: 25px;"><i class="fa fa-check"></i> Update Certificate</button>

                             
                            </div>

                        </div>

                    </form>
     
            
       
          
            
            
        </div>
    </div>
    
    
    
   
   

@endsection


@push('js')
     <script>
     
    $('select[name="name_title"]').val("{!! $pdo->name_title !!}");
    $('select[name="connected_by"]').val("{!! $pdo->connected_by !!}");
    
    $(document).on('change','body #photo',function(){
            let file = $(this)[0].files[0];
            let src = URL.createObjectURL(file);
            $('#img').attr('src',src);
    });
    
    </script>
@endpush