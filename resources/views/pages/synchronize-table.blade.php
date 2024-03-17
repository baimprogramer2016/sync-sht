<table class="table table-bordered text-white ">
    <thead>
        <tr class="text-dark">
            @foreach ($data_query[0] as $col => $value)
            <th scope="col">{{ $col }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data_query as $index => $row)
        <tr>
            @foreach ($row as $value)
            <td>{{ $value }}</td>
            {{-- <td>{{ iconv('UTF-8', 'UTF-8//IGNORE', $value) }}</td> --}}
            @endforeach
        </tr>

        @endforeach
    </tbody>
</table>
