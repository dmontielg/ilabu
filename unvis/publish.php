<HTML>
	<HEAD>
		<TITLE>
		</TITLE>
	</HEAD>
	<BODY>
<pre>
<?php
require_once 'ProgressBar/ProgressBar.class.php';   

# this script publishes everything in phoebus.homeip.net to www.phoebus.nl
# nov 17, 2004
# jul 2007, copy phoebusdev

# dec 2006, modified files only
$modified_only=1;
$test=0;

# this nonsense should make the first flush/ob_flush sooner...

echo "<h5>";
for ($j=0;$j<10;$j++)
{
for ($i=0;$i<4000;$i++){echo "  ";}

ob_flush();
flush();
}
echo "</h5>";

// first count the number of folders, for the percentage bar...

$ftp_server="cluster15.erasmusmc.nl";
$ftp_user_name="apache";
$ftp_user_pass="lmri15"; // top secret!!!
$ftp_home="/DATA1/www/ilabu.erasmusmc.nl/shtml";

// set up basic connection
$conn_id = ftp_connect($ftp_server); 

echo "<h2>Publishing ilabu-ontw to ilabu</h2>";

echo "<br>\n";

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

// check connection
if ((!$conn_id) || (!$login_result)) { 
       echo "FTP connection has failed!";
       echo "Attempted to connect to $ftp_server for user $ftp_user_name\n"; 
       exit; 
   } else {
       if ($test)echo "Connected to $ftp_server, for user $ftp_user_name\n";
   }

// turn passive mode on
if (ftp_pasv($conn_id, TRUE)){if ($test)echo "Now in passive Mode...\n";}else{if ($test)echo "failed to switch to passive mode\n";}

if ($test)echo "Current directory is now: " . ftp_pwd($conn_id) . "\n";

if ($test)
	{
	echo "files on ftp-server:\n";
	$file_list=ftp_rawlist($conn_id, ".");
	print_r($file_list);
	}

ftp_start($conn_id,"..",$ftp_home . "");

// close the FTP stream 
ftp_close($conn_id); 

echo "done.";

echo "<span style=\"color:gray;\">";
echo "\n\nProgresBar courtesy of:\n";
echo " * @author David Bongard (mail@bongard.net | www.bongard.net)\n";
echo " * @version 1.2 - 20070814\n";
echo " * @license http://www.opensource.org/licenses/mit-license.php MIT License\n";
echo " * @copyright Copyright &copy; 2007, David Bongard\n";
echo "</span>";



