<?php
namespace SleepingOwl\Framework\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;

class AppController extends Controller
{
    /**
     * @param Request $request
     * @param Translator $translator
     *
     * @return Response
     */
    public function settings(Request $request, Translator $translator)
    {
        $content = 'window.Framework = '.json_encode([
            'Settings' => [
                'locale' => $translator->getLocale(),
                'trans' => [],
                'config' => config('sleepingowl'),
            ]
        ]);

        return new Response($content, 200, [
            'Content-Type' => 'text/javascript',
        ]);
    }
}