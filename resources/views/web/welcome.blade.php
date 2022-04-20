@extends('web.layouts.app')

@section('content')
  <welcome-signin> {{ csrf_field() }} </welcome-signin>
@endsection
