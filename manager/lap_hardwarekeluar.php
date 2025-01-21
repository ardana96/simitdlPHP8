<?php
ob_start(); // Menangani output buffering untuk menghindari error FPDF
require('kop_hardwarekeluar.php');
include('../config.php');

function GenerateWord()
{
    // Get a random word
    $nb = rand(3, 10);
    $w = '';
    for ($i = 1; $i <= $nb; $i++) {
        $w .= chr(rand(ord('a'), ord('z')));
    }
    return $w;
}

function GenerateSentence()
{
    // Get a random sentence
    $nb = rand(1, 10);
    $s = '';
    for ($i = 1; $i <= $nb; $i++) {
        $s .= GenerateWord() . ' ';
    }
    return substr($s, 0, -1);
}

function selisihHari($tglAwal, $tglAkhir)
{
    // List tanggal merah selain hari minggu
    $tglLibur = array("2021-10-20", "2021-08-17", "2021-08-10", "2021-07-20");

    // Memecah string tanggal awal untuk mendapatkan tanggal, bulan, tahun
    $pecah1 = explode("-", $tglAwal);
    $date1 = $pecah1[0];
    $month1 = $pecah1[1];
    $year1 = $pecah1[2];

    // Memecah string tanggal akhir untuk mendapatkan tanggal, bulan, tahun
    $pecah2 = explode("-", $tglAkhir);
    $date2 = $pecah2[0];
    $month2 = $pecah2[1];
    $year2 = $pecah2[2];

    // Mencari total selisih hari dari tanggal awal dan akhir
    $jd1 = GregorianToJD($month1, $date1, $year1);
    $jd2 = GregorianToJD($month2, $date2, $year2);

    $selisih = $jd2 - $jd1;
    $libur1 = 0;
    $libur2 = 0;
    $libur3 = 0;

    // Proses menghitung tanggal merah dan hari minggu di antara tanggal awal dan akhir
    for ($i = 1; $i <= $selisih; $i++) {
        // Menentukan tanggal pada hari ke-i dari tanggal awal
        $tanggal = mktime(0, 0, 0, $month1, $date1 + $i, $year1);
        $tglstr = date("Y-m-d", $tanggal);

        // Menghitung jumlah tanggal pada hari ke-i yang masuk dalam daftar tanggal merah selain minggu
        if (in_array($tglstr, $tglLibur)) {
            $libur1++;
        }

        // Menghitung jumlah tanggal pada hari ke-i yang merupakan hari minggu
        if (date("N", $tanggal) == 7) {
            $libur2++;
        }

        // Menghitung jumlah tanggal pada hari ke-i yang merupakan hari sabtu
        if (date("N", $tanggal) == 6) {
            $libur3++;
        }
    }

    // Menghitung selisih hari yang bukan tanggal merah dan hari minggu
    $selisihTotal = $selisih - $libur1 - $libur2 - $libur3;

    if ($selisihTotal == 1) {
        $jselisihTotal = $selisihTotal;
    }
    if ($selisihTotal == 0) {
        $selisihTotal = 1;
    }
    return $selisihTotal;
}

function countWorkDays($start_date, $end_date)
{
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
$pdf->SetWidths(array(7, 17, 19, 40, 30, 60, 25, 40, 20, 20));

$bln_akhir = $_POST['bln_akhir'];
$thn_akhir = $_POST['thn_akhir'];

// Mengambil data dari tabel
$sql = "
    SELECT *
    FROM service a
    LEFT JOIN divisi b ON a.divisi = b.kd
    WHERE a.statup = 'service' 
    AND a.status = 'Selesai' 
    AND a.ket = 'D' 
    AND MONTH(a.tgl) = '" . $bln_akhir . "'
    AND YEAR(a.tgl) = '" . $thn_akhir . "'
    ORDER BY a.svc_kat, a.tgl ASC
";

$stmt = sqlsrv_query($conn, $sql);

$no = 0;
while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $no = $no + 1;
    $tgl = $database['tgl'] ? $database['tgl']->format('d-m-Y') : '';
    $nama = $database['nama'];
    $bagian = $database['bagian'];
    $tgl2 = $database['tgl2'] ? $database['tgl2']->format('d-m-Y') : '';
    $divisi = $database['namadivisi'];
    $kasus = $database['kasus'];
    $penerima = $database['penerima'];
    $teknisi = $database['teknisi'];
    $tindakan = $database['tindakan'];
    $status = $database['status'];
    $ippc = $database['ippc'];
    $tgl3 = $database['tgl3'] ? $database['tgl3']->format('d-m-Y') : '';
    $luar = $database['luar'];
    $perangkat = $database['perangkat'];

    $namabesar = strtoupper($nama);
    $perangkatbesar = strtoupper($perangkat);
    $kasusbesar = strtoupper($kasus);
    $penerimabesar = strtoupper($penerima);
    $statusbesar = strtoupper($status);
    $teknisibesar = strtoupper($teknisi);
    $luarbesar = strtoupper($luar);
    $tglRequest = $database['tglRequest'] ? $database['tglRequest']->format('d-m-Y') : '';

    $durasi = 0;
    if ($tglRequest == "" || $tglRequest == null) {
        $durasi = 0;
    } else {
        $durasi = countWorkDays($tglRequest, $tgl);
    }

    $pdf->Row(array(
        $no,
        $tglRequest,
        $tgl2,
        $namabesar . "\n" . $bagian . "-" . $divisi,
        $perangkatbesar,
        $kasusbesar,
        $penerimabesar,
        $statusbesar . "-" . $luarbesar . "(" . $tgl3 . ")",
        countWorkDays($tgl, $tgl3) . " hr",
        $durasi . " hr"
    ));
}
ob_end_clean(); // Bersihkan buffer sebelum Output
$pdf->Output();
?>

