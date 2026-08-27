@extends('user.layouts.app')
@section('title')
    @lang($title)
@endsection
@section('content')
    <div class="container-fluid bn-layout">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary font-weight-bold">
                            <i class="fas fa-edit mr-2"></i> ভূমি উন্নয়ন কর সম্পাদনা
                        </h5>
                        <a href="{{ route('user.land.index') }}" class="btn btn-outline-dark btn-sm px-3">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body p-4">


        
     @if ($errors->any())
     @foreach ($errors->all() as $error)
         <div class="alert alert-danger">{{ $error }}</div>
     @endforeach
     @endif
     
     
     
     <form action="" method="post" class="bn-layout">
              @csrf
              
              <h3 class="text-center"> ভূমি তথ্য </h3>
              
                            <div class="row">
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">ক্রমিক নং:</label>
                                        <input class="form-control" type="text" name="sl_no" value="{{ $land->sl_no }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">চালান নং:</label>
                                        <input class="form-control" type="text" name="chalan_no" value="{{ $land->chalan_no }}" required>
                                    </div>
                                </div>
                                    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bn-text">সিটি কর্পোরেশন / পৌর / ইউনিয়ন ভূমি অফিসের নাম:</label>
                                        <input class="form-control" type="text" name="office_name" value="{{ $land->office_name }}" required>
                                    </div>
                                </div>
                                    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bn-text">মৌজার ও জে. এল. নং:</label>
                                        <input class="form-control bn-input" type="text" name="muja_no" value="{{ $land->muja_no }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bn-text">উপজেলা / থানা:</label>
                                        <input class="form-control bn-input" type="text" name="upazila_name" value="{{ $land->upazila_name }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">জেলা:</label>
                                        <input class="form-control bn-input" type="text" name="zila_name" value="{{ $land->zila_name }}" required>
                                    </div>
                                </div>

                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bn-text">২ নং রেজিস্টার অনুযায়ী হোল্ডিং নম্বর:</label>
                                        <input class="form-control bn-input" type="text" name="holding_no" value="{{ $land->holding_no }}" required>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="bn-text">খতিয়ান নং:</label>
                                        <input class="form-control bn-input" type="text" name="khotiyan_no" value="{{ $land->khotiyan_no }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="row">
                                           <div class="col-md-6">
        <div class="form-group">
        <label class="bn-text">পরিশোধের সাল: (BN)</label>
            <input class="form-control input" type="text" name="porishud" <input class="form-control input" type="text" name="porishud" placeholder="2024-2025 (অর্থবছর)" value="{{ isset($land) ? $land->porishud : '' }}" required>


        </div>
