<?php
include("../../db/connect.php");

$html .= "<!DOCTYPE html>";
$html .= "<html lang='pt-BR'>";
$html .= "<head>"; 
$html .= "<meta charset='UTF-8'>";
$html .= "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
$html .= "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
$html .= "<link rel='stylesheet' href='http://localhost/hovet/sistema/pdf/css/custom.css'>";
$html .= "<title>Relatório de Insumos Prestes a Expirar</title>";
$html .= "</head>";
$html .= "<body>";
$html .= "<div class='container'>";
$html .= "<img src='logo_hovet.jpg'>";

//Coleta de dados caso seja personalizado
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$sql = "";
    
if (!empty($dados)) {
    // echo "tem post";
    $data_referencia = mysqli_real_escape_string($conexao,$_POST["data_referencia"]);
    $intervalo_dias = mysqli_real_escape_string($conexao,$_POST["intervalo_dias"]);

    $html .= "<h3 align='center'>Relatório de insumos prestes a expirar nos próximos $intervalo_dias dias<br></h3>";

    $sql= "SELECT 
                d.deposito_id, 
                d.deposito_qtd,
                date_format(d.deposito_validade, '%d/%m/%Y') as validadedeposito,
                i.insumos_nome,
                i.insumos_unidade,
                datediff(d.deposito_validade, curdate()) as diasvencimento,
                es.estoques_nome
            FROM 
                deposito d 
            INNER JOIN 
                insumos i 
            ON
                d.deposito_insumos_id = i.insumos_id
            INNER JOIN 
                estoques es
            ON
                es.estoques_id = d.deposito_estoque_id
            WHERE 
                deposito_validade<='{$data_referencia}' + interval {$intervalo_dias} day ORDER BY insumos_nome ASC";

} else {
    $html .= "<h3 align='center'>Relatorio de Insumos Prestes a Expirar nos Próximos 30 dias<br></h3>";

    $sql= "SELECT 
            d.deposito_id, 
            d.deposito_qtd,
            date_format(d.deposito_validade, '%d/%m/%Y') as validadedeposito,
            i.insumos_nome,
            i.insumos_unidade,
            datediff(d.deposito_validade, curdate()) as diasvencimento,
            es.estoques_nome
        FROM deposito d 
        inner join insumos i 
        on d.deposito_insumos_id = i.insumos_id
        inner join estoques es
        on es.estoques_id = d.deposito_estoque_id
        where deposito_validade<=curdate() + interval 30 day ORDER BY insumos_nome ASC";
}

$res = $conexao->query($sql);
date_default_timezone_set('America/Sao_Paulo');
$agora = date('d/m/Y H:i');

if($res->num_rows > 0){
    $html .= "<table border=1 cellspacing=3>";
    $html .= "<thead><tr><th> ID </th><th> Insumo </th><th> Quantidade </th><th> Validade </th><th> Guardado em </th><th> Aviso de Vencimento </th></tr></thead>";
    $html .= "<tbody>";
    
    while($row = $res->fetch_object()){
        
        $html .= "<tr>";
        $html .= "<td>".$row->deposito_id."</td>";
        $html .= "<td>".$row->insumos_nome."</td>";
        $html .= "<td>".$row->deposito_qtd."</td>";
        $html .= "<td>".$row->validadedeposito."</td>";
        $html .= "<td>".$row->estoques_nome."</td>";
        $dias = ['30','45'];

        $mensagem_aviso = '';
        $class_to_add = '';

        if($row->diasvencimento <= $dias[0]){                                    
            $class_to_add = "vermelho";
        } else if($row->diasvencimento <= $dias[1]){
            $class_to_add = "amarelo";
        } else if($row->diasvencimento > $dias[1]){
            $class_to_add = "verde";
        }
            
        if ($row->diasvencimento <= 0){
            $mensagem_aviso = "INSUMO VENCIDO!";
        } else{
            $mensagem_aviso = $row->diasvencimento . " dia(s) para o vencimento";
        }
            
        $html .="<td class=". $class_to_add . ">". $mensagem_aviso;
        
        $html .= "</tr>";
    }
    $html .= "</tbody>";
    $html .= "</table>";
    $html .= "</div>";
    $html .= "";

}else{
    $html .= "<h3 align='center'>Relatorio de Insumos Prestes a Expirar nos Próximos 30 dias<br></h3>";
    $html .="<p>Nenhum dado foi encontrado para este relatorio.</p>";
    //echo "Sem resultado";
}
$html .= "<p>Relatorio gerado em " . $agora ."</p>";
$html .= "</body>";
$html .= "</html>";

require __DIR__.'/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

//instanciar Options
$options = new Options();
$options->setChroot(__DIR__);

$options->setIsRemoteEnabled(true);

//instanciar Dompdf
$dompdf = new Dompdf($options);
//$dompdf = new Dompdf();

$dompdf->loadHtml($html);

//configurando o papel
$dompdf->setPaper('A4', 'landscape');

// $dompdf->loadHtml('Olá Html');
$dompdf->render();

//Pegar a data atual e nome do arquivo
$data_atual = date('Y-m-d');
$file_name = "" . $data_atual . "-relatorio_insumo_expirar.pdf";

// header('Content-type: application/pdf');    
header('Content-type: application/pdf');
    $dompdf->stream(
        $file_name,
        array(
            "Attachment"=>true
        )
    );

?>