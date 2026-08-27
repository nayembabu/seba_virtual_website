<style type="text/css">
.translucent {
	filter: alpha(opacity = 50);
	-moz-opacity: 0.8;
	opacity: 0.8;
}

table.dataentry {
	Color: black;
	border: 1px solid #990000;
	text-align: left;
}

tr.dataentry {
	Font-family: serif;
	Font-variant: normal;
	border: 1px solid black;
}

th.dataentry {
	Font-weight: bold;
	border: 1px solid black;
}

td.dataentry {
	border: 1px solid black;
}
</style>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">



<script type="text/javascript">
	function getDepartureInfo()
	{
		//var clrid = 'SA-I-2025-0117166';
		$.ajax({
			type : 'GET',
			url : 'departure',
			dataType : 'json',			
			success : function(data) {
					console.log(data.msg)
					if(data.body!=null)
					{
					photoStr = 'data:image/jpg;base64,' + data.body.photoStr;
	
					$("#regnuber").html(data.body.empregid);
					$("#fullName").html(data.body.empfullname);
					$("#fathersName").html(data.body.father);
					$("#passportNumber").html(data.body.passportid);
					$("#clearanceId").html(data.body.clearanceid);
					$("#country").html(data.body.country);
					$("#post").html(data.body.post);
					$("#visano").html(data.body.visano);
					
					$("#empPhoto").attr('src', photoStr);
					}
					else
						alert(data.msg);
			},
			error : function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError);
			}
		});
	}
	getDepartureInfo();
</script>



<table width="70%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr bgcolor="#EBF5F1">
        <td width=18% height="24px;" style="padding-left: 10px; padding-top: 8px;"><b>Name:</b></td>
        <td width=30% style="padding-top: 8px;">{{ $name }}</td>
        <td width="22%" style="padding-top: 8px;"><b>BMET Number: </b></td>
        <td width="20%" style="padding-top: 8px;">{{ $bmet_no }}</td>
    </tr>

    <tr bgcolor="#FFF2FF">
        <td height="24px;" style="padding-left: 10px;"><b>Father's Name:</b></td>
        <td>{{ $father_name }}</td>
        <td><b>Profession:</b></td>
        <td>{{ $job }}</td>
    </tr>

    <tr bgcolor="#EBF5F1">
        <td height="24px;" style="padding-left: 10px;"><b>Passport No:</b></td>
        <td>{{ $passport_no }}</td>
        <td><b>Visa No: </b></td>
        <td>{{ $visa_no }}</td>
    </tr>

    <tr bgcolor="#FFF2FF">
        <td height="24px;" style="padding-left: 10px;"><b>Clearance Id:</b></td>
        <td>{{ $clearance_id }}</td>
        <td><b>Country: </b></td>
        <td>{{ $country }}</td>
    </tr>
</table>

<br />
<br />
<br />
<center>
    <img src="{{ $photoUrl }}" style="height: 100px;"/>
</center>
