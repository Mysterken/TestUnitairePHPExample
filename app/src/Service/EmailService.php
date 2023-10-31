<?php

namespace App\Service;

use InvalidArgumentException;

require_once '/app/src/Service/EmailService.php';

class EmailService
{
    public function sendEmail(string $author, string $subject, string $content, string $receiver): bool
    {
        if (empty($author) || empty($subject) || empty($content) || empty($receiver)) {
            throw new InvalidArgumentException('Missing argument');
        }
        // Envoie un email
        return true;
    }


    /**
     * @codeCoverageIgnore
     */
    public function sendEmailToAll(string $author, string $subject, string $content, array $receivers): bool
    {
        if (empty($author) || empty($subject) || empty($content) || empty($receivers)) {
            throw new InvalidArgumentException('Missing argument');
        }
        // Envoie un email à tous les utilisateurs
        return true;
    }
}