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
        if(isset($_POST['generate'])) {
			include 'combine-images-to-video.php';
			$filename = basename($process->getOutput()->getMediaPath());
			file_put_contents('tmp/log.txt', $filename."\n", FILE_APPEND | LOCK_EX);
		}
		?>
		
        <form action="" enctype="multipart/form-data" method="POST">
	        <div id="video" class="well">
				<legend>Convert CSV to Video</legend>
				<div class="form-group">
					<label for="file">Choose File :</label>
					<input type="file" class="form-control" name="file"/>
				</div>
				<div class="form-group">
					<label for="profile">Profile :</label>
					<select name="profile" class="form-control">
					  <option>Choose profile..</option>
					  <?php foreach (glob("profile/*.xml") as $filename) { ?>
					  <option value="<?=basename($filename, ".xml");?>"><?=basename($filename, ".xml");?><option>
					  <?php } ?>
					</select>
				</div>
				<input type="submit" class="btn btn-warning" name="generate" value="Generate" />
				<a class="btn btn-success" href="addprofile.php">Add New Profile</a>
				<a class="btn btn-primary" href="profile.php">List Profile</a>
			</div>
        </form>
			
	<hr/>
	<center>
	<p>&copy; 2013 <b>Uler Tools</b> | All Rights Reserved.</p>
	
	<a href="/#" title="Uler Team" style="margin-right:10px;"><img src="images/uler.png"/></a>
	<a href="/#" title="dropColors"><img src="images/favicon.png"/></a>
	</center>

</div>
</body>
</html>
