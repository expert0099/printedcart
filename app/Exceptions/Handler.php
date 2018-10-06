<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
	 
    /* public function render($request, Exception $e)
    {
		return parent::render($request, $e);
    } */
	
	public function render($request, Exception $e)
    {
        /* if(config('app.debug') && !($e instanceof ValidationException) && !($e instanceof HttpResponseException)){
			return response()->view('errors.404', ['error'=>'Page not found!'], 404);
        }
        if($e instanceof TokenMismatchException){
            return redirect()->route('home');
        }       
		if($e instanceof ModelNotFoundException){
            return response()->view('errors.404', ['error'=>'Page not found!'], 404);
        }  
        if($e instanceof \Symfony\Component\Debug\Exception\FatalErrorException) {
            return \Response::view('errors.500',array(),500);
        }
        if($this->isHttpException($e)){
            switch($e->getStatusCode()){
				case 403:
                    return \Response::view('errors.403',array('error'=>'Unauthorized access!'),403);
                break;
                case 404:
                    return \Response::view('errors.404',array('error'=>'Page not found!'),404);
                break;
                case 500:
                    return \Response::view('errors.500',array('error'=>'Internal server error!'),500);   
                break;
				case 503:
                    return \Response::view('errors.503',array('error'=>'Be right back!'),503);   
                break;

                default:
                    return $this->renderHttpException($e);
                break;
            }
        }
        else
        { */
            return parent::render($request, $e);
        //}      
    }

}
