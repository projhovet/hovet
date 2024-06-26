<?php
$idFornecedor = $_GET["id"];
if (empty($_GET['id'])){
    
    echo "<script language='javascript'>window.alert('preencha o ID!!'); </script>";
    echo "<script language='javascript'>window.location='/hovet/sistema/index.php?menuop=fornecedores';</script>";
    exit;

}

$sql = "SELECT 
            f.id,
            f.razao_social,
            f.cpf_cnpj,
            f.ctg_fornecedores_id,
            f.end_logradouro,
            f.end_cep,
            f.end_num,
            f.end_bairro,
            f.end_email,
            f.end_telefone,
            f.observacao,
            c.categoria

        FROM
            fornecedores f
        INNER JOIN
            categorias_fornecedores c
        ON
            c.id = f.ctg_fornecedores_id
            
        WHERE
            f.id={$idFornecedor}";

$result = mysqli_query($conexao,$sql) or die("Erro ao realizar a consulta. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($result);
?>

<div class="container cadastro_all">
    <div class="cards cadastro_fornecedor">
        <div class="voltar">
            <h4>Editar Fornecedor</h4>
            <a href="index.php?menuop=fornecedores" class="confirmaVolta">
                <button class="btn">
                    <span class="icon">
                        <ion-icon name="arrow-back-outline"></ion-icon>
                    </span>
                </button>
            </a>
        </div>
        <form class="form_cadastro" action="index.php?menuop=atualizar_fornecedor" method="post">
                <div class="display-flex-row">
                    <div>
                        <div class="form-group valida_movimentacao">

                            <div class="display-flex-cl">
                                <label>ID do Fornecedor</label>
                                <input type="text" class="form-control largura_um_quarto" name="idFornecedor" value="<?=$dados['id']?>" readonly>
                            </div>
                        </div>

                        <div class="form-group valida_movimentacao">

                            <div class="display-flex-cl">
                                <label>Razão Social</label>
                                <input type="text" class="form-control" name="razaoSocialFornecedor" placeholder="Informe a Razão Social..." value="<?=$dados['razao_social']?>" required>
                            </div>

                            <div class="display-flex-cl">
                                <label>CNPJ ou CPF</label>
                                <input type="text" class="form-control" maxlength="14" name="cnpjCpfFornecedor" placeholder="Informe somente números..." min="1" value="<?=$dados['cpf_cnpj']?>">
                            </div>

                            <div class="display-flex-cl">
                                <label>Categoria</label>
                                <input type="text" class="form-control" name="categoriaFornecedor" id="tipos_fornecedor_1" onkeyup="searchInput_cadDeposito(this.value, 1,9)" placeholder="Informe a categoria..."  value="<?=$dados['ctg_fornecedores_id']?> - <?=$dados['categoria']?>">
                                <span class="ajuste_span" id="resultado_cad_categoria_fornecedor_1" ></span>
                            </div>

                        </div>

                        <div class="form-group valida_movimentacao">

                            <div class="display-flex-cl">
                                <label>Logradouro</label>
                                <input type="text" class="form-control" name="logradouroFornecedor" placeholder="Informe o Logradouro..." value="<?=$dados['end_logradouro']?>">
                            </div>

                            <div class="display-flex-cl">
                                <label>CEP</label>
                                <input type="text" class="form-control" name="cepFornecedor" placeholder="Informe o CEP..." value="<?=$dados['end_cep']?>">
                            </div>

                            <div class="display-flex-cl">
                                <label>Bairro</label>
                                <input type="text" class="form-control" name="bairroFornecedor" placeholder="Informe o Bairro..." value="<?=$dados['end_bairro']?>">
                            </div>

                        </div>

                        <div class="form-group valida_movimentacao">

                            <div class="display-flex-cl">
                                <label>Número do Endereço</label>
                                <input type="text" class="form-control" name="numEnderecoFornecedor" placeholder="Informe o número..." value="<?=$dados['end_num']?>">
                            </div>

                            <div class="display-flex-cl">
                                <label>E-mail</label>
                                <input type="text" class="form-control" name="emailFornecedor" placeholder="Informe o E-mail..." value="<?=$dados['end_email']?>">
                            </div>

                            <div class="display-flex-cl">
                                <label>Fone ou FAC</label>
                                <input type="text" class="form-control" name="foneFacFornecedor" placeholder="Informe o contato..." maxlength="14" value="<?=$dados['end_telefone']?>">
                            </div>

                        </div>

                        <div class="form-group valida_movimentacao">

                            <div class="display-flex-cl">
                                <label>Observação</label>
                                <textarea class="form-control" name="observacaoFornecedor" rows="3"><?=$dados['observacao']?></textarea>
                            </div>

                        </div>
                    </div>

                </div>

        
            <div class="form-group valida_movimentacao">
                <label>Confirmo que os dados estão validados</label>
                <input type="checkbox" class="form-control-sm" name="valida_dados_insercao_fornecedor" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Atualizar" name="btnAtualizarUsuario" class="btn_cadastrar">
            </div>
        </form>
    </div>
</div>