<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Redirector;
use Domains\Order\Payment\PaymentData;
use Domains\Order\Payment\PaymentSystem;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseController extends Controller
{
	public function index(): Redirector
	{
		return redirect(PaymentSystem::create(new PaymentData())->url());
	}


	public function callback(): JsonResource
	{
		return PaymentSystem::validate()->response();
	}
}
