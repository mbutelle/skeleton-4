<?php

namespace App\Shared\Infrastructure\Csv;

class CsvFileWriter
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var bool|resource
     */
    private $fileDescriptor;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var array
     */
    private $headers;

    /**
     * @param string|null $file
     * @param array|null  $headers
     * @param string|null $delimiter
     */
    public function __construct($file = null, array $headers = array(), $delimiter = ';')
    {
        if (!$file) {
            $file = 'php://stdout';
        }

        $this->delimiter = $delimiter;
        $this->file = $file;
        $this->headers = $headers;

        $this->fileDescriptor = $this->createFileDescriptor($this->file);

        if ($this->headers) {
            fputcsv($this->fileDescriptor, $this->headers, $this->delimiter);
        }
    }

    /**
     * @param array $line
     *
     * @throws \InvalidArgumentException
     */
    public function write(array $line)
    {
        $this->checkLine($line);
        $this->checkLineWithHeader($line);

        fputcsv($this->fileDescriptor, $line, $this->delimiter);
    }

    /**
     * @throws \LogicException
     */
    public function close()
    {
        if (null === $this->fileDescriptor) {
            throw new \LogicException('Cannot close the writer, it was not opened.');
        }

        fclose($this->fileDescriptor);
        $this->fileDescriptor = null;
    }

    /**
     * @param $file
     *
     * @return bool|resource
     */
    private function createFileDescriptor($file)
    {
        if (!is_dir(\dirname($file))) {
            mkdir(\dirname($file), 0775, true);
        }

        $fp = @fopen($file, 'w');
        if (false === $fp) {
            throw new \RuntimeException(sprintf(
                'Unable to write to file "%s".',
                $file
            ));
        }

        return $fp;
    }

    /**
     * @param array $line
     */
    private function checkLine(array $line)
    {
        foreach ($line as $value) {
            if (\is_array($value) || \is_object($value)) {
                throw new \InvalidArgumentException(
                    sprintf('Expected a scalar, got a "%s".',
                        \is_object($value) ? \get_class($value) : strtolower(\gettype($value)))
                );
            }
        }
    }

    /**
     * @param array $line
     */
    private function checkLineWithHeader(array $line)
    {
        if (!$this->headers) {
            return;
        }

        if (array_diff($this->headers, array_keys($line))) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The line to insert in the file is incorrect.'."\n"
                    .'Please respect the format of the header "[\'%s\']".'."\n"
                    .'Current line: "[\'%s\']".'."\n",
                    implode('\', \'', $this->headers),
                    implode('\', \'', array_keys($line))
                )
            );
        }
    }
}
