<?php
// 1. DEFINIÇÃO DE CLASSE BASE (ABSTRAÇÃO)

use Mockery\Matcher\Any;

abstract class Animal {
    // 1.1 Propriedades (Encapsulamento)
    protected $nome;      // Acessível apenas na classe e herdeiras
    private $especie;    // Acessível apenas nesta classe

    // 1.2 Construtor (Inicialização)
    public function __construct($nome, $especie) {
        $this->nome = $nome;         // Atribui valor ao atributo $nome
        $this->especie = $especie;   // Atribui valor ao atributo $especie
        echo "Animal $nome criado!\n";
    }

    // 1.3 Método Abstrato (Implementação obrigatória nas filhas)
    abstract public function fazerSom();

    // 1.4 Método Concreto (Comportamento compartilhado)
    public function apresentar() {
        return "Eu sou $this->nome, um $this->especie!";
    }

    // 1.5 Destruidor (Limpeza)
    public function __destruct() {
        echo "Animal $this->nome foi liberado da memória\n";
    }
}

// 2. HERANÇA (Especialização)
class Gato extends Animal{
    private $raca;

    public function __construct($nome, $raca)
    {
        parent::__construct($nome, "Gato");
        $this->raca = $raca;
    }

    public function fazerSom()
    {
        return "$this->nome diz: Miau!";
    }

    public function abanarRabo()
    {
        return "$this->nome Não gosta de Voçê!";
    }
}
class Cachorro extends Animal {
    // 2.1 Propriedade específica
    private $raca;

    // 2.2 Construtor específico
    public function __construct($nome, $raca) {
        parent::__construct($nome, "Cachorro");  // Chama construtor pai
        $this->raca = $raca;
    }

    // 2.3 Implementação do método abstrato (Polimorfismo)
    public function fazerSom() {
        return "$this->nome diz: Au Au!";
    }

    // 2.4 Método específico
    public function abanarRabo() {
        return "$this->nome está abanando o rabo!";
    }
}

// 3. INTERFACE (Contrato)
interface Treinavel {
    public function sentar();
}

interface amigando {
    public function se_esfregar();
}

// 4. CLASSE COM IMPLEMENTAÇÃO DE INTERFACE
class CaoAdestrado extends Cachorro implements Treinavel {
    // 4.1 Implementação da interface
    public function sentar() {
        return "$this->nome sentou sob comando!";
    }

    // 4.2 Override (Sobrescrita de método)
    public function fazerSom() {
        return parent::fazerSom() . " (baixinho)";
    }
}

class Adoramento extends Gato implements amigando {
    public function se_esfregar()
    {
        return "$this->nome está se esfregando em vc!";
    }

    public function fazerSom()
    {
        return parent::fazerSom() . "Querendo Atenção...";
    }
}

// 5. INSTANCIAÇÃO DE OBJETOS
$Catito = new Gato ("Catito", "Siames");
$rex = new Cachorro("Rex", "Pastor Alemão");  // Chama __construct()
$bob = new CaoAdestrado("Bob", "Labrador");   // Chama __construct() em cadeia

// 6. COMUNICAÇÃO ENTRE OBJETOS
class Treinador {
    public function treinar(Treinavel $animal) {  // Type hinting com interface
        return $animal->sentar();  // Comunicação via método
    }
}

$treinador = new Treinador();

// 7. EXECUÇÃO E CHAMADAS
echo $Catito->apresentar() . "\n";
echo $Catito->fazerSom() . "\n";
echo $Catito->abanarRabo() . "\n";

echo $rex->apresentar() . "\n";        // Método herdado de Animal
echo $rex->fazerSom() . "\n";          // Implementação em Cachorro
echo $rex->abanarRabo() . "\n";    // Método específico

echo $bob->apresentar() . "\n";        // Método herdado
echo $bob->fazerSom() . "\n";          // Método sobrescrito
echo $treinador->treinar($bob) . "\n"; // Comunicação entre objetos

// 8. DESTRUTORES (Automáticos no fim do script)
?>