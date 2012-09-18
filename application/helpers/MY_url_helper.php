<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function filedata($path)
{
	//Vaciamos la caché de lectura de disco
	clearstatcache();
	
	//Comprobamos si el fichero existe
	$data['exists'] = is_file($path);		
	
	// Comprobamos si el fichero es escribible
	$data['writable'] = is_writable($path);
			
	// Leemos los permisos del fichero
	$data["chmod"] = ($data["exists"] ? substr(sprintf("%o", fileperms($path)), -4) : FALSE);
	
	// Extraemos la extensión, un sólo paso
	$data["ext"] = substr(strrchr($path, "."),1);
	
	// Primer paso de lectura de ruta
	$data["path"] = array_shift(explode(".".$data["ext"],$path));
	
	// Primer paso de lectura de nombre
	$data["name"] = array_pop(explode("/",$data["path"]));
	
	// Ajustamos nombre a FALSE si está vacio
	$data["name"] = ($data["name"] ? $data["name"] : FALSE);
	
	// Ajustamos la ruta a FALSE si está vacia
	$data["path"] = ($data["exists"] ? ($data["name"] ? realpath(array_shift(explode($data["name"],$data["path"]))) : realpath(array_shift(explode($data["ext"],$data["path"])))) : ($data["name"] ? array_shift(explode($data["name"],$data["path"])) : ($data["ext"] ? array_shift(explode($data["ext"],$data["path"])) : rtrim($data["path"],"/")))) ;
	
	// Ajustamos el nombre a FALSE si está vacio o a su valor en caso contrario
	$data["filename"] = (($data["name"] OR $data["ext"]) ? $data["name"].($data["ext"] ? "." : "").$data["ext"] : FALSE);
	
	// Devolvemos los resultados
	return $data;
}

function url_title($str, $separator = 'dash', $lowercase = FALSE)
{
	if ($separator == 'dash')
	{
		$search		= '_';
		$replace	= '-';
	}
	else
	{
		$search		= '-';
		$replace	= '_';
	}

	$trans = array(
					'á'						=> 'a',
					'é'						=> 'e',
					'í'						=> 'i',
					'ó'						=> 'o',
					'ú'						=> 'u',
					'ç'						=> 's',
					'à'						=> 'a',
					'ò'						=> 'o',
					'ñ'						=> 'n',
					'&\#\d+?;'				=> '',
					'&\S+?;'				=> '',
					'\s+'					=> $replace,
					'[^a-z0-9\-\._]'		=> '',
					$replace.'+'			=> $replace,
					$replace.'$'			=> $replace,
					'^'.$replace			=> $replace,
					'\.+$'					=> ''
				);

	$str = strip_tags($str);

	foreach ($trans as $key => $val)
	{
		$str = preg_replace("#".$key."#i", $val, $str);
	}

	if ($lowercase === TRUE)
	{
		$str = strtolower($str);
	}

	return trim(stripslashes($str));
}

	