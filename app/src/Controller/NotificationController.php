<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Notification\NotificationService;
use Exception;

class NotificationController extends AbstractController
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    #[Route('/notifications', name: 'get_notifications', methods: ['GET'])]
    public function getNotifications(Request $request): JsonResponse
    {
        $userId = $request->query->get('user_id');

        if (!$userId) {
             return $this->json(['error' => 'Missing user_id'], 400);
        }

        try {
            return $this->json($this->notificationService->getUserNotifications((int)$userId));
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()], 404);
        }
    }
}
