<table>
    <tr>
        <th class="text-center">#</th>
        <th class="text-center">Email</th>
        <th class="text-center">Subscribed At</th>
    </tr>

    @foreach($rows as $idx=>$row)
        <tr>
            <td>{{$idx+1}}</td>
            <td class="text-center">{{$row->email }}</td>
            <td class="text-center">{{$row->created_at?->format('Y-m-d') ?? '' }}</td>
        </tr>
    @endforeach

</table>
