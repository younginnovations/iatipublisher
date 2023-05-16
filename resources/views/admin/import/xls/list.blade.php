@extends('admin.layouts.app')

@section('content')
    <xls-list :status="{{ json_encode($status) }}" :import-data="{{ json_encode($importData) }}"
        :global-error="{{ json_encode($errors) }}"></xls-list>
@endsection
