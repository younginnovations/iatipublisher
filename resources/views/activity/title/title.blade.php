@extends('admin.layouts.app')

@section('content')

{!! form($form) !!}
<div class="hidden collection-container"
    data-prototype="{{ form_row($form->narrative->prototype()) }}">
</div>
@endsection
