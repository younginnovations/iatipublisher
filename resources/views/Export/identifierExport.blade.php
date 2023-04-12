<table>
    <thead>
    <tr>
        @foreach($headers as $head)
            <th><b>{{ $head }}</b></th>
        @endforeach
    </tr>
    </thead>
    <tbody>

    @foreach($identifiers as $headerKey => $identifier)
       <tr>
           @foreach($headers as $header)
               <td>
                   {{ $identifier[$header] ?? ''  }}
               </td>
           @endforeach
       </tr>
    @endforeach

    </tbody>
</table>
