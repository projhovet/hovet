<?php

$stringList = array();

if ( isset( $_GET['menuop'] ) && ! empty( $_GET['menuop'] )) {
    // Cria variáveis dinamicamente
    // $contador = 0;
    foreach ( $_GET as $chave => $valor ) {
        $valor_tmp = $chave;
        $position = strpos($valor_tmp, "menuop");
        $valor_est = strstr($valor_tmp,$position);
        array_push($stringList, $valor_est);

    }
    // var_dump($stringList);

    $idCategoria = $stringList[1];

    $categoriaId = $_GET[$idCategoria];

    $insumo_id = $stringList[2];

    $idInsumo = $_GET[$insumo_id];

    if (empty($_GET['idInsumo'])){
        
        echo "<script language='javascript'>window.alert('preencha o ID!!'); </script>";
        echo "<script language='javascript'>window.location='/hovet/sistema/index.php?menuop=insumos&categoriaInsumoId=$categoriaId';</script>";
        exit;

    }

}

// $idInsumo = $_GET["idInsumo"];

$sql = "SELECT 
            i.id,
            i.nome,
            i.qtd_critica,
            i.descricao,
            i.unidade,
            t.id as tipo_id,
            t.tipo
        FROM 
            insumos i
        INNER JOIN 
            tipos_insumos t
        ON
            i.tipo_insumos_id = t.id
        WHERE 
            i.id={$idInsumo}";
$result = mysqli_query($conexao,$sql) or die("Erro ao realizar a consulta. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($result);
?>

<div class="container cadastro_all">
    <div class="cards cadastro_insumo">
        <div class="voltar">
            <h4>Edição de Insumo</h4>
            <a href="index.php?menuop=insumos&categoriaInsumoId=<?=$categoriaId?>" class="confirmaVolta">
                <button class="btn">
                    <span class="icon">
                        <ion-icon name="arrow-back-outline"></ion-icon>
                    </span>
                </button>
            </a>
        </div>
        <form class="form_cadastro" action="index.php?menuop=atualizar_insumo&categoriaInsumoId=<?=$categoriaId?>" method="post">

            <div class="form-group valida_movimentacao">

                <div class="display-flex-cl">
                    <label>ID</label>
                    <input type="text" class="form-control largura_um_quarto" name="idInsumo" value="<?=$dados["id"]?>" readonly>
                </div>

            </div>

            <div class="form-group valida_movimentacao">

                <div class="display-flex-cl">
                    <label>Nome</label>
                    <input type="text" class="form-control" name="nomeInsumo" value="<?=$dados["nome"]?>" required>
                </div>

                <div class="display-flex-cl">
                    <label>Quantidade Crítica</label>
                    <input type="number" class="form-control" name="qtdCriticaInsumo" value="<?=$dados["qtd_critica"]?>" required>
                </div>

            </div>

            <div class="form-group valida_movimentacao">

                <div class="display-flex-cl">
                    <label>Tipo de Insumo</label>
                    <select class="form-control" name="tipoInsumo" required>
                        <option><?=$dados['tipo_id']?> - <?=$dados['tipo']?></option>
                        <?php
                        $sql_allTipos = "SELECT * FROM tipos_insumos ";
                        $result_allTipos = mysqli_query($conexao,$sql_allTipos) or die("Erro ao realizar a consulta. " . mysqli_error($conexao));
                        
                        while($tipoInsumo = mysqli_fetch_assoc($result_allTipos)){
                        ?>
                            <option><?=$tipoInsumo["id"]?> - <?=$tipoInsumo["tipo"]?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="display-flex-cl">
                    <label>Unidade</label>
                    <select name="unidadeInsumo" class="form-control" id="" required>
                        <option><?=$dados['unidade']?></option>
                        <option>Caixa</option>
                        <option>Pacote</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="display-flex-cl">
                    <label>Descrição</label>
                    <textarea class="form-control" name="descricaoInsumo" rows="3" required><?=$dados["descricao"]?></textarea>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Atualizar" name="btnAtualizarInsumo" class="btn_cadastrar">
            </div>
        </form>
    </div>
</div>