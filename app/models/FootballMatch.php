<?php

class FootballMatch extends Model
{
    public function getAllMatches(): array
    {
        $query = $this->db->prepare("SELECT * FROM matches");
        $query->execute();

        $results = $query->fetchAll(\PDO::FETCH_ASSOC);

        return count($results) > 0 ? $results : [];
    }

    private function destroyMatch(int $id): bool
    {

        $updateQuery = $this->db->prepare("UPDATE matches SET status = -1 WHERE id = :id");
        $updateQuery->bindParam(':id', $id);
        return $updateQuery->execute();
    }

    private function insertMatchSetting($key, $value): void
    {
        $query = $this->db->prepare("INSERT INTO settings (key, value) VALUES (:key, :value)");
        $query->bindParam(':key', $key);
        $query->bindParam(':value', $value);
        $query->execute();
    }

    private function getMatchSettings()
    {

        $query = $this->db->prepare("SELECT key, value FROM settings");
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        $returnArr = [];
        foreach ($result as $each) {
            $returnArr[$each['key']] = $each['value'];
        }

        return $returnArr;
    }

    private function isMatchSettingExists($key): bool
    {
        $query = $this->db->prepare("SELECT 1 FROM settings WHERE key = :key");
        $query->bindParam(':key', $key);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function checkMatchSettings(): bool
    {
        $keys = ['match_title', 'match_location', 'participant_limit', 'match_date'];
        foreach ($keys as $key) {
            if (!$this->isMatchSettingExists($key)) {
                return false;
            }
        }

        return true;
    }

    public function setMatchConfiguration($params)
    {
        foreach ($params as $key => $value) {
            $this->insertMatchSetting($key, $value);
        }
    }

    public function getLastMatch(): array
    {
        $query = $this->db->prepare("SELECT * FROM matches WHERE status != -1 ORDER BY created_at DESC LIMIT 1;");
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);
        $matchConfiguration = $this->getMatchSettings();
        if (!empty($result)) {
            $now = date("Y-m-d H:i:s");
            if ($now >= $result['match_date'] && $this->destroyMatch(intval($result['id']))) {
                $date = strtotime($result['match_date']);
                $date = strtotime('+7 day', $date);
                $this->addMatch([
                    'match_title' => $matchConfiguration['match_title'],
                    'match_location' => $matchConfiguration['match_location'],
                    'participant_limit' => (int) $matchConfiguration['participant_limit'] ?? 14,
                    'match_date' => date('Y-m-d H:i:s', $date)
                ]);

                return $this->getLastMatch();
            }

            $query = $this->db->prepare("SELECT * FROM players WHERE match_id = :id ORDER BY created_at ASC");
            $query->bindParam(':id', $result['id']);
            $query->execute();

            $playerResult = $query->fetchAll(\PDO::FETCH_ASSOC);
            $result['players'] =  count($playerResult) > 0 ? $playerResult : [];

            return $result;
        } else {
            $this->addMatch([
                'match_title' => $matchConfiguration['match_title'],
                'match_location' => $matchConfiguration['match_location'],
                'participant_limit' => (int) $matchConfiguration['participant_limit'] ?? 14,
                'match_date' => date('Y-m-d H:i:s', strtotime($matchConfiguration['match_date']))
            ]);
            return $this->getLastMatch();
        }
    }

    public function addMatch(array $params): bool
    {
        $query = $this->db->prepare("INSERT INTO matches (match_title, match_location, participant_limit, match_date) VALUES (:match_title, :match_location, :participant_limit, :match_date)");
        $query->bindParam(':match_title', $params['match_title']);
        $query->bindParam(':match_location', $params['match_location']);
        $query->bindParam(':participant_limit', $params['participant_limit']);
        $query->bindParam(':match_date', $params['match_date']);

        return $query->execute();
    }

    private function getMatchById(int $id)
    {
        $matchQuery = $this->db->prepare("SELECT * FROM matches WHERE id = :match_id");
        $matchQuery->bindParam(':match_id', $id);
        $matchQuery->execute();

        return $matchQuery->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteMatch(int $id): bool
    {
        $query = $this->db->prepare("DELETE FROM matches WHERE id = :id");
        $query->bindParam(':id', $id);

        return $query->execute();
    }

    public function updateMatch(array $params): bool
    {
        $updateQuery = $this->db->prepare("UPDATE matches SET match_title = :match_title, match_location = :match_location, match_date = :match_date, created_at = :created_at WHERE id = :match_id");
        $updateQuery->bindParam(':match_title', $params['match_title']);
        $updateQuery->bindParam(':match_location', $params['match_location']);
        $updateQuery->bindParam(':match_date', $params['match_date']);
        $updateQuery->bindParam(':created_at', $params['created_at']);
        $updateQuery->bindParam(':match_id', $params['match_id']);

        return $updateQuery->execute();
    }

    public function deletePlayer(int $matchId, int $playerId): bool
    {
        $matchResult = $this->getMatchById($matchId);
        if ($matchResult) {
            $query = $this->db->prepare("DELETE FROM players WHERE match_id = :matchId AND id = :playerId");
            $query->bindParam(':matchId', $matchId);
            $query->bindParam(':playerId', $playerId);

            $deleteResult = $query->execute();
            if ($deleteResult) {
                $status = (intval($matchResult['participant_count']) - 1 < intval($matchResult['participant_limit'])) ? 1 : 0; // 0 closed 1 open
                $updateQuery = $this->db->prepare("UPDATE matches SET participant_count = participant_count - 1, status = :status WHERE id = :match_id");
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

            $query = $this->db->prepare("INSERT INTO players (name, match_id, created_at) VALUES (:name, :match_id, :now)");
            $query->bindParam(':name', $params['name']);
            $query->bindParam(':match_id', $params['match_id']);
            $query->bindParam(':now', date('Y-m-d H:i:s'));
            $insertResult = $query->execute();

            if ($insertResult) {
                Logger::info('New player ' . $params['name'] . ' added. match id : ' . $params['match_id'] . '.');
                $status = (intval($matchResult['participant_count']) + 1 === intval($matchResult['participant_limit'])) ? 0 : 1; // 0 closed 1 open
                $updateQuery = $this->db->prepare("UPDATE matches SET participant_count = participant_count + 1, status = :status WHERE id = :match_id");
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
