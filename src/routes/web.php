<?php

use Illuminate\Support\Facades\Route;
use Zampou\CinetPay\Controllers\CinetPayController;

Route::match(['get', 'post'], '/cnetpay-ipn', CinetPayController::class)->name('cinetpay-ipn');