<?php
ob_start(); // Menangani output buffering untuk menghindari error FPDF
require('kop_hardware.php');
include('../config.php');

function GenerateWord()
{
	//Get a random word
	$nb=rand(3,10);
	$w='';
	for($i=1;$i<=$nb;$i++)
		$w.=chr(rand(ord('a'),ord('z')));
	return $w;
}

function GenerateSentence()
{
	//Get a random sentence
	$nb=rand(1,10);
	$s='';
	for($i=1;$i<=$nb;$i++)
		$s.=GenerateWord().' ';
	return substr($s,0,-1);
}

function selisihHari($tglAwal, $tglAkhir){
    $tglLibur = Array("2023-04-07","2023-04-20","2023-04-21", "2023-08-25", "2023-05-18");

    $pecah1 = explode("-", $tglAwal);
    $date1 = $pecah1[0];
    $month1 = $pecah1[1];
    $year1 = $pecah1[2];

    $pecah2 = explode("-", $tglAkhir);
    $date2 = $pecah2[0];
    $month2 = $pecah2[1];
    $year2 =  $pecah2[2];

    $jd1 = GregorianToJD($month1, $date1, $year1);
    $jd2 = GregorianToJD($month2, $date2, $year2);

    $selisih = $jd2 - $jd1;

    $libur1 = 0;
    $libur2 = 0;
    $libur3 = 0;

    for($i=1; $i<=$selisih; $i++)
    {
        $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
        $tglstr = date("Y-m-d", $tanggal);

        if (in_array($tglstr, $tglLibur)) 
        {
           $libur1++;
        }
         
        if ((date("N", $tanggal) == 7))
        {
           $libur2++;
        }
		if ((date("N", $tanggal) == 6))
        {
           $libur3++;
        }
    }

    $selisihTotal = $selisih - $libur1 - $libur2 - $libur3; 

	if($selisihTotal == 1){
		$jselisihTotal = $selisihTotal;
    }
	if($selisihTotal== 0){
		$selisihTotal = 1;
	}
	return $selisihTotal;
}

function countWorkDays($start_date, $end_date) {
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);

    if ($start > $end) {
        return 0;
    }

    $workDays = 0;

    while ($start <= $end) {
        if ($start->format('N') < 6) { 
            $workDays++;
        }
        $start->modify('+1 day');
    }

    return $workDays;
}

$pdf = new PDF('L');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(7,17,19,40,30,50,20,30,25,20,20));

$bln_akhir = $_POST['bln_akhir'];
$thn_akhir = $_POST['thn_akhir'];

$sql = "SELECT 
    a.tgl AS tgl,
    a.nama AS nama,
    a.bagian AS bagian,
    a.tgl2 AS tgl2,
    b.namadivisi AS namadivisi,
    a.kasus AS kasus,
    a.penerima AS penerima,
    a.teknisi AS teknisi,
    a.tindakan AS tindakan,
    a.status AS status,
    a.ippc AS ippc,
    c.model AS perangkat,
    a.svc_kat AS kategori,
    a.tglRequest AS tglRequest
FROM service a
LEFT JOIN divisi b ON a.divisi = b.kd
LEFT JOIN pcaktif c ON c.ippc = a.ippc
WHERE a.statup='service' AND a.status='Selesai' AND a.ket='D' 
AND MONTH(a.tgl) = '".$bln_akhir."'
AND YEAR(a.tgl) = '".$thn_akhir."'
ORDER BY a.svc_kat, a.tgl ASC";

$params = ["%" . $bln_akhir . "-" . $thn_akhir . "%"];
$stmt = sqlsrv_query($conn, $sql, $params);

$no = 0;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $no++;

    $tgl = $database['tgl'] ? $database['tgl']->format('d-m-Y') : '';
    $tgl2 = $database['tgl2'] ? $database['tgl2']->format('d-m-Y') : '';
    $tglRequest = $database['tglRequest'] ? $database['tglRequest']->format('d-m-Y') : '';

    $kategori_text = ($database['kategori'] == "NON_SP") ? "NON SPAREPART" : 
                     (($database['kategori'] == "SP") ? "SPAREPART" : "-");

    $durasi = (!empty($tglRequest)) ? countWorkDays($tglRequest, $tgl) : 0;

    $pdf->Row([
        $no, 
        $bln_akhir, 
        $tgl, 
        strtoupper($database['nama']) . "\n" . $database['bagian'] . "-" . $database['namadivisi'],
        strtoupper($database['perangkat']), 
        strtoupper($database['kasus']), 
        strtoupper($database['penerima']), 
        strtoupper($database['status']) . "-" . strtoupper($database['teknisi']) . " ($tgl2)", 
        $kategori_text, 
        countWorkDays($tgl, $tgl2) . " hr", 
        $durasi . " hr"
    ]);
}