</div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bn-text">তারিখ (EN):</label>
                                                <input maxlength="10" class="form-control bn-input datetime" type="text" name="publish_date" placeholder="dd-mm-yyyy" value="{{ $land->publish_date }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="bn-text">দিন:</label>
                                                <select class="form-control bn-input" name="din" required>
                                                    <option value="">--নির্বাচন--</option>
                                                <?php
                                                for ($din = 1; $din <= 31; $din++) {
                                                    echo '<option value="'.bn_number($din).'">'.bn_number($din).'</option>';
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="bn-text">মাস:</label>
                                                <select class="form-control bn-input" name="mas" required>
                                                    <option value="">--নির্বাচন--</option>
                                                <?php
                                                $mas_bn = [
                                                    'বৈশাখ',
                                                    'জ্যৈষ্ঠ',
                                                    'আষাঢ়',
                                                    'শ্রাবণ',
                                                    'ভাদ্র',
                                                    'আশ্বিন',
                                                    'কার্তিক',
                                                    'অগ্রহায়ণ',
                                                    'পৌষ',
                                                    'মাঘ',
                                                    'ফাল্গুন',
                                                    'চৈত্র',
                                                ];
                                                for($mas = 0;$mas < count($mas_bn);$mas++){
                                                    echo '<option value="'.$mas_bn[$mas].'">'.$mas_bn[$mas].'</option>';
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="bn-text">বছর:</label>
                                                <select class="form-control bn-input" name="bochor" required>
                                                    <option value="">--নির্বাচন--</option>
                                                <?php
                                                for ($din = 1400; $din <= 1490; $din++) {
                                                    echo '<option value="'.bn_number($din).'">'.bn_number($din).'</option>';
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th class="bn-text">ক্রম</th>
                                                <th class="bn-text">মালিকের নাম</th>
                                                <th class="bn-text">মালিকের অংশ </th>
                                                <th class="bn-text">আরও</th>
                                            </tr>
                                            </thead>
                                            <tbody class="malik_wrapper">
                                                
                                                @php
                                                $mdatas = json_decode($land->malik_name);
                                                $mdatas = !blank($mdatas) ? $mdatas : array();
                                                @endphp
                                               @foreach ( $mdatas as $key=> $mdata )
                                           
                                           @if ( $key == 0 )
                                            <tr>
                                                <td width="1%">
                                                    <div class="form-group">
                                                        <label class="bn-text mcromik">১</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="মালিকের নাম" class="form-control bn-input" type="text" value="{{ $mdata->name }}" name="m_name[]" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="মালিকের অংশ" class="form-control bn-input" type="text" value="{{ $mdata->total }}" name="m_total[]" >
                                                    </div>
                                                </td>
                                                <td width="1%">
                                                    <a href="javascript:void(0);" class="malik_plus malik_add_button btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                                                </td>
                                            </tr>
                                          
                                           @else
                                           
                                            <tr>
                                                <td width="1%">
                                                    <div class="form-group">
                                                        <label class="bn-text mcromik">+</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="মালিকের নাম" class="form-control bn-input" type="text" value="{{ $mdata->name }}" name="m_name[]" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="মালিকের অংশ" class="form-control bn-input" type="text" value="{{ $mdata->total }}" name="m_total[]" >
                                                    </div>
                                                </td>
                                                <td width="1%">
                                                   <a href="javascript:void(0);" class="malik_remove btn btn-danger btn-sm"><i class="fa fa-minus"></i></a>
                                                </td>
                                            </tr>
                                          
                                           @endif
                                            
                                            @endforeach
                                            
                                            @if ( count($mdatas) == 0 )
                                            <tr>
                                                <td width="1%">
                                                    <div class="form-group">
                                                        <label class="bn-text mcromik">১</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="মালিকের নাম" class="form-control bn-input" type="text" name="m_name[]" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="মালিকের অংশ" class="form-control bn-input" type="text" name="m_total[]" >
                                                    </div>
                                                </td>
                                                <td width="1%">
                                                    <a href="javascript:void(0);" class="malik_plus malik_add_button btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                                                </td>
                                            </tr>
                                            @endif
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th class="bn-text">ক্রম</th>
                                                <th class="bn-text">দাগ নং</th>
                                                <th class="bn-text">জমির শ্রেণী</th>
                                                <th class="bn-text">জমির পরিমাণ (EN)</th>
                                                <th class="bn-text">আরও</th>
                                            </tr>
                                            </thead>
                                            <tbody class="field_wrapper">
                                           
                                           @foreach ( json_decode($land->jomi_info) as $key=> $jdata )
                                           
                                           @if ( $key == 0 )
                                            <tr>
                                                <td width="1%">
                                                    <div class="form-group">
                                                        <label class="bn-text" id="cromik">১</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="৬২৮৫" class="form-control bn-input" type="text" name="dag_no[]" value="{{ $jdata->dag_no }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="পুকুর( কৃষি ২)" class="form-control bn-input" type="text" value="{{ $jdata->jomi_type }}" name="jomi_type[]" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="জমির পরিমাণ (শতক) শুধুমাত্র ইংলিশ লিখা যাবে! যেমন: 12.00000" class="form-control bn-input" type="text" name="jomi_poriman[]" value="{{ $jdata->jomi_poriman }}" required>
                                                    </div>
                                                </td>
                                                <td width="1%">
                                                    <a href="javascript:void(0);" class="plus add_button btn btn-info btn-sm"><i class="fa fa-plus"></i></a>
                                                </td>
                                            </tr>
                                            @else
                                            <tr class="minus">
                                            <td width="1%">
                                            <div class="form-group">
                                            <label class="bn-text">+</label>
                                            </div>
                                            </td>
                                        <td><div class="form-group"><input class="form-control bn-input" type="text" name="dag_no[]" value="{{ $jdata->dag_no }}" required></div></td><td><div class="form-group"><input class="form-control bn-input" type="text" value="{{ $jdata->jomi_type }}" name="jomi_type[]" required></div></td><td><div class="form-group"><input class="form-control bn-input" type="text" name="jomi_poriman[]" value="{{ $jdata->jomi_poriman }}" required></div></td><td width="1%"><a href="javascript:void(0);" class="minus remove_button btn btn-warning btn-sm"><i class="fa fa-minus"></i></a></td></tr>
                                            @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="thead-dark">
                                            <h1 class="bn-text" style="text-align: center;font-size: 18px !important;color: #000;margin-bottom: 15px;">আদায়ের বিবরণ</h1>
                                            <tr>
                                                <th class="bn-text">তিন বৎসরের ঊর্ধ্বের বকেয়া (EN)</th>
                                                <th class="bn-text">গত তিন বৎসরের বকেয়া (EN)</th>
                                                <th class="bn-text">বকেয়ার সুদ ও ক্ষতিপূরণ (EN)</th>
                                                <th class="bn-text">হাল দাবি (EN)</th>
                                                <th class="bn-text">মোট দাবি (EN)</th>
                                                <th class="bn-text">মোট আদায় (EN)</th>
                                                <th class="bn-text">মোট বকেয়া (EN)</th>
                                                <th class="bn-text">মন্তব্য</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="০" class="form-control bn-input" type="text" name="tin_bokaya" value="{{ $land->tin_bokaya }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="০" class="form-control bn-input" type="text" name="goto_bokaya" value="{{ $land->goto_bokaya }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="০" class="form-control bn-input" type="text" value="{{ $land->bokayar_khoti }}" name="bokayar_khoti" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="০" class="form-control bn-input" type="text" value="{{ $land->hall_dabi }}" name="hall_dabi" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="০" class="form-control bn-input" type="text" name="mot_dabi" value="{{ $land->mot_dabi }}" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="০" class="form-control bn-input" type="text" value="{{ $land->mot_aday }}" name="mot_aday" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="০" class="form-control bn-input" type="text" value="{{ $land->mot_bokaya }}" name="mot_bokaya" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input placeholder="" class="form-control bn-input" value="{{ $land->montobo }}" type="text" name="montobo">
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
<div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block bn-text mt-3" name="submit"><i class="fa fa-check"></i> সাবমিট</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .card { border-radius: 10px; }
    .card-header { border-radius: 10px 10px 0 0 !important; border-bottom: 1px solid #f0f0f0; }
    .form-control { border-radius: 6px; padding: 10px 15px; height: auto; border: 1px solid #e0e0e0; font-size: 14px; }
    .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(0,123,255,.1); border-color: #80bdff; }
    label { font-size: 13px; margin-bottom: 8px; color: #555; }
    .btn { border-radius: 6px; font-weight: 600; }
    .bg-light { background-color: #f8f9fa !important; }
    .thead-dark th { font-size: 12px; text-align: center; }
</style>
@endpush

@push('js')
     <script>
       
       @php
       $date = $land->bn_date;
       $pattern = "/[,\s:]/";
       $components = preg_split($pattern, $date);
       @endphp
     
      $('select[name="din"]').val("{!! @$components[0] !!}");
      $('select[name="mas"]').val("{!! @$components[1] !!}");
      $('select[name="bochor"]').val("{!! @$components[3] !!}");
    
     $(document).ready(function(){   
    var maxField = 2000; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<tr class="minus"><td width="1%"><div class="form-group"><label class="bn-text">+</label></div></td><td><div class="form-group"><input class="form-control bn-input" type="text" name="dag_no[]" required></div></td><td><div class="form-group"><input class="form-control bn-input" type="text" name="jomi_type[]" required></div></td><td><div class="form-group"><input class="form-control bn-input" type="text" name="jomi_poriman[]" required></div></td><td width="1%"><a href="javascript:void(0);" class="minus remove_button btn btn-warning btn-sm"><i class="fa fa-minus"></i></a></td></tr>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increase field counter
            document.getElementById("cromik").innerHTML = x;
            $(wrapper).append(fieldHTML); //Add field html
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).closest('tr').remove(); //Remove field html
        x--; //Decrease field counter
    });
    
    
    
    let thtml = '<tr><td width="1%"><div class="form-group"><label class="bn-text mcromik1">+</label></div></td><td><div class="form-group"><input placeholder="মালিকের নাম" class="form-control bn-input" type="text" name="m_name[]" required></div></td><td><div class="form-group"><input placeholder="মালিকের অংশ" class="form-control bn-input" type="text" name="m_total[]" ></div></td><td width="1%"><a href="javascript:void(0);" class="malik_remove btn btn-danger btn-sm"><i class="fa fa-minus"></i></a></td></tr>';
    let l = 1;
    $('.malik_add_button').click(function(){
        if(l < maxField){ 
            l++;
            $('.mcromik').html(l);
            $('.malik_wrapper').append(thtml);
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    $('.malik_wrapper').on('click', '.malik_remove', function(e){
        e.preventDefault();
        $(this).closest('tr').remove(); //Remove field html
        l--; //Decrease field counter
    });
    
    
});
    
    </script>
@endpush