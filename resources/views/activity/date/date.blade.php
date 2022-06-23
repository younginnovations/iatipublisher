@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        <div class="px-10 pt-4 pb-[71px]">
            @include('admin.layouts.activityTitle')
            <div class="activities">
                <aside class="activities__sidebar">
                    <elements-note></elements-note>
                </aside>
                <div class="activities__content">
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach (session()->get('error') as $error)
                                    {{ $error }}
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="py-[6.06%] px-[12%] bg-white">
                        @include('admin.activity.partial.form-title')
                        {!! form($form) !!}
                        <div class="hidden parent-collection" data_name="description"
                            data-prototype="{{ form_row($form->activity_date->prototype()) }}">
                        </div>
                        <div class="hidden collection-container" form_type="activity_date_narrative"
                            data-prototype="{{ str_replace('activity_date[0]','activity_date[__PARENT_NAME__]',form_row($form->activity_date->getChildren()[0]->getChild('narrative')->prototype())) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
