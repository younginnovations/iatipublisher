@extends('admin.layouts.app')

@section('content')
    <setting-page :currencies='{{ json_encode($currencies) }}' :languages='{{ json_encode($languages) }}'
                  :humanitarian='{{ json_encode($humanitarian) }}' :organization='{{ Auth::user()->organization}}' :budget-not-provided="{{ json_encode($budgetNotProvided)}}"
                  :activity-id='{{$activityId}}'></setting-page>
@endsection