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

      <div class="row-fluid row-form">
       <div class="span12">
        <form action="" method="post" class="form-horizontal">
        <legend>Simular</legend>
          <div class="control-group">
            <label for="Valor" class="control-label">Valor</label>
            <div class="controls">
              <input type="text" name='valor' class="form-control" />
            </div>
          </div>

          <div class="control-group">
            <label for="Tempo" class="control-label">Tempo</label>
            <div class="controls">
              <input type="text" name='tempo' class="form-control" />
            </div>
          </div>

          <div class="control-group">
            <label for="Taxa" class="control-label">Taxa</label>
            <div class="controls">
              <input type="text" name='taxa' class="form-control" />
            </div>
          </div>
         <div class="control-group">
            <label for="vmaximo" class="control-label">Valor Máximo</label>
            <div class="controls">
              <input type="text" name='vmaximo' class="form-control" />
            </div>
          </div>

          <div class="control-group">
            <div class="controls">
              <input type="submit" name="calcular" class="btn btn-success btn-sm" value="Calcular" />
            </div>
          </div>
          
        </form>
             <?php
          // echo $pmt;
           
           ?>
        </div>
      </div>

      <?php

      #$teste = new Calculate(50.000,4,10);
      #var_dump($teste->calcPrice());

       // Somente quando o formulário for submetido
       if($_POST['calcular'])
        {
            # Captura as variáveis vindas do formulário
            # O formulário está configurado com o método POST
            $valor = $_POST['valor'];
            $tempo = $_POST['tempo'];
            $taxa  = $_POST['taxa'];
            $vmaximo = $_POST['vmaximo'];

            # Instanciando a classe de calculos
            # Veja que é passado os três valores que a classe exige em seu construtor
            $obj = new SimularEmprestimo($valor,$tempo,$taxa,$vmaximo);
        }

        # Verifica se o objeto da classe Calculate existe.
        # Ou seja, se essa condição acontecer, significa que o usuário enviou o formulário
        # A Classe Calculate foi instanciada logo acima na variável $obj
        # Então além de verificar se existe a variável $obj, verifica-se também se seu método calc()
        # retornou alguma coisa
        # caso tenha retornado, é mostrado o bloco de html logo abaixo 
        #
        if(isset($obj) && !empty($obj->calcPrice())):
      ?>
       <div class="row-fluid list">
         <div class="span12">
           <div class="table-responsive">
               
         
            <table class="table table-bordered">
              
              <thead>
                <tr><th colspan="5" class="table-title"><b>Tabela Prince</b></th></tr>
                <tr>
                  <th>Tempo</th>
                  <th>Parcela</th>
                  <th>Amortização</th>
                  <th>Juros</th>
                  <th>Dívida</th>
                </tr>
              </thead>
              <tbody>
              <?php
              # O método calc() retorna um array de objetos
              # é feita a iteração desses objetos 
              foreach($obj->calcPrice() as $calc):
              ?>
                <tr>
                  <td><?= $calc->tempo;?></td>
                  <td><?= $calc->parcela; ?></td>  
                  <td><?= $calc->amortizacao; ?></td>
                  <td><?= $calc->juros; ?></td>
                  <td><?= $calc->divida; ?></td>
                </tr>
              <?php endforeach; # Fim do calculo das linhas ?>
              </tbody>
            </table>
               <?php
                $pmt= $calc->parcela;
              ?>
               
               <?php
               
               if($pmt > $vmaximo){
                   echo $pmt;
                   echo 'O das parcela excede o valor do seu limite'.'<br/>';
                   echo $vmaximo;
                   
                  
               }else
               echo 'Valor dentro dos limites';
               ?>
            
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th colspan="5" class="table-title">
                    <b>
                      Tabela SAC
                    </b>
                  </th>
                </tr>
                <tr>
                  <th>Tempo</th>
                  <th>Parcela</th>
                  <th>Amortização</th>
                  <th>Juros</th>
                  <th>Dívida</th>
                </tr>
              </thead>
              <tbody>
              <?php
              # O método calc() retorna um array de objetos
              # é feita a iteração desses objetos 
              foreach($obj->calcSac() as $calc):
              ?>
                <tr>
                  <td><?= $calc->tempo;?></td>
                  <td><?= $calc->parcela; ?></td>
                  <td><?= $calc->amortizacao; ?></td>
                  <td><?= $calc->juros; ?></td>
                  
                  <td><?= $calc->divida; ?></td>
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