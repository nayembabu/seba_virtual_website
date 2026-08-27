<style>
    button {
        width: 90px;
        height: 26px;
        cursor: pointer;
    }
    div.print-section {
        width: 800px;
        text-align: left;
        margin-top: 10px;
        margin-bottom: 50px;
    }
    @media print {    
        div.print-section { display: none; }
    }
</style>

<style type="text/css" media="print">
    @page { 
        size: landscape;
    }
</style>

<center>
    <div><button onClick="window.print();">Print</button></div>
    <table width="800" cellpadding="2" cellspacing="2" style="border-bottom:2px solid black;">
        <tr>
            <td align="left" valign="top">
                <img src="https://evisa.e-gov.kg/images/img/logo_3.png" width="90" />
            </td>
            <td align="left" valign="top" style="line-height:22px;font-size:17px;">
                <b><p align="center">КЫРГЫЗ РЕСПУБЛИКАСЫНЫН ТЫШКЫ ИШТЕР МИНИСТРЛИГИ</p>
<p align="center">MINISTRY OF FOREIGN AFFAIRS OF THE KYRGYZ REPUBLIC</p>
<p align="center"><strong>Бирдиктүү уруксат/Uniform permit</strong></p></b><br>
            </td>
            <td align="right" valign="middle">

            </td>
        </tr>
    </table>    
    <br>
    <table width="800" cellpadding="2" cellspacing="2">
        <tr>
            <td>
                @if($visaApplication->profile_photo)
                    <img src="{{ asset('../storage/uploads/visa/'.$visaApplication->profile_photo) }}" width="110">
                @else
                    <img src="{{ asset('assets/images/default-avatar.png') }}" width="110">
                @endif
            </td>
            <td align="right" style="line-height:22px;font-size:17px;">
                Визанын номери/visa number: {{ $visaApplication->visa_number }}<br>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
				<table width="100%" cellpadding="2" cellspacing="2">
                    <tr>
                        <td>Толук аты-жөнү/Full name:</td>
                        <td>{{ $visaApplication->full_name }}</td>
                    </tr>
                    <tr>
                        <td>Туулган датасы/Date of birth:</td>
                        <td>{{ date('d-m-Y', strtotime($visaApplication->date_of_birth)) }}</td>
                    </tr>
                    <tr>
                        <td>Жарандыгы/Citizenship:</td>
                        <td>{{ $visaApplication->citizenship }}</td>
                    </tr>
                    <tr>
                        <td>Жол жүрүүчү документтин (паспорттун) номери/<br>Number of Travel document (passport):</td>
                        <td>{{ $visaApplication->passport_number }}</td>
                    </tr>
                    <tr>
                        <td>Жол жүрүүчү документтин түрү/Type of travel document:</td>
                        <td>{{ $visaApplication->travel_document_type }}</td>
                    </tr>
                    <tr>
                        <td>Жол жүрүүчү документтин (паспорттун) берилген датасы/<br>DATE of issue of the travelling document (passport):</td>
                        <td>{{ date('d-m-Y', strtotime($visaApplication->passport_issue_date)) }}</td>
                    </tr>
                    <tr>
                        <td>Жол жүрүүчү документтин (паспорттун) бүткөн датасы/<br>Date of expiry of the travelling document (passport):</td>
                        <td>{{ date('d-m-Y', strtotime($visaApplication->passport_expiry_date)) }}</td>
                    </tr>
                    <tr>
                        <td>Бирдиктүү документтин мөөнөтү /<br>Validity of uniform permit:</td>
                        <td>15-05-2025 - 13-07-2025</td>
                    </tr>
                    <tr>
                        <td>Визанын түрү/Type of visa:</td>
                        <td>{{ $visaApplication->visa_type }}</td>
                    </tr>
                    <tr>
                        <td>Визанын колдонулуу мөөнөтү/Validity of visa:</td>
                        <td>{{ $visaApplication->visa_validity }}</td>
                    </tr>
                    <tr>
                        <td>Кирүүлөрдүн саны/Number of entries:</td>
                        <td>{{ $visaApplication->number_of_entries }}</td>
                    </tr>
                    <tr>
                        <td>Жүрүү мөөнөтү/Period of stay(days):</td>
                        <td>{{ $visaApplication->period_of_stay }}</td>
                    </tr>
                    <tr>
                        <td>Чакыруучу/Invitation:</td>
                        <td>{{ $visaApplication->invitation ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Чакыруу тараптын жеке салык номери/<br>Inviting party's individual taxpayer number</td>
                        <td>01809199510105</td>
                    </tr>
                    <tr>
                        <td>Иштөөгө уруксат/The right to work:</td>
                        <td>Uniform permit</td>
                    </tr>
                    <tr>
                        <td>Берилген датасы/Date of issue:</td>
                        <td>2025-05-15</td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <br>
                            <b>Validity period of a visa is generally longer than period of stay. The validity period establishes the first and last dates during which the visa can be used. Period of stay indicates the length of time you have permission to remain in Kyrgyzstan within the validity period of the visa.</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</center>

