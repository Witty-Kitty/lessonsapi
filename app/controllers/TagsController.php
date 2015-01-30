<?php

use Acme\Transformers\TagTransformer;

class TagsController extends ApiController {

	protected $tagTransformer;

	function __construct(TagTransformer $tagTransformer){

		$this->tagTransformer = $tagTransformer;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($lessonId = null)
	{
		
		$tags = $this->getTags($lessonId);

		return $this->respond([
			'data' => $this->tagTransformer->transformCollection($tags->all())
		]);
	}


	public function getTags($lessonId){
		return $lessonId ? Lesson::findOrFail($lessonId)->tags : Tag::all();

	}


}
