<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends Render_Controller
{
    // kode rabs
    private $kode = [
        ['3.1'], // Pengembangan Perpustakaan
        ['3.3'], // Penerimaan Peserta Didik Baru
        // Kegiatan pembelajaran dan eskul siswa
        [
            '3,2', // Pengadaan Alat dan Media Pembelajaran
            '3.4', // Kegiatan Kesiswaan
        ],
        ['8'], // Pengembangan dan implementasi sistem penilaian
        ['6.1.2'], // Pembelian alat dan bahan habis pakai
        ['7.2'], // Langganan Daya dan Jasa
        ['3.5'], // Baju Seragam Siswa
        ['Pembiayaan Pengelolaan Bantuan'],
        ['5'], // Pengembangan Sarana dan Prasarana Sekolah
        ['4'] // Pengembangan Pendidik dan Tenaga Kependidikan
    ];

    private $kodes = [
        '1' => [
            '2' => '1'
        ],
        '2' => [
            '3' => '2'
        ],
        '3' => [
            '0' => '3.2',
            '1' => '3.3',
            '2' => '3.1',
            '6' => '3.4'
        ],
        '4' => [

            '9' => '4'
        ],
        '5' => [
            '8' => '5'
        ],
        '6' => [
            '4' => '6.1',
            '7' => '6.2'
        ],
        '7' => [
            '5' => '7.1',
            '6' => '7.2'
        ],
        '8' => [
            '4' => '7.2',
            '5' => '7.1'
        ],
    ];

    public function index()
    {
        // Page Settings
        $this->title           = 'Laporan Rekap';
        $this->content           = 'laporan-rekap';
        $this->navigation         = ['Laporan', 'Rekap'];
        $this->plugins           = ['datatables', 'daterangepicker'];

        // Breadcrumb setting
        $this->breadcrumb_1       = 'Dashboard';
        $this->breadcrumb_1_url     = base_url() . 'dashboard';
        $this->breadcrumb_2       = 'Laporan Rekap';
        $this->breadcrumb_2_url     = '#';

        // Send data to view
        $cabang = $this->db->select("id, kode")->from('cabangs')->where("user_id <>", '1')->get()->result_array();
        $this->data['listCabang'] = $cabang == null ? [] : $cabang;
        $this->render();
    }


    // Ajax Data
    public function ajax_data()
    {
        $start   = $this->input->post('start');
        $draw   = $this->input->post('draw');
        $length = $this->input->post('length');
        $cari   = $this->input->post('search');

        $tanggal =  $this->input->post('tanggal');
        $cabang =  $this->input->post('cabang');

        if (isset($cari['value'])) {
            $_cari = $cari['value'];
        } else {
            $_cari = null;
        }

        $data = $this->rekap->getDanaPenggunaanOperasional($this->kodes, $tanggal, $cabang);
        $count   = count($data);

        array($cari);

        echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data['data']));
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
    public function cetak1()
    {
        // footer laporan
        $this->load->model('pengaturan/LaporanModel', 'laporan');
        $cabang = $this->input->get('cabang');
        $tanggal_start =  $this->input->get('tanggal-start');
        $tanggal_end =  $this->input->get('tanggal-end');
        $data['tahun'] = explode("-", $tanggal_start)[0];
        $tanggal = json_encode([
            'start' => $tanggal_start,
            'end' => $tanggal_end,
        ]);


        // isi laporan
        $this->load->library('libs');
        $cabang = $this->input->get('cabang');
        $data['detail'] = $this->rekap->getCetakDetail($tanggal, $cabang);
        $data['datas'] = $data = $this->rekap->penggunaanDanaOperasional($this->kode, $tanggal, $cabang);
        $data['laporan'] = $this->laporan->getData();

        // wajib
        $data['head'] = $this->rekap->getCetakHead($cabang);
        $data['periode'] = $tanggal_start == $tanggal_end ? $tanggal_end : "$tanggal_start / $tanggal_end";

        // load view
        $this->load->view("templates/export/eksport-excel-laporan-bln", $data);
    }

    private function w($width)
    {
        return 0.71 + $width;
    }

    public function cetak()
    {
        // footer laporan
        $this->load->model('pengaturan/LaporanModel', 'laporan');
        $laporan = $this->laporan->getData();
        $cabang = $this->input->get('cabang');
        $tanggal_start =  $this->input->get('tanggal-start');
        $tanggal_end =  $this->input->get('tanggal-end');

        // dumy data
        // $cabang = '1';
        // $tanggal_start =  "2021-01-01";
        // $tanggal_end =  "2021-06-30";

        $tanggal = json_encode([
            'start' => $tanggal_start,
            'end' => $tanggal_end,
        ]);

        // init kode menurut tabel fisik


        $head = $this->db->get_where('cabangs', ['id' => $cabang])->row_array();
        $tahun = explode("-", $tanggal_end)[0];
        $periode = $tanggal_start == $tanggal_end ? $tanggal_end : "$tanggal_start / $tanggal_end";
        $detail = $this->rekap->getDanaPenggunaanOperasional($this->kodes, $tanggal, $cabang);


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
        $col_end = "M";
        $title_excel = "REKAP REALISASI PENGGUNAAN BANTUAN OPERASIONAL " . $head['nama'];
        // Header excel ================================================================================================
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Dokumen Properti
        $spreadsheet->getProperties()
            ->setCreator("SIKK")
            ->setLastModifiedBy("SIKK")
            ->setTitle($title_excel)
            ->setSubject("SIKK")
            ->setDescription("Laporan Buku Kas Umum " . $head['nama'] . ' Periode ' . $periode)
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
            $drawing->setOffsetX(-20);
            $drawing->setOffsetY(10);
            $drawing->setCoordinates('C1');
        }


        // set default font
        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);


        // header ======================================================================================================
        $header_title_start = "D";
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
            ->setCellValue("A$row", "REKAP REALISASI PENGGUNAAN BANTUAN OPERASIONAL");
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
            ->setCellValue("A$row", "TAHUN " . $tahun);
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
        $sheet->setCellValue("D$row", ": " . $head['nama']);

        $row++;
        $sheet->setCellValue("B$row", "Kota");
        $sheet->setCellValue("D$row", ": Kota " . $laporan['kota']);

        $row++;
        $sheet->setCellValue("B$row", "Negara");
        $sheet->setCellValue("D$row", ": Malaysia");

        $row++;
        $sheet->setCellValue("B$row", "Periode");
        $sheet->setCellValue("D$row", ": " . $periode);

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
        $sheet->getStyle($col_start . $row . ":" . $col_end . ($row + 1))->applyFromArray($styleArray);
        $styleArray['fill']['startColor']['rgb'] = 'E5E7EB';
        $sheet->getStyle($col_start . ($row + 2) . ":" . $col_end . ($row + 2))->applyFromArray($styleArray);

        // apply header
        // numbering
        for ($i = 0; $i < 13; $i++) {
            $sheet->setCellValue(chr(65 + $i) . ($row + 2), ($i + 1));
        }
        $text_rotate = [
            "font" => [
                "bold" => true
            ],
            "alignment" => [
                'wrapText' => TRUE,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $col_index = 0;
        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
            ->setCellValue(chr(65 + $col_index) . $row, "No Urut");
        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->applyFromArray($text_rotate);

        $col_index++;
        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
            ->setCellValue(chr(65 + $col_index) . $row, "Program Keahlian");
        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->applyFromArray($text_rotate);

        $col_index++;
        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index + 9) . ($row))
            ->setCellValue(chr(65 + $col_index) . $row, "Penggunaan Dana Bantuan Operasional");
        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index  + 9) . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index  + 9) . ($row))->getFont()->setBold(true);

        $start_orientation = $col_index;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Pengembangan Perpustakaan");
        $col_index++;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "PPDB");
        $col_index++;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Kegiatan pembelajaran dan eskul siswa");
        $col_index++;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Kegiatan ulangan dan ujian");
        $col_index++;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Pembelian bahan habis pakai");
        $col_index++;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Langganan daya dan jasa");
        $col_index++;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Bantuan Peserta Didik");
        $col_index++;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Pembiayaan Pengelolaan Bantuan");
        $col_index++;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Perbaikan/Pengadaan Sarana dan Prasarana Sekolah");
        $col_index++;
        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Peningkatan Kompetensi Guru dan Tenaga Kependidikan");

        // set orientasi 1 baris
        $sheet->getStyle(chr(65 + $start_orientation) . ($row + 1) . ":" . chr(65 + $col_index) . ($row + 1))->applyFromArray($text_rotate);

        $col_index++;
        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
            ->setCellValue(chr(65 + $col_index) . $row, "Jumlah");
        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->applyFromArray($text_rotate);
        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->getAlignment()->setTextRotation(0);

        $spreadsheet->getActiveSheet()->getRowDimension($row + 1)->setRowHeight(80);
        $row += 2;
        $start_tabel = $row + 1;
        foreach ($detail['data'] as $q) {
            $c = 0;
            $row++;
            $sheet->setCellValue(chr(65 + $c) . $row, $q['no_urut']);
            $sheet->setCellValue(chr(65 + ++$c) . $row, $q['uraian']);
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][0]) ? $q['penggunaan'][0] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][1]) ? $q['penggunaan'][1] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][2]) ? $q['penggunaan'][2] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][3]) ? $q['penggunaan'][3] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][4]) ? $q['penggunaan'][4] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][5]) ? $q['penggunaan'][5] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][6]) ? $q['penggunaan'][6] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][7]) ? $q['penggunaan'][7] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][8]) ? $q['penggunaan'][8] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, isset($q['penggunaan'][9]) ? $q['penggunaan'][9] : "");
            $sheet->setCellValue(chr(65 + ++$c) . $row, $q['jumlah']);
        }
        $row++;
        $jumlah_cell = "A" . $row . ":" . "B" . $row;
        $sheet->mergeCells($jumlah_cell)
            ->setCellValue("A" . $row, "Jumlah");
        $sheet->getStyle($jumlah_cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $c = 2;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);
        $c++;
        $rumus = "=sum(" . chr(65 + $c) . $start_tabel . ":" . chr(65 + $c) . ($row - 1) . ")";
        $sheet->setCellValue(chr(65 + $c) . $row, $rumus);

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
            "alignment" => [
                'wrapText' => TRUE,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
            ]
        ];
        $sheet->getStyle($col_start . $start_tabel . ":" . $col_end . $row)
            ->applyFromArray($styleArray);

        // $sheet->getStyle("F" . $start_tabel . ":" . $col_end . $row)->getNumberFormat()->setFormatCode($code_rm);
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
        $sheet->setCellValue("L" . $row, $laporan['kota'] . ", " . $date);

        $row++;
        $sheet->setCellValue($col_start . $row, "Kepala Sekolah");
        $sheet->setCellValue("L" . $row, "Pemegang Kas");

        $row += 3;
        $sheet->setCellValue($col_start . $row, $laporan['kepala_nama']);
        $sheet->setCellValue("L" . $row, $laporan['kas_nama']);

        $row++;
        $sheet->setCellValue($col_start . $row, "NIP. " . $laporan['kepala_nip']);
        $sheet->setCellValue("L" . $row, "NIP. " . $laporan['kas_nip']);

        // set width column
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth($this->w(4));
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth($this->w(30));
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth($this->w(14));
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth($this->w(14));

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

    function __construct()
    {
        parent::__construct();
        $this->load->model('laporan/bkuModel', 'rekap');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');

        // Cek session
        $this->sesion->cek_session();
    }
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */