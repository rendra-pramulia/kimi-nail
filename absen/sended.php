<?php
$koneksi = mysql_connect("localhost","root","");
$koneksi_db = mysql_select_db ("kimi");

$url = "http://kiminail.web.id/kirim.php";

$ambil = "SELECT * FROM absensi WHERE status = 'Open' ";
$hasil = mysql_query($ambil);
while($row = mysql_fetch_assoc($hasil))
{
	$PIN = $row['id_finger'];
	$dates = $row['dates'];
	$hours = $row['hours'];
	$curlHandle = curl_init();
	curl_setopt($curlHandle, CURLOPT_URL, $url);
	curl_setopt($curlHandle, CURLOPT_POSTFIELDS, "id_finger=".$PIN."&dates=".$dates."&hours=".$hours);
	curl_setopt($curlHandle, CURLOPT_HEADER, 0);
	curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
	curl_setopt($curlHandle, CURLOPT_POST, 1);
	curl_exec($curlHandle);
	curl_close($curlHandle);
	
	mysql_query("UPDATE absensi SET status = 'Close' WHERE id_real = '$row[id_real]' ");
	echo $row['id_real'];
}

?>