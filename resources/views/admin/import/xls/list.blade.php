@extends('admin.layouts.app')

@section('content')

{{ json_encode($status) }}
{{ json_encode($importData) }}

@endsection
