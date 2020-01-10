<?php
	function spin($content) {
        $zz = substr_count($content, "}");
        $m  = 0;
        while ($m < $zz) {
            $nn     = strpos($content, "}");
            $y      = substr($content, 0, $nn);
            $p      = strrpos($y, "{");
            $bdata  = substr($content, $p, $nn - $p + 1);
            $bdata2 = preg_replace("/{|}/", "", $bdata);
            $cspin  = explode("|", $bdata2);
            shuffle($cspin);
            $newspin = $cspin[0];
            $content = str_replace($bdata, $newspin, $content);
            ++$m;
        }
        return $content;
	}
	function mywpclean_character($content){
		$a = array('”', '“', 'â€œ', 'â€', '‘', 'â€˜', 'â€', ' ™', '™', '¦', 'â€', 'Â½', 'Ã©', 'Ã', '¢', '•', 'ã', '—', '[', ']', 'â€™', '’', '–', '&#8211;', '&#8230;', '&#8220;', '&#8221;', '&#8217;', '&#038;', '&#8212;', '&#8216;', '&#8242;', '&#8243;', '&#8482;', '&#174;');
		$b = array('', '', '', '', '', '', ' ', "'", "'", '', '', ' 1/2', 'e', 'a', '-', '*', 'a', '-', '', '', "'", "'", '-', '-', '...', '"', '"', "'", '', '-', "'", "'", '"', '', '');
		$content = str_replace($a, $b, $content);
		$content = preg_replace('/&#(.*?);/', ' ', $content);
		$content = htmlspecialchars_decode($content, ENT_QUOTES | ENT_HTML5);
		return $content;
	}
	setlocale(LC_ALL, 'en_US.UTF8');
	function GenerateUrl($string, $delimiter = '-') {
		$string = htmlentities($string, ENT_QUOTES, 'UTF-8');
		$pattern = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
		$string = preg_replace($pattern, '$1', $string);
		$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		$pattern = '~[^0-9a-z]+~i';
		$string = preg_replace($pattern, $delimiter, $string);
		return strtolower(trim($string, $delimiter));
	}

	function rrmdir($dir) {
		if (is_dir($dir)) {
		 $objects = scandir($dir);
		 foreach ($objects as $object) {
		   if ($object != "." && $object != "..") {
			 if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
		   }
		 }
		 reset($objects);
		 rmdir($dir);
		}
	}
	
	function find_string($filename, $id) {
		$f = fopen($filename, "r");
		$result = false;
		while ($row = fgetcsv($f)) {
			if ($row[0] == $id) {
				$result = $row[1];
				break;
			}
		}
		fclose($f);
		return $result;
	}
	function random_lines($filename, $numlines, $unique=true) {
		if (!file_exists($filename) || !is_readable($filename))
			return null;
		$filesize = filesize($filename);
		$lines = array();
		$n = 0;

		$handle = @fopen($filename, 'r');

		if ($handle) {
			while ($n < $numlines) {
				fseek($handle, rand(0, $filesize));

				$started = false;
				$gotline = false;
				$line = "";

				while (!$gotline) {
					if (false === ($char = fgetc($handle))) {
						$gotline = true;
					} elseif ($char == "\n" || $char == "\r") {
						if ($started)
							$gotline = true;
						else
							$started = true;
					} elseif ($started) {
						$line .= $char;
					}
				}

				if ($unique && array_search($line, $lines))
					continue;

				$n++;
				array_push($lines, $line);
			}

			fclose($handle);
		}

		return $lines;
	}
	function rand_array($array, $n) {
		$random = array_rand($array, $n);
		if ($n == 1) {
			$arr = ucwords(trim($array[$random]));
		} else {
			$arr = array();
			foreach ($random as $x) {
				$arr[] = ucwords(trim($array[$x]));
			}
			$arr = join(', ', $arr);
		}
		return $arr;
	}
	function template_kw($content, $config) {
		preg_match_all("/\{(keyword+):(.*?)\}/", $content, $match);
		$keyword = explode("\n", base64_decode($config->keyword));	
		foreach ($match[2] as $n) {
		$content = str_replace('{keyword:'.$n.'}', rand_array($keyword, $n), $content);
		}
		return $content;
	}
	function template_kota($content, $config) {
		preg_match_all("/\{(kota+):(.*?)\}/", $content, $match);
		$kota = explode("\n", base64_decode($config->kota));
		foreach ($match[2] as $n) {
		$content = str_replace('{kota:'.$n.'}', rand_array($kota, $n), $content);
		}
		return $content;
	}
?>
