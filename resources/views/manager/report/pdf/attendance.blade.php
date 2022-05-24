<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<h2>Attendance Report</h2>

<table>
    <tr>
        <th>Guard Name</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Date</th>
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

</body>
</html>

