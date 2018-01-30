<?php

namespace App\Jobs;

use App\Notifications\TestedProcessEntity;
use App\User;
use App\Http\Controllers\CodeSnifferController;
use App\Http\Controllers\DownloadController;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Zttp\Zttp;
use Zttp\ZttpResponse;
use Exception;

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
     *  commande pour créer un job : php artisan make:job nomDuJobEntity
     *
     * @param string $urlGit
     */
    public function __construct(string $urlGit)
    {
        /** ajouter un paramètre */
        $this->setUrlGit($urlGit);
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
<<<<<<< HEAD
        /*
        $headers = ['Content-Type' => 'application/json'];
        $url = sprintf(
            url()->to('/'), $this->getUrlGit()
        );

        /**
         * @var ZttpResponse $response

        $response = Zttp::withHeaders($headers)->get($url);
=======
        /** on a eu pour ordre de lancer cette fonction */
        /** stop 10sec */
        usleep(10000000);

        // And sometimes i'll just randomly fail.
        if(rand(1, 100) >= 10) throw new \Exception('Everything is horrible.');
>>>>>>> 2ff8aec3ee25e62b1112cc9404f671d78b6fc74e


        Log::info("Success with this url : ", [
                'url' => $this->getUrlGit(),
            ]);

<<<<<<< HEAD
            throw new \RuntimeException($error);
        }
        /*
        $codeSniffer = new CodeSnifferController();
        $downloadObject = new DownloadController();

        $codeSniffer->CreateLog($downloadObject->getProjectName($url));

        $this->getUser()->notify(new TestedProcessEntity($response->json()));*/

        

=======
        return 'ok';
    }

    public function failed(Exception $exception)
    {
        Log::error("error name : ", [
            'url' => $exception,
        ]);

        return 'failed';
>>>>>>> 2ff8aec3ee25e62b1112cc9404f671d78b6fc74e
    }

    /**
     * getter de l'url en paramètre
     * @return string
     */
    public function getUrlGit(): string
    {
        return $this->urlGit;
    }

    /**
     * set l'url en paramètre
     * @param string $urlGitgetUrlGit
     */
    public function setUrlGit(string $urlGit)
    {
        $this->urlGit = $urlGit;
    }
}
