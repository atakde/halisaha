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
		$params['match_title'] = Helper::filterXSS(Request::post('match_title', ''), true);
		$params['match_location'] = Helper::filterXSS(Request::post('match_location', ''), true);
		$params['participant_limit'] = Helper::filterXSS(Request::post('participant_limit', 0), true);
		$params['match_date'] = Helper::filterXSS(Request::post('match_date', false), true);

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

	public function setMatchConfiguration()
	{
		$params = [];
		$params['match_title'] = Helper::filterXSS(Request::post('match_title', ''), true);
		$params['match_location'] = Helper::filterXSS(Request::post('match_location', ''), true);
		$params['participant_limit'] = Helper::filterXSS(Request::post('participant_limit', 0), true);
		$params['match_date'] = Helper::filterXSS(Request::post('match_date', false), true);

		if (
			!is_numeric($params['participant_limit'])
			|| empty($params['match_title'])
			|| empty($params['match_date'])
			|| empty($params['match_location'])
		) {
			die("Invalid data.");
		}

		(new FootballMatch())->setMatchConfiguration($params);
		Header('Location: ' . Config::get('URL'));
	}

	public function addPlayer()
	{
		$params = [];
		$params['name'] = Helper::filterXSS(Request::post('name', ''), true);
		$params['match_id'] = Request::post('match_id');

		if (empty($params['name']) || !$params['match_id']) {
			$this->view->renderJson(['message' => 'Invalid params.'], 400);
		}

		$params['match_id'] = intval($params['match_id']);
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
