<?php

/**
* Classe responsável por manipular a tabela de usuários
* executando as operações de CRUD
*/
class Cliente
{
	/**
	* @property resource $conn - Guarda o link da conexão com o banco
	*/
	private $conn;

	/**
	* @property string TABLE - Nome da tabela que a classe irá operar 
	*
	*/
	const TABLE = 'clientes';

	/**
	* @properts
	* Variáveis correspondentes às colunas da tabela
	*/
	public $id;
	public $cpf;
	public $nomeCliente;
	public $profissao;
	public $salario;
	public $email;
	public $telefone;
	public $endereco;
        public $parcelaativa;
        public $quantparcela;
        public $valorparcela;

	/**
	* @propert $find
	* Usado para pesquisar cpf
	*/
	public $find;

	/**
	* Método construtor da classe. Instancia a classe iniciando uma conexão com o banco de dados
	* com base nas informações do arquivo de configuração config.ini, na raiz do site.
	*
	* @method __construct()
	* @param $id null
	* @param return void
	*/
	public function __construct($id=null)
	{
		$config = parse_ini_file('config.ini');
		extract($config);

		if($this->conn = mysqli_connect($host,$user,$pass,$base))
		{	
			mysqli_set_charset($this->conn,'utf8');

			$this->id = $id;
			$this->select();
		}
		else
			mysqli_connect_error($this->conn);

	}

	/**
	* Método salvar() - Bem intuitivo. Salva um registro novo
	* Este método é utilizado tanto pra inserir quanto para alterar um registro
	*
	* @method salvar()
	* @return void
	*/
	public function salvar()
	{
		if($this->id)
		{
			$sql = "UPDATE ".self::TABLE." SET ".
			"cpf         = {$this->cpf},
		    nomeCliente     = '{$this->nomeCliente}',
		    profissao       = '{$this->profissao}',
		    salario         = {$this->salario},
		    email           = '{$this->email}',
		    telefone        = {$this->telefone},
		    endereco        = '{$this->endereco}',
                    parcelaativa    = '{$this->parcelaativa}',
                    quantparcela    = {$this->quantparcela},
                    valorparcela    = {$this->valorparcela}
		    WHERE id    = {$this->id}";
		}
		else
		{
			$sql = "INSERT INTO ".self::TABLE."
			(cpf, nomeCliente, profissao, salario, email, telefone, endereco, parcelaativa, quantparcela, valorparcela)".
			"VALUES ({$this->cpf}, '{$this->nomeCliente}', '{$this->profissao}',
			{$this->salario}, '{$this->email}', {$this->telefone}, '{$this->endereco}', '{$this->parcelaativa}', {$this->quantparcela}, {$this->valorparcela})";
		}
		echo $sql.'<br>';

		if($this->id)
			$param = '?edit='.$this->id;

		if($result = mysqli_query($this->conn, $sql))
		{
			header('location: '.$_SERVER['PHP_SELF'].$param);
		}
		else
			echo 'Erro ao inserir usuário! '.mysqli_error($this->conn);
	}

	/**
	* Método select() retorna um registro específico ou todos os registrosde uma busca
	*
	* @method select()
	* @return object 
	*/
	public function select()
	{

		if($this->find)
			$param = " WHERE cpf LIKE '%{$this->find}%'";

		if($this->id)
			$param = " WHERE id = {$this->id}";

		$sql = 'SELECT * FROM '.self::TABLE.$param;
		if($result = mysqli_query($this->conn, $sql))
		{
			if($this->id)
			{
				$row = mysqli_fetch_object($result);
				$this->cpf 	    = $row->cpf;
				$this->nomeCliente  = $row->nomeCliente;
				$this->profissao    = $row->profissao;
				$this->salario      = $row->salario;
				$this->email        = $row->email;
				$this->telefone     = $row->telefone;
				$this->endereco     = $row->endereco;
			}
			else
			{
				while($row=mysqli_fetch_object($result))
				{
					$data[] = $row;
				}

				return $data;
			}
		}
		else
			echo 'Erro ao selecionar registros ! '.mysqli_error($this->conn); 
	}

	/**
	* Método delete() eleimina um registro
	*
	* @method delete()
	* @return void
	*/
	public function delete()
	{
		$sql = "DELETE FROM ".self::TABLE." WHERE id = {$this->id}";
		if(mysqli_query($this->conn, $sql))
		{
			header('location: '.$_SERVER['PHP_SELF']);
		}
		else
			echo mysqli_error($this->conn);
	}
}