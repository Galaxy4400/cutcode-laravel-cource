<?php

namespace Domains\Order\Processes;

use DomainException;
use Domains\Order\Events\OrderCreated;
use Domains\Order\Models\Order;
use Illuminate\Pipeline\Pipeline;
use Supports\Transaction;
use Throwable;

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
				flash()->info('Good # ' . $order->id);
				
				event(new OrderCreated($order));
			},

			onFail: function (Throwable $exception) {
				throw new DomainException(app()->isProduction()
					? "Что-то пошло не так. Обратитесь в техподдержку"
					: $exception->getMessage()
				);
			}

		);
	}
}