ob_end_clean(); // Bersihkan buffer sebelum Output
$pdf->Output();
?>


#region code yang lama

<?php
// require('kop_hardware.php');
// include('../config.php');
 
// function GenerateWord()
// {
// 	//Get a random word
// 	$nb=rand(3,10);
// 	$w='';
// 	for($i=1;$i<=$nb;$i++)
// 		$w.=chr(rand(ord('a'),ord('z')));
// 	return $w;
// }

// function GenerateSentence()
// {
// 	//Get a random sentence
// 	$nb=rand(1,10);
// 	$s='';
// 	for($i=1;$i<=$nb;$i++)
// 		$s.=GenerateWord().' ';
// 	return substr($s,0,-1);
// }

// function selisihHari($tglAwal, $tglAkhir){
// // list tanggal merah selain hari minggu
//     $tglLibur = Array("2023-04-07","2023-04-20","2023-04-21", "2023-08-25", "2023-05-18");
	
// 	// $tglAwal = "16-08-2021";
// 	// $tglAkhir = "18-08-2021";
     
//     // memecah string tanggal awal untuk mendapatkan
//     // tanggal, bulan, tahun
//     $pecah1 = explode("-", $tglAwal);
//     $date1 = $pecah1[0];
//     $month1 = $pecah1[1];
//     $year1 = $pecah1[2];
// 	$tanggalGabungan1 = $date1."-".$month1."-".$year1;
//     // memecah string tanggal akhir untuk mendapatkan
//     // tanggal, bulan, tahun
//     $pecah2 = explode("-", $tglAkhir);
//     $date2 = $pecah2[0];
//     $month2 = $pecah2[1];
//     $year2 =  $pecah2[2];
 
//     // mencari total selisih hari dari tanggal awal dan akhir
//     $jd1 = GregorianToJD($month1, $date1, $year1);
//     $jd2 = GregorianToJD($month2, $date2, $year2);
 
//     $selisih = $jd2 - $jd1;
//      //echo '1. '.$jd2.'<br>' ;
// 	 //echo '2 .'.$jd1;
//     // proses menghitung tanggal merah dan hari minggu
//     // di antara tanggal awal dan akhir
//     for($i=1; $i<=$selisih; $i++)
//     {
//         // menentukan tanggal pada hari ke-i dari tanggal awal
//         $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
//         $tglstr = date("Y-m-d", $tanggal);
         
//         // menghitung jumlah tanggal pada hari ke-i
//         // yang masuk dalam daftar tanggal merah selain minggu
//         if (in_array($tglstr, $tglLibur)) 
//         {
//            $libur1++;
//         }
         
//         // menghitung jumlah tanggal pada hari ke-i
//         // yang merupakan hari minggu
//         if ((date("N", $tanggal) == 7))
//         {
//            $libur2++;
//         }
// 		if ((date("N", $tanggal) == 6))
//         {
//            $libur3++;
//         }
// 		//$hari = date("N", $tanggal) == 7;
		
//     }
     
//     // menghitung selisih hari yang bukan tanggal merah dan hari minggu
//     $selisihTotal=$selisih-$libur1-$libur2-$libur3; 
	
// 	if($selisihTotal == 1){

// 		$jselisihTotal = $selisihTotal;
//     }
// 	if($selisihTotal== 0){

// 		$selisihTotal = 1;
// 	}
// 	return $selisihTotal;
// }

// function countWorkDays($start_date, $end_date) {
//     // Konversi tanggal ke format DateTime
//     $start = new DateTime($start_date);
//     $end = new DateTime($end_date);

//     // Pastikan tanggal akhir lebih besar dari tanggal awal
//     if ($start > $end) {
//         return 0;
//     }

//     $workDays = 0;

//     // Iterasi dari tanggal awal ke tanggal akhir
//     while ($start <= $end) {
//         // Cek jika hari bukan Sabtu (6) atau Minggu (0)
//         if ($start->format('N') < 6) { // N memberikan angka 1-7 untuk Senin-Minggu
//             $workDays++;
//         }
//         // Tambahkan 1 hari
//         $start->modify('+1 day');
//     }

//     return $workDays;
// }

// $pdf=new PDF ('L');
// $pdf->AddPage();
// $pdf->SetFont('Arial','',8);
// //Table with 20 rows and 5 columns
// $pdf->SetWidths(array(7,17,19,40,30,50,20,30,25,20,20));
// //srand(microtime()*1000000);

