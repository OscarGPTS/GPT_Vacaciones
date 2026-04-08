<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VacationCalculatorService;
use App\Models\User;

class CalculateVacationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacations:calculate 
                            {--user= : Calculate for specific user ID} 
                            {--all : Calculate for all users} 
                            {--force : Force recalculation even if records exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate vacation days for users based on their admission date and company policy';

    /**
     * Execute the console command.
     */
    public function handle(VacationCalculatorService $calculator)
    {
        $this->info('Starting vacation calculation...');

        $userId = $this->option('user');
        $all = $this->option('all');
        $force = $this->option('force');

        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return Command::FAILURE;
            }

            $this->info("Calculating vacations for user: {$user->first_name} {$user->last_name}");
            $result = $calculator->calculateVacationsForUser($user);

            if ($result['success']) {
                $this->info($result['message']);
                $this->table(
                    ['Type', 'Records Created'],
                    [
                        ['Historical', count($result['data']['historical'] ?? [])],
                        ['Current', count($result['data']['current'] ?? [])]
                    ]
                );
            } else {
                $this->error($result['message']);
                return Command::FAILURE;
            }

        } elseif ($all) {
            $this->info('Calculating vacations for all users...');

            // Recalcular todos los usuarios
            $results = $calculator->recalculateAllUsers();

            $this->info("Calculation completed!");
            $this->table(
                ['Status', 'Count'],
                [
                    ['Success', $results['success']],
                    ['Failed', $results['failed']]
                ]
            );

            if (count($results['errors']) > 0) {
                $this->error('Errors occurred:');
                foreach ($results['errors'] as $error) {
                    $this->line("User ID {$error['user_id']}: {$error['message']}");
                }
            }

            // Resumen de registros históricos y actuales
            $historicalCount = 0;
            $currentCount = 0;

            User::whereHas('job')->chunk(100, function ($users) use (&$historicalCount, &$currentCount) {
                foreach ($users as $user) {
                    $historicalCount += \App\Models\VacationsAvailable::where('users_id', $user->id)
                        ->where('is_historical', true)->count();
                    $currentCount += \App\Models\VacationsAvailable::where('users_id', $user->id)
                        ->where('is_historical', false)->count();
                }
            });

            $this->info('Summary of records:');
            $this->table(
                ['Type', 'Total Records'],
                [
                    ['Historical', $historicalCount],
                    ['Current', $currentCount]
                ]
            );

        } else {
            $this->error('Please specify --user=ID or --all option.');
            return Command::FAILURE;
        }

        $this->info('Vacation calculation finished successfully!');
        return Command::SUCCESS;
    }
}