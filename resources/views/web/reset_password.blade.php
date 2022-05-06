@extends('web.layouts.app')

@section('content')
  <reset-password :reset_token='{{ json_encode($token) }}' :email='{{ json_encode($email) }}'></reset-password>
@endsection
