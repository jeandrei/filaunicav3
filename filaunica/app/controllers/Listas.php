<?php 
	class Listas extends Controller{
		public function __construct(){
			//vai procurar na pasta model um arquivo chamado Fila.php e incluir
			$this->listaModel = $this->model('Lista');
			$this->etapaModel = $this->model('Etapa');
			$this->filaModel = $this->model('Fila');
			$this->situacaoModel = $this->model('Situacao');
		}

		//emite o relatório de lista de chamada
		public function listachamada(){  
			$this->view('listas/listachamada');
		}
}