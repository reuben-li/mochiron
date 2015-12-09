<?php
if (isset($_GET['term'])){
    $return_arr = array();
    try {
        $config = parse_ini_file('../../sql.ini');
        $con=mysqli_connect($config['host'],$config['username'],$config['password'],$config['dbname']);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $key=mysqli_real_escape_string($con,$_GET['term']);
        mysqli_set_charset($con,"utf8");
        $query="SELECT jpn,eng,match(jpn,eng,jpn_s,yomi,romaji) against ('".$key.
            "') from allonly7 where match(jpn,eng,jpn_s,yomi,romaji) against ('".$key."') LIMIT 10";
        $result = mysqli_query($con,$query);

        while($row = mysqli_fetch_array($result)) {
            $return_arr[] =  $row['eng'];
        }
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}
?>
