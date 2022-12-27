<?php

namespace Newnet\Core\Http\Controllers\Web;

use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home');
    }
}
