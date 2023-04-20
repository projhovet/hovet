<section class="painel_usuarios">
    <div class="container">
        <div class="menu_header">
            <div class="menu_user">
                <h3>Dispensário - Gaveteiro</h3>
                <a href="index.php?menuop=cadastro_dispensario">
                    <button class="btn">Inserir</button>
                </a>
                <a href="#">
                    <button class="btn">Retirar</button>
                </a>
            </div>
            <div>
                <form action="index.php?menuop=painel_gaveteiro" method="post" class="form_buscar">
                    <input type="text" name="txt_pesquisa_dispensario_gaveteiro" placeholder="Buscar">
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
                        <th>Operações</th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Unidade</th>
                        <th>Validade</th>
                        <th>Local</th>
                        <th>Dias para o vencimento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $quantidade_registros_dispensario = 10;

                        $pagina_dispensario_gaveteiro = (isset($_GET['pagina_dispensario_gaveteiro']))?(int)$_GET['pagina_dispensario_gaveteiro']:1;

                        $inicio_dispensario = ($quantidade_registros_dispensario * $pagina_dispensario_gaveteiro) - $quantidade_registros_dispensario;

                        $txt_pesquisa_dispensario_gaveteiro = (isset($_POST["txt_pesquisa_dispensario_gaveteiro"]))?$_POST["txt_pesquisa_dispensario_gaveteiro"]:"";

                        $sql = "SELECT 
                                        disp.dispensario_id,
                                        disp.dispensario_qtd,
                                        date_format(disp.dispensario_validade, '%d/%m/%Y') AS validadeDispensario,
                                        i.insumos_nome,
                                        i.insumos_unidade,
                                        datediff(disp.dispensario_validade, curdate()) AS diasParaVencimentoDispensario,
                                        lcd.local_nome
                                        FROM dispensario disp
                                        INNER JOIN deposito deps
                                        ON disp.dispensario_deposito_id = deps.deposito_id
                                        INNER JOIN insumos i
                                        ON deps.deposito_insumos_id = i.insumos_id
                                        INNER JOIN local_dispensario lcd 
                                        ON disp.dispensario_local_id = lcd.local_id
                                    WHERE
                                        (disp.dispensario_local_id = 3 or disp.dispensario_local_id = 2) AND 
                                        (disp.dispensario_id='{$txt_pesquisa_dispensario_gaveteiro}' or
                                        i.insumos_nome LIKE '%{$txt_pesquisa_dispensario_gaveteiro}%' or
                                        i.insumos_unidade LIKE '%{$txt_pesquisa_deposito}%' or
                                        disp.dispensario_qtd LIKE '%{$txt_pesquisa_dispensario_gaveteiro}%' or
                                        disp.dispensario_validade LIKE '%{$txt_pesquisa_dispensario_gaveteiro}%' or
                                        lcd.local_nome LIKE '%{$txt_pesquisa_dispensario_gaveteiro}%')
                                        ORDER BY insumos_nome ASC 
                                        LIMIT $inicio_dispensario,$quantidade_registros_dispensario";
                        $rs = mysqli_query($conexao,$sql) or die("//Dispensario/Painel_gaveteiro/select_geral/ - Erro ao executar a consulta! " . mysqli_error($conexao));
                        while($dados = mysqli_fetch_assoc($rs)){
                        
                    ?>
                    <tr>
                        <td class="operacoes">
                            <a href="index.php?menuop=excluir_dispensario&idInsumodispensario=<?=$dados["dispensario_id"]?>"
                                class="confirmaDelete">
                                <button class="btn">

                                    <span class="icon">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </span>
                                </button>
                            </a>
                        </td>
                        <td><?=$dados["dispensario_id"]?></td>
                        <td><?=$dados["insumos_nome"]?></td>
                        <td><?=$dados["dispensario_qtd"]?></td>
                        <td><?=$dados["insumos_unidade"]?></td>
                        <td><?=$dados["validadeDispensario"]?></td>
                        <td><?=$dados["local_nome"]?></td>
                        <td <?php 
                                $dias = ['30','45'];
 
                                if($dados["diasParaVencimentoDispensario"] <= $dias[0]){                                    
                                ?> class="vermelho" <?php
                                } else if($dados["diasParaVencimentoDispensario"] <= $dias[1]){
                                    ?> class="amarelo" <?php
                                } else if($dados["diasParaVencimentoDispensario"] > $dias[1]){
                                    ?> class="verde" <?php
                                } 
                                ?>><?php if ($dados["diasParaVencimentoDispensario"] <= 0){
                                    echo "INSUMO VENCIDO!";
                                } else{
                                    echo $dados["diasParaVencimentoDispensario"] . " dia(s) para o vencimento";
                                }
                                ?>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <div class="paginacao">
                <?php
                    $sqlTotaldispensario = "SELECT dispensario_id FROM dispensario WHERE dispensario_local_id=3";
                    $queryTotaldispensario = mysqli_query($conexao,$sqlTotaldispensario) or die(mysqli_error($conexao));

                    $numTotaldispensario = mysqli_num_rows($queryTotaldispensario);
                    $totalPaginasdispensario = ceil($numTotaldispensario/$quantidade_registros_dispensario);
                    
                    echo "<a href=\"?menuop=painel_gaveteiro&pagina_dispensario_gaveteiro=1\">Início</a> ";

                    if ($pagina_dispensario_gaveteiro>6) {
                        ?>
                            <a href="?menuop=painel_gaveteiro?pagina_dispensario_gaveteiro=<?php echo $pagina_dispensario_gaveteiro-1?>"> << </a>
                        <?php
                    } 

                    for($i=1;$i<=$totalPaginasdispensario;$i++){

                        if ($i >= ($pagina_dispensario_gaveteiro) && $i <= ($pagina_dispensario_gaveteiro+5)) {
                            
                            if ($i==$pagina_dispensario_gaveteiro) {
                                echo "<span>$i</span>";
                            } else {
                                echo " <a href=\"?menuop=painel_gaveteiro&pagina_dispensario_gaveteiro=$i\">$i</a> ";
                            } 
                        }          
                    }

                    if ($pagina_dispensario_gaveteiro<($totalPaginasdispensario-5)) {
                        ?>
                            <a href="?menuop=painel_gaveteiro?pagina_dispensario_gaveteiro=<?php echo $pagina_dispensario_gaveteiro+1?>"> >> </a>
                        <?php
                    }
                    
                    echo " <a href=\"?menuop=painel_gaveteiro&pagina_dispensario_gaveteiro=$totalPaginasdispensario\">Fim</a>";
                ?>
            </div>
        </div>
    </div>
</section>