// //koneksi ke database
// // mysql_connect("localhost","root","dlris30g");
// // mysql_select_db("sitdl");

// // $status=$_POST['status'];
// $bln_akhir=$_POST['bln_akhir'];
// $thn_akhir=$_POST['thn_akhir'];
// $tanggal_akhir=$thn_akhir.$bln_akhir;
// $tanggal_akhir_format=$bln_akhir."-".$thn_akhir;


// //mengambil data dari tabel
// // $sql=mysql_query("SELECT * from service,divisi where service.divisi=divisi.kd and statup='service' and service.status='Selesai' and service.ket='D' and  service.tgl like '%".$tanggal_akhir_format."' order by service.tgl asc");
// // $count=mysql_num_rows($sql);
// // $no = 0;
// // for($i=0;$i<$count;$i++);{
// // while ($database = mysql_fetch_array($sql)) {
// // $no++;	
// // $tgl=$database['tgl'];
// // $nama=$database['nama'];
// // $bagian=$database['bagian'];
// // $barang=$database['barang'];
// // $tgl2=$database['tgl2'];
// // $divisi=$database['namadivisi'];
// // $kasus=$database['kasus'];
// // $penerima=$database['penerima'];
// // $teknisi=$database['teknisi'];
// // $tindakan=$database['tindakan'];
// // $status=$database['status'];
// // $ippc=$database['ippc'];
// // $perangkat=$database['perangkat'];
// // $awal=substr($tgl,0,2);
// // $akhir=substr($tgl2,0,2);
// // $semua=$hbulan;
// // $bulan_awal=substr($tgl,3,2);
// // $bulan_akhir=substr($tgl2,3,2);
// // $total_bulan=$bulan_akhir-$bulan_awal;
// // $hbulan=$total_bulan*30+$akhir-$awal;
// // $namabesar=strtoupper($nama);
// // $perangkatbesar=strtoupper($perangkat);
// // $kasusbesar=strtoupper($kasus);
// // $penerimabesar=strtoupper($penerima);
// // $statusbesar=strtoupper($status);
// // $teknisibesar=strtoupper($teknisi);
// // if($hbulan == 0){
// // $hbulan=1;	
// // }


// // $sql=mysql_query("SELECT 
// // a.tgl as tgl,
// // a.nama as nama,
// // a.bagian as bagian,
// // a.tgl2 as tgl2,
// // b.namadivisi as namadivisi,
// // a.kasus as kasus,
// // a.penerima as penerima,
// // a.teknisi as teknisi,
// // a.tindakan as tindakan,
// //  a.status as status,
// // a.ippc as ippc,
// // c.model as perangkat,
// // a.svc_kat as kategori,
// // a.tglRequest as tglRequest

// //  FROM service a
// // LEFT JOIN divisi b ON a.divisi = b.`kd`
// // LEFT JOIN pcaktif c ON c.ippc = a.ippc 
// // WHERE  a.statup='service' AND a.status='Selesai' AND a.ket='D' 
// // and  a.tgl like '%".$tanggal_akhir_format."'
// // ORDER BY a.svc_kat, a.tgl ASC");
// // $count=mysql_num_rows($sql);
// // $no = 0;
// // for($i=0;$i<$count;$i++);{
// // while ($database = mysql_fetch_array($sql)) {
// // $no++;	


// $sql = "SELECT 
//     a.tgl AS tgl,
//     a.nama AS nama,
//     a.bagian AS bagian,
//     a.tgl2 AS tgl2,
//     b.namadivisi AS namadivisi,
//     a.kasus AS kasus,
//     a.penerima AS penerima,
//     a.teknisi AS teknisi,
//     a.tindakan AS tindakan,
//     a.status AS status,
//     a.ippc AS ippc,
//     c.model AS perangkat,
//     a.svc_kat AS kategori,
//     a.tglRequest AS tglRequest
// FROM service a
// LEFT JOIN divisi b ON a.divisi = b.kd
// LEFT JOIN pcaktif c ON c.ippc = a.ippc
// where  a.statup='service' AND a.status='Selesai' AND a.ket='D' 
// AND MONTH(a.tgl) = '".$bln_akhir."'
// AND YEAR(a.tgl) = '".$thn_akhir."'
// ORDER BY a.svc_kat, a.tgl ASC";

// $params = ["%" . $tanggal_akhir_format . "%"];
// $stmt = sqlsrv_query($conn, $sql, $params);

// $no = 0;
// while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
//     $no++;

