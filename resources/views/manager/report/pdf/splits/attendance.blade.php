<table class="customerInfo" style="margin-top: -1px;width: 100% !important;  border: 1px solid #E5E5E5; border-collapse: collapse !important">
    <tr>
        <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Guard</th>
        <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Time In</th>
        <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Time Out</th>
        <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Date</th>
    </tr>
    @foreach($attendance as $a)
        <tr>
            <td>{{$a->guards->guard_name}}</td>
            <td>{{$a->local_time_in}}</td>
            <td>{{$a->local_time_out}}</td>
            <td>{{$a->date}}</td>
        </tr>
    @endforeach
</table>


