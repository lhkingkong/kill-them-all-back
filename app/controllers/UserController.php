<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		/*if(Session::has('abc'))
		{
		    return Session::get('abc');
		} else {
		    Session::put('abc', 'some value');
		    return "saved";        
		}*/
		//
		if (Session::has('user')){
			$user = Session::get('user');
			return Response::json(array('user' => $user));
			//$results = DB::select('select * from users where user_id = ?', array($user.id));
			//return Response::json(array('user' => $results[0]));
		}else{
			return Response::json(array('user' => false));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function sign_in()
	{
		//
		$user = Input::get('user');
		$pass = Input::get('password');
		$response = DB::table('users')
			->select('user_id', 'email', 'name')
			->where('password', $pass)
			->where(function($query) use ($user) {
				$query->orWhere('name', $user)->orWhere('email', $user);
			})
			->get();
		if(!$response)
			return Response::json(array('user' => false));
		else{
			Session::put('user', $response[0]);
			Session::save();
			return Response::json(array('user' => Session::get('user')));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function sign_up()
	{
		//
		$user = Input::get('user');
		$email = Input::get('email');
		$pass = Input::get('password');

		DB::table('users')->insert(
			array('email' => $email, 'name' => $user, 'password' => $pass)
		);

		$response = DB::table('users')
			->select('user_id', 'email', 'name')
			->where('password', $pass)
			->where(function($query) use ($user) {
				$query->orWhere('name', $user)->orWhere('email', $user);
			})
			->get();
		if(!$response)
			return Response::json(array('user' => false));
		else{
			Session::put('user', $response[0]);
			Session::save();
			return Response::json(array('user' => Session::get('user')));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function log_off()
	{
		//
		Session::flush();
		return Response::json(array('user' => false));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return "create";
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		return "store";
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		return "show";
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		return "edit";
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		return "update";
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		return "destroy";
	}


}
