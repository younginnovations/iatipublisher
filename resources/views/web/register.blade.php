@extends('web.layouts.app')

@section('content')
  <register-form :translation="{{ json_encode(trans('auth')) }}" :country='{{ json_encode($countries) }}'
    :registration_agency='{{ json_encode($registration_agencies) }}'></register-form>
@endsection
