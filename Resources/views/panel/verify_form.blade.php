@extends('agent::layouts.app')

@section('title')
    {{ __('KYC form') }}
@endsection

@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ __('Agent Verification')}}
            </h1>
        </div>
      </div>
    </div>
    <x-error-msg/>
    <x-flash-msg/>
    <form class="" action="{{ route('landlord.agent.kyc.verify.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 h6">{{ __('Verification info')}}</h4>
            </div>
            <div class="card-body">
                @foreach ($verification_form as $key => $element)
                    @if ($element->field_type == 'text' || $element->field_type == 'email' || $element->field_type == 'tel' || $element->field_type == 'date' || $element->field_type == 'url')
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ $element->field_name }} @if($element->field_required) <span class="text-danger">*</span> @endif </label>
                            </div>
                            <div class="col-md-10">
                                <input type="{{ $element->field_type }}" class="form-control mb-3" placeholder="{{ $element->field_placeholder }}" name="{{ $element->field_name }}" @if($element->field_required) required @endif>
                            </div>
                        </div>
                    @elseif($element->field_type == 'file')
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ $element->field_name }} @if($element->field_required) <span class="text-danger">*</span> @endif</label>
                            </div>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <label class="custom-file-label">
                                        <input type="{{ $element->field_type }}" name="{{ $element->field_name }}" id="file-{{ $key }}" class="custom-file-input" @if($element->field_required) required @endif>
                                        <span class="custom-file-name">{{ __('Choose file') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @elseif ($element->field_type == 'select' && is_array($element->select_options))
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ $element->field_name }} @if($element->field_required) <span class="text-danger">*</span> @endif</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control selectpicker" data-minimum-results-for-search="Infinity" name="{{ $element->field_name }}" @if($element->field_required) required @endif>
                                        @foreach ($element->select_options as $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @elseif ($element->field_type == 'textarea')
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ $element->field_name }} @if($element->field_required) <span class="text-danger">*</span> @endif</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control" rows="5" name="{{ $element->field_name }}" @if($element->field_required) required @endif></textarea>
                            </div>
                        </div>
                    @elseif ($element->field_type == 'checkbox')
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ $element->field_name }} ({{ $element->field_placeholder }}) @if($element->field_required) <span class="text-danger">*</span> @endif</label>
                            </div>
                            <div class="col-md-10">
                                <input type="{{ $element->field_type }}" class="form-control mb-3" placeholder="{{ $element->field_placeholder }}" name="{{ $element->field_name }}" @if($element->field_required) required @endif>
                            </div>
                        </div>
                    @elseif ($element->field_type == 'multi_select' && is_array($element->options))
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ $element->field_name }} @if($element->field_required) <span class="text-danger">*</span> @endif</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control selectpicker" data-minimum-results-for-search="Infinity" name="element_{{ $key }}[]" multiple @if($element->field_required) required @endif>
                                        @foreach ($element->options as $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @elseif ($element->field_type == 'radio')
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ $element->field_name }} @if($element->field_required) <span class="text-danger">*</span> @endif</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    @foreach ($element->options as $value)
                                        <div class="radio radio-inline">
                                            <input type="radio" name="element_{{ $key }}" value="{{ $value }}" id="{{ $value }}" @if($element->field_required) required @endif>
                                            <label for="{{ $value }}">{{ $value }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('Apply')}}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
