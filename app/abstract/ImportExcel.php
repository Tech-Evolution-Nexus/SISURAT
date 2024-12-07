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
                $value = $cell->getValue();

                $cellFormat = $cell->getStyle()->getNumberFormat()->getFormatCode();

                // Periksa apakah nilai adalah tanggal (Excel timestamp)
                if (
                    is_numeric($value)
                    && $value >= 1
                    && $value <= 2958465
                    && (strpos($cellFormat, 'd') !== false || strpos($cellFormat, 'y') !== false)
                ) {
                    $unixDate = ($value - 25569) * 86400; // Konversi Excel timestamp ke UNIX timestamp
                    $formattedDate = date('Y-m-d', $unixDate); // Format tanggal
                    $value = $formattedDate;
                }
                $rowData[strtolower(str_replace(" ", "_", $columnName))] = $value;
                $colIndex++;
            }

            $this->run($rowData);
            $importedData[] = $rowData;
        }

        return $importedData;
    }


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

    abstract public function run(array $data);
}
