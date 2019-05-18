<?php include "templates/include/header.php"; ?>

<main role="main" class="container">

  <div class="container">
	<div class="row">
		<div align="center" class="col-12">
				<h1>Welcome to the Lessons Learned Form</h1>
				<p class="lead">Use this form to tell us lessons you feel we have learned with our projects.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
				<form action="index.php?action=postAnswer" method="post" enctype="multipart/form-data">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="email">Email</label>
							<input type="email" class="form-control"  name="email" id="email" placeholder="Email" required>
						</div>
						<div class="form-group col-md-6">
							<label for="name">Full Name</label>
							<input type="text" class="form-control"  name="name" id="name" placeholder="Name" required>
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress">Address</label>
						<input type="text" class="form-control"  name="inputAddress" id="inputAddress" placeholder="1234 Main St" required>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputCity">City</label>
							<input type="text" class="form-control" name="inputCity" id="inputCity" required>
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">State</label>
							<select name="inputState" id="inputState" class="form-control" required>
								<option selected>Choose...</option>
								<option>...</option>
							</select>
						</div>
						<div class="form-group col-md-2">
							<label for="inputZip">Zip</label>
							<input type="text" class="form-control" name="inputZip" id="inputZip" required>
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="gridCheck" id="gridCheck">
							<label class="form-check-label" for="gridCheck">
								Check me out
							</label>
						</div>
					</div>
					<button type="submit" name="saveChanges" value="Save Changes" class="btn btn-primary">Sign in</button>
				</form>
		</div>
	</div>
  </div>

</main><!-- /.container -->

<?php include "templates/include/header.php"; ?>