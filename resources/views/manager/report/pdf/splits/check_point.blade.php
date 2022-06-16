
<table class="customerInfo" style="margin-top: -1px;width: 100% !important;  border: 1px solid #E5E5E5; border-collapse: collapse !important">
    <tr>
        <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Client</th>
        <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Guard</th>
        <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Location</th>
        <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Date</th>
        <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Scan Time</th>
    </tr>
    @foreach($check_point as $i)
        <tr>
            <td>{{$i->client->client_name}}</td>
            <td>{{$i->guards->guard_name}}</td>
            <td>{{$i->checkpoint->checkpoint_name}}</td>
            <td>{{$i->date}}</td>
            <td>{{$i->local_time}}</td>
        </tr>
    @endforeach
</table>

