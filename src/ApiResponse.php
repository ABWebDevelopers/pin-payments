<?php
namespace ABWebDevelopers\PinPayments;

use Psr\Http\Message\ResponseInterface;
use ABWebDevelopers\PinPayments\Endpoint\Exception\UnauthorizedException;
use ABWebDevelopers\PinPayments\Endpoint\Exception\JSONException;

class ApiResponse
{
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        if ($this->response->getStatusCode() === 401) {
            throw new UnauthorizedException;
        }
    }

    public function successful()
    {
        return ($this->response->getStatusCode() === 200);
    }

    public function data()
    {
        $data = json_decode($this->response->getBody()->getContents(), true);
        $error = json_last_error();

        if ($error !== JSON_ERROR_NONE) {
            switch ($error) {
                case JSON_ERROR_DEPTH:
                    $errorString = 'The maximum stack depth has been exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $errorString = 'Invalid or malformed JSON';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $errorString = 'Control character error, possibly incorrectly encoded';
                    break;
                case JSON_ERROR_SYNTAX:
                    $errorString = 'Syntax error';
                    break;
                case JSON_ERROR_UTF8:
                    $errorString = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                case JSON_ERROR_UTF16:
                    $errorString = 'Malformed UTF-16 characters, possibly incorrectly encoded';
                    break;
                default:
                    $errorString = 'Unknown JSON error';
                    break;
            }

            throw new JSONException('Unable to decode response JSON: ' . $errorString);
        }

        return $data;
    }
}
