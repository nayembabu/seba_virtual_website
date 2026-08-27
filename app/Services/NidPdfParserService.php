<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class NidPdfParserService
{
    protected string $scriptPath;
    protected string $pythonBin;
    protected int    $timeoutSeconds = 30;

    public function __construct()
    {
        $this->scriptPath = storage_path('app/scripts/parse_nid_pdf.py');
        $this->pythonBin  = env('PYTHON_BIN', '/usr/bin/python3');
    }

    public function parse(UploadedFile $file): array
    {
        if (! file_exists($this->scriptPath)) {
            Log::error('[NidPdfParser] Script not found: ' . $this->scriptPath);
            return ['status' => false, 'message' => 'PDF parser script not found.'];
        }

        $cmdArray = [
            $this->pythonBin,
            $this->scriptPath,
            $file->getRealPath()
        ];

        $result = $this->execWithTimeout($cmdArray, $this->timeoutSeconds);

        if ($result === null) {
            Log::error('[NidPdfParser] Command timed out', ['cmd' => $cmdArray]);
            return ['status' => false, 'message' => 'PDF parsing timed out.'];
        }

        $output = $result['stdout'];
        $error  = $result['stderr'];

        if (!empty($error)) {
            Log::error('[NidPdfParser] Python Stderr Output', ['stderr' => $error]);
        }

        // Debug: log raw output when < 5 fields found
        $decoded = json_decode(trim($output), true);

        if (isset($decoded['_debug_raw'])) {
            Log::info('[NidPdfParser] RAW TEXT from PDF', ['raw' => $decoded['_debug_raw']]);
        } elseif (isset($decoded['raw_text'])) {
            Log::info('[NidPdfParser] RAW TEXT from PDF (no fields)', ['raw' => $decoded['raw_text']]);
        }

        if (! is_array($decoded)) {
            Log::error('[NidPdfParser] Invalid JSON output', [
                'raw_stdout' => $output,
                'raw_stderr' => $error
            ]);
            return ['status' => false, 'message' => 'PDF parser failed to process.'];
        }

        return $decoded;
    }

    public function parsePdf(UploadedFile $file)
    {
        return $this->parse($file);
    }

    protected function execWithTimeout(array $cmd, int $seconds): ?array
    {
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];

        $process = proc_open($cmd, $descriptors, $pipes);

        if (! is_resource($process)) {
            return null;
        }

        fclose($pipes[0]);
        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        $stdout    = '';
        $stderr    = '';
        $startTime = time();

        while (! feof($pipes[1]) || ! feof($pipes[2])) {
            if ((time() - $startTime) >= $seconds) {
                proc_terminate($process);
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);
                return null;
            }

            $outChunk = fread($pipes[1], 4096);
            if ($outChunk !== false) {
                $stdout .= $outChunk;
            }

            $errChunk = fread($pipes[2], 4096);
            if ($errChunk !== false) {
                $stderr .= $errChunk;
            }

            usleep(10_000);
        }

        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);

        return [
            'stdout' => $stdout,
            'stderr' => $stderr
        ];
    }
}
