@extends('admin.layouts.app')

@section('content')
    <activities-detail
        :translated-data='{{json_encode($translatedData)}}'
    >
    </activities-detail>

    <h2>Activity Detail Page</h2>
    <div>
        Saved data:
        <div>
            {{json_encode($activity)}}
        </div>
    </div>
@endsection
