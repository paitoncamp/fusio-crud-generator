<?php 
require_once 'init.php';
use Wirams\FusioCrudGen\DatabaseRepository;

$databaseRepository = new DatabaseRepository($connection);
$databases = $databaseRepository->getDatabases($connection);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Entity Generator</title>
	<link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/css/sumoselect/sumoselect.css" />
	<script src="assets/js/jquery2_1_1.js"></script>
	<script src="assets/js/bootstrap/bootstrap.min.js"></script>
	<script src="assets/js/sumoselect/jquery.sumoselect.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="text-success">Fusio Source Generator</h1>	
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<?php
					if(isset($_GET['error'])){
						echo '<div class="alert alert-danger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  	'.$_GET['error'].'
						</div>';
					}

					if(isset($_GET['success'])){
						echo '<div class="alert alert-success">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  	<strong>Success!</strong> '.$_GET['success'].'
						</div>';
					}
				?>
			</div>
		</div>
		<form action="generator.php" method="POST">
			<div class="row">
				<div class="col-md-4">
					<label for="database">Select Dabases <span class="text-danger">*</span></label>
					<select name="database" id="database" class="form-control" required="required">
						<?php
						foreach($databases as $database){
						?>
						<option value="<?php echo $database; ?>"> <?php echo $database; ?></option>
						<?php
						}
						?>
					</select>
					<!--input type="hidden" id="gentype" name="gentype" value="model"/-->
					
					
				</div>
				<div class="col-md-4 col-md-offset-1">
					<label for="tables">Select Tables <span class="text-danger">*</span> <small class="tableLoading text-info"></small></label>
					<select name="tables" id="tables" class="form-control" multiple="multiple" required="required">
						
					</select>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-md-4">
					<input class="form-check-input" type="checkbox"  name="gentype[]" value="model">
					<label class="form-check-label" for="model">Model</label>
					
					<input class="form-check-input" type="checkbox"  name="gentype[]" value="repository">
					<label class="form-check-label" for="repository">Repository</label>
					
					<input class="form-check-input" type="checkbox" name="gentype[]" value="service">
					<label class="form-check-label" for="service">Service</label>
					
					<input class="form-check-input" type="checkbox"  name="gentype[]" value="actions">
					<label class="form-check-label" for="actions">Actions</label>
				</div>
			</div>
			<br /><br />
			<div class="row">
				<div class="col-md-12">
					<input type="submit" value="Generate" class="btn btn-success">
				</div>
			</div>
		</form>
		
	</div>
	
	<script>
		$(document).ready(function(){
			$('#database').SumoSelect({
				search: true, 
				searchText: 'Search Database Name'
			});

			$('#tables').SumoSelect({
				search: true, 
				searchText: 'Search Tables Name',
				selectAll: true,
				outputAsCSV : true,
				csvSepChar: ','
			});	
			
			$('#database1').SumoSelect({
				search: true, 
				searchText: 'Search Database Name'
			});

			$('#tables1').SumoSelect({
				search: true, 
				searchText: 'Search Tables Name',
				selectAll: true,
				outputAsCSV : true,
				csvSepChar: ','
			});	
			
			$('#database2').SumoSelect({
				search: true, 
				searchText: 'Search Database Name'
			});

			$('#tables2').SumoSelect({
				search: true, 
				searchText: 'Search Tables Name',
				selectAll: true,
				outputAsCSV : true,
				csvSepChar: ','
			});	
			
			$('#database3').SumoSelect({
				search: true, 
				searchText: 'Search Database Name'
			});

			$('#tables3').SumoSelect({
				search: true, 
				searchText: 'Search Tables Name',
				selectAll: true,
				outputAsCSV : true,
				csvSepChar: ','
			});	
		});
	</script>
	<script src="assets/js/getTablesByDatabase.js"></script>
</body>
</html>
