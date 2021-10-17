<?php

class MatchController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function home()
	{
		$this->view->render('football/index');
	}

	public function addMatch()
	{
		$params = [];
		$params['match_title'] = Request::post('match_title', '');
		$params['match_location'] = Request::post('match_location', '');
		$params['participant_limit'] = Request::post('participant_limit', 0);
		$params['match_date'] = Request::post('match_date', false);
		return (new FootballMatch())->addMatch($params);
	}

	public function deleteMatch()
	{
		$id = Request::post('match_id');

		if (!$id) {
			$this->view->renderJson(['message' => 'Invalid parameters.'], 400);
		}

		return (new FootballMatch())->deleteMatch(intval($id));
	}

	public function getAllMatches()
	{
		$model = new FootballMatch();
		$results = $model->getAllMatches();

		$this->view->renderJson(['message' => 'success', 'content' => $results], 200);
	}

	public function getLastMatch()
	{
		$model = new FootballMatch();
		return $model->getLastMatch();
	}

	public function addPlayer()
	{
		$params = [];
		$params['name'] = Request::post('name', '');
		$params['match_id'] = Request::post('match_id');

		if (empty($params['name']) || !$params['match_id']) {
			$this->view->renderJson(['message' => 'Invalid params.'], 400);
		}

		$res = (new FootballMatch())->addPlayer($params);

		$this->view->renderJson(['message' => 'success', 'content' => $res], 200);
	}

	public function removePlayer()
	{
		$matchId = Request::post('match_id');
		$playerId = Request::post('player_id');

		if (!$matchId || !$playerId) {
			$this->view->renderJson(['message' => 'Invalid Params.'], 400);
		}

		$res = (new FootballMatch())->deletePlayer(intval($matchId), intval($playerId));

		$this->view->renderJson(['message' => 'success', 'content' => $res], 200);
	}
}
