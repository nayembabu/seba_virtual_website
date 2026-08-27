@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <center>
                <h3 class="text-info">Charge: {{ inum(get_settings()->land_fee) }}</h3>
            </center>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif
     
     
     
          <form action="" method="post" class="bn-layout">
              @csrf
              
              <h3 class="text-center"> উত্তরাধকিার সনদ তথ্য </h3>
              
                            <div class="row">
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">ক্রমিক নং:</label>
                                        <input class="form-control" type="text" name="sl_no" value="<?php echo $sl_no = str_pad(mt_rand(1,999999999999),12,'0',STR_PAD_LEFT); ?>" required>
                                    </div>
                                </div>
                               
                                    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bn-text">সিটি কর্পোরেশন / পৌর / ইউনিয়ন অফিসের নাম:</label>
                                        <input class="form-control" type="text" name="office_name" value="" required>
                                    </div>
                                </div>
                                    
                                

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bn-text">উপজেলা / থানা:</label>
                                        <input class="form-control bn-input" type="text" name="upazila_name" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">জেলা:</label>
                                        <input class="form-control bn-input" type="text" name="zila_name" required>
                                    </div>
                                </div>
                                <!--otheres info-->
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">নাম:</label>
                                        <input class="form-control bn-input" type="text" name="a_name" required>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">পিতা:</label>
                                        <input class="form-control bn-input" type="text" name="a_fathers" required>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">স্বামী/স্ত্রী:</label>
                                        <input class="form-control bn-input" type="text" name="a_wife_husband" required>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">গ্রাম:</label>
                                        <input class="form-control bn-input" type="text" name="a_village" required>
                                    </div>
                                </div>

                              
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bn-text">ইস্যু তারিখ (EN):</label>
                                                <input maxlength="10" class="form-control bn-input datetime" type="text" name="publish_date" placeholder="dd-mm-yyyy" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            <h3 class="text-center"> উত্তরাধীকারদের তথ্য </h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th class="bn-text">ক্রম</th>
                                                <th class="bn-text">নাম</th>
                                                <th class="bn-text">পিতা/স্বামীর নাম</th>
                                                <th class="bn-text">জন্ম/মৃত্যুর তারিখ</th>
                                                <th class="bn-text">NID/জন্ম/মৃত্যু সনদ নং</th>
                                                <th class="bn-text">সম্পর্ক</th>
                                                <th class="bn-text">মন্তব্য</th>
                                                <th class="bn-text">আরও</th>
                                            </tr>
                                            </thead>
                                            <tbody class="malik_wrapper">
                                            <tr>
                                                <td width="1%">
                                                    <div class="form-group">
                                                        <label class="bn-text mcromik">১</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder=" নাম" class="form-control bn-input" type="text" name="name[]" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="পিতা/স্বামীর নাম" class="form-control bn-input" type="text" name="father_name[]" >
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="জন্ম/মৃত্যুর তারিখ" class="form-control bn-input" type="text" name="b_d_date[]" >
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="NID/জন্ম/মৃত্যু সনদ নং" class="form-control bn-input" type="text" name="b_d_no[]" >
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="সম্পর্ক" class="form-control bn-input" type="text" name="relation[]" >
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="মন্তব্য" class="form-control bn-input" type="text" name="comment[]" >
                                                    </div>
                                                </td>
                                               
                                                
                                                <td width="1%">
                                                    <a href="javascript:void(0);" class="malik_plus malik_add_button btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-md-12">
                                
                                <button type="submit" class="btn btn-primary bn-text" name="submit" style="margin: 0 auto; display: block;"><i class="fa fa-check"></i> সাবমিট</button>
                                   
                            </div>
                        </form>

     
            
       
          
            
            
        </div>
    </div>
    
    
    
   
   
 
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            var maxField = 20; // Input fields increment limitation
            let thtml = '<tr><td width="1%"><div class="form-group"><label class="bn-text mcromik1">+</label></div></td><td><div class="form-group"><input placeholder=" নাম" class="form-control bn-input" type="text" name="name[]" required></div></td><td><div class="form-group"><input placeholder="পিতা/স্বামীর নাম" class="form-control bn-input" type="text" name="father_name[]" ></div></td><td><div class="form-group"><input placeholder="জন্ম/মৃত্যুর তারিখ" class="form-control bn-input" type="text" name="b_d_date[]" ></div></td><td><div class="form-group"><input placeholder="NID/জন্ম/মৃত্যু সনদ নং" class="form-control bn-input" type="text" name="b_d_no[]" ></div></td><td><div class="form-group"><input placeholder="সম্পর্ক" class="form-control bn-input" type="text" name="relation[]" ></div></td><td><div class="form-group"><input placeholder="মন্তব্য" class="form-control bn-input" type="text" name="comment[]" ></div></td><td width="1%"><a href="javascript:void(0);" class="malik_remove btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td></tr>';
            let l = 1;
            $('.malik_add_button').click(function () {
                if (l < maxField) {
                    l++;
                    $('.mcromik').html(l);
                    $('.malik_wrapper').append(thtml);
                } else {
                    alert('A maximum of ' + maxField + ' fields are allowed to be added. ');
                }
            });

            $('.malik_wrapper').on('click', '.malik_remove', function (e) {
                e.preventDefault();
                $(this).closest('tr').remove(); // Remove field html
                l--; // Decrease field counter
            });
        });
    </script>
@endpush