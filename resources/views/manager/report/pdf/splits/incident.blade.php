@foreach($incident as $i)
    <table class="customerInfo" style="margin-top: -1px;width: 100% !important;  border: 1px solid #E5E5E5; border-collapse: collapse !important">
        <tr>
            <th style="background-color: #f2f2f2; color: #808080; text-transform: uppercase">Information</th>
            <th style="background-color: #f2f2f2; color: #808080; text-transform: uppercase">Incident Report</th>
            <th style="background-color: #f2f2f2; color: #808080; text-transform: uppercase">Image</th>
        </tr>
        <tr>
            <td style="width: 20%">
                <p style="font-size: 10px"><b>Location</b>: {{$i->client->client_address}}</p>
                <p style="font-size: 10px"><b>Client</b>: {{$i->client->client_name}}</p>
                <p style="font-size: 10px"><b>Guard</b>: {{$i->guards->guard_name}}</p>
                <p style="font-size: 10px"><b>Time</b>: {{\Carbon\Carbon::parse($i->created_at)->format('h:i a')}}</p>
                <p style="font-size: 10px"><b>Date</b>: {{$i->date}}</p>
            </td>
            <td style="width: 40%">
                <p style="font-size: 10px;text-decoration: underline"><b>Nature of complaint:</b></p>
                <p style="font-size: 10px">{{$i->nature_of_complaint}}</p>
                <p style="font-size: 10px; text-decoration: underline"><b>Police called? {{gettype($i->police_called) == 'integer' ? $i->police_called == 1 ? "Yes" : 'No' : $i->police_called}}</b></p>
                <p style="font-size: 10px;text-decoration: underline"><b>Anyone arrested?</b></p>
                <p style="font-size: 10px">{{$i->anyone_interested}}</p>
                <p style="font-size: 10px;text-decoration: underline"><b>Property damaged?</b></p>
                <p style="font-size: 10px">{{$i->property_damaged}}</p>
                <p style="font-size: 10px;text-decoration: underline"><b>Witness:</b></p>
                <p style="font-size: 10px">{{$i->witness}}</p>
                <p style="font-size: 10px;text-decoration: underline"><b>Additional Information:</b></p>
                <p style="font-size: 10px">{{$i->information}}</p>
            </td>
                <td style="width: 40%;padding: 0">
                    <img src="{{$i->incident_report_images->first()->images}}" width="280">
                </td>
        </tr>
    </table>
@endforeach