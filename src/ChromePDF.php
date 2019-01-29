<?php

namespace ChrisBraybrooke\LaravelChromePdf;

use Spiritix\Html2Pdf\Input\StringInput;
use Spiritix\Html2Pdf\Output\DownloadOutput;
use Spiritix\Html2Pdf\Output\StringOutput;
use Spiritix\Html2Pdf\Output\EmbedOutput;
use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Support\Renderable;
use Spiritix\Html2Pdf\Converter;
use Illuminate\Support\Facades\Storage;

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
     * @var \Spiritix\Html2Pdf\Output\StringOutput
     */
    protected $stringOutput;

    /**
     * @var \Spiritix\Html2Pdf\Output\EmbedOutput
     */
    protected $embedOutput;

    /**
     * @var string
     */
    protected $html;

    /**
     * @var array
     */
    protected $options = [];

    public function __construct(
        StringInput $stringInput,
        DownloadOutput $downloadOutput,
        StringOutput $stringOutput,
        EmbedOutput $embedOutput
    ) {
        $this->stringInput =  $stringInput;
        $this->downloadOutput =  $downloadOutput;
        $this->stringOutput = $stringOutput;
        $this->embedOutput = $embedOutput;
    }

    /**
     * Load a view file as the html to be converted into a pdf.
     *
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function loadView(string $view, array $data = [], array $mergeData = [])
    {
        $view = View::make($view, $data, $mergeData);
        return $this->loadHTML($view);
    }

    /**
     * Set the html which should be converted into a pdf.
     *
     * @param string $html
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function loadHTML(string $html)
    {
        $this->html = $this->renderHtml($html);
        return $this;
    }

    /**
     * Save the file once done converting.
     *
     * @param string $fileName
     * @param string $disk
     * @return bool
     */
    public function save(string $fileName = 'file.pdf', string $disk = 'public')
    {
        $pdfString = $this->convert($this->stringOutput)->get();
        return Storage::disk($disk)->put($fileName, $pdfString);
    }

    /**
     * Display the file within the browser itself.
     *
     * @param string $fileName
     * @return string
     */
    public function inline($fileName = 'file.pdf')
    {
        return $this->convert($this->embedOutput)->embed($fileName);
    }

    /**
     * Download the file to the users device.
     *
     * @param string $fileName
     * @return void
     */
    public function download($fileName = 'file.pdf')
    {
        $this->convert($this->downloadOutput)->download($fileName);
    }

    /**
     * Set the header on the pdf document.
     *
     * @param string $html
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function header(string $html)
    {
        $this->options['headerTemplate'] = $this->renderHtml($html);
        return $this;
    }

    /**
     * Set the header on the pdf document loading content from a view.
     *
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function headerView(string $view, array $data = [], array $mergeData = [])
    {
        $this->header(View::make($view, $data, $mergeData));
        return $this;
    }

    /**
     * Set the footer on the pdf document.
     *
     * @param string $html
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function footer(string $html)
    {
        $this->options['footerTemplate'] = $this->renderHtml($html);
        return $this;
    }

    /**
     * Set the footer on the pdf document loading content from a view.
     *
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function footerView(string $view, array $data = [], array $mergeData = [])
    {
        $this->header(View::make($view, $data, $mergeData));
        return $this;
    }

    /**
     * Set the size of the page.
     *
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function size(string $format)
    {
        $this->options['format'] = $format;
        return $this;
    }

    /**
     * Set the size of the page to be a5.
     *
     * @param boolean $landscape
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function a5($landscape = false)
    {
        if ($landscape) {
            $this->landscape();
        }
        $this->size('a5');
        return $this;
    }

    /**
     * Set the size of the page to be a4.
     *
     * @param boolean $landscape
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function a4($landscape = false)
    {
        if ($landscape) {
            $this->landscape();
        }
        $this->size('a4');
        return $this;
    }

    /**
     * Set the size of the page to be a3.
     *
     * @param boolean $landscape
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function a3($landscape = false)
    {
        if ($landscape) {
            $this->landscape();
        }
        $this->size('a3');
        return $this;
    }

    /**
     * Set the size of the orientation to be landscape.
     *
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function landscape()
    {
        $this->options['landscape'] = true;
        return $this;
    }

    /**
     * Set an option on the PDF.
     *
     * @param string $optionKey
     * @param mixed $optionValue
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function setOption(string $optionKey, $optionValue = true)
    {
        $this->options[$optionKey] = $optionValue;
        return $this;
    }

    /**
     * Set the options on the PDF.
     *
     * @param array $options
     * @return \ChrisBraybrooke\LaravelChromePdf\ChromePDF
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Convert the input to an output format.
     *
     * @param mixed $output
     * @return \Spiritix\Html2Pdf\Converter
     */
    private function convert($output)
    {
        if ($this->html) {
            $html = $this->stringInput;
            $html->setHtml($this->html);

            $converter = new Converter($html, $output);
            if ($this->options) {
                $converter->setOptions($this->options);
            }
            return $converter->convert();
        }
    }

    /**
     * Render the html if it needs doing.
     *
     * @param string $html
     * @return string
     */
    private function renderHtml(string $html)
    {
        if ($html instanceof Renderable) {
            $html = $html->render();
        }
        return $html;
    }
}
