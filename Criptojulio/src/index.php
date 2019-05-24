<?php

require_once("../vendor/autoload.php");
use Cripto\Classe\Servico;

$requisicao = new Servico('generate-data?token=' . Servico::TOKEN);
$resultadoRequisicao = json_decode($requisicao->send());

$cripto = new \Cripto\Classe\Cripto();
$cripto->setMensagem(strtolower($resultadoRequisicao->cifrado))
        ->setNumeroCasas($resultadoRequisicao->numero_casas);

$decriptado =  $cripto->decrypt();

//Excreve no arquivo
unlink('answer.json');
$arquivoNome = "answer.json";

$texto = '{';
$texto .= '"numero_casas":';
$texto .= $resultadoRequisicao->numero_casas . ',';
$texto .= '"token":';
$texto .= '"' . $resultadoRequisicao->token . '"' . ',';
$texto .= '"cifrado":';
$texto .= '"' . $resultadoRequisicao->cifrado . '"' . ',';
$texto .= '"decifrado":';
$texto .= '"' . $decriptado . '"' . ',';
$texto .= '"resumo_criptografico":';
$texto .= '"' . sha1($decriptado) . '"';
$texto .= '}';

$arquivo = fopen($arquivoNome, 'a');
fwrite($arquivo, $texto);
fclose($arquivo);

$envioArquivo = new Servico('submit-solution?token=' . Servico::TOKEN);
$enviar = $envioArquivo->sendArquivo();
echo $enviar;