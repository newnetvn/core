@select(['name' => 'mail_driver', 'label' => __('core::setting-mail.driver'), 'options' => get_mail_driver_options()])
<div id="driver-smtp">
    @input(['name' => 'mail_host', 'label' => __('core::setting-mail.host'), 'placeholder' => __('core::setting-mail.placeholder.host')])
    @input(['name' => 'mail_port', 'label' => __('core::setting-mail.port'), 'placeholder' => __('core::setting-mail.placeholder.port')])
    @input(['name' => 'mail_encryption', 'label' => __('core::setting-mail.encryption'), 'placeholder' => __('core::setting-mail.placeholder.encryption')])
    @input(['name' => 'mail_username', 'label' => __('core::setting-mail.username'), 'placeholder' => __('core::setting-mail.placeholder.username')])
    @input(['name' => 'mail_password', 'label' => __('core::setting-mail.password')])
</div>
<div id="driver-ses">
    @input(['name' => 'mail_key', 'label' => __('core::setting-mail.key')])
    @input(['name' => 'mail_secret', 'label' => __('core::setting-mail.secret')])
    @input(['name' => 'mail_region', 'label' => __('core::setting-mail.region')])
</div>

@input(['name' => 'mail_address', 'label' => __('core::setting-mail.address'), 'placeholder' => __('core::setting-mail.placeholder.address')])
@input(['name' => 'mail_name', 'label' => __('core::setting-mail.name'), 'placeholder' => __('core::setting-mail.placeholder.name')])

<div class="form-group row component-mail_test">
    <label for="mail_test" class="col-12 col-form-label font-weight-600">Check Config</label>
    <div class="col-12">
        <div class="row">
            <div class="col-10">
                <input type="email"  class="form-control"  name="mail_test"  id="mail_test"
                       placeholder="{{ __('core::setting-mail.placeholder.mail_test') }}" >
            </div>
            <button id="check_config_mail" class="col-2 btn btn-primary">Check</button>
        </div>
        <div class="loading-email" style="display: none">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
        <div id="notify" class="mt-3">
        </div>
    </div>
</div>

@push('scripts')

    <script>
        function CheckMail()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#check_config_mail').click(function (e) {
                e.preventDefault();

                mail = $('#mail_test').val();
                $('#notify').html('');
                if (mail) {
                    $('.loading-email').show();
                    $.ajax({
                        url: adminPath + '/theme-setting/check-configmail',
                        method: 'POST',
                        data: {
                            mail_test: mail,
                            mail_driver: $('#mail_driver').val() ?? '',
                            mail_host: $('#mail_host').val() ?? '',
                            mail_port: $('#mail_port').val() ?? '',
                            mail_username: $('#mail_username').val() ?? '',
                            mail_password: $('#mail_password').val() ?? '',
                            mail_encryption: $('#mail_encryption').val() ?? '',

                            mail_key: $('#mail_key').val() ?? '',
                            mail_secret: $('#mail_secret').val() ?? '',
                            mail_region: $('#mail_region').val() ?? '',

                            mail_address: $('#mail_address').val() ?? '',
                            mail_name: $('#mail_name').val() ?? '',
                        },
                        success: function (response) {
                            $('.loading-email').hide();
                            $('#notify').html(`
                                <div class="alert alert-success" style="margin-bottom: unset"> Config mail successful! </div>
                            `)
                        },
                        error: function(response){
                            $('.loading-email').hide();
                            $('#notify').html(`
                                <div class="alert alert-danger" style="margin-bottom: unset"> ERROR! </div>
                            `)
                        }
                    });
                } else {
                    alert('{{ __('core::setting-mail.required-mail') }}')
                }

            })

            $('#mail_driver').change(function () {
                driver = $('#mail_driver').val()
                switch (driver) {
                    case 'smtp':
                        $('#driver-smtp').show();
                        $("#driver-smtp :input").attr("disabled", false)
                        $('#driver-ses').hide();
                        $("#driver-ses :input").attr("disabled", true);
                        break;
                    case 'ses':
                        $('#driver-smtp').hide();
                        $("#driver-smtp :input").attr("disabled", true);
                        $('#driver-ses').show();
                        $("#driver-ses :input").attr("disabled", false);
                        break;
                }
            })
        }
        $(document).ready(function () {
            new CheckMail();
            $('#driver-' + $('#mail_driver').val()).show();
        })
    </script>

@endpush

@push('styles')
    <style>
        .loading-email {
            width: 144px;
            height: 48px;
            position: relative;
            margin: 0 auto;
        }
        .loading-email span {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            position: absolute;
            bottom: 0;
            left: 0;
            display: block;
            background-color: #9B5986;
            animation: Loading 3s infinite ease-in-out;
        }
        .loading-email span:nth-of-type(2) { left: 30px; animation-delay: .2s; }
        .loading-email span:nth-of-type(3) { left: 60px; animation-delay: .4s; }
        .loading-email span:nth-of-type(4) { left: 90px; animation-delay: .6s; }
        .loading-email span:last-of-type { left: 120px; animation-delay: .8s; }

        @keyframes Loading {
            0% { height: 20px; transform: translateY(0); background-color: #9B59B6; }
            50% { height: 20px; transform: translateY(50px); background-color: #3498D6; }
            100% { height: 20px; transform: translateY(0); background-color: #9B59B6; }
        }
        #driver-smtp, #driver-mailgun, #driver-postmark, #driver-ses {
            display: none;
        }

    </style>
@endpush

