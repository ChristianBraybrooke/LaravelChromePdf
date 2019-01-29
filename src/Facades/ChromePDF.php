<?php
namespace ChrisBraybrooke\LaravelChromePdf\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

class ChromePDF extends BaseFacade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chrome.pdf';
    }
}
