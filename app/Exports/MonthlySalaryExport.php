<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use Spatie\Pdf\Pdf;
use Spatie\Pdf\Structure;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;


class MonthlySalaryExport implements FromCollection, WithTitle, WithEvents, WithHeadings
{
    private $basicSalaryCollection;
    private $benefitsCollection;
    private $deductionsCollection;
    private $workOvertime;
    private $netSalary;
    private $month;
    private $customHeading;
    private $totalBenefits;
    private $totalDeductions;
    

    public function __construct($basicSalaryCollection, $benefitsCollection, $deductionsCollection, $workOvertime, $netSalary, $month, $customHeading)
    {
        $this->basicSalaryCollection = $basicSalaryCollection;
        $this->benefitsCollection = $benefitsCollection;
        $this->deductionsCollection = $deductionsCollection;
        $this->workOvertime = $workOvertime;
        $this->netSalary = $netSalary;
        $this->month = $month;
        $this->customHeading = $customHeading;
        // $this->totalBenefits = $totalBenefits;
        // $this->totalDeductions = $totalDeductions;
    }

    public function collection()
    {
        // Merge all the collections into one
        $mergedCollection = new Collection();
        $mergedCollection->push([
            'Basic Salary' => number_format($this->basicSalaryCollection),
            'Work Overtime' => number_format($this->workOvertime),
            'Benefits' => '',
            'Deductions' => '',
        ]);

        foreach ($this->benefitsCollection as $benefit) {
            $mergedCollection->push([
                'Basic Salary' => '',
                'Work Overtime' => '',
                'Benefits' => "{$benefit->name} - " . number_format($benefit->amount),
                'Deductions' => '',
            ]);
        }

        foreach ($this->deductionsCollection as $deduction) {
            $mergedCollection->push([
                'Basic Salary' => '',
                'Work Overtime' => '',
                'Benefits' => '',
                'Deductions' => "{$deduction->name} - " . number_format($deduction->amount),
            ]);
        }

        $mergedCollection->push([
            'Basic Salary' => '',
            'Work Overtime' => '',
            'Benefits' => '',
            'Deductions' => '',
        ]);


        return $mergedCollection;
    }

    public function headings(): array
    {
        return [
            [$this->customHeading],
            ['Basic Salary', 'Work Overtime', 'Benefits', 'Deductions'],
        ];
    }

    public function title(): string
    {
        return 'Salary Payslip - ' . $this->month;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Styling and formatting code can be added here
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->getStyle('A1:D1')->getAlignment()->setVertical('center');
                $event->sheet->getStyle('A1:D1')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('A1:D1')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:D1')->getFont()->setSize(18);

                $event->sheet->getStyle('A2:D2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    
                ]);

                $columnsToAutosize = ['A', 'B', 'C', 'D'];
                foreach ($columnsToAutosize as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }

                $lastRow = $event->sheet->getDelegate()->getHighestRow();
                $lastColumn = $event->sheet->getDelegate()->getHighestColumn();
                $tableRange = "A3:{$lastColumn}{$lastRow}";
                $totalsRow = $lastRow + 1;
                $netSalaryRow = $totalsRow + 1;

                $event->sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->getStyle("B2:B{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->getStyle("C2:C{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->getStyle("D2:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $event->sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // $event->sheet->setCellValue("C{$totalsRow}", $this->totalDeductions);
                // $event->sheet->setCellValue("D{$totalsRow}",  $this->totalBenefits);

                $event->sheet->mergeCells("A{$netSalaryRow}:D{$netSalaryRow}");
                $event->sheet->setCellValue("A{$netSalaryRow}", 'Net Salary'.'              '.number_format($this->netSalary));
         
                

                $event->sheet->getStyle("A{$totalsRow}:D{$totalsRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $event->sheet->getStyle("A{$netSalaryRow}:D{$netSalaryRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);


                
            },
        ];
    }

    

}
