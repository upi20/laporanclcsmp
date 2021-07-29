<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Standard extends Render_Controller
{


  public function index()
  {
    // Page Settings
    $this->title           = 'Laporan Standard';
    $this->content           = 'laporan-standard';
    $this->navigation         = ['LAPORAN', 'Standar'];
    $this->plugins           = ['datatables', 'daterangepicker'];

    // Breadcrumb setting
    $this->breadcrumb_1       = 'Dashboard';
    $this->breadcrumb_1_url     = base_url() . 'dashboard';
    $this->breadcrumb_2       = 'Laporan Standard';
    $this->breadcrumb_2_url     = '#';

    // Send data to view
    $cabang = $this->db->select("id, kode")->from('cabangs')->where("user_id <>", '1')->get()->result_array();
    $this->data['listCabang'] = $cabang == null ? [] : $cabang;
    if ($this->session->userdata('data')['level'] == 'Admin Sekolah') {
      $this->data['cabangdetail'] = $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
      $this->content           = 'laporan-standard-sekolah';
    }
    $this->render();
  }


  // Ajax Data
  public function ajax_data()
  {
    $start   = $this->input->post('start');
    $draw   = $this->input->post('draw');
    $length = $this->input->post('length');
    $cari   = $this->input->post('search');

    $filter_data_kode = $this->input->post('kode');
    $filter_data_cabang =  $this->input->post('cabang');
    $filter_data_tanggal =  $this->input->post('tanggal');


    if (isset($cari['value'])) {
      $_cari = $cari['value'];
    } else {
      $_cari = null;
    }
    $data   = $this->Sm->getAllData($length, $start, $_cari, $filter_data_kode, $filter_data_tanggal, $filter_data_cabang)->result_array();
    $count   = count($data);


    array($cari);
    echo json_encode(array('recordsTotal' => $count, 'recordsFiltered' => $count, 'draw' => $draw, 'search' => $_cari, 'data' => $data, 'mod' => $filter_data_cabang));
  }

  public function cetak1()
  {
    // footer laporan
    $this->load->model('pengaturan/LaporanModel', 'laporan');
    $data['laporan'] = $this->laporan->getData();

    $start   = $this->input->get('start');
    $draw   = $this->input->get('draw');
    $length = $this->input->get('length');
    $cari   = $this->input->get('search');

    $filter_data_kode = $this->input->get('kode');
    $filter_data_cabang =  $this->input->get('cabang');
    $tanggal_start =  $this->input->get('tanggal-start');
    $tanggal_end =  $this->input->get('tanggal-end');

    $filter_data_tanggal = json_encode([
      'start' => $tanggal_start,
      'end' => $tanggal_end,
    ]);

    if (isset($cari['value'])) {
      $_cari = $cari['value'];
    } else {
      $_cari = null;
    }
    $data['tahun'] = explode("-", $tanggal_start)[0];
    $data['cabang'] = $this->db->get_where('cabangs', ['id' => $filter_data_cabang])->row_array();
    $data['periode'] = $tanggal_start == $tanggal_end ? $tanggal_end : "$tanggal_start / $tanggal_end";
    $data['standar'] = $this->Sm->getAllDataCetak($length, $start, $_cari, $filter_data_kode, $filter_data_tanggal, $filter_data_cabang)->result_array();
    $this->load->view("templates/export/eksport-excel-laporan-standar", $data);
  }

  public function cetak()
  {
    // footer laporan
    $this->load->model('pengaturan/LaporanModel', 'laporan');
    $laporan = $this->laporan->getData();
    $filter_data_cabang = $this->input->get('cabang');
    $tanggal_start =  $this->input->get('tanggal-start');
    $tanggal_end =  $this->input->get('tanggal-end');
    $filter_data_kode = $this->input->get('kode');

    $filter_data_tanggal = json_encode([
      'start' => $tanggal_start,
      'end' => $tanggal_end,
    ]);

    // data utama
    // data sekolah
    $head = $this->db->get_where('cabangs', ['id' => $filter_data_cabang])->row_array();
    if (!isset($head['id'])) {
      $head = $this->db->get_where('cabangs', ['user_id' => $this->session->userdata('data')['id']])->row_array();
    }
    // data body
    $detail = $this->Sm->getAllDataCetak(null, null, null, $filter_data_kode, $filter_data_tanggal, $filter_data_cabang)->result_array();


    $tahun = explode("-", $tanggal_start)[0];
    $periode = $tanggal_start == $tanggal_end ? $tanggal_end : "$tanggal_start / $tanggal_end";

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
    $col_end = "E";
    $title_excel = "LAPORAN STANDAR " . $head['nama'];
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
      $drawing->setOffsetX(20);
      $drawing->setOffsetY(10);
      $drawing->setCoordinates('A1');
    }

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
    $sheet->setCellValue("C$row", ": " . $head['nama']);

    $row++;
    $sheet->setCellValue("B$row", "Kota");
    $sheet->setCellValue("C$row", ": Kota " . $laporan['kota']);

    $row++;
    $sheet->setCellValue("B$row", "Negara");
    $sheet->setCellValue("C$row", ": Malaysia");

    $row++;
    $sheet->setCellValue("B$row", "Periode");
    $sheet->setCellValue("C$row", ": " . $periode);

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
      'RM',
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
      "alignment" => [
        'wrapText' => TRUE,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
      ]
    ];
    $start_tabel = $row + 1;
    $jumlah_total = 0;
    foreach ($detail as $q) {
      $c = 0;
      $row++;
      $sheet->setCellValue(chr(65 + $c) . "$row", ($row - 19));
      $sheet->setCellValue(chr(65 + ++$c) . "$row", $q['tanggal']);
      $sheet->setCellValue(chr(65 + ++$c) . "$row", $q['kode']);
      $sheet->setCellValue(chr(65 + ++$c) . "$row", $q['uraian']);
      $sheet->setCellValue(chr(65 + ++$c) . "$row", $q['harga_ringgit']);
      $jumlah_total += $q['harga_ringgit'];
    }
    // row jumlah
    $sheet->mergeCells($col_start . $row . ":D" . $row)
      ->setCellValue("A$row", "Jumlah");
    $sheet->setCellValue("E$row", $jumlah_total);
    // format
    // nomor center
    $sheet->getStyle($col_start . $start_tabel . ":" . $col_start . $row)
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    // border all data
    $sheet->getStyle($col_start . $start_tabel . ":" . $col_end . $row)
      ->applyFromArray($styleArray);

    // $code_rm = '_-[$RM-ms-MY]* #.##0,00_-;-[$RM-ms-MY]* #.##0,00_-;_-[$RM-ms-MY]* "-"??_-;_-@_-';
    // $sheet->getStyle("F" . $start_tabel . ":" . $col_end . $row)->getNumberFormat()->setFormatCode($code_rm);
    $sheet->getStyle("E" . $start_tabel . ":" . $col_end . $row)
      ->getNumberFormat()
      ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


    // set alignment
    $sheet->getStyle("C" . $start_tabel . ":D" . $row)
      ->getAlignment()
      ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

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

    // function for width column
    function w($width)
    {
      return 0.71 + $width;
    }


    // set width column
    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(w(4));
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(w(17));
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(w(10));
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(w(32));
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(w(24));

    // add image
    if ($linux_cek || $windows_cek) {
      $drawing->setWorksheet($spreadsheet->getActiveSheet());
    }
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
    $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0);

    // page center on
    $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);


    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $title_excel . '.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');

    // baru
  }

  function __construct()
  {
    parent::__construct();
    $this->load->model('laporan/StandardModel', 'Sm');
    $this->default_template = 'templates/dashboard';
    $this->load->library('plugin');
    $this->load->helper('url');

    // Cek session
    $this->sesion->cek_session();
  }
}

/* End of file Data.php */
/* Location: ./application/controllers/kota.php */