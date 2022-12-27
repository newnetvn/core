<div class="form-group row component-{{ $name }}">
    <label for="{{ $name }}" class="col-12 col-form-label font-weight-600">{{ $label }}</label>
    <div class="col-12">
        <textarea name="{{ $name }}"
                  id="{{ $name }}"
                  class="form-control {{ config('core.wysiwyg_editor') }}-editor @error($name) is-invalid @enderror"
                  placeholder="{{ $placeholder ?? $label }}"
        >{{ old(get_dot_array_form($name), $value ?? object_get($item, get_dot_array_form($name))) }}</textarea>
        @error($name)
            <span class="invalid-feedback text-left">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        @if(!empty($helper))
            <span class="helper-block">
                {!! $helper !!}
            </span>
        @endif
    </div>
</div>

@if(config('core.wysiwyg_editor') == 'froala')
    @assetadd('codemirror', "https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css")
    @assetadd('codemirror', "https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js")
    @assetadd('codemirror.xml', "https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js", ['codemirror'])
    @assetadd('froala', asset("vendor/newnet-admin/plugins/froala/css/froala_editor.pkgd.min.css"))
    @assetadd('froala', asset("vendor/newnet-admin/plugins/froala/js/froala_editor.pkgd.min.js"))
    @assetadd('froala.style', asset("vendor/newnet-admin/plugins/froala/css/froala_style.min.css"), ['froala'])
    @if(App::getLocale() !== 'en')
        @assetadd('froala.lang', asset("vendor/newnet-admin/plugins/froala/js/languages/" . App::getLocale() .".js"), ['froala'])
    @endif
    @assetadd('froala-script', asset("vendor/newnet-admin/js/scripts/froala.js"), ['jquery', 'froala'])
@elseif(config('core.wysiwyg_editor') == 'tinymce')
    @assetadd('tinymce', asset("vendor/newnet-admin/css/tinymce.css"))
    @assetadd('tinymce', asset("vendor/newnet-admin/plugins/tinymce/tinymce.min.js"), ['jquery'])
    @assetadd('tinymce-script', asset("vendor/newnet-admin/js/scripts/tinymce.js"), ['jquery', 'tinymce'])
@endif
