<!DOCTYPE html>
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Signika:600|Roboto+Condensed' rel='stylesheet' type='text/css'>
</head>
<style>
    .page-break {
        page-break-after: always;
    }
    @font-face {
        font-family: 'HeaderFont';
        src: url({{ storage_path('fonts\texgyreschola-bold.otf') }}) format("opentype");
        font-weight: 400;
        font-style: normal;
    }
    @font-face {
        font-family: 'SmallHeader';
        src: url({{ storage_path('fonts\texgyreschola-regular.otf') }}) format("opentype");
        font-style: normal;
    }
    body{
        font-family: Arial, sans-serif;
    }
    .headerFont{
        font-family: "HeaderFont";
    }
    .headerSmall{
        font-family: 'SmallHeader';
    }
    .customerInfo{
    }
    .customerInfo td{
        border-collapse: collapse !important;
        border: 1px solid #E5E5E5;
        padding: 5px;
    }
    .customerInfo tr{
        border-collapse: collapse !important;
        border: 1px solid #E5E5E5;
    }
    p{
        line-height: 15px;
        padding: 0;
        margin: 0;
    }
</style>
<body>
@include('manager.report.pdf.splits.header')
<table style="width: 100% !important;  border: none; border-collapse: collapse !important">
    <tr>
        <td style="text-align:right !important;"><b class="headerSmall">CPS FILE#: CPS-{{rand(1000,9999)}}</b></td>
    </tr>
</table>
<table style="width: 100% !important;  border: none; border-collapse: collapse !important;margin-bottom: 10px">
    <tr>
        <td style="text-align:center !important;font-size: 24px"><b class="headerSmall" style="text-decoration: underline">DAILY REPORT</b></td>
    </tr>
</table>
<div>
    @include('manager.report.pdf.splits.daily')
</div>
<div class="page-break"></div>
<h1 style="font-size: 10px; text-decoration: underline"><b>Related Photos:</b></h1>
<br>
@foreach($daily_report as $d)
    @foreach($d->daily_report_images as $i)
        <img src="{{$i->images}}" width="345">
    @endforeach
@endforeach
</body>
</html>