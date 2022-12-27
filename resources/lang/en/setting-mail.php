<?php
return [
    'panel_title' => 'Config Mail',
    'driver' => 'Driver',
    'host' => 'Host',
    'port' => 'Port',
    'username' => 'Username',
    'password' => 'Password',
    'encryption' => 'Encryption',
    'address' => 'Address',
    'name' => 'Name',
    'required-mail' => 'Please enter your email!',
    'secret' => 'Secret',
    'key' => 'Key',
    'region' => 'Region',
    'email_subject' => 'CHECK CONFIG MAIL',
    
    'placeholder' => [
        'driver'        => 'Default: smtp',
        'host'          => 'Default: '.env('MAIL_HOST', 'smtp.mailgun.org'),
        'port'          => 'Default: '.env('MAIL_PORT', 587),
        'username'      => 'Default: '.env('MAIL_USERNAME'),
        'password'      => 'Default: '.env('MAIL_PASSWORD'),
        'encryption'    => 'Default: '.env('MAIL_ENCRYPTION', 'tls'),
        'address'       => 'Default: '.env('MAIL_FROM_ADDRESS'),
        'name'          => 'Default: '.env('MAIL_FROM_NAME'),
        'mail_test'     => 'Enter your email to test Config email'
    ]
];
