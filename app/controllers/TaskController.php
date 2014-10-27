<?php

class TaskController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return Response::json(array('output' => $this->getTasks()));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return array
	 */
	public function getTasks(){
		if (Session::has('user')){
			$user = Session::get('user');
			$response =DB::table('tasks')
	            ->join('task_by_user', 'tasks.id', '=', 'task_by_user.task_id')
	            //->select('tasks.id', 'tasks.phone', 'tasks.price')
	            ->where('task_by_user.user_id', '=', $user->user_id)
	            ->where('tasks.task_status', '=', 1)
	            ->orderBy('task_by_user.position', 'asc')
	            ->get();
	        $len = count($response);
	        for($i=0; $i<$len; $i++){
	        	$response[$i]->items = DB::table('items')
	            	->where('task_id', '=', $response[$i]->id)
	            	->orderBy('position', 'asc')
	            	->get();
	        }
			return $response;
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
			$user = Session::get('user');

			$type = Input::get('taskType');

			if($type==1){
				$content = "";
			}else{
				$content = Input::get('content');
			}

			$task_id = DB::table('tasks')->insertGetId(
				array(
					'title' => Input::get('title'), 
					'content' => $content,
					'exp_date' => Input::get('expDate'),
					'task_type' => $type,
					'task_status' => 1
				)
			);

			$rows=DB::table('task_by_user')
			->where('user_id', '=', $user->user_id)
			->increment('position');

			DB::table('task_by_user')->insert(
				array('user_id' => $user->user_id, 'task_id' => $task_id, 'position' => 0)
			);

            if($type==1){
            	$listOptions = json_decode(json_encode(Input::get('listOptions')), FALSE);

				DB::table('items')->where('task_id', '=', $task_id)->delete();

				$len = count($listOptions);
				for($i = 0;$i<$len; $i++){
					DB::table('items')->insert(
						array('task_id' => $task_id, 'content' => $listOptions[$i]->text, 'checked' => $listOptions[$i]->checked, 'position' => $i)
					);
				}
			}
			return Response::json(array('output' => $this->getTasks(), 'other'=> "test"));
		}else
			return Response::json(array('output' => 'not logged'));
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
