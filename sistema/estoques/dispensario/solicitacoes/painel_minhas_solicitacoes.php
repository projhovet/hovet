<?php

use Sabberworm\CSS\Value\Value;
$stringList = array();
// var_dump($_GET);

if (   isset( $_GET['menuop'] ) && ! empty( $_GET['menuop'] )) {
	// Cria variáveis dinamicamente
	foreach ( $_GET as $chave => $valor ) {
        $valor_tmp = $chave;
        $position = strpos($valor_tmp, "menuop");
        $valor_est = strstr($valor_tmp,$position);
        array_push($stringList, $valor_est);
        // print_r($valor_est);
	}

    $qualStatus_tmp = $stringList[1];
    $qualStatus = $qualStatus_tmp;

    $pagina_slc_tmp = $stringList[2];
    $pagina_slc = $pagina_slc_tmp;
    // echo "<br>Tipo de operacao: $qualStatus_tmp";
}

?>
<section class="painel_usuarios">
    <div class="container">
        <div class="menu_header">
            <div class="menu_user">
                <h3>Minhas Solicitações</h3>
                <?php
                    
                    $sqlStatusTipo = "SELECT * FROM status_slc";
                    $resultTotalStatus = mysqli_query($conexao,$sqlStatusTipo) or die("//sql_status - erro ao realizar a consulta: " . mysqli_error($conexao));

                    while($tipo_status_slc = mysqli_fetch_assoc($resultTotalStatus)){
                    
                    ?>
                    
                    <a href="index.php?menuop=minhas_solicitacoes&<?=$tipo_status_slc['status_slc_status']?>">
                        <button class="btn"><?=$tipo_status_slc['status_slc_status']?>s</button>
                    </a>

                <?php
                    }
                ?>
            </div>
            <div>
                <form action="index.php?menuop=minhas_solicitacoes&<?=$qualStatus?>" method="post" class="form_buscar">
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
                        <th>Tipo de Solicitação</th>
                        <th>Solicitante</th>
                        <th>Dispensário de Origem</th>
                        <th>Data e Horário</th>
                        <th id="">Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
               
                        $quantidade_registros_solicitacoes = 10;

                        $pagina_solicitacoes = (isset($_GET[$qualEstoque]))?(int)$_GET[$qualEstoque]:1;

                        // print_r($_GET);

                        $inicio_solicitacoes = ($quantidade_registros_solicitacoes * $pagina_solicitacoes) - $quantidade_registros_solicitacoes;

                        $txt_pesquisa_solicitacoes = (isset($_POST["txt_pesquisa_solicitacoes"]))?$_POST["txt_pesquisa_solicitacoes"]:"";

                        $sql = "SELECT
                            s.pre_slc_id,
                            u.usuario_primeiro_nome,
                            i.insumos_nome,
                            s.pre_slc_qtd_solicitada,
                            s.pre_slc_oid_solicitacao,
                            s.pre_slc_data,
                            st.setores_setor,
                            s.pre_slc_justificativa,
                            stt.status_slc_status,
                            es.estoques_nome,
                            tp.tipos_movimentacoes_movimentacao
                            
                        FROM pre_solicitacoes s
                            
                            INNER JOIN usuarios u
                            ON s.pre_slc_solicitante = u.usuario_id
                            
                            INNER JOIN dispensario d
                            ON s.pre_slc_dispensario_id = d.dispensario_id
                            
                            INNER JOIN insumos i
                            ON d.dispensario_insumos_id = i.insumos_id 
                            
                            INNER JOIN setores st
                            ON s.pre_slc_setor_destino = st.setores_id
                            
                            INNER JOIN status_slc stt
                            ON s.pre_slc_status_slc_id = stt.status_slc_id
                            
                            INNER JOIN estoques es
                            ON s.pre_slc_dips_solicitado = es.estoques_id
                            
                            INNER JOIN tipos_movimentacoes tp
                            ON tp.tipos_movimentacoes_id = s.pre_slc_tp_movimentacoes_id
                        
                        WHERE
                            s.pre_slc_solicitante = {$sessionUserID} AND stt.status_slc_status = '{$qualStatus}' AND
                            (s.pre_slc_oid_solicitacao LIKE '%{$txt_pesquisa_solicitacoes}%' or u.usuario_primeiro_nome LIKE '%{$txt_pesquisa_solicitacoes}%' or
                            tp.tipos_movimentacoes_movimentacao LIKE '%{$txt_pesquisa_solicitacoes}%')
                            
                        GROUP BY pre_slc_oid_solicitacao 
                        ORDER BY pre_slc_data DESC 
                            
                        LIMIT $inicio_solicitacoes,$quantidade_registros_solicitacoes";
                        $rs = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));

                        while($dados_para_while = mysqli_fetch_assoc($rs)){
                            // $valor_form = $dados_para_while['estoques_nome_real'];
                            $qtd_linhas_tabelas++;
                        
                    ?>
                    <tr>
                        <td>
                            <?php
                                $solicitacao_id = $dados_para_while["pre_slc_oid_solicitacao"];
                                echo $solicitacao_id;    
                            ?>
                        </td>
                        <td>
                            <?php
                                $movimentacao_tmp = $dados_para_while["tipos_movimentacoes_movimentacao"];
                                $tipo_slc = strtok($movimentacao_tmp, " ");
                                echo $tipo_slc;
                            ?>
                        </td>
                        <td><?=$dados_para_while["usuario_primeiro_nome"]?></td>
                        <td><?=$dados_para_while["estoques_nome"]?></td>
                        <td><?php echo date("d/m/Y H:i", strtotime($dados_para_while['pre_slc_data']));?></td>
                        <td>
                            <a href="index.php?menuop=pre_solicitacoes&idSolicitacao=<?=$dados_para_while["pre_slc_oid_solicitacao"]?>&<?=$dados_para_while['status_slc_status']?>">Ver Detalhes</a>
                        </td>
                    </tr>
                    <?php
                        }
                        echo '<input type="hidden" id="quantidade_linhas_tabelas" value="'.$qtd_linhas_tabelas.'">';
                    ?>
                </tbody>
            </table>
        </div>
        <div class="paginacao">
            <?php
                $sqlTotalSlc = "SELECT 
                                    ps.pre_slc_id 
                                FROM 
                                    pre_solicitacoes ps
                                INNER JOIN 
                                    status_slc st
                                ON 
                                    st.status_slc_id = ps.pre_slc_status_slc_id 
                                WHERE 
                                    st.status_slc_status = '{$qualStatus}'
                                GROUP BY pre_slc_oid_solicitacao";

                $queryTotalSlc = mysqli_query($conexao,$sqlTotalSlc) or die(mysqli_error($conexao));

                $numTotalSlc = mysqli_num_rows($queryTotalSlc);


                // print_r($numTotalSlc);
                // if ($numTotalSlc == 0) {
                //     $numTotalSlc = 1;
                // }
                $totalPaginasSlc = ceil($numTotalSlc/$quantidade_registros_solicitacoes);

                echo "<a href=\"?menuop=minhas_solicitacoes&" . $qualStatus . "&pagina_solicitacoes=1\">Início</a> ";

                if ($pagina_solicitacoes>6) {
                    ?>
                        <a href="?menuop=minhas_solicitacoes&<?=$qualStatus?>&pagina_solicitacoes=<?php echo $pagina_solicitacoes-1?>"> << </a>
                    <?php
                } 

                for($i=1;$i<=$totalPaginasSlc;$i++){
                    // print_r($i);

                    if ($i >= ($pagina_solicitacoes) && $i <= ($pagina_solicitacoes+5)) {
                        
                        if ($i==$pagina_solicitacoes) {
                            echo "<span>$i</span>";
                        } else {
                            echo " <a href=\"?menuop=minhas_solicitacoes&" . $qualStatus . "&pagina_solicitacoes=$i\">$i</a> ";
                        } 
                    }          
                }

                if ($pagina_solicitacoes<($totalPaginasSlc-4)) {
                    ?>
                        <a href="?menuop=minhas_solicitacoes&<?=$qualStatus?>&pagina_solicitacoes=<?php echo $pagina_solicitacoes+1?>"> >> </a>
                    <?php
                }
                
                echo " <a href=\"?menuop=minhas_solicitacoes&$qualStatus&pagina_solicitacoes=$totalPaginasSlc\">Fim</a>";
            ?>
        </div>
    </div>
</section>