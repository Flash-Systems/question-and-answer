
<html lang="en">
<?php 
session_start();
include('./includes/db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Question and Answer</title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background:#59b6ec61;
		display: flex;
		align-items: center;
		background: url(includes/uploads/qa.jpg);
	    background-repeat: no-repeat;
	    background-size: cover;
	}
	#login-right .card{
		margin: auto;
		z-index: 1
	}
	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
    z-index: 10;
}
div#login-right::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: calc(100%);
    height: calc(100%);
    background: #000000e0;
}

</style>

<body>


  <main id="main" class=" bg-dark">
  		<div id="login-left">
  		</div>

  		<div id="login-right">
  			<div class="card col-md-8">
  				<div class="card-body">
				
				<div id="msg"></div>
  						
  					<form action="" id="manage-user" >
					<input type="hidden" name="id" id="id" value="">
					<div class="form-group">
  							<label for="name" class="control-label">Full Name</label>
  							<input type="text" id="name" name="name" class="form-control" required >
  						</div>
  						<div class="form-group">
  							<label for="username" class="control-label">Username</label>
  							<input type="text" id="username" name="username" class="form-control" required>
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label">Password</label>
  							<input type="password" id="password" name="password" class="form-control" required>
  						</div>
						<div class="form-group">
						<label for="type">User Type</label>
						<select name="type" id="type" class="custom-select" >
							<option value="2" >User Account</option>
						</select>
						</div>
  						<center>
						<button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Register </button><br />
						<a href="login.php" class="form-link"><small class="muted-text">Already Registered? </small></a><br />
						</center>
  					</form>
  				</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>

<script>
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		$.ajax({
			url:'ajax_call.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					$('#msg').html('<div class="alert alert-success">Registered successfully! <a href="login.php" class="form-link">Login Here</a></div>')
				}
				if(resp ==2){
					$('#msg').html('<div class="alert alert-danger">Username taken!</div>')
				}
				if(resp>2){
					$('#msg').html('<div class="alert alert-danger">An error occur!</div>')
				}
			}
		})
	})

</script>
	
</html>