@extends('web.layouts.app')

@section('content')
  <reset-password :resetToken='{{ json_encode($token) }}' :email='{{ json_encode($email) }}'></reset-password>
@endsection