// $tgl=$database['tgl'] ? $database['tgl']->format('d-m-Y') : '';
// $nama=$database['nama'];
// $bagian=$database['bagian'];
// //$barang=$database['barang'];
// $tgl2=$database['tgl2'] ? $database['tgl2']->format('d-m-Y') : '';
// $divisi=$database['namadivisi'];
// $kasus=$database['kasus'];
// $penerima=$database['penerima'];
// $teknisi=$database['teknisi'];
// $tindakan=$database['tindakan'];
// $status=$database['status'];
// $ippc=$database['ippc'];
// $perangkat=$database['perangkat'];
// $kategori = $database['kategori'];
// $tglRequest = $database['tglRequest'] ? $database['tglRequest']->format('d-m-Y') : '';
// // $tgl=$database['a.tgl'];
// // $nama=$database['a.nama'];
// // $bagian=$database['a.bagian'];
// // $barang=$database['a.barang'];
// // $tgl2=$database['a.tgl2'];
// // $divisi=$database['b.namadivisi'];
// // $kasus=$database['a.kasus'];
// // $penerima=$database['a.penerima'];
// // $teknisi=$database['a.teknisi'];
// // $tindakan=$database['a.tindakan'];
// // $status=$database['a.status'];
// // $ippc=$database['a.ippc'];
// // $perangkat=$database['c.model'];
// $awal=substr($tgl,0,2);
// $akhir=substr($tgl2,0,2);
// //$semua=$hbulan;
// $bulan_awal=substr($tgl,3,2);
// $bulan_akhir=substr($tgl2,3,2);
// //$total_bulan=$bulan_akhir-$bulan_awal;
// //$hbulan=$total_bulan*30+$akhir-$awal;
// $namabesar=strtoupper($nama);
// $perangkatbesar=strtoupper($perangkat);
// $kasusbesar=strtoupper($kasus);
// $penerimabesar=strtoupper($penerima);
// $statusbesar=strtoupper($status);
// $teknisibesar=strtoupper($teknisi);
// // if($hbulan == 0){
// // $hbulan=1;	
// // }

// if($kategori == "NON_SP"){
// 	$kategori_text = "NON SPAREPART";
// }else if ($kategori == "SP"){
// 	$kategori_text = "SPAREPART";
// }else {
// 	$kategori_text = "-";
// }


// // $awal_cuti = $tgl;
// // $akhir_cuti = $tgl2;
 
// // // tanggalnya diubah formatnya ke Y-m-d 
// // //$awal_cuti = DateTime::createFromFormat('d-m-Y', $awal_cuti);
// // $awal_cuti = date_create($awal_cuti);
// // $awal_cuti = date_format($awal_cuti, 'Y-m-d');
// // $awal_cuti = strtotime($awal_cuti);
 
// // $akhir_cuti = date_create($akhir_cuti);
// // $akhir_cuti = date_format($akhir_cuti, 'Y-m-d');
// // $akhir_cuti = strtotime($akhir_cuti);
 
// // $haricuti = array();
// // $sabtuminggu = array();
 
// // for ($i=$awal_cuti; $i <= $akhir_cuti; $i += (60 * 60 * 24)) {
//     // if (date('w', $i) !== '0' && date('w', $i) !== '6') {
//         // $haricuti[] = $i;
//     // } else {
//         // $sabtuminggu[] = $i;
//     // }
 
// // }

// // $jumlah_cuti = count($haricuti);
// // $jumlah_sabtuminggu = count($sabtuminggu);
// // $abtotal = $jumlah_cuti + $jumlah_sabtuminggu;

// // if($jumlah_cuti == 1){

// 	// $jumlah_cuti = $jumlah_cuti;
// // }
// // if($jumlah_cuti == 0){

// 	// $jumlah_cuti = 1;
// // }


// // if($jumlah_cuti > 1){
// 	// $jumlah_cuti = $jumlah_cuti - 1;
// // }

// $durasi = 0;
// if($tglRequest == ""|| $tglRequest == null){
// 	$durasi = 0;
// }else{
// 	$durasi = countWorkDays($tglRequest,$tgl);
// 	//$durasi = 2;
// }

// $pdf->Row(array($no, $bln_akhir, $tgl,$namabesar."\n".$bagian."-".$divisi,$perangkatbesar,$kasusbesar,$penerimabesar,$statusbesar."-".$teknisibesar."    (".$tgl2.")", $kategori_text, countWorkDays($tgl,$tgl2)." hr", $durasi." hr"));
// }
// $pdf->Output();


// //$pdf->Row(array($no, $tgl,$namabesar."\n".$bagian."-".$divisi,$perangkatbesar,$kasusbesar,$penerimabesar,$statusbesar."-".$teknisibesar."    (".$tgl2.")",$hbulan."hr"));
// //}}
// //$pdf->Output();
?>


#endregion