<?php

class FighterController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return Response::json(array('output' => $this->getFighter()));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return array
	 */
    public function getFighter(){
		if (Session::has('user')){
			$user = Session::get('user');
			$response =DB::table('fighters')
	            ->where('iduser', '=', $user->iduser)
                ->where('idgame', '=', Input::get('game'))
	            ->get();
	        if(!$response){
              	return 'no fighter';
            }else
				return $response[0];
		}else
			return 'not logged';
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if (Session::has('user')){
			$round =DB::table('rounds')
				->where('idgame', '=', Input::get('game'))
				->orderBy('round','desc')
	            ->first();
	        if(!$round){
	        	return Response::json(array('output' => 'no rounds registered'));
	        }
	        if($round->round>1 || $round->status==1){
	        	return Response::json(array('output' => 'game started'));
	        }

			$user = Session::get('user');

			$response =DB::table('fighters')
	            ->where('iduser', '=', $user->iduser)
                ->where('idgame', '=', Input::get('game'))
	            ->get();
	        if(!$response){
              	$fighter_id = DB::table('fighters')->insertGetId(
					array(
						'gender' => Input::get('gender'), 
						'name' => Input::get('name'),
						'killspeech' => Input::get('killSpeech'),
						'lastwords' => Input::get('lastWords'),
						'victoryspeech' => Input::get('victorySpeech'),
						'type' => Input::get('type'),
						'idclass' => Input::get('fighterClass'),
						'hp' => Input::get('hp'),
						'classhp' => Input::get('hp'),
						'lastwords' => Input::get('lastWords'),
						'idgame' => Input::get('game'),
						'iduser' => $user->iduser,
						'color' => Input::get('color'),
						'status' => 1
					)
				);

				$response =DB::table('fighters')
	            ->where('iduser', '=', $user->iduser)
                ->where('idgame', '=', Input::get('game'))
	            ->get();
	            if(!$response){
	            	return Response::json(array('output' => 'not saved'));
	            }else{
	            	return Response::json(array('output' => $response[0]));
	            }
            }else
				return Response::json(array('output' => $response[0]));
		}else
			return Response::json(array('output' => 'not logged'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function get_all($game,$game_status){
		
			$fighters =DB::table('fighters')
                ->where('idgame', '=', $game)
	            ->get();
	        if(!$fighters){
              	return [];
            }else{
            	//if($game_status == 3){
	            	foreach ($fighters as &$fighter) {
						$fighter->info = $this->get_info_by_idfighter($fighter->idfighter, $game_status);
					}
				//}
            	return $fighters;
            }
	}

	public function get_info()
	{
		if(Input::get('fighters')){
			$fighters = Input::get('fighters');
			foreach ($fighters as &$fighter) {
				$fighter['info'] = $this->get_info_by_idfighter($fighter['idfighter'],3);
			}
			return Response::json(array('output' => $fighters));
		}else{
			if (Session::has('user')){
				$user = Session::get('user');
				$fighter =DB::table('fighters')
		            ->where('iduser', '=', $user->iduser)
	                ->where('idgame', '=', Input::get('game'))
		            ->first();
		        if(!$fighter){
	              	return Response::json(array('output' => 'no fighter'));
	            }else
					return Response::json(array('output' => $fighter, 'user' => $user));
			}
		}
	}

	public function get_info_by_idfighter($idfighter, $game_status)
	{
		$fighter =DB::table('fighters')
			->where('idfighter', '=', $idfighter)
			->where('idgame', '=', Input::get('game'))
			->first();
		if(!$fighter){
			return array('fighter' => 'no fighter');
		}
		$UserController = new UserController();
		if($game_status == 3){
			$user = $UserController->get_user_by_id($fighter->iduser);
		}else{
			$user = "";
		}
		$TimelineController = new TimelineController();
		$timeline = $TimelineController->get_time_line_by_idfighter($idfighter);
		return array('fighter' => $fighter, 'user' => $user, 'timeline' => $timeline);
	}

	public function kill_random(){
		if (Session::has('admin')){
			$fighters =DB::table('fighters')
				->where('idgame', '=', Input::get('game'))
				->where('hp', '>', 0)
				->orderBy(DB::raw('RAND()'))
				->take(Input::get('kills'))
				->get();
			if(!$fighters){
				return array('fighter' => 'no fighter');
			}
			foreach ($fighters as &$fighter) {
				DB::table('fighters')
				->where('idfighter', '=', $fighter->idfighter)
				->update(array(
					'hp' => 0
				));

				$action = (object) array(
					'idaction' => 0,
					'idgame' => Input::get('game'),
					'idround' => Input::get('round'),
					'iduser' => 0,
					'idfighter' => 0,
					'target' => $fighter->idfighter,
					'order' => 0,
					'turn' => 1,
					'status' => 1,
					'damage' => 100,
					'critical' => 0,
					'effective' =>  0,
					'name' => 'Ice King (admin)',
					'type' => 1,
					'idclass' => 1,
					'hp' => 100,
					'color' => 1,
					'killspeech' => '¿Te volviste reggaetonero?',
					'gender' => 4,
					'classhp' => 100,
					'target_fighter' => (object) array(
					 	'idfighter' => $fighter->idfighter,
						'name' => $fighter->name,
						'iduser' => $fighter->iduser,
						'idgame' => $fighter->idgame,
						'type' => $fighter->type,
						'idclass' => $fighter->idclass,
						'hp' => 0,
						'status' => $fighter->status,
						'color' => $fighter->color,
						'lastwords' => $fighter->lastwords,
						'gender' => $fighter->gender,
						'classhp' => $fighter->classhp
					)
				);	
						
				$TimelineController = new TimelineController();
				$TimelineController->create($action);
			}
			$fighters = $this->get_all(Input::get('game'), 1);
			return Response::json(array('output' => $fighters));
		}else
			return Response::json(array('output' => 'not admin'));
	}

	public function kill_fighter(){
		if (Session::has('admin')){
			DB::table('fighters')
				->where('idfighter', '=', Input::get('fighter'))
				->update(array(
					'hp' => 0
				));
			return Response::json(array('output' => 'killed'));
		}else
			return Response::json(array('output' => 'not admin'));
	}

	public function revive_fighter(){
		if (Session::has('admin')){
			DB::table('fighters')
				->where('idfighter', '=', Input::get('fighter'))
				->update(array(
					'hp' => Input::get('hp')
				));
			return Response::json(array('output' => 'revived'));
		}else
			return 'not admin';
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
