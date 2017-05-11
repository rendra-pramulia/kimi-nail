<?php
//$koneksi = mysql_connect("localhost","root","");
//$koneksi_db = mysql_select_db ("kimi");

/*$IP="192.168.1.107";*/
$IP="192.168.1.200";
$Key="1";
$Connect = fsockopen($IP, "80", $errno, $errstr, 1);
    if($Connect)
	{
        $soap_request="
						<GetAttLog>
                            <ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey>
                            <Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg>
                        </GetAttLog>";
     
        $newLine="\r\n";
        fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
        fputs($Connect, "Content-Type: text/xml".$newLine);
        fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
        fputs($Connect, $soap_request.$newLine);
        $buffer="";
        while($Response=fgets($Connect, 1024))
		{ $buffer=$buffer.$Response;    }
    }
	else 
	echo "Koneksi Gagal";

	
	function Parse_Data($data,$p1,$p2)
	{
		$data=" ".$data;
		$hasil="";
		$awal=strpos($data,$p1);
		if($awal!="")
		{
			$akhir=strpos(strstr($data,$p1),$p2);
			if($akhir!="")
			{ $hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1)); }
		}
		return $hasil;	
	}
	
	//$url = "http://kimisalon.apli.connexhost.com/kirim.php";

	echo "
	<h3>Data Dari Finger Print</h3>
	<table border='1'>
	<tr>
		<th width='50'>No</th>
		<th>ID Finger</th>
		<th>Tanggal</th>
		<th>Jam</th>
	</tr>
	";

	$buffer=Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
	$buffer=explode("\r\n",$buffer);
	for($a=0;$a<count($buffer);$a++)
	{
		$data=Parse_Data($buffer[$a],"<Row>","</Row>");
		$PIN=Parse_Data($data,"<PIN>","</PIN>");
		$DateTime=Parse_Data($data,"<DateTime>","</DateTime>");
		
		$dates = implode(" ", array_slice(explode(" ",$DateTime), 0, 1));
		$hours = implode(" ", array_slice(explode(" ",$DateTime), 1, 1));
		
		//$curlHandle = curl_init();
		//curl_setopt($curlHandle, CURLOPT_URL, $url);
		//curl_setopt($curlHandle, CURLOPT_POSTFIELDS, "id_finger=".$PIN."&dates=".$dates."&hours=".$hours);
		//curl_setopt($curlHandle, CURLOPT_HEADER, 0);
		//curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($curlHandle, CURLOPT_TIMEOUT,90);
		//curl_setopt($curlHandle, CURLOPT_POST, 1);
		//curl_exec($curlHandle);
		//curl_close($curlHandle);
		
		
		$id_finger = $PIN;
		if(!empty($id_finger))
		/*{
			$unik = $dates.$hours.$id_finger;
			$query = "INSERT INTO absensi (id_finger, dates, hours, unik) VALUES ('$id_finger', '$dates', '$hours', '$unik')";
			mysql_query($query);
		}*/

		echo "
		<tr>
			<td>$a</td>
			<td>$PIN</td>
			<td>$dates</td>
			<td>$hours</td>
		</tr>
		";

	}
?>