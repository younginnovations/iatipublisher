@extends('admin.layouts.app')

@section('content')
    <h2>Activity Detail Page</h2>
    <div>
        Saved data:
        <div>
            {{json_encode($activity)}}
        </div>
    </div>
@endsection
