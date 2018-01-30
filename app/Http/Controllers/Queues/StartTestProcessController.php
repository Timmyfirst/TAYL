<?php

namespace App\Http\Controllers\Queues;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\CodeSnifferController;
use App\Jobs\TestProcessEntity;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StartTestProcessController extends Controller
{
    public function __construct()
    {
        // passage d'arguments si besoin
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function __invoke(Request $request)
    {
<<<<<<< HEAD
        $download = new DownloadController;
        $urlGit = $request->urlGit;
        $message = '';
        try {
            /** function gitClone **/
            $download->store($urlGit);

            $message .= 'git clone success ';
=======
        $test = ["1","2"];
        $urlGit = $request->urlGit;
        $message = '';
        try {
            /** function gitClone */
            $message .= 'git clone success';

            /** on lance en queue cette fonction */
            dispatch(new TestProcessEntity($urlGit));
            dispatch(new TestProcessEntity($urlGit));
            dispatch(new TestProcessEntity($urlGit));
            dispatch(new TestProcessEntity($urlGit));
            dispatch(new TestProcessEntity($urlGit));
            dispatch(new TestProcessEntity($urlGit));
>>>>>>> 2ff8aec3ee25e62b1112cc9404f671d78b6fc74e

        } catch (ModelNotFoundException $exception) {
            /** catch en cas d'erreur importante */
            abort(Response::HTTP_BAD_REQUEST, 'Url does not exist.');
        }

<<<<<<< HEAD
        /** function tests **/
        dispatch(new TestProcessEntity($urlGit));

=======
        /** Message envoyé directement sans attendre la fin des dispatch */
>>>>>>> 2ff8aec3ee25e62b1112cc9404f671d78b6fc74e
        $message .= 'An email has been dispatched to userName about a test for this git Project ' . $urlGit;

        return response($message, Response::HTTP_OK, ['Content-Type' => 'text/plain']);
    }

}
