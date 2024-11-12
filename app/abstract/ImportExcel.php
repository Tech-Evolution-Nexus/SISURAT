<?php

namespace app\abstract;

use PhpOffice\PhpSpreadsheet\IOFactory;

abstract class ImportExcel
{
    public function import($filePath)
    {
        $filePath = $filePath["tmp_name"];
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $importedData = [];

        $headerRow = $this->getHeaderRow($sheet);
        foreach ($sheet->getRowIterator(2) as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $rowData = [];
            $colIndex = 0;

            foreach ($cellIterator as $cell) {
                $columnName = $headerRow[$colIndex];
                $rowData[strtolower($columnName)] = $cell->getValue();
                $colIndex++;
            }

            $this->run($rowData);
            $importedData[] = $rowData;
        }

        return $importedData;
    }

    /**
     * Get the header row from the spreadsheet.
     *
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @return array
     */
    protected function getHeaderRow($sheet)
    {
        $headerRow = [];
        $row = $sheet->getRowIterator(1)->current();
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        foreach ($cellIterator as $cell) {
            $headerRow[] = $cell->getValue();
        }

        return $headerRow;
    }

    /**
     * Abstract method for processing each row's data.
     *
     * @param array $data
     */
    abstract public function run(array $data);
}
