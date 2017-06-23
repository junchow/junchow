<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function createVcode($tmp)
    {
        $builder = new CaptchaBuilder;
        $builder->build($width=100, $height=40, $font=null);
        $phrase = $builder->getPhrase();
        Session::flash('vcode', $phrase);

        header('Cache-Control:no-cache, must-revalidate');
        header('Content-Type:image/jpeg');

        $builder->output();
    }


    public function validateVcode(Request $request)
    {
        $vcode = $request->get('vcode');
        return Session::get('vcode')==$vcode;
    }
}
