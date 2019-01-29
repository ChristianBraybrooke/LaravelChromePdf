<?php

namespace ChrisBraybrooke\LaravelChromePdf;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Spiritix\Html2Pdf\Input\StringInput;
use Spiritix\Html2Pdf\Output\DownloadOutput;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->app->bind('chrome.pdf', function ($app) {
            return new ChromePDF(new StringInput(), new DownloadOutput());
        });
        $this->app->alias('chrome.pdf', 'ChrisBraybrooke\LaravelChromePdf\ChromePDF');
    }
}
