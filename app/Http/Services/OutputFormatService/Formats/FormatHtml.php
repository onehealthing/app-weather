<?php

namespace App\Http\Services\OutputFormatService\Formats;

use Symfony\Component\HttpFoundation\Response;

class FormatHtml implements FormatInterface
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

        return new Response($content, 200, [
            'Content-Type' => 'text/html'
        ]);
    }
}
