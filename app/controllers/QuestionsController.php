<?php

class QuestionsController extends \BaseController {

	/**
	 * Enable csrf authenticity on post
	 */
	public function __construct() {
		$this->beforeFilter('csrf', array('on' => ['post']));
	}

	/**
	 * Display a listing of the resource.
	 * GET /questions
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('questions.index')
			->withTitle('Make It Snappy Q&A - Home')
			->withQuestions(Question::unsolved());
	}


	/**
	 * Store a newly created question in storage.
	 * POST /create
	 *
	 * @return Response
	 */
	public function create()
	{
		$validator = Question::validate(Input::all());

		if ($validator->passes()) {
			Question::create(array(
					'question' => Input::get('question'),
					'user_id' => Auth::user()->id
			));

			return Redirect::route('home')
				->withMessage('Your question has been posted!');
		} else {
			return Redirect::route('home')
				->withErrors($validator)
				->withInput();
		}
	}

}