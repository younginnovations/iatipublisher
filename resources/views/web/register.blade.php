@extends('web.layouts.app')

@section('content')
  <register-form :country='{{json_encode($countries)}}' :agency='{{json_encode($registration_agencies)}}' ></register-form>
@endsection
