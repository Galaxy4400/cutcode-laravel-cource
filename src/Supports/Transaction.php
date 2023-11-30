<?php

namespace Supports;

use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

class Transaction
{
	public static function run(Closure $process, Closure $onSuccess = null, Closure $onFail = null)
	{
		try {
			DB::transaction();

			return tap($process(), function ($result) use ($onSuccess) {
				if (!is_null($onSuccess)) {
					$onSuccess($result);
				}

				DB::commit();
			});
		} catch (Throwable $exception) {
			DB::rollBack();

			if (!is_null($onFail)) {
				$onFail($exception);
			}

			throw $exception;
		}
	}
}
