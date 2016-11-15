<?php



//Required contants (FINC_ means file includer)
if(!defined('FINC_DOCROOT'))
	define('FINC_DOCROOT',realpath(__DIR__."/.."));
if(!defined('FINC_DEFAULT_FILE'))
	define('FINC_DEFAULT_FILE',"default.php");


//Main function
function finc_includer($finc_path="",$finc_dir="",$finc_params=array())
{
	//Check dirs with includes
	if(!preg_match("/^[a-z0-9\_\.\-]+$/i",$finc_dir)||!file_exists(FINC_DOCROOT."/{$finc_dir}")||!is_dir(FINC_DOCROOT."/{$finc_dir}"))
	  return false;
	//-------
	//Check path for including not permitted files (for example: /../ dirs)
	if(preg_match("/(^\.|\/\.)/",$finc_path))
	  return false;
	//--------
	//Check first available file
	//Variable $finc_path_parts can be used for read more params
	$finc_path_parts_buffer = $finc_path_parts = preg_split("/\/+/",$finc_path,-1,PREG_SPLIT_NO_EMPTY);
	while(count($finc_path_parts_buffer))
	{
		$finc_included_file = FINC_DOCROOT."/{$finc_dir}/".implode("/",$finc_path_parts_buffer).".php";
		if(file_exists($finc_included_file) && is_file($finc_included_file))
		{
			include($finc_included_file);
			return true ;
		}
		array_pop($finc_path_parts_buffer);//Get up level file (if available)
	}
	//--------
	//If path is incorrect include default file
	$finc_included_file = FINC_DOCROOT."/{$finc_dir}/".FINC_DEFAULT_FILE;
	if(file_exists($finc_included_file) && is_file($finc_included_file))
	{
		include($finc_included_file);
		return true;
	}
	else
		return false;
}//function finc_includer...



function finc_includer_buffer($finc_path="",$finc_dir="",$finc_params=array())
{
	ob_start();
		$result = finc_includer($finc_path, $finc_dir, $finc_params);
		if($result!==false)
		  $result = ob_get_contents();
	ob_end_clean();
	//Return false or buffer
	return $result;
}
