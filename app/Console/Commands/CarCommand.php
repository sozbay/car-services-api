<?php

namespace App\Console\Commands;

use App\Models\Car;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'car:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit',-1);
        Car::query()->truncate();
        try {
            $response = Http::get('https://static.novassets.com/automobile.json')->json();
            $this->output->progressStart(count($response['RECORDS']));
            foreach (array_chunk($response['RECORDS'], 50) as $cars) {
                $this->output->progressAdvance(50);
                Car::query()->insert($cars);
            }
            $this->output->progressFinish();
            return self::SUCCESS;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return self::FAILURE;
        }
    }
}
