<table>
    <tr>
        <td colspan="4" style="font-weight: bolder;text-align: center">
            بيانات المراكز المسجلة حتي الآن
        </td>
    </tr>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">اسم</th>
        <th class="text-center">الكود</th>
        <th class="text-center">اسم المالك</th>
        <th class="text-center">المحافظة</th>
        <th class="text-center">البريد</th>
        <th class="text-center">رقم الهاتف</th>
        <th class="text-center">الحالة</th>
        <th class="text-center">تاريخ الإضافة</th>
    </tr>

    @foreach($rows as $idx=>$row)
        <tr>
            <td>{{$idx+1}}</td>
            <td class="text-center">{{$row->name }}</td>
            <td class="text-center">{{$row->code }}</td>
            <td class="text-center">{{$row->owner?->name }}</td>
            <td class="text-center">{{$row->governorate?->governorate_name_ar }}</td>
            <td class="text-center">{{$row->owner?->email }}</td>
            <td class="text-center">{{$row->phone }}</td>
            <td class="text-center">
                @if($row->is_active)
                    <span class="badge badge-success">مفعل</span>
                @else
                    <span class="badge badge-danger">غير مفعل</span>
                @endif
            </td>
            <td class="text-center">{{$row->created_at->format('Y-m-d')}}</td>

        </tr>
    @endforeach

</table>
