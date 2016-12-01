<?php
namespace SleepingOwl\Api\Exceptions;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler as IlluminateExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use ReflectionFunction;
use SleepingOwl\Api\Contracts\Exceptions\Handler as HandlerContract;
use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler implements IlluminateExceptionHandler, HandlerContract
{
    /**
     * Array of exception handlers.
     *
     * @var array
     */
    protected $handlers = [];

    /**
     * Indicates if we are in debug mode.
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * The parent Illuminate exception handler instance.
     *
     * @var \Illuminate\Contracts\Debug\ExceptionHandler
     */
    protected $parentHandler;

    /**
     * User defined replacements to merge with defaults.
     *
     * @var array
     */
    protected $replacements = [];

    /**
     * Handler constructor.
     *
     * @param IlluminateExceptionHandler $parentHandler
     * @param bool $debug
     */
    public function __construct(IlluminateExceptionHandler $parentHandler, bool $debug)
    {
        $this->parentHandler = $parentHandler;
        $this->debug = $debug;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        $this->parentHandler->report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        return $this->handle($e);
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @param  \Exception $e
     *
     * @return void
     */
    public function renderForConsole($output, Exception $e)
    {
        $this->parentHandler->renderForConsole($output, $e);
    }

    /**
     * Register a new exception handler.
     *
     * @param callable $callback
     *
     * @return void
     */
    public function register(callable $callback)
    {
        $hint = $this->handlerHint($callback);

        $this->handlers[$hint] = $callback;
    }

    /**
     * Handle an exception if it has an existing handler.
     *
     * @param \Exception $exception
     *
     * @return JsonResponse
     */
    public function handle(Exception $exception)
    {
        foreach ($this->handlers as $hint => $handler) {
            if (! $exception instanceof $hint) {
                continue;
            }

            if ($response = $handler($exception)) {
                if (! $response instanceof BaseResponse) {
                    $response = new JsonResponse($response, $this->getExceptionStatusCode($exception));
                }

                return $response;
            }
        }

        return $this->genericResponse($exception);
    }

    /**
     * Handle a generic error response if there is no handler available.
     *
     * @param \Exception $exception
     *
     * @throws \Exception
     *
     * @return JsonResponse
     */
    protected function genericResponse(Exception $exception)
    {
        $replacements = $this->prepareReplacements($exception);

        $response = $this->newResponseArray();

        array_walk_recursive($response, function (&$value, $key) use ($exception, $replacements) {
            if (starts_with($value, ':') && isset($replacements[$value])) {
                $value = $replacements[$value];
            }
        });

        $response = $this->recursivelyRemoveEmptyReplacements($response);

        return new JsonResponse($response, $this->getStatusCode($exception), $this->getHeaders($exception));
    }

    /**
     * Get the status code from the exception.
     *
     * @param \Exception $exception
     *
     * @return int
     */
    protected function getStatusCode(Exception $exception)
    {
        return $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;
    }

    /**
     * Get the headers from the exception.
     *
     * @param \Exception $exception
     *
     * @return array
     */
    protected function getHeaders(Exception $exception)
    {
        return $exception instanceof HttpExceptionInterface ? $exception->getHeaders() : [];
    }

    /**
     * Prepare the replacements array by gathering the keys and values.
     *
     * @param \Exception $exception
     *
     * @return array
     */
    protected function prepareReplacements(Exception $exception)
    {
        $statusCode = $this->getStatusCode($exception);

        if (! $message = $exception->getMessage()) {
            $message = sprintf('%d %s', $statusCode, Response::$statusTexts[$statusCode]);
        }

        $replacements = [
            ':message' => $message,
            ':status_code' => $statusCode,
        ];

        if ($exception instanceof MessageBagErrors && $exception->hasErrors()) {
            $replacements[':errors'] = $exception->getErrors();
        }

        if ($code = $exception->getCode()) {
            $replacements[':code'] = $code;
        }

        if ($this->runningInDebugMode()) {
            $replacements[':debug'] = [
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
                'class' => get_class($exception),
                'trace' => explode("\n", $exception->getTraceAsString()),
            ];
        }

        return array_merge($replacements, $this->replacements);
    }
    /**
     * Set user defined replacements.
     *
     * @param array $replacements
     *
     * @return void
     */
    public function setReplacements(array $replacements)
    {
        $this->replacements = $replacements;
    }

    /**
     * Recursirvely remove any empty replacement values in the response array.
     *
     * @param array $input
     *
     * @return array
     */
    protected function recursivelyRemoveEmptyReplacements(array $input)
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = $this->recursivelyRemoveEmptyReplacements($value);
            }
        }

        return array_filter($input, function ($value) {
            if (is_string($value)) {
                return ! starts_with($value, ':');
            }

            return true;
        });
    }

    /**
     * Create a new response array with replacement values.
     *
     * @return array
     */
    protected function newResponseArray()
    {
        return [
            'message' => ':message',
            'errors' => ':errors',
            'code' => ':code',
            'status_code' => ':status_code',
            'debug' => ':debug',
        ];
    }

    /**
     * Get the exception status code.
     *
     * @param \Exception $exception
     * @param int        $defaultStatusCode
     *
     * @return int
     */
    protected function getExceptionStatusCode(Exception $exception, $defaultStatusCode = 500)
    {
        return ($exception instanceof HttpExceptionInterface) ? $exception->getStatusCode() : $defaultStatusCode;
    }

    /**
     * Determines if we are running in debug mode.
     *
     * @return bool
     */
    protected function runningInDebugMode()
    {
        return $this->debug;
    }

    /**
     * Get the hint for an exception handler.
     *
     * @param callable $callback
     *
     * @return string
     */
    protected function handlerHint(callable $callback)
    {
        $reflection = new ReflectionFunction($callback);

        $exception = $reflection->getParameters()[0];

        return $exception->getClass()->getName();
    }

    /**
     * Get the exception handlers.
     *
     * @return array
     */
    public function getHandlers()
    {
        return $this->handlers;
    }
}