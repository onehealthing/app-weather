<?php

namespace App\Http\Services\OutputFormatService;

use App\Http\Services\OutputFormatService\Formats\FormatHtml;
use App\Http\Services\OutputFormatService\Formats\FormatInterface;
use App\Http\Services\OutputFormatService\Formats\FormatJson;
use App\Http\Services\OutputFormatService\Formats\FormatPdf;
use App\Http\Services\OutputFormatService\Formats\FormatRaw;
use Symfony\Component\HttpFoundation\Response;

class OutputFormatService implements OutputFormatServiceInterface
{
    /**
     * @var array
     */
    private array $formats = [
        'raw' => FormatRaw::class,
        'json' => FormatJson::class,
        'pdf' => FormatPdf::class,
        'html' => FormatHtml::class,
    ];

    /**
     * @param string $format
     *
     * @return bool
     */
    public function isFormatAvailable(string $format): bool
    {
        return array_key_exists($format, $this->formats);
    }

    /**
     * @param array $data
     * @param string $format
     *
     * @return string
     */
    public function format(array $data, string $format): Response
    {
        return $this->getFormatInstance($format)->format($data);
    }

    /**
     * @param string $format
     *
     * @return \App\Http\Services\OutputFormatService\Formats\FormatInterface
     */
    private function getFormatInstance(string $format): FormatInterface
    {
        return new $this->formats[$format];
    }
}
