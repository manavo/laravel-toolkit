<?php namespace Manavo\LaravelToolkit;

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\AssetManager;
use Assetic\AssetWriter;
use Config;

class Utilities
{

    public static function apostropheS($string)
    {
        if (ends_with($string, 's')) {
            return $string . "'";
        } else {
            return $string . "'s";
        }
    }

    public static function getExtension($filename)
    {
        $parts = explode('.', $filename);

        $ext = strtolower(array_pop($parts));
        return $ext;
    }

    public static function pluralize($string, $count)
    {
        if ($count != 1) {
            return str_plural($string);
        } else {
            return $string;
        }
    }

    public static function linkify($string)
    {
        $regex = '/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/i';

        return preg_replace($regex, '<a href="$0" target="_blank">$0</a>', $string);
    }

    public static function asset($path)
    {
        $localFile = public_path() . '/' . $path;
        // Check if it's a local file
        if (file_exists($localFile)) {
            $timestamp = filemtime($localFile);
            $append = '?t=' . $timestamp;
        } else {
            $append = '';
        }

        if (substr($path, -3) === 'css') {
            return '<link href="/' . $path . $append . '" rel="stylesheet" />';
        } else {
            if (substr($path, -2) === 'js') {
                return '<script src="/' . $path . $append . '" type="text/javascript"></script>';
            } else {
                return '';
            }
        }
    }

    public static function br2nl($text)
    {
        return preg_replace('/<br\\s*?\/??>/i', "\n", $text);
    }

    public static function publishAssets($force = false)
    {
        $css = [];
        $cssAssets = Config::get('manavo/laravel-toolkit::assets.css');
        if (is_array($cssAssets)) {
            foreach ($cssAssets as $cssFile) {
                $css[] = new FileAsset(public_path($cssFile));
            }
        }
        $js = [];
        $jsAssets = Config::get('manavo/laravel-toolkit::assets.js');
        if (is_array($jsAssets)) {
            foreach ($jsAssets as $jsFile) {
                $js[] = new FileAsset(public_path($jsFile));
            }
        }

        $am = new AssetManager();

//        $cssFilter = new \Assetic\Filter\UglifyCssFilter();

        $cssCollection = new AssetCollection($css, array());
        $cssCollection->setTargetPath('app.css');
        $am->set('css', $cssCollection);

        $jsCollection = new AssetCollection($js);
        $jsCollection->setTargetPath('app.js');
        $am->set('js', $jsCollection);

        $mergedCss = public_path() . '/builds/app.css';
        $mergedJs = public_path() . '/builds/app.js';

        $write = false;
        if (!file_exists($mergedCss) || !file_exists($mergedJs)) {
            $write = true;
        } else {
            if ($cssCollection->getLastModified() > filemtime($mergedCss)) {
                $write = true;
            }
            if ($jsCollection->getLastModified() > filemtime($mergedJs)) {
                $write = true;
            }
        }

        if ($write || $force) {
            $writer = new AssetWriter(public_path() . '/builds');
            $writer->writeManagerAssets($am);
        }
    }

}
