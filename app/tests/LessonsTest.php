<?php

class LessonsTest extends ApiTester {

	use Factory;

	/** @test */
	public function it_fetches_lessons(){

		$this->times(3)->make('Lesson');

		$this->getJson('api/v1/lessons');

		$this->assertResponseOk();
	}

	protected function getStub(){

		return [
			'title' => $this->fake->sentence,
			'body' => $this->fake->paragraph,
			'some_bool' => $this->fake->boolean
		];
	}


	/** @test */
	public function it_fetches_a_single_lesson(){
		$this->make('Lesson');

		$lesson = $this->getJson('api/v1/lessons/1')->data;

		$this->assertResponseOk();
		$this->assertObjectHasAttributes($lesson, 'body', 'active');

	}

	/** @test */
	public function it_404s_if_a_lesson_is_not_found(){

		$json = $lesson = $this->getJson('api/v1/lessons/x');

		$this->assertResponseStatus(404);

		$this->assertObjectHasAttributes($json, 'error');

	}

	/** @test */
	public function it_creates_a_new_lesson_given_valid_parameters(){

		$this->getJson('api/v1/lessons', 'POST', $this->getStub());

		$this->assertResponseStatus(201);
	}

	/** @test */
	public function it_throws_a_422_if_a_new_lesson_request_fails_validation(){

		$this->getJson('api/v1/lessons', 'POST');

		$this->assertResponseStatus(422);

	}
}
