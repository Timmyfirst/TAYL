<?php

namespace App\Jobs;

use App\Notifications\TestedProcessEntity;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;
use Zttp\Zttp;
use Zttp\ZttpResponse;

class TestProcessEntity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Url Git to fetch
     *
     * @var string
     */
    private $urlGit;


    /**
     * Create a new job instance.
     *
     * @param string $urlGit
     */
    public function __construct(string $urlGit)
    {
        $this->setUrlGit($urlGit);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $headers = ['Content-Type' => 'application/json'];
        $url = sprintf(
            url()->to('/'), $this->getUrlGit()
        );

        /**
         * @var ZttpResponse $response
         */
        $response = Zttp::withHeaders($headers)->get($url);

        if (empty($response) === true || 200 !== $response->status()) {
            $error = 'Failed to fetch Url Git entity.';

            Log::error($error, [
                'url' => $url,
                'response' => $response->json(),
                'status' => $response->status(),
                'headers' => $response->headers(),
            ]);

            throw new \RuntimeException($error);
        }

        $this->getUser()->notify(new TestedProcessEntity($response->json()));
    }

    /**
     * @return string
     */
    public function getUrlGit(): string
    {
        return $this->urlGit;
    }

    /**
     * @param string $urlGit
     */
    public function setUrlGit(string $urlGit)
    {
        $this->urlGit = $urlGit;
    }
}
