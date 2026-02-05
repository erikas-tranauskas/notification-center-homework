<?php

declare(strict_types=1);

namespace App\Service\Notification;

use App\Repository\UserRepository;
use App\Response\Notification\Notification;
use App\Exception\UserNotFoundException;

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
            throw new UserNotFoundException($userId);
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
