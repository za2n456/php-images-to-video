<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>Video Toolkit</title>
		<!-- CSS -->
		<link href="https://bootswatch.com/3/cyborg/bootstrap.min.css" rel="stylesheet" media="screen"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="assets/scripts.js"></script>
		<script src="assets/bootstrap.min.js"></script>
		
    </head>
	<body>
	<div class="container" style="max-width:730px;margin:20px auto;">
		<div class="navbar navbar-inverse">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Video Toolkit</a>
            </div>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                
            </div>
        </div>
		<?php
		if(isset($_GET['p'])) {
			$config = @simplexml_load_file("profile/".$_GET['p'].".xml");
		    if(isset($_POST['submit'])) {
		    	$name = $_POST['name'];
		        $narasi = $_POST['narasi'];
		        $title = $_POST['title'];
		        $content = $_POST['content'];
		        $images = $_POST['images'];
		        $audio = $_POST['audio'];
		        $durasi = $_POST['durasi'];
		        $text = $_POST['text'];
				
		    	$name = stripslashes($name);
		        $narasi = stripslashes($narasi);
		        $title = stripslashes($title);
		        $content = stripslashes($content);
		        $images = stripslashes($images);
		        $audio = stripslashes($audio);
		        $durasi = stripslashes($durasi);
		        $text = stripslashes($text);
		        
				$name = base64_encode($name);
		        $narasi = base64_encode($narasi);
		        $title = base64_encode($title);
		        $content = base64_encode($content);
		        $images = base64_encode($images);
		        $audio = base64_encode($audio);
		        $durasi = base64_encode($durasi);
		        $text = base64_encode($text);

		        $xml = file_get_contents("profile/".$_GET['p'].".xml");
		        $xml = str_replace("<name>".$config->name."</name>","<name>".$name."</name>",$xml);
		        $xml = str_replace("<narasi>".$config->narasi."</narasi>","<narasi>".$narasi."</narasi>",$xml);
				$xml = str_replace("<title>".$config->title."</title>","<title>".$title."</title>",$xml);
				$xml = str_replace("<content>".$config->content."</content>","<content>".$content."</content>",$xml);
				$xml = str_replace("<images>".$config->images."</images>","<images>".$images."</images>",$xml);
				$xml = str_replace("<audio>".$config->audio."</audio>","<audio>".$audio."</audio>",$xml);
				$xml = str_replace("<durasi>".$config->durasi."</durasi>","<durasi>".$durasi."</durasi>",$xml);
				$xml = str_replace("<text>".$config->text."</text>","<text>".$text."</text>",$xml);
							
		        if(@file_put_contents("profile/".$_GET['p'].".xml",$xml))
		        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Setting Saved</div>';
		    }
			
		?>
		<form action="" method="post" enctype="multipart/form-data">
		<div class="well">
			<legend>Template Editor</legend>
				Template Tag : {keyword:n} , {kota:n}
				<br/><br/>
			<div class="form-group">
				<label for="name">Profile Name :</label>
				<input type="text" class="form-control" id="name" name="name" rows="10" value="<?=base64_decode($config->name)?>"/>
			</div>
			<div class="form-group">
				<label for="title">Judul :</label>
				<input type="text" class="form-control" id="title" name="title" value="<?=base64_decode($config->title)?>"/>			  
			</div>
			<div class="form-group">
				<label for="content">Deskripsi :</label>
				<textarea class="form-control" id="content" name="content" rows="20"><?=base64_decode($config->content)?></textarea>			  
			</div>
			<div class="form-group">
				<label for="narasi">Narasi :</label>
				<textarea class="form-control" id="narasi" name="narasi" rows="10"><?=base64_decode($config->narasi)?></textarea>			  
			</div>
		</div>
		<div id="video" class="well">
			<legend>Video Generator</legend>
			<div class="form-group">
				<label for="images">Direktori Gambar :</label>
				<input type="text" class="form-control" id="images" name="images" value="<?=base64_decode($config->images)?>"/>			  
			</div>
			<div class="form-group">
				<label for="audio">Direktori Audio :</label>
				<input type="text" class="form-control" id="audio" name="audio" value="<?=base64_decode($config->audio)?>"/>			  
			</div>
			<div class="form-group">
				<label for="durasi">Durasi Video (detik) :</label>
				<input type="text" class="form-control" id="durasi" name="durasi" value="<?=base64_decode($config->durasi)?>"/>			  
			</div>
			<div class="form-group">
				<label for="text">Text :</label>
				<input type="text" class="form-control" id="text" name="text" value="<?=base64_decode($config->text)?>"/>			  
			</div>
			<input type="hidden" name="filename" value="<?=$filename?>"/>	
			<input type="submit" class="btn btn-success" name="submit" value="Submit" />
			<a class="btn btn-primary" href="profile.php">List Profile</a>
		</div>
		</form>
		<?php } else { ?>
			<table class="table table-striped">
			  <thead>
				<tr>
				  <th width="600" scope="col">Name</th>
				  <th scope="col">Action</th>
				</tr>
			  </thead>
			  <tbody>
				<?php foreach (glob("profile/*.xml") as $filename) { ?>
				<tr>
				  <td><a href="profile.php?p=<?=basename($filename, ".xml");?>"><?=basename($filename, ".xml");?></a></td>
				  <td></td>
				</tr>
				<?php } ?>
			  </tbody>
			</table>
		<?php } ?>
	</div>
	
	</body>
</html>
