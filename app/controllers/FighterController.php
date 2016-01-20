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
	public function get_all($game){
		
			$response =DB::table('fighters')
                ->where('idgame', '=', $game)
	            ->get();
	        if(!$response){
              	return [];
            }else
            	return $response;
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
