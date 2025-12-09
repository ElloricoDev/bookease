<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BorrowedBook;
use App\Models\LateFeeSetting;
use Carbon\Carbon;

class CalculateLateFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:calculate-late-fees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and update late fees for overdue books';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = LateFeeSetting::getActive();
        
        if (!$settings) {
            $this->error('Late fee settings not found.');
            return 1;
        }

        $overdueBooks = BorrowedBook::whereNull('returned_at')
            ->where('due_date', '<', Carbon::now())
            ->get();

        $updated = 0;
        foreach ($overdueBooks as $borrowed) {
            $daysOverdue = $borrowed->daysOverdue();
            $calculatedFee = $settings->calculateLateFee($daysOverdue);
            
            if ($borrowed->late_fee != $calculatedFee) {
                $borrowed->update([
                    'late_fee' => $calculatedFee,
                    'borrow_status' => 'overdue',
                ]);
                $updated++;
            }
        }

        $this->info("Updated late fees for {$updated} overdue books.");
        return 0;
    }
}
