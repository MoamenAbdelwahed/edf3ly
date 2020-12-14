<?php

namespace Application\Src\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Application\Src\Exceptions\ApplicationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Application\Src\Http\Response\JsonResponseDefault;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class Handler
 * @package Application\Src\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        switch ($e) {

            case ($e instanceof TooManyRequestsHttpException):
                return $this->renderCustomException($e);
                break;

            case ($e instanceof NotFoundHttpException ):
                return $this->renderCustomException($e);
                break;

            case ($e instanceof ApplicationException ):
                return $this->renderCustomException($e);
                break;

            case ($e instanceof InvalidArgumentException ):
                return $this->renderCustomException($e);
                break;

            default:
                return parent::render($request, $e);
        }
    }

    /**
     * @param Exception $e
     * @return mixed
     */
    protected function renderCustomException(Exception $e)
    {
        switch ($e){

            case ($e instanceof TooManyRequestsHttpException):
                return JsonResponseDefault::create(false,'',$e->getMessage(),$e->getStatusCode());
                break;

            case ($e instanceof ApplicationException):
                return JsonResponseDefault::create(false,'',$e->getMessage(),$e->getCode());
                break;

            case ($e instanceof NotFoundHttpException):
                return JsonResponseDefault::create(false,'','Bad Request',$e->getStatusCode());
                break;

            case ($e instanceof InvalidArgumentException):
                $code = ($e->getCode() == 403) ? 403 : 400;
                return JsonResponseDefault::create(false,'', $e->getMessage(), $code);
                break;

            default:
        }
    }
}
