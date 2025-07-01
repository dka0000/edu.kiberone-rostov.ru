<?php

namespace Otus\Diag;

use Bitrix\Main\Diag\FileExceptionHandlerLog;
use Bitrix\Main\Diag\ExceptionHandlerFormatter;

class FileExceptionHandlerLogCustom extends FileExceptionHandlerLog{
    protected $level;
	protected $ignoredFiles = [

    ];
    protected $ignoredErrors =[
        "Undefined array key",
        "String offset cast occurred",
        "Undefined variable",
        "intec.core"
    ];

    public function write($exception, $logType)
	{
        if ($this->shouldIgnore($exception)) {
            return;
        }
        $text = ExceptionHandlerFormatter::format($exception, false, $this->level);

		$context = [
			'type' => static::logTypeToString($logType),
		];

		$logLevel = static::logTypeToLevel($logType);

        $message = "OTUS - {date} - Host: {host} - {type} - {$text}\n";

		$this->logger->log($logLevel, $message, $context);
	}

	protected function shouldIgnore($exception)
    {
        if ($exception instanceof \ErrorException) {
            $file = $exception->getFile();
            $text = ExceptionHandlerFormatter::format($exception, false, $this->level);
            foreach ($this->ignoredFiles as $ignoredFile) {
                if (stripos($file, $ignoredFile) !== false) {
                    return true;
                }
            }
            foreach ($this->ignoredErrors as $ignoredError) {
                if (stripos($text, $ignoredError) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
}