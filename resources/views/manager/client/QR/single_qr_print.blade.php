<!DOCTYPE html>
<html>
<body>
<div align="center">
    {{--@include('reports.splits.header')--}}
    <h4>Scan QR Code.</h4>
    <img  src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(500)->generate($checkpoint->qr_code)) }} ">
</div>

</body>
</html>