<header>
    <h2>Inserir Fornecedor</h2>
</header>
<?php 

    $dados_enviados_array = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    if (!empty($dados_enviados_array['btnAdicionarFornecedor'])) {

        foreach ($dados_enviados_array['razaoSocialFornecedor'] as $chave_cad_fornecedor => $valor_cad_fornecedor) {
            $razaoSocialFornecedor = $valor_cad_fornecedor;

            $categoriaFornecedor = $dados_enviados_array['categoriaFornecedor'][$chave_cad_fornecedor];
            $categoriaFornecedor = strtok($categoriaFornecedor, " ");

            $logradouroFornecedor = $dados_enviados_array['logradouroFornecedor'][$chave_cad_fornecedor];
            $cnpjCpfFornecedor = $dados_enviados_array['cnpjCpfFornecedor'][$chave_cad_fornecedor];
            $emailFornecedor = $dados_enviados_array['emailFornecedor'][$chave_cad_fornecedor];            
            $cepFornecedor = $dados_enviados_array['cepFornecedor'][$chave_cad_fornecedor];
            $numEnderecoFornecedor = $dados_enviados_array['numEnderecoFornecedor'][$chave_cad_fornecedor];
            $bairroFornecedor = $dados_enviados_array['bairroFornecedor'][$chave_cad_fornecedor];
            $foneFacFornecedor = $dados_enviados_array['foneFacFornecedor'][$chave_cad_fornecedor];
            $observacaoFornecedor = $dados_enviados_array['observacaoFornecedor'][$chave_cad_fornecedor];

            $sql = "INSERT INTO fornecedores (
                razao_social,
                ctg_fornecedores_id,
                cpf_cnpj,
                end_logradouro,
                end_num,
                end_bairro,
                end_cep,
                end_email,
                end_telefone,
                observacao)
                VALUES(
                    '{$razaoSocialFornecedor}',
                    {$categoriaFornecedor},
                    '{$cnpjCpfFornecedor}',
                    '{$logradouroFornecedor}',
                    '{$numEnderecoFornecedor}',
                    '{$bairroFornecedor}',
                    '{$cepFornecedor}',
                    '{$emailFornecedor}',
                    '{$foneFacFornecedor}',
                    '{$observacaoFornecedor}'
                )";

            if(mysqli_query($conexao, $sql)){
                echo "<script language='javascript'>window.alert('Fornecedor cadastrado com sucesso!'); </script>";
                echo "<script language='javascript'>window.location='/hovet/sistema/index.php?menuop=fornecedores';</script>";

            } else{
                die("//cadastro de fornecedores - Erro ao cadastrar fornecedor(es): " . mysqli_error($conexao));
            }

        }

    } else {
        echo '//Cad_fornecedor/ - nenhum formulário enviado';
    }

?>