<?php

class GameController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json(array('output' => $this->getGames()));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return array
	 */
	public function getGames(){
		$response =DB::table('games')
	        ->get();
		return $response;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return array
	 */
	public function getGameById($id){
		if (Session::has('admin')){
			$response =DB::table('games')
				->where('idgame', '=', $id)
	            ->get();
			return $response;
		}else
			return 'not admin';
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if (Session::has('admin')){
			$game_id = DB::table('games')->insertGetId(
				array(
					'name' => Input::get('name'), 
					'status' => 0
				)
			);

			return Response::json(array('output' => $this->getGames(), 'other'=> "test"));
		}else
			return Response::json(array('output' => 'not admin'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function change_status($game, $status)
	{

		if (Session::has('admin')){
			DB::table('games')
            ->where('idgame', $game)
            ->update(array( 
					'status' => $status
            	));
		}else
			return Response::json(array('output' => 'not admin'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function get_info(){
		//
		if (Session::has('user')){
			$user = Session::get('user');
			$rows = 0;
			$tasks = Input::get('sortedIDs');

			$len= count($tasks);
			for($i=0; $i<$len; $i++){
				$rows = DB::table('task_by_user')
	            ->where('task_id', '=', $tasks[$i])
	            ->where('user_id', '=', $user->user_id)
	            ->update(array('position' => $i));
        	}

			return Response::json(array('output' => $this->getTasks(), 'other'=> 'test'));
		}else
			return Response::json(array('output' => 'not logged'));
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
		if (Session::has('user')){
			$user = Session::get('user');

			DB::table('tasks')
            ->where('id', $id)
            ->update(array('task_status' => 0));

			return Response::json(array('output' => $this->getTasks()));
		}else
			return Response::json(array('output' => 'not logged'));
	}


}
