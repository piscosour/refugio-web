<?php namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface ServiceContract {

	/**
	 * Create an instance after a valid registration.
	 *
	 * @param  Request  $request
	 * @return \App\{Model}
	 */
	public function create(Request $request);

	/**
	 * Update an instance after a valid registration.
	 *
	 * @param  Request  $request
	 * @return \App\{Model}
	 */
	public function update(Request $request, $id);

}