<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    protected $seo, $config;

    public function __construct()
    {
        $this->config = Config::where('id', 1)->first();
    }

    public function contact()
    {
        return view('web.'.$this->config->template.'.contact');
    }
}
