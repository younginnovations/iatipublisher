@extends('admin.layouts.app')

@section('content')
  <organisation-data :elements="{{ json_encode($elements) }}" :groups="{{ json_encode($elementGroups) }}"
    :activity="{{ json_encode($activity) }}" :progress="{{ $progress }}"></organisation-data>
@endsection
