<?php
require('kop_software.php');

 
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
// list tanggal merah selain hari minggu
    $tglLibur = Array("2021-10-20","2021-08-17", "2021-08-10", "2021-07-20");
	
	// $tglAwal = "16-08-2021";
	// $tglAkhir = "18-08-2021";
     
    // memecah string tanggal awal untuk mendapatkan
    // tanggal, bulan, tahun
    $pecah1 = explode("-", $tglAwal);
    $date1 = $pecah1[0];
    $month1 = $pecah1[1];
    $year1 = $pecah1[2];
	$tanggalGabungan1 = $date1."-".$month1."-".$year1;
    // memecah string tanggal akhir untuk mendapatkan
    // tanggal, bulan, tahun
    $pecah2 = explode("-", $tglAkhir);
    $date2 = $pecah2[0];
    $month2 = $pecah2[1];
    $year2 =  $pecah2[2];
 
    // mencari total selisih hari dari tanggal awal dan akhir
    $jd1 = GregorianToJD($month1, $date1, $year1);
    $jd2 = GregorianToJD($month2, $date2, $year2);
 
    $selisih = $jd2 - $jd1;
     
    // proses menghitung tanggal merah dan hari minggu
    // di antara tanggal awal dan akhir
    for($i=1; $i<=$selisih; $i++)
    {
        // menentukan tanggal pada hari ke-i dari tanggal awal
        $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
        $tglstr = date("Y-m-d", $tanggal);
         
        // menghitung jumlah tanggal pada hari ke-i
        // yang masuk dalam daftar tanggal merah selain minggu
        if (in_array($tglstr, $tglLibur)) 
        {
           $libur1++;
        }
         
        // menghitung jumlah tanggal pada hari ke-i
        // yang merupakan hari minggu
        if ((date("N", $tanggal) == 7))
        {
           $libur2++;
        }
		if ((date("N", $tanggal) == 6))
        {
           $libur3++;
        }
		//$hari = date("N", $tanggal) == 7;
		
    }
     
    // menghitung selisih hari yang bukan tanggal merah dan hari minggu
    $selisihTotal=$selisih-$libur1-$libur2-$libur3; 
	
	if($selisihTotal == 1){

		$jselisihTotal = $selisihTotal;
    }
	if($selisihTotal== 0){

		$selisihTotal = 1;
	}
	return $selisihTotal;
}


$pdf=new PDF ('L');
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
//Table with 20 rows and 5 columns
$pdf->SetWidths(array(7,17,17,19,17,40,50,17,22,15,19, 19, 18));
//srand(microtime()*1000000);

//koneksi ke database
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");
$status=$_POST['status'];
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$bln_akhir."-".$thn_akhir;

