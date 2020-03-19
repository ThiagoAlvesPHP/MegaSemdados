<!DOCTYPE html>
<html>
<head>
	<title>Mega Reguladora</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="icon" href="admin/assets/img/favicon.png" type="image/x-icon"/>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
  	<script src="admin/assets/js/jquery.min.js"></script>
	<script src="admin/assets/js/bootstrap.min.js"></script>
	<style type="text/css">
		body{
			background-image: linear-gradient( to right, #00CED1, blue );
		}
		.alert{
			height: 100%;
			margin-top: 20px;
			border-radius: 50px;
			text-align: center;
		}
		.btn{
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			height: 100px;
			font-size: 30px;
			width: 80%;
			margin: auto;
			margin-top: 20px;	
			font-weight: bold;
		}
		@media only screen and (max-width: 600px) {
		  .btn {
		    font-size: 20px;
		  }
		}

		a:hover{
			text-decoration: none;
		}
		.img-responsive{
			margin: auto;
		}
	</style>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="alert alert-success">
				<img src="admin/assets/img/MegaB.png" class="img-responsive">
				<h4>Áreas de Acesso</h4>
				<a href="admin/index.php">
					<button class="btn btn-success btn-lg btn-block">
						Área Administrativa
					</button>
				</a>
				<a href="cliente/index.php">
					<button class="btn btn-primary btn-lg btn-block">
						Área do Cliente
					</button>
				</a>

				<hr>
				<a target="_blank" href="https://www.albicod.com/">Construido por ALBICOD</a>
			</div>
		</div>
	</div>
</div>

</body>
</html>