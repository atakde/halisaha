<?php

class FootballMatch
{
    public function getAllMatches(): array
    {
        $db = Database::getFactory()->getConnection();
        $query = $db->prepare("SELECT * FROM matches");
        $query->execute();

        $results = $query->fetchAll(\PDO::FETCH_ASSOC);

        return count($results) > 0 ? $results : [];
    }

    private function destroyMatch(int $id): bool
    {
        $db = Database::getFactory()->getConnection();

        $updateQuery = $db->prepare("UPDATE matches SET status = -1 WHERE id = :id LIMIT 1");
        $updateQuery->bindParam(':id', $id);
        return $updateQuery->execute();
    }

    public function getLastMatch(): array
    {
        $db = Database::getFactory()->getConnection();
        $query = $db->prepare("SELECT * FROM matches WHERE status != -1 ORDER BY created_at DESC LIMIT 1;");
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        if (!empty($result)) {
            $now = date("Y-m-d H:i:s");
            if ($result['status'] == 0 && $now >= $result['match_date'] && $this->destroyMatch(intval($result['id']))) {
                return [];
            }

            $query = $db->prepare("SELECT * FROM players WHERE match_id = :id ORDER BY created_at ASC");
            $query->bindParam(':id', $result['id']);
            $query->execute();

            $playerResult = $query->fetchAll(\PDO::FETCH_ASSOC);
            $result['players'] =  count($playerResult) > 0 ? $playerResult : [];

            return $result;
        }

        return [];
    }

    public function addMatch(array $params): bool
    {
        $db = Database::getFactory()->getConnection();
        $query = $db->prepare("INSERT INTO matches (match_title, match_location, participant_limit, match_date) VALUES (:match_title, :match_location, :participant_limit, :match_date)");
        $query->bindParam(':match_title', strip_tags($params['match_title']));
        $query->bindParam(':match_location', strip_tags($params['match_location']));
        $query->bindParam(':participant_limit', $params['participant_limit']);
        $query->bindParam(':match_date', $params['match_date']);

        return $query->execute();
    }

    private function getMatchById(int $id)
    {
        $db = Database::getFactory()->getConnection();
        $matchQuery = $db->prepare("SELECT * FROM matches WHERE id = :match_id");
        $matchQuery->bindParam(':match_id', $id);
        $matchQuery->execute();

        return $matchQuery->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteMatch(int $id): bool
    {
        $db = Database::getFactory()->getConnection();
        $query = $db->prepare("DELETE FROM matches WHERE id = :id");
        $query->bindParam(':id', $id);

        return $query->execute();
    }

    public function deletePlayer(int $matchId, int $playerId): bool
    {
        $matchResult = $this->getMatchById($matchId);
        if ($matchResult) {
            $db = Database::getFactory()->getConnection();
            $query = $db->prepare("DELETE FROM players WHERE match_id = :matchId AND id = :playerId");
            $query->bindParam(':matchId', $matchId);
            $query->bindParam(':playerId', $playerId);

            $deleteResult = $query->execute();
            if ($deleteResult) {
                $status = (intval($matchResult['participant_count']) - 1 < intval($matchResult['participant_limit'])) ? 1 : 0; // 0 closed 1 open
                $updateQuery = $db->prepare("UPDATE matches SET participant_count = participant_count - 1, status = :status WHERE id = :match_id");
                $updateQuery->bindParam(':status', $status);
                $updateQuery->bindParam(':match_id', $matchId);
                $updateRes = $updateQuery->execute();

                if ($updateRes) {
                    return true;
                }
            }
        }

        return false;
    }

    public function addPlayer(array $params): bool
    {
        $matchResult = $this->getMatchById($params['match_id']);
        if ($matchResult) {

            if (intval($matchResult['participant_count']) >= intval($matchResult['participant_limit'])) {
                return false;
            }

            $db = Database::getFactory()->getConnection();
            $query = $db->prepare("INSERT INTO players (name, match_id) VALUES (:name, :match_id)");
            $query->bindParam(':name', strip_tags($params['name']));
            $query->bindParam(':match_id', $params['match_id']);
            $insertResult = $query->execute();

            if ($insertResult) {
                $status = (intval($matchResult['participant_count']) + 1 === intval($matchResult['participant_limit'])) ? 0 : 1; // 0 closed 1 open
                $updateQuery = $db->prepare("UPDATE matches SET participant_count = participant_count + 1, status = :status WHERE id = :match_id");
                $updateQuery->bindParam(':status', $status);
                $updateQuery->bindParam(':match_id', $params['match_id']);
                $updateRes = $updateQuery->execute();

                if ($updateRes) {
                    return true;
                }
            }
        }

        return false;
    }
}
