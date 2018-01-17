<?php

namespace App\Http\Controllers\Queues;

use App\Http\Controllers\Controller;
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
        $urlGit = $request->urlGit;
        $message = '';
        try {
            /** function gitClone */
            $message .= 'git clone success';
        } catch (ModelNotFoundException $exception) {
            abort(Response::HTTP_BAD_REQUEST, 'Url does not exist.');
        }

            dispatch(new TestProcessEntity($urlGit));

        $message .= 'An email has been dispatched to userName about a test for this git Project ' . $urlGit;

        return response($message, Response::HTTP_OK, ['Content-Type' => 'text/plain']);
    }
}
