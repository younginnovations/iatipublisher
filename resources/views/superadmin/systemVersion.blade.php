@extends('admin.layouts.app')

@section('content')
    <system-version :php-dependencies="{{json_encode($phpDependencies)}}" :node-dependencies="{{json_encode($nodeDependencies)}}"
                    :package-manager-version="{{json_encode($version)}}" :latest-manager-version="{{json_encode($latestVersion)}}">

    </system-version>
@endsection
