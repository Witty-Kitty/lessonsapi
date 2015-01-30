<?php

use Illuminate\Pagination\Paginator;

class ApiController extends BaseController{

	const HTTP_NOT_FOUND = 404;
	protected $statusCode = 200;

	public function getStatusCode(){

		return $this->statusCode;

	}

	public function setStatusCode($statusCode){

		$this->statusCode = $statusCode;

		return $this;
	}


	public function respondNotFound($message = 'Not Found!'){

		return $this->setStatusCode(self::HTTP_NOT_FOUND)->respondWithError($message); 
	
	}


	public function respond($data, $headers = []){

		return Response::json($data, $this->getStatusCode(), $headers);
	}


	public function respondWithError($message){

		return $this->respond([
				'error' => [
					'message' => $message,
					'statusCode' => $this->getStatusCode()
				]
			]); 

	}

	protected function respondCreated($message)
{
	return $this->setStatusCode(201)->respond([

			'message' => $message
		]);
}

	protected function respondWithPagination(Paginator $lessons, $data){

		$data = array_merge($data, [
			'paginator' => [
					'total_count' => $lessons->getTotal(),
					'total_pages' =>  ceil($lessons->getTotal() / $lessons->getPerPage()),
					'current_page' => $lessons->getCurrentPage(),
					'limit' => $lessons->getPerPage(),
			]
			]);
	 return $this->respond($data); 

}
}