#region code lama
<?php
// require('kop_hardwarekeluar.php');
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
//     $tglLibur = Array("2021-10-20","2021-08-17", "2021-08-10", "2021-07-20");
	
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
// $pdf->SetWidths(array(7,17,19, 40,30,60,25,40,20, 20));
// //srand(microtime()*1000000);




// $bln_akhir=$_POST['bln_akhir'];
// $thn_akhir=$_POST['thn_akhir'];



// //mengambil data dari tabel
// $sql = "SELECT *
// FROM service a
// LEFT JOIN divisi b ON a.divisi = b.kd
// where  a.statup='service' AND a.status='Selesai' AND a.ket='D' 
// AND MONTH(a.tgl) = '".$bln_akhir."'
// AND YEAR(a.tgl) = '".$thn_akhir."'
// ORDER BY a.svc_kat, a.tgl ASC";

// //$params = ["%" . $tanggal_akhir_format . "%"];
// $stmt = sqlsrv_query($conn, $sql);

// $no = 0;
// while ($database = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
// $no = $no+1;
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
// $tgl3=$database['tgl3'] ? $database['tgl3']->format('d-m-Y') : '';
// $luar=$database['luar'];
// $perangkat=$database['perangkat'];
// // $awal=substr($tgl,0,2);
// // $akhir=substr($tgl3,0,2);
// // $semua=$hbulan;
// // $bulan_awal=substr($tgl2,3,2);
// // $bulan_akhir=substr($tgl3,3,2);
// // $total_bulan=$bulan_akhir-$bulan_awal;
// // $hbulan=$total_bulan*30+$akhir-$awal;
// $namabesar=strtoupper($nama);
// $perangkatbesar=strtoupper($perangkat);
// $kasusbesar=strtoupper($kasus);
// $penerimabesar=strtoupper($penerima);
// $statusbesar=strtoupper($status);
// $teknisibesar=strtoupper($teknisi);
// $luarbesar=strtoupper($luar);
// $tglRequest = $database['tglRequest']? $database['tglRequest']->format('d-m-Y') : '';




// //$tanggal1 = new DateTime($tgl);
// //$tanggal2 = new DateTime($tgl2);

// //$days = round(($tanggal2->format('U') - $tanggal1->format('U')) / (60*60*24));

// //if($days == 0)
// //{
// //	$selisih = 1;
// //}
// //else
// //{
// 	// $selisih = $days;
// //}

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

// // if($jumlah_cuti > 1){
// 	// $jumlah_cuti = $jumlah_cuti - 1;
// // }

// // if($jumlah_cuti == 0){

// 	// $jumlah_cuti = 1;
// // }

// $durasi = 0;
// if($tglRequest == ""|| $tglRequest == null){
// 	$durasi = 0;
// }else{
// 	$durasi = countWorkDays($tglRequest,$tgl);
// 	//$durasi = 2;
// }

// $pdf->Row(array($no, $tglRequest, $tgl2,$namabesar."\n".$bagian."-".$divisi,$perangkatbesar,$kasusbesar,$penerimabesar,$statusbesar."-".$luarbesar."(".$tgl3.")",countWorkDays($tgl,$tgl3)." hr", $durasi." hr"));
// }
// $pdf->Output();
?>
#endregion