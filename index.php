<?php
# Faz o carregamento de classes automaticamente
 require 'classes/AutoLoader.php'; 
 ?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulador Casa Bancária</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

   <div class="geral">
     <div class="container-fluid">
      <div class="row-fluid" id="nav">
        <div class="span12">
              <ul class="nav nav-pills menu">
                <li <?php Helper::active('index') ?>><a href="index.php">Home</a></li>
                <li <?php Helper::active('simular') ?>><a href="simular.php">Simulação</a></li>
                <li <?php Helper::active('cadastro') ?>><a href="cadastro.php">Cadastro</a></li>
                <li <?php Helper::active('emprestimo') ?>><a href="emprestimo.php">Emprestimo</a></li>
              </ul>
        </div>
      </div>
    
      <div class="row-fluid">
        <div class="span12">
          <div class="hero-unit">
          <h1>Bem vindo(a)</h1>
          <p> Sistema de simulação de empréstimos</p>
        </div>
        </div>
      </div>

     </div><!--container-->
   </div><!--geral-->

  </body>
</html>