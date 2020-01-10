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
        if(isset($_POST['submit'])) {
			$name = base64_encode(stripslashes($_POST['name']));
            $narasi = base64_encode(stripslashes($_POST['narasi']));
            $title = base64_encode(stripslashes($_POST['title']));
            $content = base64_encode(stripslashes($_POST['content']));
            $images = base64_encode(stripslashes($_POST['images']));
            $audio = base64_encode(stripslashes($_POST['audio']));
            $durasi = base64_encode(stripslashes($_POST['durasi']));
            $text = base64_encode(stripslashes($_POST['text']));

            $xml = "<config>";
            $xml .= "<name>".$name."</name>";
            $xml .= "<narasi>".$narasi."</narasi>";
			$xml .= "<title>".$title."</title>";
			$xml .= "<content>".$content."</content>";
			$xml .= "<images>".$images."</images>";
			$xml .= "<audio>".$audio."</audio>";
			$xml .= "<durasi>".$durasi."</durasi>";
			$xml .= "<text>".$text."</text>";
			$xml .= "</config>";
			
            if(@file_put_contents("profile/".$_POST['name'].".xml",$xml))

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
				<input type="text" class="form-control" id="name" name="name" rows="10" value=""/>
			</div>
			<div class="form-group">
				<label for="title">Judul :</label>
				<input type="text" class="form-control" id="title" name="title" value=""/>			  
			</div>
			<div class="form-group">
				<label for="content">Deskripsi :</label>
				<textarea class="form-control" id="content" name="content" rows="20"></textarea>			  
			</div>
			<div class="form-group">
				<label for="narasi">Narasi :</label>
				<textarea class="form-control" id="narasi" name="narasi" rows="10"></textarea>			  
			</div>
		</div>
		<div id="video" class="well">
			<legend>Video Generator</legend>
			<div class="form-group">
				<label for="images">Direktori Gambar :</label>
				<input type="text" class="form-control" id="images" name="images" value="media/images/"/>			  
			</div>
			<div class="form-group">
				<label for="audio">Direktori Audio :</label>
				<input type="text" class="form-control" id="audio" name="audio" value="media/audio/"/>			  
			</div>
			<div class="form-group">
				<label for="durasi">Durasi Video (detik) :</label>
				<input type="text" class="form-control" id="durasi" name="durasi" value="100-120"/>			  
			</div>
			<div class="form-group">
				<label for="text">Text :</label>
				<input type="text" class="form-control" id="text" name="text" value="ORDER VIA WA/SMS 0896-6304-5556"/>	  
			</div>
			<input type="submit" class="btn btn-success" name="submit" value="Submit" />
			<a class="btn btn-primary" href="profile.php">List Profile</a>
		</div>
		</form>
	</div>
	
	</body>
</html>
