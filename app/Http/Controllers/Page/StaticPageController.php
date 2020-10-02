<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    public function referralProgram()
    {
        return view('pages.static.referral-program');
    }
}
