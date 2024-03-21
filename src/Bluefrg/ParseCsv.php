<?php
declare(strict_types=1);

namespace Bluefrg;

class ParseCsv extends \SplFileObject
{
    protected array $_aHeaders = [];

    public function __construct($sCsvFile)
    {
        parent::__construct($sCsvFile, 'r');

        $this->setFlags(self::SKIP_EMPTY | self::READ_AHEAD | self::DROP_NEW_LINE | self::READ_CSV);
    }

    /**
     * Set the first row as the row containing headers
     * WARNING This will reset the pointer
     * @param bool $bFirstRowHeader
     */
    public function firstRowHeader(bool $bFirstRowHeader = true): void
    {
        parent::rewind();

        if ($bFirstRowHeader === true) {
            $this->_aHeaders = parent::current();
            parent::next();
        }
        else {
            $this->_aHeaders = [];
        }
    }

    /**
     * Retrieve an array of header values
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->_aHeaders;
    }

    public function rewind(): void
    {
        parent::rewind();

        if ( count($this->_aHeaders) ) {
            // We need to move the pointer to the row after the header
            parent::next();
        }
    }

    public function current(): false|array|string
    {
        if ( count($this->_aHeaders) ) {
            return array_combine($this->_aHeaders, parent::current());
        }

        return parent::current();
    }

    public function seek($iLinePos): void
    {
        parent::seek(++$iLinePos);
    }

    /**
     * Parse CSV as string data instead of a file
     * @param string $sCsvBody
     * @return self
     */
    public static function string(string $sCsvBody): self
    {
        fwrite($rFp = tmpfile(), $sCsvBody);

        return new self(stream_get_meta_data($rFp)['uri']);
    }
}