//mengambil data dari tabel
 $sql=mysql_query("SELECT software.*,divisi.*,
 CASE svc_kat
WHEN 'LOW' THEN 1
WHEN 'MEDIUM' THEN 2
WHEN 'HIGH' THEN 3
WHEN 'URGENT' THEN 4
ELSE 0
END
 AS angka

 from software,divisi where status='Selesai' And cetak<>'T' and software.divisi=divisi.kd AND tgl like '%".$tanggal_akhir_format."' order by angka desc, tgl");
 
 // $sql=mysql_query(" 
// SELECT * FROM (SELECT 
// @row_number:=CASE
        // WHEN @kat_no = svc_kat 
			// THEN @row_number + 1
        // ELSE 0
    // END AS kat_num,
    // @kat_no:=svc_kat kat, data1.* FROM (




// SELECT software.*,divisi.*,
// CASE svc_kat
// WHEN 'LOW' THEN 1
// WHEN 'MEDIUM' THEN 2
// WHEN 'HIGH' THEN 3
// WHEN 'URGENT' THEN 4
// ELSE 0
// END
 // AS angka

 // FROM software,divisi WHERE STATUS='Selesai' AND cetak<>'T' AND software.divisi=divisi.kd AND tgl LIKE '%10-2022' ORDER BY angka DESC, tgl ) AS data1) AS data2");
$count=mysql_num_rows($sql);


for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
$no = $no+1;
//$number = $database['kat_num'];
$tgl=$database['tgl'];
$nama=$database['nama'];
$bagian=$database['bagian'];
$barang=$database['barang'];
$tgl2=$database['tgl2'];
$divisi=$database['namadivisi'];
$kasus=$database['kasus'];
$penerima=$database['penerima'];
$teknisi=$database['oleh'];
$tindakan=$database['tindakan'];
$status=$database['status'];
$ippc=$database['ippc'];
$perangkat=$database['perangkat'];
$kategori = $database['svc_kat'];
$awal=substr($tgl,0,2);
$akhir=substr($tgl2,0,2);
$semua=$hbulan;
$bulan_awal=substr($tgl,3,2);
$bulan_akhir=substr($tgl2,3,2);
$total_bulan=$bulan_akhir-$bulan_awal;
$hbulan=$total_bulan*30+$akhir-$awal;
$tglRequest = $database['tglRequest'];
$tglApprove = $database['tglapprove'];
//$tanggal1 = new DateTime($tgl);
//$tanggal2 = new DateTime($tgl2);

//$days = round(($tanggal2->format('U') - $tanggal1->format('U')) / (60*60*24));

//if($days == 0)
//{
//	$selisih = 1;
//}
//else
//{
	//$selisih = $days;
//}

// $awal_cuti = $tgl;
// $akhir_cuti = $tgl2;
 
// // tanggalnya diubah formatnya ke Y-m-d 
// //$awal_cuti = DateTime::createFromFormat('d-m-Y', $awal_cuti);
// $awal_cuti = date_create($awal_cuti);
// $awal_cuti = date_format($awal_cuti, 'Y-m-d');
// $awal_cuti = strtotime($awal_cuti);
 
// $akhir_cuti = date_create($akhir_cuti);
// $akhir_cuti = date_format($akhir_cuti, 'Y-m-d');
// $akhir_cuti = strtotime($akhir_cuti);
 
// $haricuti = array();
// $sabtuminggu = array();
 
// for ($i=$awal_cuti; $i <= $akhir_cuti; $i += (60 * 60 * 24)) {
    // if (date('w', $i) !== '0' && date('w', $i) !== '6') {
        // $haricuti[] = $i;
    // } else {
        // $sabtuminggu[] = $i;
    // }
 
// }

// $jumlah_cuti = count($haricuti);
// $jumlah_sabtuminggu = count($sabtuminggu);
// $abtotal = $jumlah_cuti + $jumlah_sabtuminggu;

// if($jumlah_cuti == 1){

	// $jumlah_cuti = $jumlah_cuti;
// }

// if($jumlah_cuti > 1){
	// $jumlah_cuti = $jumlah_cuti - 1;
// }
// if($jumlah_cuti == 0){

	// $jumlah_cuti = 1;
// }





$namabesar=strtoupper($nama);
$kasusbesar=strtoupper($kasus);
$penerimabesar=strtoupper($penerima);
$statusbesar=strtoupper($status);
$teknisibesar=strtoupper($teknisi);
$kategori_text = strtoupper($kategori);

$durasi = 0;
if($tglRequest == ""|| $tglRequest == null){
	$durasi = 0;
}else{
	$durasi = selisihHari($tglRequest,$tgl2);
	//$durasi = 2;
}

$durasiTunggu = 0;
if($tglApprove == ""|| $tglApprove == null){
	$durasiTunggu = 0;
}else{
	$durasiTunggu = selisihHari($tglApprove,$tgl2);
	//$durasi = 2;
}


//$pdf->Row(array($tgl,$namabesar."\n".$bagian."\n".$divisi,$kasus,$penerimabesar,$statusbesar."-".$teknisibesar."\n"."(".$tgl2.")",$hbulan."hr"));
$pdf->Row(array($no,$tglRequest , $tglApprove, $tgl, $tgl2, $namabesar."\n".$bagian.' - '.$divisi,$kasus,$penerimabesar,$tindakan,  $kategori_text, selisihHari($tgl,$tgl2)." hr", $durasi." hr",$durasiTunggu." hr"));


}}
$pdf->Output();
?>
