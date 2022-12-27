@if(config('core.enable_translate'))
    <div class="newnet-translate-alert">
        {{ trans('core::translate.edit_version') }}
        <strong>"{{ get_current_edit_locale_name() }}"</strong>
    </div>
@endif
