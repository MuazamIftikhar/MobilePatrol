
@section('script')
    <script>
        $(document).ready(function () {
            var timezone=$('.timezone').val();
            moment.tz.setDefault(timezone);
            var setDate = moment();
            $('.datetimepicker').val(setDate.format('YYYY-MM-DD hh:mm'));
            $(".datetimepicker").datetimepicker({
            });
            $('.datepicker').val(setDate.format('MM/DD/YYYY'));
            $('.datepicker').datepicker({
                orientation: "bottom"

            });
        });
    </script>
@endsection

{{--<script>--}}
    {{--var timezone = moment.tz.guess();--}}
    {{--$('#timezone').val(timezone);--}}
{{--</script>--}}