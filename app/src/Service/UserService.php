<?php

namespace App\Service;


use App\CustomException\EmailNotSentException;
use App\Repository\UserRepository;
use App\User;

class UserService
{
    private UserRepository $userRepository;
    private EmailService $emailService;

    public function __construct(
        string $dsn = 'sqlite:/app/data.db'
    ) {
        $this->userRepository = new UserRepository($dsn);
        $this->emailService = new EmailService();
    }

    public function setEmailService($emailService): void
    {
        $this->emailService = $emailService;
    }

    public function createTable(): void
    {
        $this->userRepository->createTable();
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->findOneById($id);
    }

    public function getUserByName(string $name)
    {
        return $this->userRepository->findOneByName($name);
    }

    /**
     * @throws EmailNotSentException
     */
    public function addUser(string $name, string $email, string $password): void
    {
        $user = new User();
        $user
            ->setName($name)
            ->setEmail($email)
            ->setPassword($password);

        $this->userRepository->add($user);

        $emailSent = $this->emailService->sendEmail('admin', 'New user', 'A new user has been created', 'admin');

        if (!$emailSent) {
            throw new EmailNotSentException();
        }
    }

    public function deleteUser(int $id): void
    {
        $this->userRepository->delete($id);
    }

    public function updateUser(int $id, string $name, string $email, string $password): void
    {
        $user = new User();
        $user
            ->setId($id)
            ->setName($name)
            ->setEmail($email)
            ->setPassword($password);

        $this->userRepository->update($user);
    }
}