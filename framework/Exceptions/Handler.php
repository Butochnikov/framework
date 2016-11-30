<?php
namespace SleepingOwl\Framework\Exceptions;

use App\Exceptions\Handler as AppHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
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
