@extends('admin.layouts.app')

@section('content')
<xls-list :status= "{{ json_encode($status) }}" :import-data= "{{ json_encode($importData) }}" ></xls-list>
<!-- {{ json_encode($status) }} -->
<!-- {{ json_encode($importData) }} -->

@endsection
