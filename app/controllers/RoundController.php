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
		if (Session::has('admin')|| Session::has('user')){
			$GameController = new GameController();
			$FighterController = new FighterController();

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

						$game = $GameController->getGameById(Input::get('game'));
						$fighters = $FighterController->get_all(Input::get('game'), $game->status);
						return array('round' => $round, 'game' => $game, 'fighters' => $fighters);
					}else{
						return array('round' => $round, 'inBattle' => 1 );
					}
				}else{
					return array('wait' => 1);
				}
			}else{
				$game = $GameController->getGameById(Input::get('game'));
				$fighters = $FighterController->get_all(Input::get('game'), $game->status);
				$action = '';
				$action2 = false;
				if(Session::has('user')){
					$user = Session::get('user');
					$response =DB::table('actions')
			            ->where('iduser', '=', $user->iduser)
		                ->where('idgame', '=', Input::get('game'))
		                ->where('idround', '=', $round->round)
			            ->get();
			         
			         $len = count($response);
			         if($len>0){
			         	$action = $response[0];
			         	if(isset($response[1])){
			         		$action2 = $response[1];
			         	}
			         }

				}
				if($action2){
					return array('round' => $round, 'game' => $game, 'fighters' => $fighters, 'action' => $action, 'action2' => $action2);
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
