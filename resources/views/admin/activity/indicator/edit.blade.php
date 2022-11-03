@extends('admin.layouts.app')

@section('content')
  <section class="section min-h-[calc(100vh_-_60px)]">
    @include('web.components.loader')
    <div class="px-5 xl:px-10 pt-4 pb-[71px]">
      @include('admin.layouts.activityTitle')
      <div class="activities">
        <aside class="activities__sidebar activities__sidebar-inner">
          <sidebar-help-block></sidebar-help-block>
        </aside>
        <div class="activities__content">
          <div class="inline-flex flex-wrap gap-2 mb-5 xl:mb-8">
            <a href='#title' class="tab-btn-anchor" v-smooth-scroll>
              <button class="tab-btn">
                <span>title</span>
              </button>
            </a>
            <a href="#description" class="tab-btn-anchor" v-smooth-scroll>
              <button class="tab-btn">
                <span>description</span>
              </button>
            </a>
            <a href="#document_link" class="tab-btn-anchor" v-smooth-scroll>
              <button class="tab-btn">
                <span>document-link</span>
              </button>
            </a>
            <a href="#reference" class="tab-btn-anchor" v-smooth-scroll>
              <button class="tab-btn">
                <span>reference</span>
              </button>
            </a>
            <a href="#baseline" class="tab-btn-anchor" v-smooth-scroll>
              <button class="tab-btn">
                <span>baseline</span>
              </button>
            </a>
          </div>
          <div class="py-[6.06%] px-[6%] xl:px-[12%] bg-white">
            @include('admin.activity.partial.form-title')

            {!! form($form) !!}
            <div class="hidden collection-container title" form_type="title_narrative"
              data-prototype="{{ form_row($form->title->getChildren()[0]->getChild('narrative')->prototype()) }}">
            </div>
            <div class="hidden collection-container title" form_type="description_narrative"
              data-prototype="{{ form_row($form->description->getChildren()[0]->getChild('narrative')->prototype()) }}">
            </div>
            {{-- document link --}}
            <div class="hidden parent-collection" form_type="document_link"
              data-prototype="{{ form_row($form->document_link->prototype()) }}">
            </div>
            <div class="hidden collection-container document_link_title_narrative"
              form_type="document_link_title_narrative"
              data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('title')->getChildren()[0]->getChild('narrative')->prototype())) }}">
            </div>
            <div class="hidden collection-container document_link_description_narrative"
              form_type="document_link_description_narrative"
              data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
            </div>
            <div class="hidden collection-container title" form_type="document_link_category"
              data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('category')->prototype())) }}">
            </div>
            <div class="hidden collection-container title" form_type="document_link_language"
              data-prototype="{{ str_replace('document_link[0]','document_link[__PARENT_NAME__]',form_row($form->document_link->getChildren()[0]->getChild('language')->prototype())) }}">
            </div>

            {{-- reference --}}
            <div class="hidden parent-collection" form_type="reference"
              data-prototype="{{ form_row($form->reference->prototype()) }}">
            </div>
            {{-- baseline --}}
            <div class="hidden parent-collection" form_type="baseline"
              data-prototype="{{ form_row($form->baseline->prototype()) }}">
            </div>
            <div class="hidden collection-container baseline_comment_narrative" form_type="baseline_comment_narrative"
              data-prototype="{{ str_replace('baseline[0]','baseline[__PARENT_NAME__]',form_row($form->baseline->getChildren()[0]->getChild('comment')->getChildren()[0]->getChild('narrative')->prototype())) }}">
            </div>
            <div class="hidden collection-container baseline_dimension" form_type="baseline_dimension"
              data-prototype="{{ str_replace('baseline[0]','baseline[__PARENT_NAME__]',form_row($form->baseline->getChildren()[0]->getChild('dimension')->prototype())) }}">
            </div>
            <div class="hidden collection-container baseline_location" form_type="baseline_location"
              data-prototype="{{ str_replace('baseline[0][location][__NAME__]','baseline[__PARENT_NAME__][location][__WRAPPER_NAME__]',form_row($form->baseline->getChildren()[0]->getChild('location')->prototype())) }}">
            </div>

            {{-- baseline document link --}}
            <div class="hidden collection-container title" form_type="baseline_document_link"
              data-prototype="{{ str_replace('baseline[0][document_link][__NAME__]','baseline[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->baseline->getChildren()[0]->getChild('document_link')->prototype())) }}">
            </div>
            <div class="hidden collection-container baseline_title_narrative" form_type="baseline_title_narrative"
              data-prototype="{{ str_replace('baseline[0][document_link][0]','baseline[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->baseline->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('title')->getChildren()[0]->getChild('narrative')->prototype())) }}">
            </div>
            <div class="hidden collection-container baseline_description_narrative"
              form_type="baseline_description_narrative"
              data-prototype="{{ str_replace('baseline[0][document_link][0]','baseline[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->baseline->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('description')->getChildren()[0]->getChild('narrative')->prototype())) }}">
            </div>
            <div class="hidden collection-container title" form_type="baseline_document_link_category"
              data-prototype="{{ str_replace('baseline[0][document_link][0]','baseline[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->baseline->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('category')->prototype())) }}">
            </div>
            <div class="hidden collection-container title" form_type="baseline_document_link_language"
              data-prototype="{{ str_replace('baseline[0][document_link][0]','baseline[__PARENT_NAME__][document_link][__WRAPPER_NAME__]',form_row($form->baseline->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('language')->prototype())) }}">
            </div>
            {{-- <div class="hidden collection-container title" form_type="baseline_title_narrative" --}}
            {{-- data-prototype="{{ str_replace(['baseline[0]', 'document_link[0]'],['baseline[__PARENT_NAME__]', 'document_link[__PARENT_NAME__]'], form_row($form->baseline->getChildren()[0]->getChild('document_link')->getChildren()[0]->getChild('title')->getChildren()[0]->getChild('narrative')->prototype())) }}"> --}}
            {{-- </div> --}}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
