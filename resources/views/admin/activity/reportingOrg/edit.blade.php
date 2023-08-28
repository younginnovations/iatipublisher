@extends('admin.layouts.layout')

@section('form')
    {!! form($form) !!}
    <div class="hidden parent-collection" data-prototype="{{ form_row($form->reporting_org->prototype()) }}">
    </div>
    <div class="hidden collection-container" form_type="reporting_org_narrative"
        data-prototype="{{ str_replace('reporting_org[0]','reporting_org[__PARENT_NAME__]',form_row($form->reporting_org->getChildren()[0]->getChild('narrative')->prototype())) }}">
    </div>
@endsection

