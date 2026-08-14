<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log($userId, $role, $action, $module, $description, $recordId = null)
    {
        try {
            ActivityLog::create([
                'user_id' => (int)$userId,
                'user_role' => strtoupper($role),
                'action' => $action,
                'module' => $module,
                'description' => $description,
                'record_id' => $recordId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now()->toIso8601String(),
            ]);
        } catch (\Throwable $e) {
            // Log failure should not break application flow
            \Illuminate\Support\Facades\Log::error('ActivityLog failed: ' . $e->getMessage());
        }
    }
}
