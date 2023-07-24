@extends('admin.layouts.app')

@section('content')
    <h2>{{translateCommon('activity_detail_page')}}</h2>
    <div>
        {{translateButton('save_data')}}:
        <div>
            {{json_encode($activity)}}
        </div>
    </div>
@endsection
