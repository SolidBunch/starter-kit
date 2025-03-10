<?php

namespace StarterKit\Handlers\Errors;

defined('ABSPATH') || exit;

use Whoops\Exception\Formatter;
use Whoops\Handler\Handler;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Util\Misc;

/**
 * WordPress-specific version of Json handler for REST API.
 */
class RestApiHandler extends JsonResponseHandler
{
    private function isRestRequest(): bool
    {
        if (defined('REST_REQUEST') && REST_REQUEST) {
            return true;
        }

        // This is dirty, but no better way to detect before parse_request.
        if (! empty($_SERVER['REQUEST_URI']) && false !== stripos($_SERVER['REQUEST_URI'], rest_get_url_prefix())) {
            return true;
        }

        return false;
    }


    public function handle(): int
    {
        if (! $this->isRestRequest()) {
            return Handler::DONE;
        }

        $data = Formatter::formatExceptionAsDataArray($this->getInspector(), $this->addTraceToOutput());
        $response = array(
            'code'    => $data['type'],
            'message' => $data['message'],
            'data'    => $data,
        );

        if (Misc::canSendHeaders()) {
            status_header(500);
            header('Content-Type: application/json; charset=' . get_option('blog_charset'));
        }

        echo wp_json_encode($response, JSON_PRETTY_PRINT);

        return Handler::QUIT;
    }
}
