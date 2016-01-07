<?php

class AdminController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Session::has('admin')){
			$admin = Session::get('admin');
			return Response::json(array('admin' => $admin));
		}else{
			return Response::json(array('admin' => false));
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
		$admin = Input::get('admin');
		$pass = Input::get('password');
		
		$response = DB::table('admin')
			->select('idadmin', 'username')
			->where('password', $pass)
			->where(function($query) use ($admin) {
				$query->orWhere('username', $admin);
			})
			->get();
		if(!$response)
			return Response::json(array('admin' => false));
		else{
			Session::put('admin', $response[0]);
			Session::save();
			return Response::json(array('admin' => Session::get('admin')));
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
		$admin = Input::get('username');
		$pass = Input::get('password');

		$response = DB::table('admin')
			->select('idadmin', 'username')
			->where('password', $pass)
			->where(function($query) use ($admin) {
				$query->orWhere('username', $admin);
			})
			->get();
		if(!$response){
			DB::table('admin')->insert(
				array('username' => $admin, 'password' => $pass)
			);

			$response = DB::table('admin')
				->select('idadmin', 'username')
				->where('password', $pass)
				->where(function($query) use ($admin) {
					$query->orWhere('username', $admin);
				})
				->get();
			if(!$response)
				return Response::json(array('admin' => false));
			else{
				Session::put('admin', $response[0]);
				Session::save();
				return Response::json(array('admin' => Session::get('admin')));
			}
		}else{
			Session::put('admin', $response[0]);
			Session::save();
			return Response::json(array('admin' => Session::get('admin')));
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
		return Response::json(array('admin' => false));
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
