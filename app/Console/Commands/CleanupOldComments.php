<?php

namespace App\Console\Commands;

use App\Models\Comment;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CleanupOldComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:cleanup {--days=30 : Number of days to keep comments}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old comments that have no replies and are older than specified days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        // Find comments older than cutoff date with no replies and empty content
        $oldComments = Comment::where('created_at', '<', $cutoffDate)
            ->where(function ($query) {
                $query->whereNull('content')
                      ->orWhere('content', '')
                      ->orWhere('content', 'like', '%deleted%');
            })
            ->whereDoesntHave('replies')
            ->get();

        $count = $oldComments->count();

        if ($count === 0) {
            $this->info('No old comments found to cleanup.');
            return;
        }

        $this->info("Found {$count} old comments to cleanup...");

        foreach ($oldComments as $comment) {
            $this->line("Deleting comment ID: {$comment->id} from post: {$comment->post->title}");
            $comment->delete();
        }

        $this->info("Successfully cleaned up {$count} old comments.");
        
        // Log the cleanup activity
        Log::info("Cleaned up {$count} old comments older than {$days} days", [
            'command' => 'comments:cleanup',
            'days' => $days,
            'count' => $count,
            'timestamp' => now()
        ]);
    }
}
