<?php
	$id = $data[0]['id_car'];
	$name = $data[0]['name'];


	$short_desc = $data[0]['shortDescript'];
	$desc = $data[0]['descript'];
	$year = $data[0]['year'];
	$prize = $data[0]['prize'];

?>

<div class='container'>
	<div class='row'>
		<div class='col-lg-6 m-auto'>
			<div id="addNewElement" style="text-align: center; margin-top: 56px; min-height: 100%;">
				<form method="post"  action="/admin/editFunc?id=<?php echo $id; ?>" enctype="multipart/form-data">
					<div class="form-group">
					  	<label for="usr" style="font-size: 14px;">Name:</label><br>
					  	<input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>" required>
					</div>
					
					
					
					<div class="form-group">
					  	<label for="comment" style="font-size: 14px;">Short description:</label><br>
					  	<textarea class="form-control" rows="2" id="short_desc" name="short_desc" required><?php echo $short_desc;?></textarea>
					</div>
					<div class="form-group">
					  	<label for="comment" style="font-size: 14px;">Description:</label><br>
					  	<textarea class="form-control" rows="5" id="desc" name="desc" required><?php echo $desc;?></textarea>
					</div>
					<div class="form-group">
					  	<label for="usr" style="font-size: 14px;">Year:</label><br>
					  	<input type="text" class="form-control" id="year" name="year" value="<?php echo $year;?>" required>
					</div>
					<div class="form-group">
					  	<label for="usr" style="font-size: 14px;">Prize:</label><br>
					  	<input type="text" class="form-control" id="prize" name="prize" value="<?php echo $prize;?>" required>
					</div>
					<div class="form-group">
					  	<input type="submit" id="submit" name="submit" value="Edit">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>