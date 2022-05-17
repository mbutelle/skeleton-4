<?php

namespace App\Shared\Infrastructure\Csv;

class CsvFileIterator implements \Iterator
{
    /**
     * @var string
     */
    private $file;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var bool|resource
     */
    private $fileDescriptor;

    /**
     * @var array
     */
    private $currentElement;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var array
     */
    private $linesWithError = array();

    /**
     * @var int
     */
    private $lineCounter = 1;

    /**
     * @param string      $file
     * @param string|null $delimiter
     */
    public function __construct($file, $delimiter = ';')
    {
        $this->file = $file;
        $this->delimiter = $delimiter;

        $this->fileDescriptor = $this->openFile();

        if (false === $this->fileDescriptor) {
            throw new \RuntimeException(sprintf('Unable to read file "%s".', $this->file));
        }

        $this->headers = fgetcsv($this->fileDescriptor, 0, $this->delimiter);
        if (false === $this->headers || $this->isNullArray($this->headers)) {
            throw new \RuntimeException(sprintf('Unable to read header from the file "%s".', $this->file));
        }

        $this->next();
    }

    /**
     * @return array
     */
    public function getLinesWithError()
    {
        return $this->linesWithError;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        preg_match('/([0-9A-Za-z_\-]+)\.csv/', $this->file, $matches);

        return $matches[1];
    }

    /**
     * @param $headers
     *
     * @return bool
     */
    private function isNullArray($headers)
    {
        // is it equal to [null] ?
        return \is_array($headers) && 1 == \count($headers) && !isset($headers[0]);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        if (\is_array($this->currentElement)) {
            return array_combine($this->headers, $this->currentElement);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        if (!$this->valid()) {
            return false;
        }

        if (!\is_resource($this->fileDescriptor)) {
            return false;
        }

        $this->currentElement = fgetcsv($this->fileDescriptor, 0, $this->delimiter);
        ++$this->lineCounter;

        if (!\is_array($this->currentElement)) {
            return $this->next();
        }

        if ($this->isNullArray($this->currentElement) || (\is_array($this->currentElement) && \count($this->currentElement) != \count($this->headers))) {
            $this->linesWithError[$this->lineCounter] = $this->currentElement;

            return $this->next();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->lineCounter;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        if (!\is_resource($this->fileDescriptor)) {
            return false;
        }

        if (feof($this->fileDescriptor)) {
            fclose($this->fileDescriptor);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        if (!\is_resource($this->fileDescriptor)) {
            $this->fileDescriptor = $this->openFile();
        }

        $this->lineCounter = 1;
        rewind($this->fileDescriptor);
        $this->headers = fgetcsv($this->fileDescriptor, 0, $this->delimiter);
        $this->next();
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return bool|resource
     */
    private function openFile()
    {
        return @fopen($this->file, 'r');
    }
}
