<section class="painel_usuarios">
    <div class="container">
        <div class="menu_header">
            <div class="menu_user">
                <h3>Estoques</h3>
                <a href="index.php?menuop=cadastro_estoque">
                    <button class="btn" id="operacao_cadastro">Novo Estoque</button>
                </a>
            </div>
            <div>
                <form action="index.php?menuop=estoques" method="post" class="form_buscar">
                    <input type="text" name="txt_pesquisa_estoquess" placeholder="Buscar">
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
                        <th id="th_operacoes_editar_deletar">Operações</th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $quantidade_registros_estoques = 10;

                        $pagina_estoques = (isset($_GET['pagina_estoques']))?(int)$_GET['pagina_estoques']:1;

                        $inicio_estoques = ($quantidade_registros_estoques * $pagina_estoques) - $quantidade_registros_estoques;

                        $txt_pesquisa_estoques = (isset($_POST["txt_pesquisa_estoques"]))?$_POST["txt_pesquisa_estoques"]:"";

                        $sql = "SELECT 
                                    *
                                FROM estoques
                                WHERE
                                    estoques_id='{$txt_pesquisa_estoques}' or
                                    estoques_nome LIKE '%{$txt_pesquisa_estoques}%' or
                                    estoques_descricao LIKE '%{$txt_pesquisa_estoques}%'
                                    ORDER BY estoques_nome ASC 
                                    LIMIT $inicio_estoques,$quantidade_registros_estoques";
                        $rs = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));
                        while($dados = mysqli_fetch_assoc($rs)){
                            $qtd_linhas_tabelas++;
                        
                    ?>
                    <tr>
                        <td class="operacoes" id="td_operacoes_editar_deletar">
                            <a href="index.php?menuop=estoques&idInsumodispensario=<?=$dados["dispensario_id"]?>"
                                class="confirmaDelete">
                                <button class="btn">
                                    <span class="icon">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </span>
                                </button>
                            </a>
                        </td>
                        <td><?=$dados["estoques_id"]?></td>
                        <td><?=$dados["estoques_nome"]?></td>
                        <td><?=$dados["estoques_descricao"]?></td>
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
                $sqlTotalEstoques = "SELECT estoques_id FROM estoques";
                $queryTotalEstoques = mysqli_query($conexao,$sqlTotalEstoques) or die(mysqli_error($conexao));

                $numTotalEstoques = mysqli_num_rows($queryTotalEstoques);
                $totalPaginasEstoques = ceil($numTotalEstoques/$quantidade_registros_estoques);
                
                echo "<a href=\"?menuop=estoques&pagina_estoques=1\">Início</a> ";

                if ($pagina_estoques>6) {
                    ?>
                        <a href="?menuop=estoques?pagina_estoques=<?php echo $pagina_estoques-1?>"> << </a>
                    <?php
                } 

                for($i=1;$i<=$totalPaginasEstoques;$i++){

                    if ($i >= ($pagina_estoques) && $i <= ($pagina_estoques+5)) {
                        
                        if ($i==$pagina_estoques) {
                            echo "<span>$i</span>";
                        } else {
                            echo " <a href=\"?menuop=estoques&pagina_estoques=$i\">$i</a> ";
                        } 
                    }          
                }

                if ($pagina_estoques<($totalPaginasEstoques-5)) {
                    ?>
                        <a href="?menuop=estoques?pagina_estoques=<?php echo $pagina_estoques+1?>"> >> </a>
                    <?php
                }
                
                echo " <a href=\"?menuop=estoques&pagina_estoques=$totalPaginasEstoques\">Fim</a>";
            ?>
        </div>
    </div>
</section>