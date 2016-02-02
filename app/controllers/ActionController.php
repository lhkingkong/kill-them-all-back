<?php

class ActionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return Response::json(array('output' => $this->getActions()));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return array
	 */
    public function getActions(){
		if (Session::has('user')){
			$user = Session::get('user');
			if(Input::get('round')){
				$response =DB::table('actions')
	                ->where('idgame', '=', Input::get('game'))
	                ->where('idround', '=', Input::get('round'))
		            ->get();
			}else{
				$response =DB::table('actions')
	                ->where('idgame', '=', Input::get('game'))
		            ->get();
			}
			if(!$response){
              	return 'no actions';
            }else
				return $response;
		}else{
			if(Session::has('admin')){
				$round =DB::table('rounds')
						->where('idgame', '=', Input::get('game'))
						->where('status', '=', 1)
	            		->first();
	            if($round){
	            	$game = Input::get('game');
					$response =DB::table('actions')
						->join('fighters', 'actions.idfighter', '=', 'fighters.idfighter')
	            		->where('actions.idgame', '=', $game)
	            		->where('fighters.idgame', '=', $game)
		                ->where('actions.idround', '=', $round->round)
		                ->orderBy('actions.turn','asc')
		                ->orderBy('actions.order','asc')
			            ->get();
				
					if(!$response){
		              	return 'no actions';
		            }else{
		            	foreach ($response as $res) {
		            		$res->target_fighter =DB::table('fighters')
					            ->where('iduser', '=', $res->target)
				                ->where('idgame', '=', $game)
					            ->first();
		            	}
		            	return $response;
		            }
				}else{
					return 'no round closed';
				}
			}else{
				return 'not logged';
			}
		}
	}

	public function order_actions(){
		$game = Input::get('game');
		$current_round =DB::table('rounds')
			->where('idgame', '=', $game)
	    	->where('status', '=', 1)
			->first();
		if(!$current_round){
			return 'the round is not closed';
		}
		
		$FighterClassController = new FighterClassController();
		$classes = $FighterClassController->getClassesBySpeed();
		$turn = 1;
		foreach ($classes as $fighterClass){
			$actions =DB::table('actions')
	            ->join('fighters', 'actions.idfighter', '=', 'fighters.idfighter')
	            ->where('actions.idgame', '=', $game)
	            ->where('fighters.idgame', '=', $game)
				->where('actions.idround', '=', $current_round->round)
				->where('fighters.idclass', '=', $fighterClass->idclass)
	            ->orderBy(DB::raw('RAND()'))
	            ->get();
			if($actions){
				$order = 1;
				foreach ($actions as $action) {
					DB::table('actions')
			            ->where('idgame', '=', $game)
						->where('idaction', '=', $action->idaction)
			            ->update(array(
			            	'turn' => $turn,
			            	'order' => $order
			            ));
			            $order++;
				}
			}
			$turn++;
		}
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
			$user = Session::get('user');
			$target = Input::get('target');

			$response =DB::table('rounds')
				->where('idgame', '=', Input::get('game'))
				->where('round', '=', Input::get('round'))
				->where('status', '=', 0)
	            ->first();
	        if(!$response){
	        	return Response::json(array('output' => 'round close to more actions'));
	        }

			$response =DB::table('actions')
	            ->where('iduser', '=', $user->iduser)
                ->where('idgame', '=', Input::get('game'))
                ->where('idround', '=', Input::get('round'))
	            ->get();
	        if(!$response){
	        	$fighter =DB::table('fighters')
		            ->where('iduser', '=', $user->iduser)
	                ->where('idgame', '=', Input::get('game'))
		            ->first();
		        if(!$fighter){
		        	return Response::json(array('output' => 'no fighter of user'));
		        }
		        $fighter_class =DB::table('classes')
		            ->where('idclass', '=', $fighter->idclass)
		            ->first();
		        if(!$fighter_class){
		        	return Response::json(array('output' => 'no class of user'));
		        }

		        // archer attack twice
		        if($fighter_class->idclass==3 && Input::get('target2')){
		        	$target2 = Input::get('target2');
					$target_fighter =DB::table('fighters')
			            ->where('iduser', '=', $target2)
		                ->where('idgame', '=', Input::get('game'))
			            ->first();
			        if(!$target_fighter){
			        	return Response::json(array('output' => 'no fighter of target'));
			        }
			        $target_fighter_class =DB::table('classes')
			            ->where('idclass', '=', $target_fighter->idclass)
			            ->first();
			        if(!$target_fighter_class){
			        	return Response::json(array('output' => 'no class of target'));
			        }

			        $attack = $this->calculate_damage($fighter, $fighter_class, $target_fighter,$target_fighter_class);

	              	$idaction = DB::table('actions')->insertGetId(
						array(
							'idgame' => Input::get('game'), 
							'idround' => Input::get('round'),
							'iduser' => $user->iduser,
							'idfighter' => $fighter->idfighter,
							'target' => $target2,
							'order' => 0,
							'turn' => 0,
							'status' => 0,
							'damage' => $attack['damage'],
							'critical' => $attack['critical'],
							'effective' =>  $attack['effective']
						)
					);
		        }

		        $target_fighter =DB::table('fighters')
		            ->where('iduser', '=', $target)
	                ->where('idgame', '=', Input::get('game'))
		            ->first();
		        if(!$target_fighter){
		        	return Response::json(array('output' => 'no fighter of target'));
		        }
		        $target_fighter_class =DB::table('classes')
		            ->where('idclass', '=', $target_fighter->idclass)
		            ->first();
		        if(!$target_fighter_class){
		        	return Response::json(array('output' => 'no class of target'));
		        }

		        $attack = $this->calculate_damage($fighter, $fighter_class, $target_fighter,$target_fighter_class);

              	$idaction = DB::table('actions')->insertGetId(
					array(
						'idgame' => Input::get('game'), 
						'idround' => Input::get('round'),
						'iduser' => $user->iduser,
						'idfighter' => $fighter->idfighter,
						'target' => $target,
						'order' => 0,
						'turn' => 0,
						'status' => 0,
						'damage' => $attack['damage'],
						'critical' => $attack['critical'],
						'effective' =>  $attack['effective']
					)
				);
				return Response::json(array('output' => 'inserted'));
            }else
				return Response::json(array('output' => 'Already action in round'));
		}else
			return Response::json(array('output' => 'not logged'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function calculate_damage($fighter, $fighter_class, $target_fighter,$target_fighter_class){
		
			$damage = 0;
			$damage += $fighter_class->attack;
			$damage -= ($target_fighter_class->defense/2);

			$effective = 0;
			/*
			Types
			1 Rock
			2 Paper
			3 Scissors
			*/
			switch($fighter->type){
				case 1: 
					if($target_fighter->type == 2){
						$damage /= 2;
						$effective = 2;
					}
					if($target_fighter->type == 3){
						$damage *= 2;
						$effective = 1;
					}
					break;
				case 2: 
					if($target_fighter->type == 3){
						$damage /= 2;
						$effective = 2;
					}
					if($target_fighter->type == 1){
						$damage *= 2;
						$effective = 1;
					}
					break;
				case 3: 
					if($target_fighter->type == 1){
						$damage /= 2;
						$effective = 2;
					}
					if($target_fighter->type == 2){
						$damage *= 2;
						$effective = 1;
					}
					break;
			}

			/*
			Classes
			1 Knight
			2 Wizard
			3 Archer
			4 Assassin
			*/
			$critical = 0;

			if($target_fighter_class->idclass == 1 && rand(1, 10)>7){
				$damage /= 2;
			}
			if($target_fighter_class->idclass == 2 && rand(1, 10)>6){// && $fighter->type == $target_fighter->type){
				$damage *= (-1.5);
				$damage = round($damage);
			}
			if($target_fighter_class->idclass == 3 && rand(1, 10)>8){
				$damage = 0;
			}
			if($fighter_class->idclass == 4 && rand(1, 10)>6){
				$damage *= 2;
				$critical = 1;
			}

            return array('damage' => $damage, 'critical' => $critical, 'effective' => $effective);
	}

	public function execute_actions()
	{
		if(Session::has('admin')){
			$game = Input::get('game');

			$round =DB::table('rounds')
						->where('idgame', '=', $game)
						->where('status', '=', 1)
	            		->first();
	        if($round){
	            $game = Input::get('game');
				$action =DB::table('actions')
					->join('fighters', 'actions.idfighter', '=', 'fighters.idfighter')
	            	->where('actions.idgame', '=', $game)
	            	->where('fighters.idgame', '=', $game)
		            ->where('actions.idround', '=', $round->round)
		            ->where('actions.status', '=', 0)
		            ->orderBy('actions.turn','asc')
		            ->orderBy('actions.order','asc')
			        ->first();
				
				while($action){
		            if($action->hp>0){
		            	$action->target_fighter =DB::table('fighters')
					        ->where('iduser', '=', $action->target)
				            ->where('idgame', '=', $game)
					        ->first();

					    $life_left = $action->target_fighter->hp - $action->damage;
					    if($life_left<0){
					    	$life_left = 0;
					    }
					    if($life_left>$action->target_fighter->classhp){
					    	$life_left = $action->target_fighter->classhp;
					    }

					    $action->target_fighter->hp = $life_left;

					    $TimelineController = new TimelineController();
					    $TimelineController->create($action);
					    
					    DB::table('fighters')
		            	->where('idfighter', '=', $action->target_fighter->idfighter)
		            	->update(array(
		            		'hp' => $life_left
		            	));
		            	DB::table('actions')
			            	->where('idgame', '=', $game)
			            	->where('idaction', '=', $action->idaction)
			            	->update(array(
			            		'status' => 1
			            	));
		            }else{
		            	DB::table('actions')
			            	->where('idgame', '=', $game)
			            	->where('idaction', '=', $action->idaction)
			            	->update(array(
			            		'status' => 2
			            	));
		            }

		            $action =DB::table('actions')
						->join('fighters', 'actions.idfighter', '=', 'fighters.idfighter')
		            	->where('actions.idgame', '=', $game)
		            	->where('fighters.idgame', '=', $game)
			            ->where('actions.idround', '=', $round->round)
			            ->where('actions.status', '=', 0)
			            ->orderBy('actions.turn','asc')
			            ->orderBy('actions.order','asc')
				        ->first();
		        }
			}
		}
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
