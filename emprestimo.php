<?php
# Faz o carregamento de classes automaticamente
 require 'classes/AutoLoader.php'; 
 error_reporting(E_ALL ^ E_NOTICE);
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
            <form method="post" class="form-search pull-right">
             <div class="input-append">
              <input name="search-cpf" class="" type="text" placeholder="Pesquisa por CPF">
              <button class="btn" type="submit"><i class="icon-search"></i></button>
            </div>
           </form>
          </div>
        </div>
    <?php
      $cliente = new Cliente();
      if($_POST['search-cpf'])
        $cliente->find = (int) $_POST['search-cpf'];
      if($cliente->select()):
          
      ?>
       <div class="row-fluid list">
         <div class="span12">
           <div class="table-responsive">
            
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nome</th>
                  <th>CPF</th>
                  <th>Emprestimos</th>
                  <th>Nº Parcela</th>
                  <th>Valor Parcela</th>
                 
                </tr>
              </thead>
              <tbody>
                  
              <?php
              foreach($cliente->select() as $cli):
              ?>
                  
                <tr>
                  <td><?= $cli->id ?></td>
                  <td><?= $cli->nomeCliente; ?></td>
                  <td><?= $cli->cpf; ?></td>
                  <td><?= $cli->parcelaativa; ?></td>
                  <td><?= $cli->quantparcela; ?></td>
                  <td><?= "R$ ".$cli->valorparcela; ?></td>
                  
                  
                </tr>
              
                <?php echo $cli->nomeCliente. " o valor máximo do teu emprestimo é de "?>
                <?php echo  - ($cli->valorparcela)+(($cli->salario*30)/100).".";?>
                <hr>
              <?php endforeach; # Fim do calculo das linhas ?>
              </tbody>
            </table>
          </div>
         </div><!--span12-->
       </div><!--row-->
      <?php endif; # Fim da condição de verificação da existência da variável $obj ?>

     </div><!--container-->
   </div><!--geral-->

  </body>
</html>