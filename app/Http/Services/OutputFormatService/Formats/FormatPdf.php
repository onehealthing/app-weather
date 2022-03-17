<?php

namespace App\Http\Services\OutputFormatService\Formats;

use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class FormatPdf implements FormatInterface
{
    /**
     * @param \GuzzleHttp\Psr7\Response[] $stream
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function format(array $stream): Response
    {
        $content = '';

        foreach ($stream as $streamItem) {
            $body = $streamItem->getBody();

            while (!$body->eof()) {
                $content .= $body->read(1024);
            }

            $content .= '<p></p>';
        }

        return new Response(Pdf::loadHTML($content)->output(), 200, [
            'Content-Type' => 'application/pdf'
        ]);
    }
}
