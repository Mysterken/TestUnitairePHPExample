<?php

namespace App\Repository;

use App\User;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct(string $dsn = 'sqlite:/app/data.db')
    {
        $this->pdo = new PDO($dsn);
    }

    public function createTable(): void
    {
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS user (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )');
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM user');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOneById(int $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function findOneByName(string $name)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE name = :name');
        $stmt->execute([':name' => $name]);
        return $stmt->fetch();
    }

    public function add(User $user): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
        $stmt->execute([
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM user WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function update(User $user): void
    {
        $stmt = $this->pdo->prepare('UPDATE user SET name = :name, email = :email, password = :password WHERE id = :id');
        $stmt->execute([
            ':id' => $user->getId(),
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
        ]);
    }
}