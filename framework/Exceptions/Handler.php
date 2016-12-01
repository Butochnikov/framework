<?php
namespace SleepingOwl\Framework\Exceptions;

use Exception;
use App\Exceptions\Handler as AppHandler;
use Illuminate\Auth\AuthenticationException;
use SleepingOwl\Api\Contracts\Exceptions\Handler as ApiExceptionsHandler;
use SleepingOwl\Framework\Contracts\SleepingOwl;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends AppHandler
{
    /**
     * @var SleepingOwl
     */
    protected $framework;

    /**
     * {@inheritdoc}
     */
    public function render($request, Exception $exception)
    {
        // Если текущий контекст - api, то все ошибки обрабатываем с помощью обработчика
        // SleepingOwl\Api\Contracts\Exceptions\Handler

        if (framework()->context(SleepingOwl::CTX_API)) {
            /** @var ApiExceptionsHandler $handler */
            $handler = $this->container->make(ApiExceptionsHandler::class);

            return $handler->render($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * {@inheritdoc}
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        if (in_array('backend', $exception->guards())) {
            return redirect()->guest(backend_url('login'));
        }

        return redirect()->guest('login');
    }

    /**
     * {@inheritdoc}
     */
    protected function renderHttpException(HttpException $e)
    {
        // Если текущий контекст - backend, то вывод ошибок перенаправляем на свой метод
        if (framework()->context(SleepingOwl::CTX_BACKEND)) {
            return $this->renderBackendException($e);
        }

        return parent::renderHttpException($e);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderBackendException($e)
    {
        $status = $e->getStatusCode();

        $view = theme()->viewPath("errors.{$status}");

        if (!view()->exists($view)) {
            $view = theme()->viewPath("errors.default");
        }

        return response()->view($view, [
            'exception' => $e,
            'status' => $status,
            'message' => $e->getMessage(),
            'title' => 'Something went wrong',
            'route' => null,
        ], $status, $e->getHeaders());
    }
}
