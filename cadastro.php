<?php require 'classes/AutoLoader.php'; 
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
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
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
      <?php

         if($_GET['del'])
         {
            $id = (int) $_GET['del'];
            $cliente = new Cliente($id);
            $cliente->delete();
         }

         if($_GET['edit'])
         {
            $id = (int) $_GET['edit'];
         }
         $cliente = new Cliente($id);
         if($_POST['cadastrar'])
         {
            # Eliminando o campo do botão, que não vai para o banco
            unset($_POST['cadastrar']);

            # Percorre os elementos do array POST adicionando seus índices e valores ao objeto cliente
            foreach($_POST as $key => $value)
              $cliente->$key = $value;

            $cliente->salvar();
         }
      ?>
        <form method="post" class="form-horizontal">
        <legend>Cadastrar</legend>
          <div class="control-group">
            <label for="Nome" class="control-label">Nome</label>
            <div class="controls">
              <input type="text" name='nomeCliente' value="<?= $cliente->nomeCliente; ?>" class="form-control" />
            </div>
          </div>

          <div class="control-group">
            <label for="Cpf" class="control-label">CPF</label>
            <div class="controls">
              <input type="text" name='cpf' value="<?= $cliente->cpf; ?>" class="form-control" />
            </div>
          </div>

          <div class="control-group">
            <label for="profissao" class="control-label">Profissão  </label>
            
            <div class="controls">
               <select name='profissao' value="<?= $cliente->profissao;?>" class="form-control">
                    <option value="pencionista">Pencionista</option>
                    <option value="aposentados">Aposentados</option>
                    <option value="funcPubl">funcionários públicos</option>
                </select>
            </div>
          </div>

          <div class="control-group">
            <label for="Salario" class="control-label">Salário</label>
            <div class="controls">
              <input type="text" name='salario' value="<?= $cliente->salario;?>" class="form-control" />
            </div>
          </div>

          <div class="control-group">
            <label for="email" class="control-label">Email</label>
            <div class="controls">
              <input type="text" name='email' value="<?= $cliente->email;?>" class="form-control" />
            </div>
          </div>

          <div class="control-group">
            <label for="email" class="control-label">Telefone</label>
            <div class="controls">
              <input type="text" name='telefone' value="<?= $cliente->telefone;?>" class="form-control" />
            </div>
          </div>

          <div class="control-group">
            <label for="Endereço" class="control-label">Endereço</label>
            <div class="controls">
              <input type="text" name='endereco' value="<?= $cliente->endereco; ?>" class="form-control" />
            </div>
          </div>
            <div class="control-group">
            <label for="Endereço" class="control-label">Emprestimos</label>
            <div class="controls">
              <input type="text" name='parcelaativa' value="<?= $cliente->parcelaativa ; ?>" class="form-control" />
            </div>
          </div>
         <div class="control-group">
            <label for="Endereço" class="control-label">Nº Parcelas</label>
            <div class="controls">
              <input type="text" name='quantparcela' value="<?= $cliente->quantparcela; ?>" class="form-control" />
            </div>
          </div>
         <div class="control-group">
            <label for="Endereço" class="control-label">Valor</label>
            <div class="controls">
              <input type="text" name='valorparcela' value="<?= $cliente->valorparcela; ?>" class="form-control" />
            </div>
          </div>

          <div class="control-group">
            <div class="controls">
              <input type="submit" name="cadastrar" class="btn btn-success btn-sm" value="Salvar" />
            </div>
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
                  <th>Profissão</th>
                  <th>Salário</th>
                  <th>Email</th>
                  <th>Telefone</th>
                  <th>Endereço</th>
                  <th>Opções</th>
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
                  <td><?= $cli->profissao; ?></td>
                  <td><?= $cli->salario; ?></td>
                  <td><?= $cli->email; ?></td>
                  <td><?= $cli->telefone; ?></td>
                  <td><?= $cli->endereco; ?></td>
                  <td>
                    <a href="?edit=<?= $cli->id ?>" class="btn btn-small">
                      <i class="icon-edit"></i>
                    </a>
                    <a href="?del=<?= $cli->id ?>" class="btn btn-small">
                      <i class="icon-trash"></i>
                    </a>
                  </td>
                </tr>
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