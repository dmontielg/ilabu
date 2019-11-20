<?php 
include ('dumper.php');

try {

    $ilabu_dumper = Shuttle_Dumper::create(array(

        'host' => 'localhost',
        'username' => 'tron',
        'password' => 'MEG@TRONcronus263',
        'db_name' => 'ilabu',
    ));
    // dump the database to plain text file
    $ilabu_dumper->dump('ilabu.sql');	
	// dump the database to gzipped file
	$ilabu_dumper->dump('ilabu.sql.gz');
	

} catch(Shuttle_Exception $e) {
	echo "Couldn't dump database: " . $e->getMessage();
}