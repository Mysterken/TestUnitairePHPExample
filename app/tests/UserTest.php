<?php

namespace Tests;

require_once '/app/src/User.php';
require_once '/app/src/Service/UserService.php';
require_once '/app/src/Repository/UserRepository.php';
require_once '/app/src/CustomException/EmailNotSentException.php';

use App\Service\EmailService;
use App\Service\UserService;
use InvalidArgumentException;
use App\CustomException\EmailNotSentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{

    public function setUp(): void
    {
        $this->userService = new UserService('sqlite::memory:');
        $this->userService->createTable();
    }

    public function tearDown(): void
    {
        $this->userService = null;
    }

    /**
     * @covers UserService::getAllUsers
     */
    public function testGetAllUsers(): void
    {
        $users = $this->userService->getAllUsers();

        $this->assertIsArray($users);
    }

    /**
     * @covers UserService::getUserByName
     * @throws EmailNotSentException
     */
    public function testGetUserByName(): void
    {
        $user = $this->userService->getUserByName('bob');

        $this->assertFalse($user);

        $this->userService->addUser('bob', 'bob@email.com', 'bob12345');

        $user = $this->userService->getUserByName('bob');

        $this->assertIsArray($user);
        $this->assertEquals('bob', $user['name']);
    }

    /**
     * @covers UserService::addUser
     * @throws EmailNotSentException
     * @throws Exception
     */
    public function testAddUser(): void
    {
        $stub = $this->createStub(EmailService::class);

        $stub->method('sendEmail')
            ->willReturn(true);

        $this->userService->addUser('test', 'test@mail.com', 'test12345');

        $user = $this->userService->getUserByName('test');
        $this->assertIsArray($user);
        $this->assertEquals('test', $user['name']);

        $this->assertTrue($stub->sendEmail('admin', 'New user', 'A new user has been created', 'admin'));
    }

    /**
     * @covers UserService::addUser
     * @throws EmailNotSentException|Exception
     */
    public function testAddUserEmailNotSentException(): void
    {
        $mock = $this->createMock(EmailService::class);

        $mock
            ->expects($this->once())
            ->method('sendEmail')
            ->with(
                $this->equalTo('admin'),
                $this->equalTo('New user'),
                $this->equalTo('A new user has been created'),
                $this->equalTo('admin')
            )
            ->willReturn(false);

        $this->expectException(EmailNotSentException::class);

        $this->userService->setEmailService($mock);

        $this->userService->addUser('test', 'test@mail.com', 'test12345');
    }

    /**
     * @covers UserService::deleteUser
     * @throws EmailNotSentException
     */
    public function testDeleteUser(): void
    {
        $users = $this->userService->getAllUsers();
        $this->assertIsArray($users);
        $this->assertCount(0, $users);

        $this->userService->addUser('test', 'test@mail.com', 'test12345');

        $users = $this->userService->getAllUsers();
        $this->assertIsArray($users);
        $this->assertCount(1, $users);

        $this->userService->deleteUser($users[0]['id']);

        $users = $this->userService->getAllUsers();
        $this->assertIsArray($users);
        $this->assertCount(0, $users);
    }

    /**
     * @covers UserService::getUserById
     * @throws EmailNotSentException
     */
    public function testGetUserById(): void
    {
        $user = $this->userService->getUserById(1);
        $this->assertFalse($user);

        $this->userService->addUser('test', 'test@mail.com', 'test12345');

        $user = $this->userService->getUserById(1);
        $this->assertIsArray($user);
        $this->assertEquals('test', $user['name']);
    }

    /**
     * @covers UserService::updateUser
     * @throws EmailNotSentException
     */
    public function testUpdateUser(): void
    {
        $this->userService->addUser('test', 'test@mail.com', 'test12345');

        $user = $this->userService->getUserById(1);
        $this->assertIsArray($user);
        $this->assertEquals('test', $user['name']);

        $this->userService->updateUser(1, 'test2', 'test@mail.com', 'test12345');

        $user = $this->userService->getUserById(1);
        $this->assertIsArray($user);
        $this->assertEquals('test2', $user['name']);
    }

    /**
     * @covers UserService::addUser
     * @throws EmailNotSentException
     */
    public function testAddUserWithInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email must be valid');

        $this->userService->addUser('test', 'test', 'test12345');
    }

    /**
     * @covers UserService::addUser
     * @throws EmailNotSentException
     */
    public function testAddUserWithInvalidPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must be at least 8 characters');

        $this->userService->addUser('test', 'test@mail.com', 't123');
    }

    /**
     * @covers UserService::addUser
     * @throws EmailNotSentException
     */
    public function testAddUserWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Name must be no more than 50 characters');

        $this->userService->addUser('testg6TAifpnq5wf8Tmh9fNZbHoJqgAvuig4I0jLBrfts4CqoIvUuB', 'test@mail.com', 'test12345');
    }

    /**
     * @covers UserService::addUser
     * @throws EmailNotSentException
     */
    public function testAddUserWithEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value must not be empty');

        $this->userService->addUser('', 'test', 'test12345');
    }

    /**
     * @covers UserService::addUser
     * @throws EmailNotSentException
     */
    public function testAddUserWithEmptyEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value must not be empty');

        $this->userService->addUser('test', '', 'test12345');
    }

    /**
     * @covers UserService::addUser
     * @throws EmailNotSentException
     */
    public function testAddUserWithEmptyPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value must not be empty');

        $this->userService->addUser('test', 'test@mail.com', '');
    }


}
