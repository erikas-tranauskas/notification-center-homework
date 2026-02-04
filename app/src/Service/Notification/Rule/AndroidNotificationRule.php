<?php

declare(strict_types=1);

namespace App\Service\Notification\Rule;

use App\Entity\User;
use App\Response\Notification\Notification;
use App\Service\Notification\Rule\NotificationRuleInterface;

class AndroidNotificationRule implements NotificationRuleInterface
{
    private const PLATFORM_ANDROID = 'android';
    private const TARGET_COUNTRY = 'ES';
    private const INACTIVITY_DAYS = 7;

    public function supports(User $user): bool
    {
        $hasAndroidDevice = false;
        foreach ($user->getDevices() as $device) {
            if (strtolower($device->getPlatform()) === self::PLATFORM_ANDROID) {
                $hasAndroidDevice = true;
                break;
            }
        }

        return !$hasAndroidDevice
            && !$user->isPremium()
            && $user->getCountryCode() === self::TARGET_COUNTRY
            && $user->getLastActiveAt() < new \DateTimeImmutable('-' . self::INACTIVITY_DAYS . ' days');
    }

    public function build(): Notification
    {
        $notification = new Notification();
        $notification->setTitle('Configurar dispositivo Android');
        $notification->setDescription('Phasellus rhoncus ante dolor, at semper metus aliquam quis. Praesent finibus pharetra libero, ut feugiat mauris dapibus blandit. Donec sit.');
        $notification->setCtaUrl('https://trendos.com/');

        return $notification;
    }
}
