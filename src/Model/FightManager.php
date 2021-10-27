<?php

namespace App\Model;

class FightManager extends AbstractManager
{
    public const TABLE = 'fight';

        /**
     * Insert new item in database
     */
    public function insert(array $fight): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`date`, `winner`) VALUES (:date, :winner)");
        $statement->bindValue('date', $fight['date'], \PDO::PARAM_STR);
        $statement->bindValue('winner', $fight['winner'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
