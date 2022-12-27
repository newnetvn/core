<?php

namespace Newnet\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LinkVendorCommand extends Command
{
    protected $name = 'newnet:link-vendor';

    protected $description = 'Link Vendor Newnet Core';

    public function handle()
    {
        $target = realpath(__DIR__.'/../../../public/newnet-admin');
        $link = public_path('vendor/newnet-admin');

        if (!File::exists($link)) {
            File::link($target, $link);

            $this->info($target.' <=> '.$link);
        } else {
            $this->error('Target is exists: '.$link);
        }
    }
}
