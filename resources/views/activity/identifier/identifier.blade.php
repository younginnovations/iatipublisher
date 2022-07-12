@extends('admin.layouts.layout')

@section('form')
  {!! form($form) !!}
  <div class="hidden identifier" activity_identifier={{ $activity->organization->identifier }}>
  </div>
@endsection
