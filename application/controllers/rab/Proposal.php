<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proposal extends Render_Controller
{
    public function index()
    {

        // Page Settings
        $this->title                     = 'Proposal';
        $this->navigation                 = ['Proposal'];
        $this->plugins                     = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1             = 'Dashboard';
        $this->breadcrumb_1_url         = base_url() . 'dashboard';
        $this->breadcrumb_2             = 'RAB';
        $this->breadcrumb_2_url         = '#';
        $this->breadcrumb_3             = 'Proposal';
        $this->breadcrumb_3_url         = '#';

        if ($this->session->userdata('data')['level'] == 'Super Admin') {
            $this->content = 'rab-proposal-admin';
            $cabang = $this->db->select("id, kode")->from('cabangs')->where("user_id <>", '1')->get()->result_array();
            $this->data['listCabang'] = $cabang == null ? [] : $cabang;
        } elseif ($this->session->userdata('data')['level'] == 'Admin Sekolah') {
            $this->content = 'rab-proposal-sekolah';
            $this->data['id_cabang'] = $this->id_cabang;
        }

        // Send data to view
        $this->render();
    }

    public function ajax_data()
    {

        $start          = $this->input->post('start');
        $draw           = $this->input->post('draw');
        $draw           = $draw == null ? 1 : $draw;
        $length         = $this->input->post('length');
        $cari           = $this->input->post('search');
        $id_cabang_adm  = $this->input->post('id_cabang');
        $status         = $this->input->post('status');
        $id_cabang      = $this->input->post('id');
        $order = ['order' => $this->input->post('order'), 'columns' => $this->input->post('columns')];
        if (isset($cari['value'])) {
            $_cari = $cari['value'];
        } else {
            $_cari = null;
        }

        $data     = $this->proposal->getAllData($draw, $length, $start, $_cari, $order, $id_cabang, $id_cabang_adm, $status)->result_array();
        $count    = $this->proposal->getAllData(null,  null,    null,   $_cari, null,   $id_cabang, $id_cabang_adm, $status)->num_rows();

        $this->output_json(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data));
    }

    public function insert()
    {
        $this->output_json($this->proposal->insert());
    }

    public function update()
    {
        // $id_cabang = $this->input->post("id_cabang");
        $id_proposal = $this->input->post("id_proposal");
        $judul = $this->input->post("judul");
        $keterangan = $this->input->post("keterangan");
        $ringgit = $this->input->post("ringgit");
        $rupiah = $this->input->post("rupiah");
        $tanggal_dari = $this->input->post("tanggal_dari");
        $tanggal_sampai = $this->input->post("tanggal_sampai");
        $termin = $this->input->post("termin");
        $rabs = json_decode($this->input->post("rabs"), true);
        $result = $this->proposal->update($id_proposal, $judul, $keterangan, $ringgit, $rupiah, $rabs, $tanggal_dari, $tanggal_sampai, $termin);
        $this->output_json($result);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        $result = $this->proposal->delete($id);
        $this->output_json($result);
    }

    public function getDataDetail()
    {
        $id_cabang = $this->input->post("id_cabang");
        $id_proposal = $this->input->post("id_proposal");
        $status = $this->input->post("status");
        $result = $this->proposal->getDataDetailAll($id_cabang, $id_proposal, $status);
        $this->output_json($result);
    }

    public function cekTambah()
    {
        $id = $this->input->post("id");
        $result = $this->proposal->cekTambah($id);
        $this->output_json($result);
    }

    public function ajukan()
    {
        $id = $this->input->post("id_proposal");
        $result = $this->proposal->ajukan($id);
        $this->output_json($result);
    }

    public function terima()
    {
        $id = $this->input->post("id");
        $result = $this->proposal->terima($id);
        $this->output_json($result);
    }

    public function tolak()
    {
        $id = $this->input->post("id");
        $result = $this->proposal->tolak($id);
        $this->output_json($result);
    }

    public function cairkan()
    {
        $id = $this->input->post("id");
        $result = $this->proposal->cairkan($id);
        $this->output_json($result);
    }

    public function exportExcel()
    {
        $id_cabang = $this->input->get("id_cabang");
        $id_cabang = $id_cabang == null ? $this->id_cabang : $id_cabang;

        $id_proposal = $this->input->get("id_proposal");
        $id_proposal = $id_proposal == null ? "0" : $id_proposal;

        $proposal_result = $this->proposal->exportExcel($id_proposal);
        $proposal_data = $this->db->get_where("proposal", ['id' => $id_proposal])->row_array();
        if ($proposal_data == null) {
            return $this->output_json(false);
        }

        // footer laporan
        $this->load->model('pengaturan/LaporanModel', 'laporan');
        $laporan = $this->laporan->getData();
        $tanggal_start =  $proposal_data['periode_dari'];
        $tanggal_end =  $proposal_data['periode_sampai'];
        $termin = $this->integerToRoman($proposal_data['periode_termin']);

        $head = $this->db->get_where('cabangs', ['id' => $id_cabang])->row_array();
        $tahun = explode("-", $tanggal_end)[0];

        $periode = $tanggal_start == $tanggal_end ? $tanggal_end : "$tanggal_start / $tanggal_end";
        // $detail = $this->rekap->getDanaPenggunaanOperasional($this->kodes, $tanggal, $cabang);

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
        $bulan_start = $bulan_array[(int)explode("-", $tanggal_start)[1]];
        $bulan_end = $bulan_array[(int)explode("-", $tanggal_end)[1]];
        $last_date_of_this_month =  date('t', strtotime(date("Y-m-d")));

        $date = $last_date_of_this_month . " " . $bulan_array[$today_m] . " " . $today_y;

        // laporan baru
        $row = 2;
        $col_start = "A";
        $col_end = "M";
        $nama_smp = isset($head['nama']) ? $head['nama'] : "";
        $title_excel = "PROPOSAL PENCAIRAN DANA BANTUAN OPERASIONAL CLC SMP " . $nama_smp;
        // Header excel ================================================================================================
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Dokumen Properti
        $spreadsheet->getProperties()
            ->setCreator("SIKK")
            ->setLastModifiedBy("SIKK")
            ->setTitle($title_excel)
            ->setSubject("SIKK")
            ->setDescription('PROPOSAL PENCAIRAN DANA BANTUAN OPERASIONAL CLC SMP Periode ' . $periode)
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
            $drawing->setOffsetX(-120);
            $drawing->setOffsetY(10);
            $drawing->setCoordinates('D1');
        }


        // set default font
        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);


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
            ->setCellValue("A$row", " PROPOSAL PENCAIRAN DANA BANTUAN OPERASIONAL CLC SMP");
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
            ->setCellValue("A$row", "TERMIN $termin (Periode $bulan_start - $bulan_end)");
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
        $sheet->setCellValue("B$row", "Nama CLC");
        $sheet->setCellValue("D$row", ": " . $nama_smp);

        $row++;
        $sheet->setCellValue("B$row", "Nama Pengelola");
        $sheet->setCellValue("D$row", ":");
        $sheet->getStyle("B" . ($row - 1) . ":D$row")->getFont()->setBold(true);
        // Tabel ===================================================================================================
        // Tabel Header
        $row += 2;
        foreach ($proposal_result as $proposal) {
            $sheet->setCellValue($col_start . $row, "  " . $proposal['kode'] . ". " . $proposal['uraian']);
            $sheet->getStyle($col_start . $row)->getFont()->setBold(true);
            $row++;
            if (count($proposal['sub']) > 0) {
                foreach ($proposal['sub'] as $proposal_sub_1) {
                    if (count($proposal_sub_1['sub']) > 0) {
                        $sheet->setCellValue("B" . $row, "  " . $proposal_sub_1['kode'] . ". " . $proposal_sub_1['uraian']);
                        $sheet->getStyle("B" . $row)->getFont()->setBold(true);
                        $row++;
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
                        $sheet->getStyle('B' . $row . ":" . $col_end . ($row + 1))->applyFromArray($styleArray);
                        $styleArray['fill']['startColor']['rgb'] = 'E5E7EB';
                        $sheet->getStyle('B' . ($row + 2) . ":" . $col_end . ($row + 2))->applyFromArray($styleArray);

                        // apply header
                        // numbering
                        for ($i = 0; $i < 12; $i++) {
                            $sheet->setCellValue(chr(66 + $i) . ($row + 2), ($i + 1));
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

                        $col_index = 1;
                        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
                            ->setCellValue(chr(65 + $col_index) . $row, "No.");
                        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->applyFromArray($text_rotate);

                        $col_index++;
                        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
                            ->setCellValue(chr(65 + $col_index) . $row, "Uraian");
                        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->applyFromArray($text_rotate);

                        $col_index++;
                        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index + 7) . ($row))
                            ->setCellValue(chr(65 + $col_index) . $row, "Satuan dan Volume");
                        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index  + 7) . ($row))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index  + 7) . ($row))->getFont()->setBold(true);

                        $start_orientation = $col_index;
                        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Vol");
                        $col_index++;
                        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Sat");
                        $col_index++;
                        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "");
                        $col_index++;
                        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Vol");
                        $col_index++;
                        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Sat");
                        $col_index++;
                        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "");
                        $col_index++;
                        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Vol");
                        $col_index++;
                        $sheet->setCellValue(chr(65 + $col_index) . ($row + 1), "Sat");
                        $col_index++;
                        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
                            ->setCellValue(chr(65 + $col_index) . $row, "Harga Satuan");
                        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->applyFromArray($text_rotate);
                        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->getAlignment()->setTextRotation(0);
                        $col_index++;
                        $sheet->mergeCells(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))
                            ->setCellValue(chr(65 + $col_index) . $row, "Jumlah");
                        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->applyFromArray($text_rotate);
                        $sheet->getStyle(chr(65 + $col_index) . $row . ":" . chr(65 + $col_index) . ($row + 1))->getAlignment()->setTextRotation(0);

                        // set orientasi 1 baris
                        $sheet->getStyle(chr(65 + $start_orientation) . ($row + 1) . ":" . chr(65 + $col_index) . ($row + 1))->applyFromArray($text_rotate);

                        // $spreadsheet->getActiveSheet()->getRowDimension($row + 1)->setRowHeight(80);
                        $row += 2;
                        $start_tabel = $row + 1;

                        // =============================================================================================================
                        $number = 1;
                        foreach ($proposal_sub_1['sub'] as $q) {
                            $c = 1;
                            $row++;

                            $jumlah_1 = (int)$q['jumlah_1_realisasi'];;
                            $jumlah_2 = $q['jumlah_2'];
                            $jumlah_3 = $q['jumlah_3'];
                            $sheet->setCellValue(chr(65 + $c) . $row, $number);
                            $sheet->setCellValue(chr(65 + ++$c) . $row, $q['nama']);
                            $col_jumlah_1 = chr(65 + ++$c) . $row;
                            $sheet->setCellValue($col_jumlah_1, $jumlah_1);
                            $sheet->setCellValue(chr(65 + ++$c) . $row, $q['satuan_1']);
                            $sheet->setCellValue(chr(65 + ++$c) . $row, "");
                            $col_jumlah_2 = chr(65 + ++$c) . $row;
                            $sheet->setCellValue($col_jumlah_2, 1);
                            $sheet->setCellValue(chr(65 + ++$c) . $row, $q['satuan_2']);
                            $sheet->setCellValue(chr(65 + ++$c) . $row, "");
                            $col_jumlah_3 = chr(65 + ++$c) . $row;
                            $sheet->setCellValue($col_jumlah_3, 1);
                            $sheet->setCellValue(chr(65 + ++$c) . $row, $q['satuan_3']);
                            $col_harga_ringgit = chr(65 + ++$c) . $row;
                            $sheet->setCellValue($col_harga_ringgit, $q['harga_ringgit']);
                            $sheet->setCellValue(chr(65 + ++$c) . $row, "=$col_jumlah_1*$col_jumlah_2*$col_jumlah_3*$col_harga_ringgit");
                            $number++;
                        }

                        $row++;
                        $jumlah_cell = "D" . $row . ":" . "K" . $row;
                        $sheet->mergeCells($jumlah_cell);
                        $sheet->getStyle($jumlah_cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->setCellValue("D" . $row, "Jumlah");

                        $sheet->setCellValue($col_end . $row, "=sum($col_end" . ($row - 1) . ":$col_end" . "$start_tabel)");
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
                        $sheet->getStyle("B" . $start_tabel . ":" . $col_end . $row)
                            ->applyFromArray($styleArray);

                        // $sheet->getStyle("F" . $start_tabel . ":" . $col_end . $row)->getNumberFormat()->setFormatCode($code_rm);
                        // $sheet->getStyle("C" . $start_tabel . ":" . $col_end . $row)
                        //     ->getNumberFormat()
                        //     ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        // $code_rm = '_("RM"* #.##0,00_);_("RM"* (#.##0,00);_("RM"* "-"??_);_(@_)';
                        // $sheet->getStyle("D" . $start_tabel . ":" . $col_end . $row)
                        //     ->getNumberFormat()
                        //     ->setFormatCode($code_rm);


                        // set alignment
                        // $sheet->getStyle("C" . $start_tabel . ":E" . $row)
                        //     ->getAlignment()
                        //     ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                        $row += 2;
                    }
                }
            }
        }

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
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth($this->w(4.57));
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth($this->w(4.57));
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth($this->w(33));
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth($this->w(3.57));
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth($this->w(5.71));
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth($this->w(2.14));
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth($this->w(3.57));
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth($this->w(5.71));
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth($this->w(2.14));
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth($this->w(3.57));
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth($this->w(5.71));
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

    private function w($width)
    {
        return 0.71 + $width;
    }

    function integerToRoman($integer)
    {
        // Convert the integer into an integer (just to make sure)
        $integer = intval($integer);
        $result = '';

        // Create a lookup array that contains all of the Roman numerals.
        $lookup = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );

        foreach ($lookup as $roman => $value) {
            // Determine the number of matches
            $matches = intval($integer / $value);

            // Add the same number of characters to the string
            $result .= str_repeat($roman, $matches);

            // Set the integer to be the remainder of the integer and the value
            $integer = $integer % $value;
        }

        // The Roman numeral should be built, return it
        return $result;
    }

    function __construct()
    {
        parent::__construct();
        $this->sesion->cek_session();
        $this->load->model('rab/ProposalModel', 'proposal');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');
        $this->cabangdetail = $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
        $this->id_cabang                 = $this->cabangdetail['id'];
        // Cek session
    }
}
