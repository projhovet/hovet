<div class="container cadastro_all">
    <div class="cards cadastro_insumo">
        <div class="voltar">
            <h4>Personalização</h4>
            <a href="index.php?menuop=listar_relatorios" class="confirmaVolta">
                <button class="btn">
                    <span class="icon">
                        <ion-icon name="arrow-back-outline"></ion-icon>
                    </span>
                </button>
            </a>
        </div>
        <form class="form_cadastro" action="/hovet/sistema/pdf/relatorio_movimentacao.php" enctype="multipart/form-data" method="post">

            <div id="">
                <hr>
                <div>
                    <div class="form-group valida_movimentacao">
                        <div class="display-flex-cl">
                            <label>Data de referência</label>
                            <input type="date" class="form-control" name="data_referencia" required>
                        </div>
                    </div>

                    <div class="form-group valida_movimentacao">
                        <div class="display-flex-cl">
                            <label>Intervalo de dias</label>
                            <input type="number" class="form-control" min="0" id="valor_dias" name="intervalo_dias" onkeyup="verifica_valor('valor_dias', 'msg_alerta', 'btn_gerar', '0')" required>
                            <span class="alerta_senhas_iguais" style="display: none;" id="msg_alerta">
                                <label>Valor inválido! Por favor, altere para um valor válido!</label>
                                <ion-icon name="alert-circle-outline"></ion-icon>
                            </span>
                        </div>
                    </div>

                    <div class="form-group valida_movimentacao">
                        <div class="display-flex-cl">
                            <div id="campos_id_movimentacoes">
                                <label>Tipo de movimentação</label>
                                <div class="display-flex-row">
                                    <div class="display-flex-cl">
                                        <input type="text" class="form-control" name="tipo_movimentacao[]" id="tipo_movimentacao_1" onkeyup="searchInput_cadDeposito(this.value, 1, 8)" placeholder="Informe o tipo de movimentação..." required>
                                        <span class="ajuste_span" id="sugestao_resultado_span_1"></span>
                                    </div>
                                    <button class="btn" type="button" onclick="adicionaCampoCad(13, 'tipo_movimentacao', 'sugestao_resultado_span_1',8,'tipo_movimentacao_1')" style="padding: 0;">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group valida_movimentacao">
                <label>Confirmo que os dados estão validados</label>
                <input type="checkbox" class="form-control-sm" name="valida_dados_insercao" required>
            </div>

            
            <div class="form-group" id="confirmaDownload">
                <input type="submit" value="Gerar" name="btn_gerar" id="btn_gerar" class="btn btn_cadastrar">
            </div>
        </form>
    </div>
    <div class="cards d-flex ml-3 p-3 wd-auto">
        <div>
            <h5>Lista de movimentações para pesquisa</h5>
            <hr>
        </div>
        <div class="banner-dados">
            <ul>
                <?php
                    $query = "SELECT * FROM tipos_movimentacoes";
                    $result = $conexao->query($query);
                    // var_dump($result);
                    $dados = $result->fetch_all();
                    // var_dump($dados);
                    
                    for ($i=0; $i < $result->num_rows; $i++) { 
                        $movimentacao = $dados[$i][1];
                        echo '<li>' . $movimentacao . '</li>';
                    }

                ?>
            </ul>
        </div>
    </div>
</div>