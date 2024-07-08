<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenAI\Client;
use App\Models\User;
use Carbon\Carbon;

class DetectNewUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatgpt:detect-new-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detect new users created in the last 24 hours using OpenAI GPT';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Client $client)
    {
        $users = User::where('created_at', '>=', Carbon::now()->subDay())->get();

        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant.',
                ],
                [
                    'role' => 'user',
                    'content' => 'Detect the new users created in the last 24 hours from the following data: ' . $users->toJson(),
                ],
            ],
        ]);

        $this->info($response['choices'][0]['message']['content']);

        return 0;
    }
}
