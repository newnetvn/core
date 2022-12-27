<?php
return [
    'panel_title' => 'Cấu hình Mail',
    'driver' => 'Driver',
    'host' => 'Host',
    'port' => 'Port',
    'username' => 'Username',
    'password' => 'Password',
    'encryption' => 'Encryption',
    'address' => 'Address',
    'name' => 'Name',
    'required-mail' => 'Vui lòng nhập địa chỉ Email nhận để kiểm tra cài đặt!',
    'secret' => 'Secret',
    'key' => 'Key',
    'region' => 'Region',
    'email_subject' => 'Kiểm tra cài đặt Mail',

    'placeholder' => [
        'driver'        => 'Default: smtp',
        'host'          => 'Default: '.env('MAIL_HOST', 'smtp.mailgun.org'),
        'port'          => 'Default: '.env('MAIL_PORT', 587),
        'username'      => 'Default: '.env('MAIL_USERNAME'),
        'password'      => 'Default: '.env('MAIL_PASSWORD'),
        'encryption'    => 'Default: '.env('MAIL_ENCRYPTION', 'tls'),
        'address'       => 'Default: '.env('MAIL_FROM_ADDRESS'),
        'name'          => 'Default: '.env('MAIL_FROM_NAME'),
        'mail_test'     => 'Nhập mail để kiểm tra cấu hình'
    ]
];
