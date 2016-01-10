<?php

class TimelineController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return Response::json(array('output' => $this->getTimeline()));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return array
	 */
    public function getTimeline(){
		if (Session::has('admin')){
			$user = Session::get('user');
			$round =DB::table('rounds')
	                ->where('idgame', '=', Input::get('game'))
	                ->where('status', '=', 1)
		            ->first();
			if($round){
				$response =DB::table('timeline')
	                ->where('idgame', '=', Input::get('game'))
	                ->where('idround', '=', $round->round)
	                ->orderBy('turn','asc')
		            ->orderBy('order','asc')
		            ->get();
			}else{
				$response =DB::table('timeline')
	                ->where('idgame', '=', Input::get('game'))
	                ->orderBy('turn','asc')
		            ->orderBy('order','asc')
		            ->get();
			}
			if(!$response){
              	return 'no actions';
            }else
				return $response;
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($action)
	{
		//
		if (Session::has('admin')){
              	$idaction = DB::table('timeline')->insertGetId(
					array(
						'idaction' => $action->idaction, 
						'idgame' => $action->idgame, 
						'idround' => $action->idround,
						'iduser' => $action->iduser,
						'idfighter' => $action->idfighter,
						'target' => $action->target,
						'order' => $action->order,
						'turn' => $action->turn,
						'status' => $action->status,
						'damage' => $action->damage,
						'critical' => $action->critical,
						'effective' =>  $action->effective,
						'name' => $action->name,
						'type' => $action->type,
						'idclass' => $action->idclass,
						'hp' => $action->hp,
						'color' => $action->color,
						'killspeech' => $action->killspeech,
						'gender' => $action->gender,
						'classhp' => $action->classhp,
						'target_idfighter' => $action->target_fighter->idfighter,
						'target_name' => $action->target_fighter->name,
						'target_iduser' => $action->target_fighter->iduser,
						'target_idgame' => $action->target_fighter->idgame,
						'target_type' => $action->target_fighter->type,
						'target_idclass' => $action->target_fighter->idclass,
						'target_hp' => $action->target_fighter->hp,
						'target_status' => $action->target_fighter->status,
						'target_color' => $action->target_fighter->color,
						'target_lastwords' => $action->target_fighter->lastwords,
						'target_gender' => $action->target_fighter->gender,
						'target_classhp' => $action->target_fighter->classhp
					)
				);
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
