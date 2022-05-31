@extends('admin.layouts.app')

@section('content')
  <organisation-data :elements="{{ json_encode($elements) }}" :element_group="{{ json_encode($elementGroups) }}"
    :activity="{{ json_encode($activity) }}" :progress="{{ $progress }}"></organisation-data>
@endsection
