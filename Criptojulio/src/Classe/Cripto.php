<?php

namespace Cripto\Classe;

class Cripto implements ICripto
{

    const ALFABETO = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    private $mensagem;
    private $numeroCasas;

    public function __construct()
    {
        $this->mensagem = "codenation";
    }

    /**
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param string $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = Utilitario::removeAcentos($mensagem);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumeroCasas()
    {
        return $this->numeroCasas;
    }

    /**
     * @param mixed $numeroCasas
     */
    public function setNumeroCasas($numeroCasas)
    {
        $this->numeroCasas = $numeroCasas;
        return $this;
    }

    public function encrypt()
    {
        return $this->modLetra();
    }

    public function decrypt()
    {
        return $this->modLetra(false);
    }

    private function modLetra($acrescentar = true)
    {
        $mensagem = str_split($this->mensagem);
        for ($i = 0; $i < (count($mensagem)); $i++) {
            if ($this->existeAlfabeto($mensagem[$i])) {
                if ($acrescentar){
                    $mensagem[$i] = Cripto::ALFABETO[$this->retornaCasa($mensagem[$i])];
                    continue;
                }
                $mensagem[$i] = Cripto::ALFABETO[$this->retornaCasa($mensagem[$i],false)];
            }
        }
        return implode("", $mensagem);
    }

    private function existeAlfabeto($char)
    {
        if (in_array($char, Cripto::ALFABETO)) {
            return true;
        }

        return false;
    }

    private function retornaCasa($char, $acrescentar = true)
    {

        $totalAlfabeto = count(Cripto::ALFABETO) - 1;
        $posAlfabeto = array_search($char, Cripto::ALFABETO);
        if (!$acrescentar) {
            $posicao = $posAlfabeto - $this->numeroCasas;
            if ($posicao < 0) {
                $posicao = ($totalAlfabeto - abs($posicao)) + 1;
            }
        }
        if ($acrescentar) {
            $posicao = $posAlfabeto + $this->numeroCasas;
            if ($posicao > $totalAlfabeto) {
                $posicao = ($posicao - $totalAlfabeto) - 1;
            }
        }
        return $posicao;
    }

}