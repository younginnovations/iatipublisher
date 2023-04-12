<table>
    <thead>
    <tr>
{{--        <th><b>{{ $primaryIdentifier  }}</b></th>--}}

        @foreach($headers as $head)
            <th><b>{{ ucwords(str_replace("_", " ", $head['index'] ?? $head)) }}</b></th>
        @endforeach
    </tr>
    </thead>
    <tbody>

    @foreach($activities as $identifier => $activity)
        @foreach($activity as $data)
            @if(!is_array_value_empty($data))
                <tr>
                    <td> @if($loop->first) {{ $identifier  }} @endif</td>
                    @foreach($headers as $headerKey => $header)
                        @if($loop->first) @continue; @endif
                        <td>
                            {{ $data[$headerKey] ?? ''  }}
                        </td>
                    @endforeach
                </tr>
            @endif
        @endforeach
    @endforeach
    </tbody>
</table>
