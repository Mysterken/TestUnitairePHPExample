<?php

namespace App;

use InvalidArgumentException;

class User
{
    private string $name;
    private string $email;
    private string $password;

    public function __construct(
        private int $id = 0,
    )
    {
    }

    private function checkNotEmpty(string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Value must not be empty');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->checkNotEmpty($name);

        if (strlen($name) > 50) {
            throw new InvalidArgumentException('Name must be no more than 50 characters');
        }

        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->checkNotEmpty($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email must be valid');
        }

        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->checkNotEmpty($password);

        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters');
        }

        $this->password = $password;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }


}