<?php

use Acme\Transformers\LessonTransformer;

class LessonsController extends ApiController {

	/**
	*	@var Acme\Transformers\LessonTransformer
	*/

	protected $lessonTransformer;

	function __construct(LessonTransformer $lessonTransformer){

		$this->lessonTransformer = $lessonTransformer;

		$this->beforeFilter('auth.basic', ['on' => 'post']);
	}

public function index() {

	if(Input::get('showall'))
	{
		$lessons = Lesson::all();

		return $this->respond([
			'data' => $this->lessonTransformer->transformCollection($lessons),
		]);

	}

	$limit = Input::get('limit') ?: 3;

	$lessons = Lesson::paginate($limit);

	return $this->respondWithPagination($lessons, [
			'data' => $this->lessonTransformer->transformPaginator($lessons),
		]);

	

}



public function show($id){

	$lesson = Lesson::find($id);

	if (! $lesson)
	{
		return $this->respondNotFound('Lesson does not exist.');
	}

	return $this->respond([

		'data' => $this->lessonTransformer->transform($lesson)

		]);
}

public function store(){
	
	if(! Input::get('title') or ! Input::get('body')){

		return $this->setStatusCode(422)
					->respondWithError('Parameters failed validation for a lesson.');
	}

	Lesson::create(Input::all());

	return $this->respondCreated('Lesson Successfully Created!');

}

}
