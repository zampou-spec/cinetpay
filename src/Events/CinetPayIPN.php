<?php

namespace Zampou\CinetPay\Events;

use Exception;
use Illuminate\Http\Request;
use Zampou\CinetPay\CinetPay;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CinetPayIPN
{
  use Dispatchable, SerializesModels;

  public $payment_data = null;

  public function __construct(Request $request)
  {
    if ($request->cpm_trans_id) {
      try {
        $site_id = $request->cpm_site_id;
        $transaction_id = $request->cpm_trans_id;
        $apikey = config('cinetpay.CINETPAY_API_KEY');

        $cinetPay = new CinetPay($site_id, $apikey);
        $this->paymentdata = $cinetPay->getPayStatus($transaction_id, $site_id);
      } catch (Exception $e) {
        throw new Exception("Erreur :" . $e->getMessage());
      }
    } else {
      throw new Exception("cpm_trans_id non fourni");
    }
  }
}
