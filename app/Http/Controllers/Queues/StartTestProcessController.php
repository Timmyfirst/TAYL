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
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    function __invoke(Request $request)
    {
        $download = new DownloadController;
        $urlGit = $request->urlGit;
        $message = '';
        try {
            /** function gitClone */
            $download->store($urlGit);

            $codeSniffer = new CodeSnifferController();

            $codeSniffer->CreateLog($download->getProjectName($urlGit));

            $message .= 'git clone success';
        } catch (ModelNotFoundException $exception) {
            abort(Response::HTTP_BAD_REQUEST, 'Url does not exist.');
        }


            /** function tests **/
            dispatch(new TestProcessEntity($urlGit));

        //$message .= 'An email has been dispatched to userName about a test for this git Project ' . $urlGit;

        return response($message, Response::HTTP_OK, ['Content-Type' => 'text/plain']);
    }

}
