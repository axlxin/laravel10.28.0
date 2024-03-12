<?php

namespace App\Exceptions;

use App\Models\ErrorInfo;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {

        });
    }

    public function render($request, Throwable $e)
    {
        $configDebug = env('APP_DEBUG');

        $code = $e->getCode();

        if ($e->getCode() != 200 && $configDebug) {  //APP_DEBUG = true

        $logInstance = Log::channel('exception');
        $logInstance->info('---------------------------------------- 响应 START ------------------------------');
        $logInstance->info('请求唯一标识：' . $_SERVER['HTTP_X_REQUEST_ID']);
        $logInstance->info('请求状态码：' . $code);
        $logInstance->info('请求地址：' . $request->getPathInfo());
        $logInstance->info('请求头：' . json_encode($request->header()));
        $logInstance->info('请求参数：' . json_encode($request->all()));
        $logInstance->info('错误提示：' . $e->getMessage());
        $logInstance->info('---------------------------------------- 响应 END ------------------------------');

        $errorLog = new ErrorInfo();
        $errorLog->error_message = json_encode($e->getMessage());
        $errorLog->trace = json_encode($e->getTrace());
        $errorLog->request_id = $_SERVER['HTTP_X_REQUEST_ID'];
        $errorLog->save();

        return response()->json([
                'error' => $e->getMessage(),'trace'=>$e->getTrace()
            ]);

        }

         if ($e instanceof NotFoundHttpException) {
             return response()->json([
                 'code'    => 404,
                 'status'  => 'fail',
                 'message' => '404 Not Found'
             ]);
         }

        }
}
