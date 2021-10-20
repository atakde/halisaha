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

		if (!$model->checkMatchSettings()) {
			$this->view->render('home/match-settings');
		} else {
			$data = [];
			$data['lastMatch'] = $model->getLastMatch();
			$this->view->render('home/index', $data);
		}
	}
}
