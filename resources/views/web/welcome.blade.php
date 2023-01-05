@extends('web.layouts.app')

@section('content')
  <welcome-signin page="{{$page}}" message="{{$message}}" intent="{{$intent}}"></welcome-signin>
@endsection
