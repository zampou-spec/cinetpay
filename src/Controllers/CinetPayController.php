<?php

namespace Zampou\CinetPay\Controllers;

use Illuminate\Http\Request;
use Zampou\CinetPay\Events\CinetPayIPN;

class CinetPayController
{
  public function index(Request $request)
  {
    if ($request->isMethod('get')) {
      return response('ok');
    }

    event(new CinetPayIPN($request));
  }
}
