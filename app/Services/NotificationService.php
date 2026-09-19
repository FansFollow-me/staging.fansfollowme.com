<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\User;

class NotificationService
{
    public function pushNotificationById(int $userId, string $type, string $title, ?string $body = null, array $data = []): AppNotification
    {
        $user = User::find($userId);
        if (! $user) {
            return AppNotification::create([
                'user_id' => $userId,
                'type' => $type,
                'title' => $title,
                'body' => $body,
                'data' => $data ?: null,
            ]);
        }

        return $this->push($user, $type, $title, $body, $data);
    }

    /** @deprecated alias kept for older call sites */
    public function pushNotificationTemp(int $userId, string $type, string $title, ?string $body = null, mixed $extra = null): AppNotification
    {
        return $this->pushNotificationById($userId, $type, $title, $body, is_array($extra) ? $extra : []);
    }

    public function push(User $user, string $type, string $title, ?string $body = null, array $data = []): AppNotification
    {
        return AppNotification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'data' => $data ?: null,
        ]);
    }
}
