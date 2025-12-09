<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BorrowedBook;
use App\Models\Notification;
use Carbon\Carbon;

class CheckOverdueBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue books and create notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueBooks = BorrowedBook::whereNull('returned_at')
            ->where('due_date', '<', Carbon::now())
            ->with(['book', 'user'])
            ->get();

        $notificationsCreated = 0;

        foreach ($overdueBooks as $borrowed) {
            // Check if notification already exists for this overdue book (today)
            $existingNotification = Notification::where('type', 'overdue')
                ->where('borrowed_book_id', $borrowed->id)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if (!$existingNotification) {
                $daysOverdue = $borrowed->daysOverdue();
                
                Notification::createNotification(
                    'overdue',
                    'Overdue Book Alert',
                    $borrowed->user->name . ' has an overdue book: "' . $borrowed->book->title . '" (' . $daysOverdue . ' day' . ($daysOverdue > 1 ? 's' : '') . ' overdue)',
                    null, // Admin notification
                    $borrowed->book_id,
                    $borrowed->id
                );

                $notificationsCreated++;
            }
        }

        $this->info("Created {$notificationsCreated} overdue book notifications.");
        return 0;
    }
}
