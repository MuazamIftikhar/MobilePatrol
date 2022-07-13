<div style="margin-top: -20px;">
    <table style="width: 100% !important;">
        <tr>
            <td style="width: 10%">
                <img src="{{$company_setting->company_logo}}" width="150">
            </td>
            <td style="width: 90%">
                <div>
                    <h1 class="headerFont" style="margin-top: -15px; text-align: center;text-decoration: underline">
                        {{$company_setting->company_name}}</h1>
                    <p class="headerSmall" style=" font-size: 12px;margin-top: -15px; text-align: center;">{{$company_setting->company_address}}</p>
                    <p class="headerSmall" style=" font-size: 12px; text-align: center;"><b>Office:</b>
                        {{$company_setting->company_phone}}
                    </p>
                    <p class="headerSmall" style=" font-size: 12px; text-align: center;"><b>Email:</b>
                        {{$company_setting->company_email}} |
                        <b>Web: </b> {{$company_setting->company_website}}
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>
