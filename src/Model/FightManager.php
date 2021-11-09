<?php

namespace App\Model;

use App\Entity\Fighter;

class FightManager extends AbstractManager
{
    public const TABLE = 'fight';
    public const JOINTABLE = 'fighter';

    public function insert(Fighter $currentWinner): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (winner) VALUES (:winner)");
        $statement->bindValue('winner', $currentWinner->getId(), \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query =
        'SELECT * FROM ' . static::TABLE .
        ' JOIN ' . static::JOINTABLE . ' ON ' . static::JOINTABLE .
        '.id=' . static::TABLE . '.winner';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        $query .= ' LIMIT 8;';

        return $this->pdo->query($query)->fetchAll();
    }
}
