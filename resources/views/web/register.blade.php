@extends('web.layouts.app')

@section('content')
  <register-form :country='{{json_encode($countries)}}' :registrationAgency='{{json_encode($registration_agencies)}}' ></register-form>
@endsection
