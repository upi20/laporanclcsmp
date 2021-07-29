<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RekapRAB extends Render_Controller
{


    public function index()
    {
        // Page Settings
        $this->title           = 'Laporan Rekapitulasi RAB Tahunan';
        $this->content           = 'laporan-rekap-rab';
        $this->navigation         = ['Laporan', 'Rekapitulasi RAB'];
        $this->plugins           = ['datatables', 'daterangepicker'];

        // Breadcrumb setting
        $this->breadcrumb_1       = 'Dashboard';
        $this->breadcrumb_1_url     = base_url() . 'dashboard';
        $this->breadcrumb_2       = 'Laporan Rekap';
        $this->breadcrumb_2_url     = '#';

        // Send data to view
        $this->data['tahun'] = date("Y");
        $this->render();
    }

    // excel sebelumnya
    public function cetak1()
    {
        // footer laporan
        $this->load->model('pengaturan/LaporanModel', 'laporan');
        $data['laporan'] = $this->laporan->getData();
        $semester = $this->input->get("semester");

        // header tabel
        $semester1 = '<th>Januari</th><th>Februari</th><th>Maret</th><th>April</th><th>Mei</th><th>Juni</th>';
        $semester2 = '<th>Juli</th><th>Agustus</th><th>September</th><th>Oktober</th><th>Nopember</th><th>Desember</th>';
        // custom month
        $jml_bulan = 12;
        $month_column = '';
        $month_start = 1;
        $month_end = 12;
        // date selected comparaison
        if ($semester == "1") {
            $jml_bulan = 6;
            $month_column = $semester1;
            $month_end = 6;
        } else if ($semester == "2") {
            $jml_bulan = 6;
            $month_column = $semester2;
            $month_start = 7;
            $month_end = 12;
        } else {
            $jml_bulan = 12;
            $month_column = $semester1 . $semester2;
        }

        // Send data to view
        $tahun = $this->input->get('tahun');
        $data['rekaps'] = $this->rekap->rekapRabCabangs($tahun, $month_start, $month_end);
        $data['jml_bulan'] = $jml_bulan;
        $data['month_column'] = $month_column;
        $data['month_start'] = $month_start;
        $data['month_end'] = $month_end;
        $data['semester'] = ($semester == "1" || $semester == "2") ? "SEMESTER " . $semester : "";
        $this->load->view("templates/export/eksport-excel-laporan-rekap-rab", $data);
    }

    public function cetak()
    {
        // header laporan
        $this->load->model('pengaturan/LaporanModel', 'laporan');
        $laporan = $this->laporan->getData();
        $semester = $this->input->get("semester");
        $tahun = $this->input->get("tahun");
        // function for width column
        function w($width)
        {
            return 0.71 + $width;
        }

        // custom month
        $jml_bulan = 12;
        $month_start = 1;
        $month_end = 12;
        // date selected comparaison
        if ($semester == "1") {
            $jml_bulan = 6;
            $month_end = 6;
        } else if ($semester == "2") {
            $jml_bulan = 6;
            $month_start = 7;
            $month_end = 12;
        } else {
            $jml_bulan = 12;
        }
        $semester = ($semester == "1" || $semester == "2") ? "SEMESTER " . $semester . " " : "";

        $rekaps = $this->rekap->rekapRabCabangs($tahun, $month_start, $month_end);
        // detail
        $bulan_array = [
            1 => 'Januari',
            2 => 'February',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $today_m = (int)Date("m");
        $today_d = (int)Date("d");
        $today_y = (int)Date("Y");

        $last_date_of_this_month =  date('t', strtotime(date("Y-m-d")));
        $date = $last_date_of_this_month . " " . $bulan_array[$today_m] . " " . $today_y;

        // laporan baru
        $row = 2;
        $col_start = "A";
        $col_end = chr(64 + $jml_bulan + 4);

        $title_excel = "REKAPITULASI REALISASI ANGGARAN BANTUAN OPERASIONAL CLC SMP $semester TAHUN $tahun";
        // Header excel ================================================================================================
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Dokumen Properti
        $spreadsheet->getProperties()
            ->setCreator("SIKK")
            ->setLastModifiedBy("SIKK")
            ->setTitle($title_excel)
            ->setSubject("SIKK")
            ->setDescription("REKAPITULASI REALISASI ANGGARAN BANTUAN OPERASIONAL CLC SMP $semester TAHUN $tahun")
            ->setKeywords("CLC SMP")
            ->setCategory("Test result file");

        // initial image ===============================================================================================
        $linux = FCPATH . 'assets/img/kinabalu.jpg';
        $windows = FCPATH . 'assets\img\kinabalu.jpg';
        $linux_cek = file_exists($linux);
        $windows_cek = file_exists($windows);
        $foto = $linux_cek ? $linux : $windows;
        if ($linux_cek || $windows_cek) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Logo');

            $drawing->setPath($foto);
            $drawing->setHeight(100);
            $drawing->setOffsetX(20);
            $drawing->setOffsetY(10);
            $drawing->setCoordinates('A1');
        }


        // set default font
        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);


        // header ======================================================================================================
        $header_title_start = "C";
        $sheet->mergeCells($header_title_start . $row . ":" . $col_end . $row)
            ->setCellValue($header_title_start . $row . "", 'KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN');
        $sheet->getStyle($header_title_start . $row . ":" . $col_end . $row)->getFont()
            ->setSize(13);

        $row++;
        $sheet->mergeCells($header_title_start . $row . ":" . $col_end . $row)
            ->setCellValue($header_title_start . $row . "", 'SEKOLAH INDONESIA KOTA KINABALU');
        $sheet->getStyle($header_title_start . $row . ":" . $col_end . $row)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 13
            ]
        ]);
        $row++;
        $sheet->mergeCells($header_title_start . $row . ":" . $col_end . $row)
            ->setCellValue($header_title_start . $row . "", "Jalan 3B KKIP Selatan Dua 88460 Kota Kinabalu Industrial Park");

        $row++;
        $sheet->mergeCells($header_title_start . $row . ":" . $col_end . $row)
            ->setCellValue($header_title_start . $row . "", "Kota Kinabalu, Sabah Malaysia");

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
            ->setCellValue("A$row", "REKAPITULASI REALISASI ANGGARAN BANTUAN OPERASIONAL");
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
            ->setCellValue("A$row", "CLC JENJANG SMP");
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
            ->setCellValue("A$row", $semester . "TAHUN " . $tahun);
        $sheet->getStyle($col_start . $row . ":" . $col_end . $row)->applyFromArray([
            "font" => [
                "bold" => true,
                "size" => 13
            ],
            "alignment" => [
                "horizontal" => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Tabel =======================================================================================================
        // Tabel Header
        $row += 2;
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
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
        $sheet->getStyle($col_start . $row . ":" . $col_end . ($row + 1))->applyFromArray($styleArray);
        $styleArray['fill']['startColor']['rgb'] = 'E5E7EB';
        $sheet->getStyle($col_start . ($row + 2) . ":" . $col_end . ($row + 2))->applyFromArray($styleArray);

        // apply header
        // numbering
        for ($i = 0; $i < $jml_bulan + 4; $i++) {
            $sheet->setCellValue(chr(65 + $i) . ($row + 2), ($i + 1));
        }

        // header tabel
        $col_index = 0;
        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
            ->setCellValue(chr(65 + $col_index) . $row, "No");
        $spreadsheet->getActiveSheet()->getColumnDimension(chr(65 + $col_index))->setWidth(w(4));

        $col_index++;
        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
            ->setCellValue(chr(65 + $col_index) . $row, "Nama CLC");
        $spreadsheet->getActiveSheet()->getColumnDimension(chr(65 + $col_index))->setWidth(w(15));

        $col_index++;
        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
            ->setCellValue(chr(65 + $col_index) . $row, "Total Anggaran");
        $spreadsheet->getActiveSheet()->getColumnDimension(chr(65 + $col_index))->setWidth(w(15));

        $col_index++;
        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index + $jml_bulan - 1) . ($row))
            ->setCellValue(chr(65 + $col_index) . $row, "Pengeluaran Bulan (RM)");
        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index  + $jml_bulan - 1) . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index  + $jml_bulan - 1) . ($row))->getFont()->setBold(true);


        // bulan
        $col_plus = false;
        for ($i = $month_start; $i <=  $month_end; $i++) {
            if ($col_plus) $col_index++;
            $col_plus = true;
            $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), $bulan_array[$i]);
            $spreadsheet->getActiveSheet()->getColumnDimension(chr(65 + $col_index))->setWidth(w(10));
        }

        $col_index++;
        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
            ->setCellValue(chr(65 + $col_index) . $row, "Jumlah Pengeluaran");
        $spreadsheet->getActiveSheet()->getColumnDimension(chr(65 + $col_index))->setWidth(w(20));

        $col_index++;
        // $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
        // ->setCellValue(chr(65 + $col_index) . $row, "Saldo");
        $spreadsheet->getActiveSheet()->getColumnDimension(chr(65 + $col_index))->setWidth(w(25));

        $row += 2;
        $start_tabel = $row + 1;
        foreach ($rekaps as $rekap) {
            $c = 0;
            $row++;
            $sheet->setCellValue(chr(65 + $c) . "$row", ($row - 14));
            $sheet->setCellValue(chr(65 + ++$c) . "$row", $rekap['nama']);

            // tanpa nol
            $sheet->setCellValue(chr(65 + ++$c) . "$row", $rekap['anggaran'] == 0 ? "" : $rekap['anggaran']);
            for ($i = $month_start; $i <= $month_end; $i++) $sheet->setCellValue(chr(65 + ++$c) . "$row", $rekap['realisasi'][$i] == 0 ? "" : $rekap['realisasi'][$i]);
            $sheet->setCellValue(chr(65 + ++$c) . "$row", $rekap['pengeluaran'] == 0 ? "" : $rekap['pengeluaran']);
            // $sheet->setCellValue(chr(65 + ++$c) . "$row", $rekap['saldo'] == 0 ? "" : $rekap['saldo']);

            // dengan nol
            // $sheet->setCellValue(chr(65 + ++$c) . "$row", $rekap['anggaran']);
            // for ($i = $month_start; $i <= $month_end; $i++) $sheet->setCellValue(chr(65 + ++$c) . "$row", $rekap['realisasi'][$i]);
            // $sheet->setCellValue(chr(65 + ++$c) . "$row", $rekap['pengeluaran']);
            // $sheet->setCellValue(chr(65 + ++$c) . "$row", $rekap['saldo']);
        }

        // format
        // nomor center
        $sheet->getStyle($col_start . $start_tabel . ":" . $col_start . $row)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // border all data

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle($col_start . $start_tabel . ":" . $col_end . $row)
            ->applyFromArray($styleArray);

        $sheet->getStyle("C" . $start_tabel . ":" . $col_end . $row)
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        // $code_rm = '_("RM"* #.##0,00_);_("RM"* (#.##0,00);_("RM"* "-"??_);_(@_)';
        // $sheet->getStyle("D" . $start_tabel . ":" . $col_end . $row)
        //     ->getNumberFormat()
        //     ->setFormatCode($code_rm);


        // set alignment
        // $sheet->getStyle("C" . $start_tabel . ":E" . $row)
        //     ->getAlignment()
        //     ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // footer
        $row += 3;
        $sheet->setCellValue($col_start . $row, "Mengetahui");
        $sheet->setCellValue($col_end . $row, $laporan['kota'] . ", " . $date);

        $row++;
        $sheet->setCellValue($col_start . $row, "Kepala Sekolah");
        $sheet->setCellValue($col_end . $row, "Pemegang Kas");

        $row += 3;
        $sheet->setCellValue($col_start . $row, $laporan['kepala_nama']);
        $sheet->setCellValue($col_end . $row, $laporan['kas_nama']);

        $row++;
        $sheet->setCellValue($col_start . $row, "NIP. " . $laporan['kepala_nip']);
        $sheet->setCellValue($col_end . $row, "NIP. " . $laporan['kas_nip']);

        // add image
        if ($linux_cek || $windows_cek) {
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
        }
        // set  printing area
        $spreadsheet->getActiveSheet()->getPageSetup()->setPrintArea($col_start . '1:' . $col_end . $row);
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        // margin
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0);

        // page center on
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $title_excel . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }




    // Ajax Data
    public function ajax_data()
    {
        $tahun   = $this->input->post('tahun');
        $month_start   = $this->input->post('start');
        $month_end   = $this->input->post('end');
        $start   = $this->input->post('start');
        $draw   = $this->input->post('draw');
        $length = $this->input->post('length');
        $cari   = $this->input->post('search');

        $tanggal =  $this->input->post('tanggal');
        $cabang =  $this->input->post('cabang');

        array($cari);

        $data   =  $this->rekap->rekapRabCabangs($tahun, $month_start, $month_end);
        $count = count($data);
        echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $cari, 'data' => $data));
    }

    public function getDdataKode()
    {
        $kode = $this->input->post('kode');

        $exe = $this->Sm->getDataKode($kode);

        $this->output_json(
            [
                'id'           => $exe['id'],
                'tanggal' => $exe['tanggal'],
                'kode' => $exe['kode'],
                'uraian' => $exe['uraian'],
            ]
        );
    }


    function __construct()
    {
        parent::__construct();
        $this->load->model('laporan/rekapRABModel', 'rekap');
        $this->default_template = 'templates/dashboard';
        $this->load->library(['plugin', 'Libs']);
        $this->load->helper('url');

        // Cek session
        $this->sesion->cek_session();
    }
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */