@extends('admin.layouts.app')

@section('content')
    <h2>{{trans('common.activity_detail_page')}}</h2>
    <div>
        {{trans('buttons.save_data')}}:
        <div>
            {{json_encode($activity)}}
        </div>
    </div>
@endsection
