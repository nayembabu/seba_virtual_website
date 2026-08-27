$('button.btn.btn-success.mt-5').click(function(){
    $('#my_nid_card').css('display', 'block');
    $.ajax({
        'url' : "nid-sign.php/",
        'method' : 'POST',
        "data" : {
            'data' : $('#nid_data').html()
        },
        success:function(data){
            console.log(data);
           $('#pdf_show').html('<iframe src="'+urls.pdf_src+'" style="height:100%; width:100%"></iframe>');
        }
    })
});

// =================
$('#scrollAfterUpload').click(function(){
    $('.my_file').click();
});

$('.my_file').change(function(e){
    
     $('#nid-s-msg').html('<div class="alert alert-info">Please wait a few moments...</div>');
     
    // $('.hidden_wrapper').css('display', 'block');
    $('#hidden_nid_profile').val('');
    $('#profile_url').attr('src', '');

    $('#hidden_nid_sign').val('');
    $('#sign_url').attr('src', '');
    
    $('#nameBangla').val('');
    $('#nameEnglish').val('');
    $('#nid').val('');
    $('#pin').val('');
    $('#nameFather').val('');
    $('#nameMother').val('');
    $('#birthPlace').val('');
    $('#dob').val('');
    $('#bloodGroup').val('');
            
    let form = document.getElementById('myForm');
    const form_data = new FormData(form);
    $.ajax({
        'url' : "http://api.priyoshop.xyz/pdftoText",
        "method" : "POST",
        processData:false,
        contentType:false,
        "data" : form_data,
        success:function(data){
            // console.log(data);
            // $('.hidden_wrapper').css('display', 'none');

            $('#hidden_nid_profile').val(data.profile);
            $('#profile_url').attr('src', data.profile);

            $('#hidden_nid_sign').val(data.sign);
            $('#sign_url').attr('src', data.sign);
            
            $('#nameBangla').val(data.bn_name);
            $('#nameEnglish').val(data.en_name);
            $('#nid').val(data.nid_number);
            $('#pin').val(data.nid_pin);
            $('#nameFather').val(data.father_n);
            $('#nameMother').val(data.mother_n);
            $('#birthPlace').val(data.date_of_place);
            $('#dob').val(data.date_of_birth);
            $('#bloodGroup').val(data.blood_group);
            
            $('#fulladdress').html(`বাসা/হোল্ডিং: ${data.home_holding_no.replace(/\s+/g, ' ').trim()}, গ্রাম/রাস্তা: ${data.aditional_village_road == data.aditional_mouza_moholla ? data.aditional_village_road.replace(/\s+/g, ' ').trim() : data.aditional_village_road.replace(/\s+/g, ' ').trim()+", "+data.aditional_mouza_moholla.replace(/\s+/g, ' ').trim()}, ডাকঘর: ${data.post_office} - ${data.post_code}, ${data.upzila.replace(/\s+/g, ' ').trim()}, ${data.city_corporation == "" ? '' : data.city_corporation.replace(/\s+/g, ' ').trim()+", "}${data.district.replace(/\s+/g, ' ').trim()}`);
            $('#nid-s-msg').html('<div class="alert alert-success">Data fetched successfully.</div>');
        }
    })
});

// profile 
const imageInput = document.getElementById('profile');

imageInput.addEventListener('change', function() {
  const file = this.files[0];   

  if (file) {
    const reader = new FileReader();

    reader.addEventListener('load', function() {
       $('#hidden_nid_profile').attr('value', this.result);
       $('#profile_url').attr('src', this.result);
    });

    reader.readAsDataURL(file);
  }
});

// sign 
const imageInput_sign = document.getElementById('sign');

imageInput_sign.addEventListener('change', function() {
  const file = this.files[0];   

  if (file) {
    const reader = new FileReader();

    reader.addEventListener('load', function() {
       $('#hidden_nid_sign').attr('value', this.result);
        $('#sign_url').attr('src', this.result);
    });

    reader.readAsDataURL(file);
  }
});