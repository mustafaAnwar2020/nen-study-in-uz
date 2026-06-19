<table>
    <tr>
        <td colspan="4" style="font-weight: bolder;text-align: center">
            بيانات الدخول للموظفين
        </td>
    </tr>
    <tr>
        <th scope="col">رقم</th>
        <th scope="col">اسم</th>
        <th scope="col">اسم المستخدم</th>
        <th scope="col">كلمة السر</th>
    </tr>

    @foreach($rows as $idx=>$row)
        <tr>
            <td>{{$row->id}}</td>
            <td>{{$row->name}}</td>
            <td>{{$row->username}}</td>
            <td>{{$row->password_text}}</td>
        </tr>
    @endforeach

</table>
