<?php

class RoundController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json(array('output' => $this->getCurrentRound()));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return array
	 */
	public function getCurrentRound(){
		$GameController = new GameController();
		$FighterController = new FighterController();
		if (Session::has('admin')|| Session::has('user')){
			$response =DB::table('rounds')
			->where('idgame', '=', Input::get('game'))
			->where('status', '=', 0)
	            ->get();

		    if(!$response){
		    	if (Session::has('admin')){
					$round_id = DB::table('rounds')->insertGetId(
						array(
							'idgame' => Input::get('game'), 
							'round' => 1,
							'status' => 0
						)
					);
					$GameController->change_status(Input::get('game'),1);
					$response =DB::table('rounds')
					->where('idgame', '=', Input::get('game'))
					->where('status', '=', 0)
			            ->get();

			        $round = $response[0];
					$game = $GameController->getGameById(Input::get('game'))[0];
					$fighters = $FighterController->get_all(Input::get('game'));
					return array('round' => $round, 'game' => $game, 'fighters' => $fighters);
				}else{
					return array('wait' => 1);
				}
			}else{
				$round = $response[0];
				$game = $GameController->getGameById(Input::get('game'))[0];
				$fighters = $FighterController->get_all(Input::get('game'));
				return array('round' => $round, 'game' => $game, 'fighters' => $fighters);
			}
		}else
			return 'not admin';
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return array
	 */
	public function get_current_round(){
		$GameController = new GameController();
		if (Session::has('user')){
			$response =DB::table('rounds')
			->where('idgame', '=', Input::get('game'))
			->where('status', '=', 0)
	            ->get();

		    if(!$response){
				$round_id = DB::table('rounds')->insertGetId(
					array(
						'idgame' => Input::get('game'), 
						'round' => 1,
						'status' => 0
					)
				);
				$response =DB::table('rounds')
				->where('idgame', '=', Input::get('game'))
				->where('status', '=', 0)
		            ->get();

		        $round = $response[0];
				$game = $GameController->getGameById(Input::get('game'))[0];
				$fighters = $GameController->getGameById(Input::get('game'))[0];
				return array('round' => $round, 'game' => $game, 'fighters' => $fighters);
			}else{
				$round = $response[0];
				$game = $GameController->getGameById(Input::get('game'))[0];
				return array('round' => $round, 'game' => $game);
			}
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
	public function sort(){
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		//
		if (Session::has('user')){
			$user = Session::get('user');
			$task_id= Input::get('id');

			$type = Input::get('taskType');

			if($type==1){
				$content = "";
			}else{
				$content = Input::get('content');
			}

			DB::table('tasks')
            ->where('id', $task_id)
            ->update(array(
            		'title' => Input::get('title'), 
					'content' => $content,
					'exp_date' => Input::get('expDate'),
					'task_type' => $type
            	));

            if($type==1){
            	$listOptions = json_decode(json_encode(Input::get('listOptions')), FALSE);

				DB::table('items')->where('task_id', '=', $task_id)->delete();

				$len = count($listOptions);
				for($i = 0;$i<$len; $i++){
					DB::table('items')->insert(
						array('task_id' => $task_id, 'content' => $listOptions[$i]->content, 'checked' => $listOptions[$i]->checked, 'position' => $i)
					);
				}
			}
			return Response::json(array('output' => $this->getTasks(), 'other'=> "test"));
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
