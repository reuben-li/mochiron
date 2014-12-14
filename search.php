<?php
 
if (isset($_GET['term'])){
   
   $term=$_GET['term'];
    putenv('LANG=en_US.UTF-8');
 //      $cut=exec( 'echo '.$term.' | mecab  -O wakati');
   $cut=exec( 'echo ' .$term.' |  mecab -O chasen | cut -d"	" -f1,3,4 | head -n -1 | tr "\t" "," | tr "\n" " " ');

	echo $cut;
}
else if	(isset($_GET['lookup'])){
		$return_arr = array();

try {
	$config = parse_ini_file('../../sql.ini');
	$con=mysqli_connect($config['host'],$config['username'],$config['password'],$config['dbname']);
	if (mysqli_connect_errno()) {
		          echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$key=mysqli_real_escape_string($con,$_GET['lookup']);
$type=mysqli_real_escape_string($con,$_GET['type']);

putenv('LANG=en_US.UTF-8');
$key=exec( 'echo '.$key.' | mecab -O dump | sed 2p -n |  cut -d, -f7 ');

mysqli_set_charset($con,"utf8");
$query="SELECT entry,match(entry) against ('".$key." ".$type."') from edict2 where match(entry) against ('".$key." ".$type."') LIMIT 5";
//$query="SELECT * from edict where entry LIKE '".$key."%' LIMIT 5";
$result = mysqli_query($con,$query);
$count = mysqli_num_rows($result);
if ($count == 0) {
	$key = mb_substr($key, 0, -1,'UTF-8');
	//echo $key;
	$key = mb_substr($key, 0, -1,'UTF-8');
	if ($key != ''){
	//echo $key;	
	$query="SELECT entry from edict2 where entry LIKE '%".$key."%' LIMIT 5";
	$result = mysqli_query($con,$query);
	}
}

//	while($row = $stmt->fetch()) {
while($row = mysqli_fetch_array($result)) {
echo $row['entry'].'<br><br>';
//$return_arr[] =  $row['entry'];
					    }
			    	} catch(PDOException $e) {
						    echo 'ERROR: ' . $e->getMessage();
										    	}
		 
		 
		    /* Toss back results as json encoded array. */
	 // $return_arr;
}
else if (isset($_GET['speech'])){
	$speech=$_GET['speech'];
	$id=$_GET['id'];
	putenv('LANG=en_US.UTF-8');
	if(!file_exists("speech/".$id.".wav")){
	exec('echo "' .$speech. '" |  open_jtalk -r 0.8 -m voice/nitech_jp_atr503_m001.htsvoice -x dic -ow speech/' .$id. '.wav');}
}
?>
