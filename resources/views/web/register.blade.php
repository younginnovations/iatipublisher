@extends('web.layouts.app')

@section('content')
  <register-form
      :country='{{json_encode($countries)}}'
      :agency='{{json_encode($registration_agencies)}}'
      :uncategorized-organisation-registration-agency='{{json_encode($uncategorizedRegistrationAgencyPrefix)}}'
  ></register-form>
@endsection
