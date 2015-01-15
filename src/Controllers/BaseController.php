<?php namespace Manavo\LaravelToolkit\Controllers;

use \Illuminate\Routing\Controller;
use Cache, App, View, Response;
use Manavo\LaravelToolkit\Utilities;

class BaseController extends Controller
{

    private $js = array();
    private $css = array();

    public function __construct()
    {
        $cacheKey = 'assets-built';

        if (!Cache::has($cacheKey) || App::environment() === 'local') {
            Utilities::publishAssets();
            Cache::put($cacheKey, true, 1440);
        }
    }

    protected function addJs($file)
    {
        $prefix = '';
        if (!starts_with($file, ['http:', 'https:'])) {
            $prefix = 'js/';
        }
        $this->js[] = $prefix.$file;

        View::share('js', $this->js);
    }

    protected function addPackageJs($file)
    {
        $this->js[] = 'packages/manavo/laravel-toolkit/js/'.$file;

        View::share('js', $this->js);
    }

    protected function addCss($file)
    {
        $prefix = '';
        if (!starts_with($file, ['http:', 'https:'])) {
            $prefix = 'css/';
        }
        $this->css[] = $prefix.$file;

        View::share('css', $this->css);
    }

    protected function addPackageCss($file)
    {
        $this->css[] = 'packages/manavo/laravel-toolkit/css/'.$file;

        View::share('css', $this->css);
    }

    protected function plainTextResponse($content, $code, $headers = [])
    {
        if ($content instanceof \Illuminate\Support\MessageBag) {
            $content = implode("\n", $content->all());
        }

        return Response::make($content, $code, array_merge(['Content-Type' => 'text/plain'], $headers));
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}
