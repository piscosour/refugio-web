<?php namespace App\Services;

use App\Services\Contracts\ServiceContract as Contract;
use Illuminate\Http\Request;
use App\Events\UserRegisterEvent;
use App\Transformers\UserTransformer;
use App\User;
use Image;

class UserService implements Contract {

	/**
	 * The storage folder images.
	 *
	 * @var string
	 */
	protected $imgFolder = 'profiles';

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(Request $request){

		$user = array(
			'name'     => $request->get('name'),
			'email'    => $request->get('email'),
			'password' => bcrypt($request->get('password'))
		);

		if ($request->hasFile('image')){

			$user['image'] = $this->storageOnDisk(
				$request->file('image'),
				$request->get('name')
			);

		}

		/* User Eloquent Model */

		$user = User::create($user);

		/* Trigger event */

		event(new UserRegisterEvent($user));

		/* Transform User Eloquent Model to Json */

		$user = fractal()->item($user)
	    			->transformWith(new UserTransformer)
				   	->toJson();

		/* Transform Json to Object */

		return json_decode($user);
	}

	/**
	 * Update an instance after a valid registration.
	 *
	 * @param  Request  $request
	 * @return \App\User
	 */
	public function update(Request $request, $id){

		$user = User::findOrFail($id);

		$data = array(
			'name'     => $request->get('name'),
			'email'    => $request->get('email')
		);

		if ($request->hasFile('image')){

			$data['image'] = $this->storageOnDisk(
				$request->file('image'),
				$request->get('name')
			);

		}

		$user->update($data); 	/* True | False */

		$user = fractal()->item($user)
		    			->transformWith(new UserTransformer)
					   	->toJson();

		return json_decode($user);

	}

	/**
	 * Storage an image on disk.
	 *
	 * @param  UploadFile  $image
	 * @param  string 	   $name
	 * @return string
	 */
	private function storageOnDisk($image, $name){

		$name    =  str_slug(trim($name)) . '-' . time();

		$imgName = $name.".".$image->getClientOriginalExtension();

		$storage = $image->move($this->imgFolder, $imgName);

		if ($storage) {

			$image = Image::make($storage);

			$image->resize(config('settings.user.width'), config('settings.user.height'), function ($constraint) {
			    $constraint->aspectRatio();
			    $constraint->upsize();
			});

			$image->save();

		}

		return $storage ? $imgName : config('settings.user.placeholder');

	}

}