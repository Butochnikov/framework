<?php
namespace SleepingOwl\Framework\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use SleepingOwl\Framework\Contracts\SleepingOwl;
use SleepingOwl\Framework\Contracts\Themes\Factory;

class AppController extends Controller
{
    /**
     * @param Translator $translator
     * @param SleepingOwl $framework
     * @param Factory $themeManager
     *
     * @return Response
     */
    public function settings(
        Translator $translator,
        SleepingOwl $framework,
        Factory $themeManager
    )
    {
        $content = 'window.Framework = '.json_encode([
            'Settings' => [
                'locale' => $translator->getLocale(),
                'trans' => [],
                'url_prefix' => $framework->config()['url_prefix'],
                'theme' => $themeManager->theme()->toArray(),
            ]
        ]);

        return new Response($content, 200, [
            'Content-Type' => 'text/javascript',
        ]);
    }
}