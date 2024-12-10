<?php
/**
 *      ██ ██    ██ ███    ███ ██████
 *      ██ ██    ██ ████  ████ ██   ██
 *      ██ ██    ██ ██ ████ ██ ██████
 * ██   ██ ██    ██ ██  ██  ██ ██
 *  █████   ██████  ██      ██ ██
 *
 * @author Dale Davies <dale@daledavies.co.uk>
 * @copyright Copyright (c) 2023, Dale Davies
 * @license MIT
 */

namespace Jump\Debugger;

class ErrorLogger implements \Tracy\ILogger {
    public function log($message, $priority = self::INFO): void {
        $logmessage = $this->format_message($message) . PHP_EOL;
        $logmessage .= $this->format_backtrace($message, true) . PHP_EOL;
        error_log($logmessage);
    }

    public static function format_message($message): string {
        if ($message instanceof \Throwable) {
            foreach (\Tracy\Helpers::getExceptionChain($message) as $exception) {
                $tmp[] = ($exception instanceof \ErrorException
                    ? \Tracy\Helpers::errorTypeToString($exception->getSeverity()) . ': ' . $exception->getMessage()
                    : get_debug_type($exception) . ': ' . $exception->getMessage() . ($exception->getCode() ? ' #' . $exception->getCode() : '')
                );
            }
            $message = implode("\ncaused by ", $tmp);
        } elseif (!is_string($message)) {
            $message = \Tracy\Dumper::toText($message);
        }
        return trim($message);
    }

    public function format_backtrace($message) {
        if (empty($message) || !$message instanceof \Throwable) {
            return '';
        }
        $count = 1;
        $from = '';
        foreach ($message->getTrace() as $caller) {
            if (!isset($caller['line'])) {
                $caller['line'] = '?';
            }
            if (!isset($caller['file'])) {
                $caller['file'] = 'unknownfile';
            }
            $from .= '-  #'.$count.' ';
            $from .= 'line ' . $caller['line'] . ' of ' . str_replace(dirname(__DIR__), '', $caller['file']);
            if (isset($caller['function'])) {
                $from .= ': call to ';
                if (isset($caller['class'])) {
                    $from .= $caller['class'] . $caller['type'];
                }
                $from .= $caller['function'] . '()';
            } else if (isset($caller['exception'])) {
                $from .= ': '.$caller['exception'].' thrown';
            }
            $from .= PHP_EOL;
            $count ++;
        }
        $from .= '';
        return $from;
    }
}
