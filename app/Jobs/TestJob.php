<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class testJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ?User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger()->info("...........LOG FROM JOB............");
        logger()->info("...........CREATING USER............");

        logger()->info("...........INJECTED USER {$this->user->name}");

        $user = User::factory()->create();

        logger()->info("USER WAS CREATED: ", ["USER" => $user->toArray()]);
        logger()->info("...........ENDING JOB............");
    }
}