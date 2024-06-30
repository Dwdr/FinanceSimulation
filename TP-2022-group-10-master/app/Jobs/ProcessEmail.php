<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email_data;


    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_data)
    {
        $this->email_data = $email_data;
    }

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle()
    {
        $response = Http::post(config('constants.EMAIL-API'), [
            'token' => '90cb2f4e-3eec-43c7-b7ae-bc45f755514a',
            'source_email' => $this->email_data['source_email'],
            'recipient_email' => $this->email_data['recipient_email'],
            'subject' => $this->email_data['subject'],
            'body' => $this->email_data['body'],
        ]);

        if($response->failed() || $response->clientError() || $response->serverError()){
            $response->throw();
        }
    }
}
