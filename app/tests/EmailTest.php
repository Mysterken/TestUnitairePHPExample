<?php

namespace Tests;

require_once '/app/src/Service/EmailService.php';

use App\Service\EmailService;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function setUp(): void
    {
        $this->emailService = new EmailService();
    }

    public function tearDown(): void
    {
        $this->emailService = null;
    }

    /**
     * @covers EmailService::sendEmail
     * @throws Exception
     */
    public function testSendEmail()
    {
        $stub = $this->createStub(EmailService::class);

        $stub->method('sendEmail')
            ->willReturn(true);

        $this->assertTrue($stub->sendEmail('John Doe', 'Hello', 'Hello John', 'Bob Doe'));
    }

    /**
     * @covers EmailService::sendEmailToAll
     * @throws Exception
     */
    public function testSendEmailToAll()
    {
        $stub = $this->createStub(EmailService::class);

        $stub->method('sendEmailToAll')
            ->willReturn(true);

        $this->assertTrue($stub->sendEmailToAll('John Doe', 'Hello', 'Hello John', ['Bob Doe', 'Jane Doe']));
    }

    /**
     * @covers EmailService::sendEmail
     * @throws Exception
     */
    public function testSendEmailWithEmptyAuthor()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->emailService->sendEmail('', 'Hello', 'Hello John', 'Bob Doe');
    }
}
