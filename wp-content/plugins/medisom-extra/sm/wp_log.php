<style>
</style>
<?
//echo getcwd();
$myfile = fopen("./wp-content/debug.log", "r") or die("log kan niet gelezen worden !");
$max	= 100;
$i		= 1;
echo 'de eerste '.$max.' regels die medisom-extra bevatten: <br>';
// Output one line until end-of-file
while(!feof($myfile) and $i < $max) {
  $regel 	= fgets($myfile);
  if (strpos($regel,'medisom-extra') > 1) {
	echo $regel.'<br>';
	$i++;
  }
}
fclose($myfile);
unlink("./wp-content/debug.log");
