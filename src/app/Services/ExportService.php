<?php

namespace App\Services;

use Spatie\ArrayToXml\ArrayToXml;

class ExportService
{
    public function csv(string $fileName, array $columns, array $data): array
    {
        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($data as $items) {
                $row = [];
                foreach ($items as $key => $item) {
                    $row[$key] = $items[$key];
                }
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return ['callback' => $callback, 'headers' => $this->makeHeader($fileName, 'csv')];
    }

    public function xml(string $fileName, array $array): array
    {
        $xmlData = ArrayToXml::convert(['__numeric' => $array]);
        return ['xmlData' => $xmlData, 'headers' => $this->makeHeader($fileName, 'xml')];
    }

    private function makeHeader(string $fileName, string $fileExtension): array
    {
        return [
            "Content-type" => "text/$fileExtension",
            "Content-Disposition" => "attachment; filename=$fileName.$fileExtension",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
    }
}
