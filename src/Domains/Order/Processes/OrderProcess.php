<?php

namespace Domains\Order\Processes;

use Throwable;
use DomainException;
use Supports\Transaction;
use Domains\Order\Models\Order;
use Illuminate\Pipeline\Pipeline;
use Domains\Order\Events\OrderCreated;
use Domains\Order\Exceptions\OrderProcessException;


class OrderProcess
{
	protected array $processes = [];


	public function __construct(
		protected Order $order,
	) {
	}


	public function processes(array $processes): self
	{
		$this->processes = $processes;

		return $this;
	}


	public function run(): Order
	{
		return Transaction::run(

			process: function () {
				return app(Pipeline::class)
					->send($this->order)
					->through($this->processes)
					->thenReturn();
			},

			onSuccess: function (Order $order) {
				flash()->info("Заказ № {$order->id} оформлен");
				
				event(new OrderCreated($order));
			},

			onFail: function (Throwable $exception) {
				app()->isProduction() 
					? throw new DomainException("Что-то пошло не так. Обратитесь в техподдержку") 
					: throw new OrderProcessException($exception);
			}
		);
	}
}
