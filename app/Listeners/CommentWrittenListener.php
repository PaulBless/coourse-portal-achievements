<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentWrittenListener 
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentWritten $event)
    {
        //
        $user = $event->user;
        $commentCount = $event->commentCount;

        // Check if the user has unlocked any comment-related achievements
        $achievementsToUnlock = config('achievements.comment_achievements');
        $unlockedAchievements = $user->achievements->pluck('achievement_name')->toArray();

        foreach ($achievementsToUnlock as $achievement) {
            if (!in_array($achievement, $unlockedAchievements) && $commentCount >= $requiredCommentCount) {
                // Unlock the achievement
                $user->achievements()->create(['achievement_name' => $achievement]);

                // Fire the AchievementUnlocked event
                event(new AchievementUnlocked($achievement, $user));
            }
        }
    }
}
