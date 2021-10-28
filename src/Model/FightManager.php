<?php

namespace App\Model;

class FightManager extends AbstractManager
{
    public const TABLE = 'fight';
    public const JOINTABLE = 'fighter';

    public function insert(array $fight): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (date, winner) VALUES (:date, :winner)");
        $statement->bindValue('date', $fight['date'], \PDO::PARAM_STR);
        $statement->bindValue('winner', $fight['winner'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query =
        'SELECT * FROM ' . static::TABLE .
        ' JOIN ' . static::JOINTABLE . ' ON ' . static::JOINTABLE .
        '.id=' . static::TABLE . ".id;";
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }
}
