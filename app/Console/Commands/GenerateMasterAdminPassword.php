<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateMasterAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master-admin:password {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily password for Master Admin access';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->argument('date');
        
        if ($date) {
            try {
                $dateObj = \Carbon\Carbon::createFromFormat('d/m/Y', $date);
            } catch (\Exception $e) {
                $this->error('Invalid date format. Use: d/m/Y (e.g., 3/5/2026)');
                return Command::FAILURE;
            }
        } else {
            $dateObj = now();
        }
        
        $dateString = 'hong' . $dateObj->day . '/' . $dateObj->month . '/' . $dateObj->year;
        $password = md5($dateString);
        
        $this->info('Master Admin Password Information:');
        $this->line('');
        $this->line('Date: ' . $dateObj->format('d/m/Y'));
        $this->line('String to hash: ' . $dateString);
        $this->line('Password: ' . $password);
        $this->line('');
        $this->line('URL Example:');
        $this->line(config('app.url') . '/master-admin?pass=' . $password);
        $this->line(config('app.url') . '/master-admin/logs/view?pass=' . $password);
        
        return Command::SUCCESS;
    }
}