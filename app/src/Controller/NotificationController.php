<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Notification\NotificationService;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class NotificationController extends AbstractController
{
    #[Route('/notifications', name: 'get_notifications', methods: ['GET'])]
    public function getNotifications(
        NotificationService $notificationService,
        #[MapQueryParameter('user_id')] int $userId,
    ): JsonResponse {
        return $this->json($notificationService->getUserNotifications((int)$userId));
    }
}
