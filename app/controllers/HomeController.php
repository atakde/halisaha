<?php

class HomeController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function home()
	{
		$model = new FootballMatch();
		$data = [];
		$data['lastMatch'] = $model->getLastMatch();
		$this->view->render('home/index', $data);
	}
}
