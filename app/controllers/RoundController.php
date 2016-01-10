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
			$round =DB::table('rounds')
			->where('idgame', '=', Input::get('game'))
			->where('status', '=', 0)
	            ->first();

		    if(!$round){
		    	if (Session::has('admin')){
		    		$round =DB::table('rounds')
						->where('idgame', '=', Input::get('game'))
						->where('status', '=', 1)
	            		->first();
	            	if(!$round){
			    		$lastRound = DB::table('rounds')
			    			->where('idgame', '=', Input::get('game'))
			    			->orderBy('idround', 'desc')
			    			->first();
			    		if(!$lastRound){
			    			$lastRound = 1;
			    		}else{
			    			$lastRound = $lastRound->round + 1;
			    		}

						$round_id = DB::table('rounds')->insertGetId(
							array(
								'idgame' => Input::get('game'), 
								'round' => $lastRound,
								'status' => 0
							)
						);
						$GameController->change_status(Input::get('game'),1);
						$round =DB::table('rounds')
						->where('idgame', '=', Input::get('game'))
						->where('status', '=', 0)
				            ->first();

						$game = $GameController->getGameById(Input::get('game'))[0];
						$fighters = $FighterController->get_all(Input::get('game'));
						return array('round' => $round, 'game' => $game, 'fighters' => $fighters);
					}else{
						return array('round' => $round, 'inBattle' => 1 );
					}
				}else{
					return array('wait' => 1);
				}
			}else{
				$game = $GameController->getGameById(Input::get('game'))[0];
				$fighters = $FighterController->get_all(Input::get('game'));
				$action = '';
				if(Session::has('user')){
					$user = Session::get('user');
					$action =DB::table('actions')
			            ->where('iduser', '=', $user->iduser)
		                ->where('idgame', '=', Input::get('game'))
		                ->where('idround', '=', $round->round)
			            ->first();
				}
				return array('round' => $round, 'game' => $game, 'fighters' => $fighters, 'action' => $action);
			}
		}else
			return 'not admin';
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function close_round()
	{
		//
		if (Session::has('admin')){
			DB::table('rounds')
            ->where('idgame', '=', Input::get('game'))
			->where('status', '=', 0)
            ->update(array(
            		'status' => 1
            	));

            $ActionController = new ActionController();

            $ActionController->order_actions();

            $ActionController->execute_actions();

			return Response::json(array('output' => 'closed'));
		}else
			return Response::json(array('output' => 'not admin'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function next_round()
	{
		//
		if (Session::has('admin')){
			DB::table('rounds')
            ->where('idgame', '=', Input::get('game'))
			->where('status', '=', 1)
            ->update(array(
            		'status' => 2
            	));

			return Response::json(array('output' => $this->getCurrentRound()));
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
