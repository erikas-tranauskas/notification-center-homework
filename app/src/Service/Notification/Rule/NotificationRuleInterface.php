<?php

declare(strict_types=1);

namespace App\Service\Notification\Rule;

use App\Entity\User;
use App\Response\Notification\Notification;

interface NotificationRuleInterface
{
    public function supports(User $user): bool;
    public function build(): Notification;
}
