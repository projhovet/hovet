<div class="container container_home" style="padding: 20px;">
    <!-- <section class="menu_lateral">
        <div class="">
            <div class="menu_op menu lateral">
                <div>
                    <p>teste</p>
                    <ul>
                        <li>teste</li>
                        <li>teste</li>
                        <li>teste</li>
                        <li>teste</li>
                    </ul>
                </div>
            </div>
        </div>
    </section> -->

    <section>
        <div>
            <h1>Informações Gerais do Sistema</h1>
            <hr>
        </div>
        <div class="cards_wrapper gap_home">
            <div class="group_cards">
                <div class="content_cards">
                    <div class="titulo">
                        <!-- <h2 title="Informações de todos os Depósitos">Depósitos</h2> -->
                        <h2 title="Informações de todos os Depósitos">
                            <a href="index.php?menuop=estoques">Depósitos</a>
                        </h2>
                        <span class="info">
                            <ion-icon name="help-circle-outline"></ion-icon>
                        </span>
                    </div>
                    <div class="cards cards_info">
                        <div class="display-flex-row just-content-spc-around ">

                            <div class="sub_dados">
                                <div class="titulo">
                                    <h4>Insumos</h4>
                                    <span class="icon">
                                        <ion-icon name="file-tray-full-outline"></ion-icon>
                                    </span>
                                </div>
                                <?php
                                    $sql = "SELECT COUNT(*) as deposito_Qtd FROM deposito WHERE deposito_Validade>curdate()";
                                    $rs = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));
                                    while($dados = mysqli_fetch_assoc($rs)){
                                ?>
                                <h2><?=$dados['deposito_Qtd']?></h2>
                                <?php
                                    }
                                ?>
                                <p>Total de insumos</p>
                            </div>
                            <div class="vencimentoProx">
                                <div class="titulo">
                                    <h4 style="color: red;">
                                        <a href="pdf/relatorio_validade.php" target="_blank" style="color: red;">A vencer</a>
                                    </h4>
                                    <span class="icon">
                                        <ion-icon name="alert-circle-outline" style="color: red;"></ion-icon>
                                    </span>
                                </div>
                                <?php
                                    $sql = "SELECT count(deposito_id) as vencidos_proxVencimento FROM deposito where deposito_Validade<=curdate() or deposito_Validade <= curdate() - interval 30 day";
                                    $result = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));
                                    ($vencidos = mysqli_fetch_assoc($result));
                                ?>
                                <h2><?=$vencidos['vencidos_proxVencimento']?></h2>
                                <p>Próximos ou Vencidos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group_cards">
                <div class="content_cards">
                    <div class="titulo">
                        <h2 title="Informações de todos os Dispensários">
                            <a href="index.php?menuop=estoques">Dispensários</a>
                        </h2>
                        <span class="info">
                            <ion-icon name="help-circle-outline"></ion-icon>
                        </span>
                    </div>
                    <div class="cards cards_info">
                        <div class="display-flex-row just-content-spc-around">
                            <div class="sub_dados">
                                <div class="titulo">
                                    <h4>Insumos</h4>
                                    <span class="icon">
                                        <ion-icon name="file-tray-full-outline"></ion-icon>
                                    </span>
                                </div>
                                <?php
                                    $sql = "SELECT COUNT(*) as dispensario_Qtd FROM dispensario";
                                    $rs = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));
                                    while($dados = mysqli_fetch_assoc($rs)){
                                ?>
                                <h2><?=$dados['dispensario_Qtd']?></h2>
                                <?php
                                    }
                                ?>
                                <p>Total de insumos</p>
                            </div>
                            <div class="vencimentoProx">
                                <div class="titulo">
                                    <h4 style="color: red;">A vencer</h4>
                                    <span class="icon">
                                        <ion-icon name="alert-circle-outline" style="color: red;"></ion-icon>
                                    </span>
                                </div>
                                <?php
                                    $sql = "SELECT count(dispensario_id) as vencidos_proxVencimento FROM dispensario where dispensario_Validade<=curdate() or dispensario_Validade <= curdate() + interval 30 day";
                                    $result = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));
                                    $vencidos = mysqli_fetch_assoc($result);
                                ?>
                                <h2><?=$vencidos['vencidos_proxVencimento']?></h2>
                                <p>Próximos ou Vencidos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group_cards">
                <div class="content_cards">
                    <div class="titulo">
                        <h2 title="Informações de todos os usuários">
                            <a href="index.php?menuop=usuarios">Usuários</a>
                        </h2>
                        <span class="info">
                            <ion-icon name="help-circle-outline"></ion-icon>
                        </span>
                    </div>
                    <div class="cards cards_info">
                        <div class="display-flex-row just-content-spc-around" style="justify-content: initial;">
                            <div class="sub_dados">
                                <div class="titulo">
                                    <h4>Cadastrados</h4>
                                    <span class="icon">
                                        <ion-icon name="file-tray-full-outline"></ion-icon>
                                    </span>
                                </div>
                                <?php
                                    $sql = "SELECT COUNT(usuario_id) as usuarios_qtd FROM usuarios";
                                    $rs = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));
                                    $dados = mysqli_fetch_assoc($rs);
                                ?>
                                <h2><?=$dados['usuarios_qtd']?></h2>
                                <p>Total de Funcionários</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cards_wrapper gap_home">
            <div class="group_cards">
                <div class="content_cards">
                    <div class="top_cards">
                        <div class="titulo">
                            <h2 title="Informações de todas as solicitações">
                                <a href="index.php?menuop=pre_solicitacoes&Pendente">Solicitações</a>
                            </h2>
                            <span class="info">
                                <ion-icon name="help-circle-outline"></ion-icon>
                            </span>
                        </div>
                    </div>
                    <div class="cards cards_info">
                        <div class="display-flex-row just-content-spc-around">
                            <div class="sub_dados">
                                <div class="titulo">
                                    <h4>Requisição</h4>
                                    <span class="icon">
                                        <ion-icon name="file-tray-full-outline"></ion-icon>
                                    </span>
                                </div>
                                <?php
                                    $sql = "SELECT COUNT(s.pre_slc_id) as pre_solicitacoes_qtd 
                                                FROM pre_solicitacoes s
                                                INNER JOIN tipos_movimentacoes tp
                                                ON s.pre_slc_tp_movimentacoes_id = tp.tipos_movimentacoes_id
                                                WHERE tp.tipos_movimentacoes_movimentacao LIKE 'Requisição%'";
                                    $rs = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));
                                    $dados = mysqli_fetch_assoc($rs);
                                ?>
                                <h2><?=$dados['pre_solicitacoes_qtd']?></h2>
                                <p>Total Pendentes</p>
                            </div>
                            <div class="sub_dados">
                                <div class="titulo">
                                    <h4>Devolução</h4>
                                    <span class="icon">
                                        <ion-icon name="file-tray-full-outline"></ion-icon>
                                    </span>
                                </div>
                                <?php
                                    $sql = "SELECT COUNT(s.pre_slc_id) as pre_solicitacoes_qtd 
                                                FROM pre_solicitacoes s
                                                INNER JOIN tipos_movimentacoes tp
                                                ON s.pre_slc_tp_movimentacoes_id = tp.tipos_movimentacoes_id
                                                WHERE tp.tipos_movimentacoes_movimentacao LIKE 'Devolução%'";
                                    $rs = mysqli_query($conexao,$sql) or die("Erro ao executar a consulta! " . mysqli_error($conexao));
                                    $dados = mysqli_fetch_assoc($rs);
                                ?>
                                <h2><?=$dados['pre_solicitacoes_qtd']?></h2>
                                <p>Total Pendentes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group_cards">
                <div class="content_cards">
                    <div class="top_cards">
                        <div class="titulo">
                            <h2 title="Informações de todas as solicitações">
                                <a href="index.php?menuop=listar_movimentacoes">Movimentações</a>
                            </h2>
                            <span class="info">
                                <ion-icon name="help-circle-outline"></ion-icon>
                            </span>
                        </div>
                        <!-- <ion-icon name="help-circle-outline"></ion-icon> -->
                    </div>
                    <div class="cards cards_info">
                        <div class="display-flex-row just-content-spc-around">
                            <div>
                                <?php
                                    $sql = "SELECT count(*) AS quantidade_compras FROM movimentacoes WHERE movimentacoes_tipos_movimentacoes_id=1";
                                    $result = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
                                    $dados = mysqli_fetch_assoc($result);
                                ?>
                                <h4>Compras</h5>
                                    <h5><?=$dados['quantidade_compras']?></h5>
                                <p>Total de Compras</p>

                                <?php
                                    $sql = "SELECT count(*) AS quantidade_retiradas FROM movimentacoes WHERE movimentacoes_tipos_movimentacoes_id=6";
                                    $result = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
                                    $dados = mysqli_fetch_assoc($result);
                                ?>
                                <h4>Retiradas</h5>
                                    <h5><?=$dados['quantidade_retiradas']?></h5>
                                <p>Total de Retiradas</p>
                            </div>
                            <div>
                                <?php
                                    $sql = "SELECT count(*) AS quantidade_doacoes FROM movimentacoes WHERE movimentacoes_tipos_movimentacoes_id=3";
                                    $result = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
                                    $dados = mysqli_fetch_assoc($result);
                                ?>
                                <h4>Doações</h5>
                                    <h5><?=$dados['quantidade_doacoes']?></h5>
                                <p>Total de Doações</p>
                        
                                <?php
                                    $sql = "SELECT count(*) AS quantidade_permutas FROM movimentacoes WHERE movimentacoes_tipos_movimentacoes_id=4";
                                    $result = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
                                    $dados = mysqli_fetch_assoc($result);
                                ?>
                                <h4>Permutas</h5>
                                    <h5><?=$dados['quantidade_permutas']?></h5>
                                <p>Total de Permutas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group_cards">
                <div class="content_cards">
                    <div class="top_cards">
                        <div class="titulo">
                            <h2 title="Tipos de relatórios que podem ser gerados">
                                <a href="index.php?menuop=listar_relatorios" id="listar">Relatórios</a>
                            </h2>
                            <span class="info">
                                <ion-icon name="help-circle-outline"></ion-icon>
                            </span>
                        </div>
                    </div>
                    <div class="cards cards_info">
                        <div class="display-flex-row just-content-spc-around" style="display: grid;">
                            <div class="relatorio">
                                <a href="pdf/relatorio_validade.php" target="_blank">Relatório de insumos prestes a expirar (mês/ano)</a>
                            </div>
                            <div class="relatorio">
                                <a href="pdf/relatorio_insumo.php" target="_blank">Relatório de insumos com estoque crítico</a>
                            </div>
                            <div class="relatorio">
                                <a href="pdf/relatorio_movimentacao.php" target="_blank">Relatório de movimentações</a>
                            </div>
                            <!-- <div class="relatorio">
                                <a href="pdf/pdf.php" target="_blank"><strong>Dispensario</strong> - Relatório de insercão e retiradas de certo insumo</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>