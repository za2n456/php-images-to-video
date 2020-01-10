<?php  
    $config = @simplexml_load_file("profile/".$_POST['profile'].".xml");
    include_once 'function.php';
	
	if (isset($_FILES['file'])) {
	$name = $_FILES['file']['name'];
	$name = str_replace('.csv', '', $name);
	$ali_csv = fopen($_FILES['file']['tmp_name'], "r");
	}
	
	fgetcsv($ali_csv);
	while ($data = fgetcsv($ali_csv)) {
			
		//variable
		$gettitle = htmlentities(mywpclean_character($data[2]));
		$images = $data[5];		
		$category = $data[0];
		$productid = $data[3];
		if ($data[8] == null) {
		  $price = '';
		  $sale_price = 'US $'.$data[7];
		  $discount = '';
		} else {
		  $price = 'US $'.$data[7];
		  $sale_price = 'US $'.$data[8];
		  $discount = $data[11].' OFF';
		}
		$expired = $data[10];
		$aff_link = $data[12];
		
		//title
		$wordChunks = explode(' ', $gettitle);
		$ex0 = $wordChunks[0];
		$ex1 = $wordChunks[1];
		$ex2 = $wordChunks[2];
		$ex3 = $wordChunks[3];
		$ex4 = $wordChunks[4];
		$ex5 = $wordChunks[5];
		$ex6 = $wordChunks[6];
		$satukata = ''.$ex0.'';
		$duakata = ''.$ex0.' '.$ex1.'';
		$tigakata = ''.$ex0.' '.$ex1.' '.$ex2.'';
		$empatkata = ''.$ex0.' '.$ex1.' '.$ex2.' '.$ex3.'';
		$limakata = ''.$ex0.' '.$ex1.' '.$ex2.' '.$ex3.' '.$ex4.'';
		$enamkata = ''.$ex0.' '.$ex1.' '.$ex2.' '.$ex3.' '.$ex4.'  '.$ex5.'';
		$tujuhkata = ''.$ex0.' '.$ex1.' '.$ex2.' '.$ex3.' '.$ex4.'  '.$ex5.' '.$ex6.'';
		
		//image url
		$image = explode(',', $images);
		$i = 1;
		
		file_put_contents('media/images/'.basename($data[4]), file_get_contents($data[4]));
		foreach ($image as $img) {
			file_put_contents('media/images/'.basename($img), file_get_contents($img));
			exec('ffmpeg "-i" "media/images/'.basename($img).'" "-vf" "scale=854:480:force_original_aspect_ratio=decrease,pad=854:480:(ow-iw)/2:(oh-ih)/2,drawbox=color=#cc0000:width=iw:height=60:t=fill, drawtext=text=FREE SHIPPING WORLDWIDE:fontfile=media/Oswald-Bold.ttf:fontsize=30:fontcolor=#ffffff:x=(w-tw)/2:y=20" "-y" "media/resized/'.$i.'.jpg"');
			$i++;
			//$video .= "file '$i.jpg'\n";
		}
		//file_put_contents('media/resized/video.txt', $video, LOCK_EX);
		sleep(2);
		$pricey = str_replace('US $', '', $sale_price);		
		$pricey = ceil( $pricey / 100 ) * 100;
		//exec('ffmpeg "-i" "media/intro2.jpg" "-i" "media/images/'.basename($image[0]).'" "-vf" "[in]overlay=100:10,scale=854:480:force_original_aspect_ratio=decrease,pad=854:480:(ow-iw)/2:(oh-ih)/2,drawtext=text=GET '.$category.' Product:fontfile=media/Oswald-Bold.ttf:fontsize=50:fontcolor=#f3cd74:x=(w-tw)/2:y=200,drawtext=text=for UNDER USD'.$pricey.' SHIPPED!:fontfile=media/Oswald-Bold.ttf:fontsize=50:fontcolor=#f3cd74:x=(w-tw)/2:y=200+60[out]" "-y" "media/resized/intro.jpg"');
		exec("ffmpeg '-i' 'media/intro2.jpg' '-i' 'media/images/".basename($data[4])."' '-filter_complex' '[0:v]scale=854:480[v0];[1:v]scale=250:250[v1];[v0][v1]overlay=300:30,drawtext=text=GET ".$category." Product:fontfile=media/Oswald-Bold.ttf:fontsize=50:fontcolor=#f3cd74:x=(w-tw)/2:y=300,drawtext=text=for UNDER ".$pricey." USD:fontfile=media/Oswald-Bold.ttf:fontsize=50:fontcolor=#f3cd74:x=(w-tw)/2:y=300+60[outv]' '-map' '[outv]' '-s' '854x480' '-y' 'media/resized/intro.jpg'");
		sleep(2);
		
		$image1 = $image[0];
		$image2 = $image[1];
		$image3 = $image[2];
		$image4 = $image[3];
		$image5 = $image[4];
		
		// template post
		$title = base64_decode($config->title);
		$title = template_kw($title, $config);
		$title = template_kota($title, $config);
		$title = str_replace('{title}', $gettitle, $title);
		$title = str_replace('{sale_price}', $sale_price, $title);
		$title = str_replace('{discount}', $discount, $title);
		$title = spin($title);
		
		$narasi = base64_decode($config->narasi);
		$narasi = str_replace('{title}', $gettitle, $narasi);
		$narasi = str_replace('{category}', $category, $narasi);
		$narasi = str_replace('{sale_price}', $sale_price, $narasi);
		$narasi = spin($narasi);
		
		$content = base64_decode($config->content);
		$content = template_kw($content, $config);
		$content = template_kota($content, $config);
		$content = str_replace('{title}', $gettitle, $content);	
		$content = str_replace('{category}', $category, $content);
		$content = str_replace('{productid}', $productid, $content);
		$content = str_replace('{sale_price}', $sale_price, $content);
		$content = str_replace('{price}', $price, $content);
		$content = str_replace('{discount}', $discount, $content);
		$content = str_replace('{expired}', $expired, $content);
		$content = str_replace('{aff_link}', $aff_link, $content);
		$content = str_replace('{image1}', $image1, $content);
		$content = str_replace('{image2}', $image2, $content);
		$content = str_replace('{image3}', $image3, $content);
		$content = str_replace('{image4}', $image4, $content);
		$content = str_replace('{image5}', $image5, $content);
		$content = str_replace('{1kata}', $satukata, $content);
		$content = str_replace('{2kata}', $duakata, $content);
		$content = str_replace('{3kata}', $tigakata, $content);
		$content = str_replace('{4kata}', $empatkata, $content);
		$content = str_replace('{5kata}', $limakata, $content);
		$content = str_replace('{6kata}', $enamkata, $content);
		$content = str_replace('{7kata}', $tujuhkata, $content);
		$content = spin($content);
		
		$audio = base64_decode($config->audio);
		$durasi = explode('-', base64_decode($config->durasi));
		$durasi = rand($durasi[0], $durasi[1]);
		$text = base64_decode($config->text);
		
		$list_audio = array_slice(scandir($audio), 2);
		$x = array_rand($list_audio, 1);
		
		$tt = escapeshellcmd('gtts-cli "'.$narasi.'" --output media/audio/tts.mp3');
		shell_exec($tt);
		
		$mp3 = "file 'tts.mp3'\n";
		$mp3 .= "file '".basename($audio.$list_audio[$x])."'\n";
		file_put_contents('media/audio/mp3.txt', $mp3, LOCK_EX);
		
		sleep(2);
		if (!file_exists('output/'.$category)) {
			mkdir('output/'.$category);
		}
		$vv = escapeshellcmd("/bin/ffmpeg '-f' 'concat' '-safe' '0' '-i' 'media/resized/video.txt' '-f' 'concat' '-safe' '0' '-i' 'media/audio/mp3.txt' '-c:v' 'libx264' '-shortest' '-r' '23' '-pix_fmt' 'yuv420p' '-y' '-q' '4' '-strict' 'experimental' '-threads' '1' '-s' '854x480' 'output/".$category."/".GenerateUrl($gettitle, "_").".mp4'");
		$exe = shell_exec($vv);
		//echo $exe;
		if ($exe){
		    array_map( 'unlink', array_filter((array) glob("media/images/*") ) );
		    //array_map( 'unlink', array_filter((array) glob("media/resized/*") ) );
		}
		sleep(2);
		
		$report = '"'.$title.'","'.$content.'"\n';
		file_put_contents('output/'.$category.'/data.csv', $report, FILE_APPEND | LOCK_EX);
	}
?>
