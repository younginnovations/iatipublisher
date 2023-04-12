<table>
    <thead>

    </thead>
    <tbody>

       @foreach($data as $datum)
           <tr>
               @foreach($datum as $keyValue => $row)
                   @if($row === false)
                       <td>FALSE</td>
                   @elseif($row === true)
                       <td>TRUE</td>
                   @else
                       <td>{{ $row ?? ''  }}</td>
                   @endif
               @endforeach
           </tr>
       @endforeach
    </tbody>
</table>
