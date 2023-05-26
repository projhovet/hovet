<?php

use Sabberworm\CSS\Value\Value;

echo $qualEstoque;

// $qualEstoque_dep = (isset($_POST["deposito"]))?$_POST["deposito"]:"";

$qualEstoque_teste = $_POST;

if (   isset( $_GET['menuop'] ) && ! empty( $_GET['menuop'] )) {
	// Cria variáveis dinamicamente
	foreach ( $_GET as $chave => $valor ) {
        $valor_tmp = $chave;
        $position = strpos($valor_tmp, "menuop");
        $valor_est = strstr($valor_tmp,$position);
		// $$chave = $valor;
        // print_r($valor_est);
	}
}

$qualEstoque_dep = $valor_est;


if ($qualEstoque_dep != "") {
    $qualEstoque = $qualEstoque_dep;
    // echo "é dep: " . $qualEstoque;
}


?>
<section class="painel_usuarios">
    <div class="container">
        <div class="menu_header">
            <div class="menu_user">
                <h3>Solicitações</h3>
            </div>
            <div>
                <form action="index.php?menuop=solicitacoes" method="post" class="form_buscar">
                    <input type="text" name="txt_pesquisa_solicitacoes" placeholder="Buscar">
                    <button type="submit" class="btn">
                        <span class="icon">
                            <ion-icon name="search-outline"></ion-icon>
                        </span>
                    </button>
                </form>
            </div>
        </div>
        <div class="tabelas">
            <table id="tabela_listar">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Solicitante</th>
                        <th>Insumo Solicitado</th>
                        <th>Dispensário de Origem</th>
                        <th>Quantidade Solicitada</th>
                        <th>Data e Horário</th>
                        <th>Tipo de Solicitação</th>
                        <th>Status</th>
                        <th id="">Operações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
               
                        $quantidade_registros_deposito = 10;

                        $pagina_deposito = (isset($_GET[$qualEstoque]))?(int)$_GET[$qualEstoque]:1;

                        // print_r($_GET);

                        $inicio_deposito = ($quantidade_registros_deposito * $pagina_deposito) - $quantidade_registros_deposito;

                        $txt_pesquisa_solicitacoes = (isset($_POST["txt_pesquisa_solicitacoes"]))?$_POST["txt_pesquisa_solicitacoes"]:"";

                        $sql = "SELECT
                                    s.solicitacoes_id,
                                    u.usuario_primeiro_nome,
                                    i.insumos_nome,
                                    s.solicitacoes_qtd_solicitada,
                                    date_format(s.solicitacoes_data, '%d/%m/%Y %H:%i:%s') AS solicitacoes_data,
                                    st.setores_setor,
                                    s.solicitacoes_justificativa,
                                    stt.status_slc_status,
                                    es.estoques_nome,
                                    tp.tipos_movimentacoes_movimentacao
                                    FROM solicitacoes s
                                    INNER JOIN usuarios u
                                    ON s.solicitacoes_solicitante = u.usuario_id
                                    INNER JOIN dispensario d
                                    ON s.solicitacoes_dispensario_id = d.dispensario_id
                                    INNER JOIN insumos i
                                    ON d.dispensario_insumos_id = i.insumos_id 
                                    INNER JOIN setores st
                                    ON s.solicitacoes_setor_destino = st.setores_id
                                    INNER JOIN status_slc stt
                                    ON s.solicitacoes_status_slc_id = stt.status_slc_id
                                    INNER JOIN estoques es
                                    ON s.solicitacoes_dips_solicitado = es.estoques_id
                                    INNER JOIN tipos_movimentacoes tp
                                    ON tp.tipos_movimentacoes_id = s.solicitacoes_tp_movimentacoes_id
                                    WHERE
                                        s.solicitacoes_id='{$txt_pesquisa_solicitacoes}' or
                                        i.insumos_nome LIKE '%{$txt_pesquisa_solicitacoes}%' or
                                        tp.tipos_movimentacoes_movimentacao LIKE '%{$txt_pesquisa_solicitacoes}%'
                                        ORDER BY insumos_nome ASC 
                                        LIMIT $inicio_deposito,$quantidade_registros_deposito";
                        $rs = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));

                        while($dados_para_while = mysqli_fetch_assoc($rs)){
                            // $valor_form = $dados_para_while['estoques_nome_real'];
                            $qtd_linhas_tabelas++;
                        
                    ?>
                    <tr>
                        <td>
                            <?php
                                $solicitacao_id = $dados_para_while["solicitacoes_id"];
                                echo $solicitacao_id;    
                            ?>
                        </td>
                        <td><?=$dados_para_while["usuario_primeiro_nome"]?></td>
                        <td><?=$dados_para_while["insumos_nome"]?></td>
                        <td><?=$dados_para_while["estoques_nome"]?></td>
                        <td><?=$dados_para_while["solicitacoes_qtd_solicitada"]?></td>
                        <td><?=$dados_para_while["solicitacoes_data"]?></td>
                        <td>
                            <?php
                                $movimentacao_tmp = $dados_para_while["tipos_movimentacoes_movimentacao"];
                                $tipo_slc = strtok($movimentacao_tmp, " ");
                                echo $tipo_slc;
                            ?>
                        </td>
                        <td style="color: 
                        <?php
                            $status_slc = $dados_para_while["status_slc_status"];
                            if($status_slc == "Pendente"){
                                echo "red";
                            } elseif ($status_slc == "Aprovada"){
                                echo "green";
                            }
                        ?>"><?=$status_slc?></td>
                        <td class="operacoes" id="">
                            <a href="index.php?menuop=status_solicitacao&idSolicitacao=<?=$solicitacao_id?>&aprovar"
                                class="confirmaOperacao">
                                <button class="btn" style="color: green;">Aprovar</button>
                            </a>
                            <a href="index.php?menuop=status_solicitacao&idSolicitacao=<?=$solicitacao_id?>&recusar"
                                class="confirmaOperacao">
                                <button class="btn" style="color: red;">Recusar</button>
                            </a>
                            <a href="index.php?menuop=detalhes_solicitacao&idSolicitacao=<?=$solicitacao_id?>"
                                class="confirmaOperacao">
                                <button class="btn" style="color: blue;">Ver detalhes</button>
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                        // array_push($dados_form_buscar,$valor_form);
                        // print_r($dados_form_buscar);
                        echo '<input type="hidden" id="quantidade_linhas_tabelas" value="'.$qtd_linhas_tabelas.'">';
                    ?>
                </tbody>
            </table>
        </div>
        <div class="paginacao">
            <?php
                $sqlTotalSlc = "SELECT solicitacoes_id FROM solicitacoes";
                $queryTotaldeposito = mysqli_query($conexao,$sqlTotalSlc) or die(mysqli_error($conexao));

                $numTotaldeposito = mysqli_num_rows($queryTotaldeposito);
                $totalPaginasdeposito = ceil($numTotaldeposito/$quantidade_registros_deposito);
                
                echo "<a href=\"?menuop=solicitacoes&" . $qualEstoque . "=1\">Início</a> ";

                if ($pagina_deposito>6) {
                    ?>
                        <a href="?menuop=solicitacoes&<?=$qualEstoque?>=<?php echo $pagina_deposito-1?>"> << </a>
                    <?php
                } 

                for($i=1;$i<=$totalPaginasdeposito;$i++){

                    if ($i >= ($pagina_deposito) && $i <= ($pagina_deposito+5)) {
                        
                        if ($i==$pagina_deposito) {
                            echo "<span>$i</span>";
                        } else {
                            echo " <a href=\"?menuop=solicitacoes&". $qualEstoque . "=$i\">$i</a> ";
                        } 
                    }          
                }

                if ($pagina_deposito<($totalPaginasdeposito-5)) {
                    ?>
                        <a href="?menuop=solicitacoes&<?=$qualEstoque?>=<?php echo $pagina_deposito+1?>"> >> </a>
                    <?php
                }
                
                echo " <a href=\"?menuop=solicitacoes&". $qualEstoque . "=$totalPaginasdeposito\">Fim</a>";
            ?>
        </div>
    </div>
</section>