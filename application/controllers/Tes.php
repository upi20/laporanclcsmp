<?php
defined('BASEPATH') or exit('No direct script access allowed');

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Tes extends Render_Controller
{
    // writer
    public function index()
    {
        $row = 2;
        $col_start = "A";
        $col_end = "E";
        // Header excel ================================================================================================
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Dokumen Properti
        $spreadsheet->getProperties()
            ->setCreator("Isep Lutpi Nur")
            ->setLastModifiedBy("Isep Lutpi Nur")
            ->setTitle("CLC SMP")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        // initial image ===============================================================================================
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(FCPATH . 'assets/img/kinabalu.jpg.jpg');
        $drawing->setHeight(100);
        $drawing->setOffsetX(20);
        $drawing->setOffsetY(10);
        $drawing->setCoordinates('A1');

        // set default font
        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);


        // header ======================================================================================================
        $sheet->mergeCells("C$row:" . $col_end . $row)
            ->setCellValue("C$row", 'KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN');
        $sheet->getStyle("C$row:" . $col_end . $row)->getFont()
            ->setSize(13);

        $row++;
        $sheet->mergeCells("C$row:" . $col_end . $row)
            ->setCellValue("C$row", 'SEKOLAH INDONESIA KOTA KINABALU');
        $sheet->getStyle("C$row:" . $col_end . $row)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 13
            ]
        ]);
        $row++;
        $sheet->mergeCells("C$row:" . $col_end . $row)
            ->setCellValue("C$row", "Jalan 3B KKIP Selatan Dua 88460 Kota Kinabalu Industrial Park");

        $row++;
        $sheet->mergeCells("C$row:" . $col_end . $row)
            ->setCellValue("C$row", "Kota Kinabalu, Sabah Malaysia");

        // set line
        $row++;
        $sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray([
            "borders" => [
                "bottom" => [
                    "borderStyle" => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    "color" => ["rgb" => "000000"],
                ],
            ],
        ]);

        // header 2 ====================================================================================================
        $row += 2;
        $sheet->mergeCells($col_start . $row . ":" . $col_end . $row)
            ->setCellValue("A$row", "REKAPITULASI PENGGUNAAN BANTUAN OPERASIONAL CLC JENJANG SMP");
        $sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 13
            ],
            "alignment" => [
                "horizontal" => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $row++;
        $sheet->mergeCells($col_start . $row . ":" . $col_end . $row)
            ->setCellValue("A$row", "PENGEMBANGAN STANDAR SARANA PRASARANA");
        $sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 13
            ],
            "alignment" => [
                "horizontal" => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $row++;
        $sheet->mergeCells($col_start . $row . ":" . $col_end . $row)
            ->setCellValue("A$row", "TAHUN 2021");
        $sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 13
            ],
            "alignment" => [
                "horizontal" => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // detail alamat sekolah =======================================================================================
        $row += 3;
        $sheet->setCellValue("B$row", "Nama Sekolah");
        $sheet->setCellValue("C$row", ": SMP 1 Bandung");

        $row++;
        $sheet->setCellValue("B$row", "Kota");
        $sheet->setCellValue("C$row", ": Kota Kinabalu");

        $row++;
        $sheet->setCellValue("B$row", "Negara");
        $sheet->setCellValue("C$row", ": Malaysia");

        $row++;
        $sheet->setCellValue("B$row", "Periode");
        $sheet->setCellValue("C$row", ": 2021-06-01 / 2021-06-30 ");

        // Tabel =======================================================================================================
        // Tabel Header
        $row += 2;
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '93C5FD',
                ]
            ],
        ];
        $sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray($styleArray);
        $row++;
        $styleArray['fill']['startColor']['rgb'] = 'E5E7EB';
        $sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray($styleArray);

        // poin-poin header disini
        $headers = [
            'No',
            'Tanggal',
            'Kode',
            'Uraian',
            'RM'
        ];

        // apply header
        for ($i = 0; $i < count($headers); $i++) {
            $sheet->setCellValue(chr(65 + $i) . ($row - 1), $headers[$i]);
            $sheet->setCellValue(chr(65 + $i) . $row, ($i + 1));
        }

        // tabel body
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $row++;
        $sheet->getStyle($col_start . $row . ":" . $col_end . ($row + 5))->applyFromArray($styleArray);

        // footer
        $row += 8;
        $sheet->setCellValue($col_start . $row, "Mengetahui");
        $sheet->setCellValue("E$row", "Kota Kinabalu, 30 Juni 2021");

        $row++;
        $sheet->setCellValue($col_start . $row, "Kepala Sekolah");
        $sheet->setCellValue("E$row", "Pemegang Kas");

        $row += 3;
        $sheet->setCellValue($col_start . $row, "Dadang Hermawan, M.Ed.");
        $sheet->setCellValue("E$row", "NIP. 19700731 199803 1 005");

        $row++;
        $sheet->setCellValue($col_start . $row, "Dede Kurniawan, S.Pd.");
        $sheet->setCellValue("E$row", "NIP. -");

        // function for width column
        function w($width)
        {
            return 0.71 + $width;
        }

        // set width column
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(w(4));
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(w(17));
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(w(10));
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(w(30));
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(w(27));

        // add image
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        // set  printing area
        $spreadsheet->getActiveSheet()->getPageSetup()->setPrintArea($col_start . '1:' . $col_end . $row);
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        // margin
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(1);

        // page center on
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Lab.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
    }

    // uploader file
    public function upload()
    {
        $this->load->view('upload');
    }

    // reader
    public function read()
    {
        $fileName = $_FILES['file']['name'];

        $config['upload_path'] = './assets/'; //path upload
        $config['file_name'] = $fileName;  // nama file
        $config['allowed_types'] = 'xls|xlsx|csv'; //tipe file yang diperbolehkan
        $config['max_size'] = 100000; // maksimal sizze

        $this->load->library('upload'); //meload librari upload
        $this->upload->initialize($config);

        $file_location = "";

        if (!$this->upload->do_upload('file')) {
            echo $this->upload->display_errors();
            exit();
        } else {
            $file_location = array('upload_data' => $this->upload->data());
            $file_location = $file_location['upload_data']['full_path'];
        }


        // excel reader

        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_location);
        var_dump($spreadsheet->getActiveSheet()->toArray());
        die;
    }
}
