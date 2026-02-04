<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Notification;

use PHPUnit\Framework\TestCase;
use App\Service\Notification\NotificationService;
use App\Service\Notification\Rule\NotificationRuleInterface;
use App\Response\Notification\Notification;
use App\Entity\User;
use App\Repository\UserRepository;
use Exception;

class NotificationServiceTest extends TestCase
{
    public function testGetUserNotificationsReturnsNotifications(): void
    {
        $userId = 1;
        $user = $this->createMock(User::class);

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('find')->with($userId)->willReturn($user);

        $notification = new Notification();
        $notification->setTitle('Title 1');
        $notification->setDescription('Description 1');
        $notification->setCtaUrl('https://example.com/1');

        $rule1 = $this->createMock(NotificationRuleInterface::class);
        $rule1->method('supports')->with($user)->willReturn(true);
        $rule1->method('build')->willReturn($notification);

        $rule2 = $this->createMock(NotificationRuleInterface::class);
        $rule2->method('supports')->with($user)->willReturn(false);

        $service = new NotificationService($userRepository, [$rule1, $rule2]);

        $notifications = $service->getUserNotifications($userId);

        $this->assertCount(1, $notifications);
        $this->assertInstanceOf(Notification::class, $notifications[0]);
        $this->assertSame('Title 1', $notifications[0]->getTitle());
        $this->assertSame('Description 1', $notifications[0]->getDescription());
        $this->assertSame('https://example.com/1', $notifications[0]->getCtaUrl());
    }

    public function testGetUserNotificationsThrowsExceptionIfUserNotFound(): void
    {
        $userId = 42;

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('find')->with($userId)->willReturn(null);

        $service = new NotificationService($userRepository, []);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("User $userId not found.");

        $service->getUserNotifications($userId);
    }
}
