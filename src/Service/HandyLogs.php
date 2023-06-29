<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class HandyLogs
{
    private $_status = ["info", "warning", "error", "success"];

    public function __construct(private Filesystem $fs)
    {
    }

    public function writeInfo($message)
    {
        $status = $this->_status[0];
        $contentInfo = "ℹ️ - " . date("d-m-Y H:i:s") . " - $status - $message" . PHP_EOL;
        $this->fs->appendToFile('log/handyLogs.log', $contentInfo);
    }

    public function writeWarning($message)
    {
        $status = $this->_status[1];
        $contentInfo = "🐛 - " . date("d-m-Y H:i:s") . " - $status - $message" . PHP_EOL;
        $this->fs->appendToFile('log/handyLogs.log', $contentInfo);
    }

    public function writeError($message)
    {
        $status = $this->_status[2];
        $contentInfo = "❌ - " . date("d-m-Y H:i:s") . " - $status - $message" . PHP_EOL;
        $this->fs->appendToFile('log/handyLogs.log', $contentInfo);
    }

    public function writeSuccess($message)
    {
        $status = $this->_status[3];
        $contentInfo = "✅ - " . date("d-m-Y H:i:s") . " - $status - $message" . PHP_EOL;
        $this->fs->appendToFile('log/handyLogs.log', $contentInfo);
    }
}
