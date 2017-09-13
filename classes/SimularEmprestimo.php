<?php

/**
* Classe para simulação de financiamentos
*
*/

class SimularEmprestimo
{
	/**
	* Variáveis que receberão os valores do formulário
	*/
	private $Valor;
	private $Tempo;
	private $Taxa;
        private $vmaximo;
        public $parcela;

        /**
	* Método construtor. É executado automaticamente no momento que a classe é instanciada
	* Inicializa a classe já recebendo os três parâmetros necessários
	* para executar os caculos, em seguida atribui os parâtros $Valor, $Tempo e $Taxa, às
	* variáveis da classe
	*
	* @method __construct()
	* @param number $Valor, $Tempo, $Taxa
	* @return vloid
	*/
	public function __construct($Valor,$Tempo,$Taxa,$vmaximo)
	{
		$this->Valor = str_replace(',','.',$Valor);
		$this->Tempo = (int) $Tempo;
		$this->Taxa  = str_replace(',','.',$Taxa) / 100;
                $this->vmaximo = str_replace(',','.',$vmaximo);
                
	}

	/**
	* Método calcPrice() é uma método recursivo, é responsável por fazer todo o trabalho de calculos
	* este método faz uso das três variáveis já setadas no momento em que a classe foi instanciada,
	* para assim poder fazer os calculos.
	*
	* @method calcPrice()
	* @return array objects - Retorna um array de objetos contendo as informações de cada linha
	*/
	public function calcPrice($divida=null,$i=null, $rows=[])
	{
		# Atribuindo as variáveis da classe à variáveis com nomes mais simples
		$tempo = $this->Tempo;
		$taxa  = $this->Taxa;
		$valor = $this->Valor;

		# Executando os calculos das colunas
		$parcela = $valor * ($taxa * pow((1+$taxa),$tempo)) / (pow((1+$taxa),$tempo)-1);
		$parcela = $divida ? $parcela : null;
		$juros = $divida * $taxa;
		$amortizacao = $juros ? $parcela - $juros : null;
		$divida = $divida ? $divida - $amortizacao : $valor;
		
		// iniciando o loop
               
                
		$i = $i ? $i : 0;

		if($i<=$tempo)
		{
			# A variável $column recebe um objeto da classe StdClass(), que é uma classe vazia
	        # e nativa do PHP, podemos atribuir valores dinamicamente a objetos desta classe.
	        # Veja que $column é um objeto idependente que guardará as informações de cada linha
	        # com suas respectivas colunas. Colunas estas que já foram calculadas logo acima
			$column = new StdClass();
			$column->tempo 			= $i;
			$column->divida 		= $this->format($divida);
			$column->amortizacao 	= $this->format($amortizacao);
			$column->juros 			= $this->format($juros);
			$column->parcela 		= $this->format($parcela);
			
			# A variável $rows[] receberá os objetos $column e em seguida $será passada
			# como parâmetro a cada execução do método calcSac()
	        # o objeto $column já contém as informações de cada coluna referente à sua linha.
	        # A variável $rows[] vai apenas recebendo os objetos $column a cada execução do método
			$rows[] = $column;
			
			# executamos o método enquanto a $i for menor que a variável $tempo
			$i++;
			return $this->calcPrice($divida,$i,$rows);
		}
		# quando o não existir mais condição de execução para execução do método retorna
		# as linhas guardadas em $rows;
		else
			return $rows;
	
	}

	/**
	** método calcSac() praticamente idêntica ao método calcPrice()
	* @method calcSac() 
	* @return array objects - Retorna um array de objetos contendo as informações de cada linha
	*/
	public function calcSac($divida=null,$i=null, $rows=[])
	{
		$tempo = $this->Tempo;
		$taxa  = $this->Taxa;
		$valor = $this->Valor;

		$amortizacao = $divida ? $valor / $tempo : 0;
		$juros = $divida ? $taxa * $divida : 0;
		$divida = $divida ? $divida - $amortizacao : $valor;
		$parcela = $amortizacao + $juros;

		$i = $i ? $i : 0;

		if($i<=$tempo)
		{

			$column = new StdClass();
			$column->tempo 			= $i;
			$column->divida 		= $this->format($divida);
			$column->amortizacao 	= $this->format($amortizacao);
			$column->juros 			= $this->format($juros);
			$column->parcela 		= $this->format($parcela);
			
			$rows[] = $column;
			
			$i++;
			return $this->calcSac($divida,$i,$rows);
		}
		else 
			return $rows;
	}

	/**
	* O método format() é apenas para auxiliar, serve para colocar valores em formato
	* de moeda brasileira
	*
	* @method format()
	* @param number $num
	* @return number $num
	*/
	private function format($num)
	{
		$num = 'R$ ' . number_format($num,2,',','.');
		return $num;
	}
}