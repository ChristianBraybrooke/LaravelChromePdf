<?php

namespace ChrisBraybrooke\LaravelChromePdf;

use Spiritix\Html2Pdf\Input\StringInput;
use Spiritix\Html2Pdf\Output\DownloadOutput;
use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Support\Renderable;
use Spiritix\Html2Pdf\Converter;

class ChromePDF
{
    /**
     * @var \Spiritix\Html2Pdf\Input\StringInput
     */
    protected $stringInput;

    /**
     * @var \Spiritix\Html2Pdf\Output\DownloadOutput
     */
    protected $downloadOutput;

    /**
     * @var string
     */
    protected $html;

    public function __construct(StringInput $stringInput, DownloadOutput $downloadOutput)
    {
        $this->stringInput =  $stringInput;
        $this->downloadOutput =  $downloadOutput;
    }

    public function loadView(string $view, array $data = [], array $mergeData = [])
    {
        $view = View::make($view, $data, $mergeData);
        return $this->loadHTML($view);
    }

    public function loadHTML(string $html)
    {
        if ($html instanceof Renderable) {
            $html = $html->render();
        }
        $this->html = $html;
        return $this;
    }

    public function inline()
    {
        return $this->html;
    }

    public function save()
    {
        return 'hello';
    }

    public function download()
    {
        return 'hello';
    }

    public function output()
    {
        if ($this->html) {
            // $html = $this->stringInput->setHtml($this->html);

            $html = $this->stringInput;
            $html->setHtml($this->html);

            $converter = new Converter($html, $this->downloadOutput);
            $output = $converter->convert();

            return $output->download('test.pdf');
        }
    }
}
