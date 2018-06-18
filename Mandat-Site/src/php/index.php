<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link href="../../ressources/css/common.css" rel="Stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<title>Mandat</title>
	</head>
	<body class="text-center">
		<div class="container" >
      <header>
        <h1>GestMandats</h1>
      </header>

        <?php
          if(isset($_GET['page']))
          {
            switch($_GET['page'])
             {
                case "login":
                  include "login.php";
                  break;
                default:
                  include "template.php";
                  break;
             }
         }else{
           include "login.php";
         }
        ?>
		</div>
	</body>
</html>
