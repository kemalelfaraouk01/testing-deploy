<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        if (Auth::guest()) return;

        foreach (static::getActivitiesToLog() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    public function recordActivity($event)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => $event,
            'subject_id' => $this->id,
            'subject_type' => get_class($this)
        ]);
    }

    protected static function getActivitiesToLog()
    {
        return ['created', 'updated']; // Aktivitas default yang akan dilacak
    }
}
