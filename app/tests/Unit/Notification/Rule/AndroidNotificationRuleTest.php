<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Device;
use PHPUnit\Framework\TestCase;
use App\Service\Notification\Rule\AndroidNotificationRule;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Attributes\DataProvider;

class AndroidNotificationRuleTest extends TestCase
{
    #[DataProvider('userProvider')]
    public function testSupports(
        bool $hasAndroidDevice,
        bool $isPremium,
        string $countryCode,
        \DateTimeImmutable $lastActiveAt,
        bool $expected
    ): void {
        $user = $this->createMock(User::class);

        $device = $this->createMock(Device::class);
        $device->method('getPlatform')->willReturn($hasAndroidDevice ? 'android' : 'ios');

        $user->method('getDevices')->willReturn(new ArrayCollection([$device]));
        $user->method('isPremium')->willReturn($isPremium);
        $user->method('getCountryCode')->willReturn($countryCode);
        $user->method('getLastActiveAt')->willReturn($lastActiveAt);

        $rule = new AndroidNotificationRule();
        $this->assertSame($expected, $rule->supports($user));
    }

    public static function userProvider(): array
    {
        $tenDaysAgo = new \DateTimeImmutable('-10 days');
        $twoDaysAgo = new \DateTimeImmutable('-2 days');

        return [
            'eligible user' => [false, false, 'ES', $tenDaysAgo, true],
            'premium user' => [false, true, 'ES', $tenDaysAgo, false],
            'has Android device' => [true, false, 'ES', $tenDaysAgo, false],
            'wrong country' => [false, false, 'FR', $tenDaysAgo, false],
            'last active too recent' => [false, false, 'ES', $twoDaysAgo, false],
        ];
    }
}