function ftp_putAll($conn_id, $src_dir, $dst_dir) {
global $test;
global $number_of_folders_to_publish;
global $number_of_folders_published;
global $files_copied;
global $bar;
global $bar_number;

$prev_percent=intval(($number_of_folders_published-1)/$number_of_folders_to_publish*100);
$percent=intval($number_of_folders_published/$number_of_folders_to_publish*100);

for ($i=$prev_percent;$i<$percent;$i++)
	{
//	if ($i)echo "|";
	if ($i>0)
		{
		$bar[$bar_number]->increase();
		$bar[$bar_number]->setMessage($i.'% '.$src_dir);
		}
	}
if ($test)echo "$src_dir ...<br>";
   $d = dir($src_dir);
$folders_not_to_publish=array("unvis","test","backup","attachments","to_be_verified","verified","tpl_c");
$files_not_to_publish=array("robots.txt","config.php");

   while($file = $d->read()) { // do this for each file in the directory
       if ($file != "." && $file != "..") { // to prevent an infinite loop
           if (is_dir($src_dir."/".$file) && !in_array($file,$folders_not_to_publish)) { // do the following if it is a directory
               if (!@ftp_chdir($conn_id, $dst_dir."/".$file)) {
// create directories that do not yet exist
                   if (ftp_mkdir($conn_id, $dst_dir."/".$file))
                     {$files_copied .=   "creating " . $dst_dir . "/" . $file . "\n";}else{$files_copied .=   "ERROR creating " . $dst_dir . "/" . $file . "\n";}
               }

if ($test)echo "following path: " . $src_dir . "/" . $file . "\n";
$number_of_folders_published++;

if ($test)
	{
	echo "files on ftp-server:" . $dst_dir . "/" . $file ."\n";
	$file_list=ftp_rawlist($conn_id, $dst_dir . "/" . $file);
	print_r($file_list);
	}

               ftp_putAll($conn_id, $src_dir."/".$file, $dst_dir."/".$file); // recursive part
           } else {
// put the files
if (!is_dir($src_dir."/".$file))
{
//if ($file != 'robots.txt')
if (!in_array($file,$files_not_to_publish))
            {
// determine if file is modified/new

$stat_items=stat("$src_dir/$file");
$mtime=$stat_items[9];

//echo $mtime;
//$now_date=getdate();
//$now=variant_date_to_timestamp($now_date);

//$nu = date('Ymd');
$timestamp = mktime( 0, 0, 0, date('m'), date('d'), date('Y') );
// actually days/100
$src_file_in_days=intval($mtime/86400);

#$days_old=$time_in_days-$file_in_days;

$dst_file_in_days=intval(ftp_mdtm ( $conn_id, $dst_dir."/".$file)/86400);
if ($dst_file_in_days < 1)$dst_file_in_days=0;

$days_diff=$src_file_in_days-$dst_file_in_days;

if ($test)echo "($src_file_in_days > $dst_file_in_days)";

if ($src_file_in_days >= $dst_file_in_days)
	{
	if ($test)
		{
 	        if ($upload = ftp_put($conn_id, $dst_dir."/".$file, $src_dir."/".$file, FTP_BINARY))
 	           {
		   echo "copied " . $dst_dir . "/" . $file . "\n";
		   }
		else
		   {
		   echo "ERROR copying " . $dst_dir . "/" . $file . "\n";
		   }
		}
	else
		{
		$filesize=intval(filesize("$src_dir/$file")/1024);
		$files_copied .= $src_dir . "/" . $file . " (";
		if ($filesize > 500)$files_copied .=  "<span style=\"color:red;\">";
        	$files_copied .=  $filesize;
		if ($filesize > 500)$files_copied .=  "</span>";
        	$files_copied .=  " kB) ";


		ob_flush();
		flush();
 	        if ($upload = ftp_put($conn_id, $dst_dir."/".$file, $src_dir."/".$file, FTP_BINARY))
        		{
			$files_copied .=  "copied. \n";}else{$files_copied .=  "ERROR copying " . $dst_dir . "/" . $file . "\n";}
			}
		}
	else
		{
		if ($test)echo "NOT copied " . $dst_dir . "/" . $file . "\n";
		}
        }
else
        {
        if ($test)echo "Skipping... " . $dst_dir . "/" . $file . "\n";
        }

ob_flush();
flush();
}
           }
       }
   }
   $d->close();
} 



$number_of_folders_to_publish=0;

function count_folders($src_dir) 
{
global $test;
global $number_of_folders_to_publish;
global $number_of_folders_published;


$d = dir($src_dir);
$folders_not_to_publish=array("unvis","test","backup","admin","attachments","to_be_verified","verified");

while($file = $d->read()) 
	{
        if ($file != "." && $file != "..") 
		{
        	if (is_dir($src_dir."/".$file) && !in_array($file,$folders_not_to_publish)) 
			{
//			echo "following path: " . $src_dir . "/" . $file . "\n";
			$number_of_folders_to_publish++;
			count_folders($src_dir."/".$file);
			} 
		else
	           {
//        	   if ($test)echo "Skipping: " . $dst_dir . "/" . $file . "\n";
	           }
		}
       }
} 

$bar_number=-1;
function ftp_start($conn_id, $src_dir, $dst_dir)
{
global $number_of_folders_to_publish;
global $number_of_folders_published;
global $files_copied;
global $bar;
global $bar_number;

$bar_number++;

$number_of_folders_to_publish=0;
$number_of_folders_published=0;
$files_copied="";

count_folders($src_dir);

echo " ($number_of_folders_to_publish ";
echo "folders)<br>";


$bar[$bar_number] = new ProgressBar();   
$bar[$bar_number]->setMessage("0%");
$bar[$bar_number]->setForegroundColor('#869be8');
$bar[$bar_number]->initialize(100);


ftp_putall($conn_id,$src_dir,$dst_dir);

$bar[$bar_number]->setMessage(" ");

$tmp_bar=$bar_number-1;
if ($tmp_bar)echo "<script language=\"javascript\">document.getElementById('progressbar".$tmp_bar."').style.display='none';</script>";
if (!$tmp_bar)echo "<script language=\"javascript\">document.getElementById('progressbar').style.display='none';</script>";

if ($files_copied)
	{
	echo "$files_copied<br>\n";
	}
else
	{
	echo "geen wijzigingen gevonden in ";
	echo "folders<br>\n";
	}

}

?> 

	</BODY>
</HTML>
