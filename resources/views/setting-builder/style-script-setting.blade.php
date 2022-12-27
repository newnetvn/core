@assetadd('ace','vendor/newnet-admin/js/ace/ace.js')

<div class="form-group row">
    <label for="code_head" class="col-12 col-form-label font-weight-600">{{__('core::setting-code.head')}}</label>
    <div class="col-12">
        <textarea name="code_head" data-editor="style" data-gutter="1"
                  id="code_head"
                  class="form-control"
                  placeholder="{{__('core::setting-code.head')}}"
                  rows="10"
        >{{ old(get_dot_array_form('code_head'), $value ?? object_get($item, get_dot_array_form('code_head'))) }}</textarea>
    </div>
</div>

<div class="form-group row">
    <label for="code_footer" class="col-12 col-form-label font-weight-600">{{__('core::setting-code.footer')}}</label>
    <div class="col-12">
        <textarea name="code_footer" data-editor="javascript" data-gutter="1"
                  id="code_footer"
                  class="form-control"
                  placeholder="{{__('core::setting-code.footer')}}"
                  rows="10"
        >{{ old(get_dot_array_form('code_footer'), $value ?? object_get($item, get_dot_array_form('code_footer'))) }}</textarea>
    </div>
</div>

@push('scripts')
    <script>
        $(function () {
            $('textarea[data-editor]').each(function () {
                var textarea = $(this);
                var mode = textarea.data('editor');
                var editDiv = $('<div>', {
                    position: 'absolute',
                    // width: textarea.width(),
                    height: 200,
                    'class': textarea.attr('class')
                }).insertBefore(textarea);
                textarea.css('display', 'none');
                var editor = ace.edit(editDiv[0]);
                editor.renderer.setShowGutter(textarea.data('gutter'));
                editor.getSession().setValue(textarea.val());
                editor.getSession().setMode("ace/mode/" + mode);
                // editor.setTheme("/static-block/admin/js/theme/idle_fingers");
                editor.setTheme("ace/theme/chrome");
                // copy back to textarea on form submit...
                textarea.closest('form').submit(function () {
                    textarea.val(editor.getSession().getValue());
                })
            });
        });
    </script>
@endpush
