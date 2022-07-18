<table class="customerInfo" style="margin-top: -1px;width: 100% !important;  border: 1px solid #E5E5E5; border-collapse: collapse !important">
    @foreach($form as $f)
        <tr>
        @foreach(json_decode($f->form_element) as $d)
            <th>{{$d->label}}</th>
        @endforeach
    </tr>
    <tr>
        @foreach(json_decode($f->form_element) as $m)
            <td>{{$m->value}}</td>
        @endforeach
    </tr>
    @endforeach
</table>
