<?php

namespace App\Traits;

trait ResponsesTrait
{
	/**
	 * Default structure for fails responses
	 *
	 * @param  int  $code
	 * @return json response
	 */

	public static function responseFails($code, $msg = null, $errors = null) {
		return response()->json(
			[
				'status' => $code,
				'success' => false,
				'message' => $msg,
				'errors' => $errors
			],
			$code
		);
	}

	/**
	 * Default structure for success responses
	 *
	 * @param  int  $code
	 * @return json response
	 */

	public static function responseSuccess($code, $msg = null, $data = null)
	{
		return response()->json(
			[
				'status' => $code,
				'success' => true,
				'message' => $msg,
				'data' => $data,
			],
			$code
		);
	}

}
