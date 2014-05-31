<html>
	<head>
		<title>AkerYachts Bildegenerator</title>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Lato:100,300,300italic|Cinzel' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="style.css">
		<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script src="bootstrap.file-input.js"></script>

		<script>
			$('document').ready(function(){
				$('input[type=file]').bootstrapFileInput();

				// Handle file upload
				$('#submit').click(function(event){
					event.preventDefault();

					// Prepare data
					var form = document.getElementById('imageform');
					var fileSelect = document.getElementById('image');
					var uploadButton = document.getElementById('submit');

					uploadButton.innerHTML = 'Fikser...';
					$(uploadButton).attr("disabled", true);
					// Get the selected files from the input
					var files = fileSelect.files;

					// Create a new FormData object.
					var data = new FormData();

					// Check the file type.
					if (!files[0].type.match('image.*')) {

						console.log("Fikk noe rart");
					}

					// Add the file to the request
					data.append('image', files[0], files[0].name);


					// Perform AJAX-request
					$.ajax({
						url: 'image_processor.php',
						type: 'POST',
						data: data,
						cache: false,
						dataType: 'json',
						processData: false, // Don't process the files
						contentType: false, // Set content type to false as jQuery will tell the server its a query string request
						success: function(data, textStatus, jqXHR){
							if(typeof data.error === 'undefined') {
								console.log(data);
								uploadButton.innerHTML = 'Last opp';
								$(uploadButton).attr("disabled", false);
								$('#image').prop('title', 'Velg bildet ditt');
								$('#download').html("<a href='"+data.download_link+"' download='"+data.formData.name+"'><button class='btn btn-lg btn-primary btn-block'>Last ned <em>"+data.formData.name+"</em></button></a>");
							} else {
								// Handle errors here
								console.log('ERRORS: ' + data.error);
								$(uploadButton).attr("disabled", false);
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							// Handle errors here
							console.log(jqXHR);	
							uploadButton.innerHTML = 'Last opp';
							$(uploadButton).attr("disabled", false);
						}
					});
				}); // End click-event

			}); // End ready-event

		</script>
	</head>
	<body>

		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<h1>AkerYachts bildegenerator</h1>

					<form role="form" action="image_processor.php" id="imageform" class="form-inline center-block">
						<div class="form-group">

							<input type="file" id="image" name="image" title="Velg bildet ditt" data-filename-placement="inside" class="pull-left btn-lg">

						</div>
						<button type="submit" class="btn btn-lg btn-primary pull-right" id="submit">Last opp</button>
					</form>
					<h2 id="download">
						
					</h2>

				</div>
			</div>
		</div>

	</body>
</html>
