<?php
use Bluefrg\ParseCsv;

class ParseCsvTest extends PHPUnit_Framework_TestCase
{
    const DUMMY_FILE = 'tests/dummyData.csv';

    public function testRowHasKeys()
    {
        $oCsv = new ParseCsv(self::DUMMY_FILE);
        $oCsv->firstRowHeader();

        $aRow = $oCsv->current();

        $this->assertArrayHasKey('sContractNumber', $aRow);
        $this->assertArrayHasKey('sContractStatus', $aRow);
        $this->assertArrayHasKey('sCustFirstName', $aRow);
    }

    public function testRowNoKeys()
    {
        $oCsv = new ParseCsv(self::DUMMY_FILE);
        // We're not using using the first row as the header

        $aRow = $oCsv->current();

        $this->assertArrayNotHasKey('sContractNumber', $aRow);
        $this->assertArrayNotHasKey('sContractStatus', $aRow);
        $this->assertArrayNotHasKey('sCustFirstName', $aRow);
    }

    public function testGetHeaders()
    {
        $oCsv = new ParseCsv(self::DUMMY_FILE);
        $oCsv->firstRowHeader();

        $aRow = $oCsv->current();

        $this->assertEquals(count($aRow), count($oCsv->getHeaders()));
    }

    public function testSeek()
    {
        // We need to change seek to omit the header column
        $oCsv = new ParseCsv(self::DUMMY_FILE);
        $oCsv->firstRowHeader();

        $oCsv->seek(0);

        $aRow = $oCsv->current();

        // If seek is working properly, the seek(0) should return the first data record and not the header row
        $this->assertFalse(in_array('sContractNumber', $aRow));
    }

    public function testString()
    {
        $sCsvBody = <<<H
id,firstName
11,Billy
H;
        $oCsv = ParseCsv::string($sCsvBody);
        $oCsv->firstRowHeader();

        $aRow = $oCsv->current();

        $this->assertEquals('Billy', $aRow['firstName']);
    }
}
