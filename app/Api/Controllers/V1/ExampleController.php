<?php

namespace App\Api\Controllers\V1;

use App\Api\Controllers\Controller;
use App\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client as HttpClient;
use Dingo\Api\Exception\ResourceException;

class ExampleController extends Controller
{
    private $http;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->http = new HttpClient(['base_uri' => env('EXAMPLE_ENDPOINT'), 'http_errors' => false]);
    }

    public function sample(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'bail|required|string',
        ]);

        if ($validator->fails()) {
            throw new ResourceException('Validation has failed', $validator->errors());
        }

        $result = Cache::get('example:request:text:'.$request->text);

        if (!$result) {
            $get = $this->http->get('anything', [
                'query' => [
                    'text' => $request->text,
                ],
            ]);

            $result = json_decode($get->getBody());

            if ($get->getStatusCode() !== 200) {
                return $this->response->error($body, $get->getStatusCode());
            }

            Cache::put('example:request:text:'.$request->text, $result, env('EXAMPLE_CACHE_MINUTES', 5));
        }

        $response = Response::ONE($request, $result, 'nested');

        return $this->response->array($response);
    }
}
