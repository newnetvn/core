@extends('core::admin.master')

@section('meta_title', __('core::theme-setting.index.page_title'))

@section('page_title', __('core::theme-setting.index.page_title'))

@section('page_subtitle', __('core::theme-setting.index.page_subtitle'))

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">{{ trans('dashboard::message.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('core.admin.setting.index') }}">{{ trans('core::setting.index.breadcrumb') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('core::theme-setting.index.breadcrumb') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <form action="{{ route('core.admin.theme-setting.save') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <ul class="nav nav-pills scrollable">
                        @foreach($panels as $key => $panel)
                            <li class="nav-item">
                                <a class="nav-link {{ $key == 0 ? 'active' : '' }} save-tab"
                                   data-toggle="pill"
                                   href="#tab{{ md5(get_class($panel)) }}"
                                >
                                    {{ $panel->getTitle() }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-right d-none d-sm-block">
                        <button class="btn btn-success" type="submit">{{ __('core::button.save') }}</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-horizontal">
                    <div class="tab-content">
                        @foreach($panels as $key => $panel)
                            <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="tab{{ md5(get_class($panel)) }}">
                                {!! $panel->render() !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="offset-2 col-auto">
                        <button class="btn btn-success" type="submit">{{ __('core::button.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
