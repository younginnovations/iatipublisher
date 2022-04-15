@extends('admin.layouts.app')

@section('content')
    <setting-page :currencies='{{ json_encode($currencies) }}' :languages='{{ json_encode($languages) }}'
        :humanitarian='{{ json_encode($humanitarian) }}'></setting-page>
@endsection
