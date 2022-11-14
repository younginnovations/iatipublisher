@extends('web.layouts.app')

@section('content')
  <iati-register-form :types='{{json_encode($types)}}'></iati-register-form>
@endsection
