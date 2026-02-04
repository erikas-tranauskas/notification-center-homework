<?php

declare(strict_types=1);

namespace App\Service\Notification;

use App\Repository\UserRepository;
use App\Response\Notification\Notification;
use Exception;

class NotificationService
{
    /** @param iterable<NotificationRuleInterface> $rules */
    public function __construct(
        private UserRepository $userRepository,
        private iterable $rules
    ) {}

    /** @return Notification[] */
    public function getUserNotifications(int $userId): array
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new Exception("User $userId not found.");
        }

        $notifications = [];
        foreach ($this->rules as $rule) {
            if ($rule->supports($user)) {
                $notifications[] = $rule->build();
            }
        }

        return $notifications;
    }
}
