<?php
namespace SleepingOwl\Framework\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Translation\Translator;
use League\Fractal\Resource\Item;
use SleepingOwl\Api\Transformers\User as UserTransformer;
use SleepingOwl\Framework\Contracts\SleepingOwl;
use SleepingOwl\Framework\Contracts\Themes\Factory;
use SleepingOwl\Api\Contracts\Manager as ApiManager;

class AppController extends Controller
{
    /**
     * @param Application $application
     * @param Translator $translator
     * @param SleepingOwl $framework
     * @param Factory $themeManager
     *
     * @return Response
     */
    public function settings(
        Application $application,
        Translator $translator,
        SleepingOwl $framework,
        Factory $themeManager,
        ApiManager $apiManager,
        Request $request
    )
    {
        $user = $request->user('backend');

        $content = 'window.GlobalConfig = '.json_encode([
            'debug' => config('app.debug'),
            'env' => $application->environment(),
            'locale' => $translator->getLocale(),
            'trans' => [],
            'url_prefix' => $framework->config()['url_prefix'],
            'url' => url(''),
            'backend_url' => backend_url(''),
            'theme' => $themeManager->theme()->toArray(),
            'user' => $user
        ]);

        return new Response($content, 200, [
            'Content-Type' => 'text/javascript',
        ]);
    }
}