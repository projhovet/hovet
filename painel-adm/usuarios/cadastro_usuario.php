<div class="container">
    <div class="cadastro_body">
        <form class="form_cadastro" action="index.php?menuop=inserir_usuario" method="post">
            <div class="form-group">
                <h4>Cadastro de Usuário</h4>
            </div>
            <div class="form-group">
                <label for="nomeUsuario">Nome Completo</label>
                <input type="text" class="form-control" name="nomeUsuario" required>
            </div>
            <div class="form-group">
                <label for="mailUsuario">E-mail</label>
                <input type="email" class="form-control" name="mailUsuario" required>
            </div>
            <div class="form-group">
                <label for="tipoUsuario">Tipo de usuário</label>
                <select class="form-control-sm" name="tipoUsuario" required>
                    <?php
                    
                    $sql_allTipos = "SELECT * FROM tipo_usuario WHERE id!=5";
                    $result_allTipos = mysqli_query($conexao,$sql_allTipos) or die("Erro ao realizar a consulta. " . mysqli_error($conexao));
                    
                    while($tipoUsu = mysqli_fetch_assoc($result_allTipos)){
                    ?>
					<option><?=$tipoUsu["tipo"]?></option>

                    <?php
                        }
                    ?>
				</select>
            </div>
            <div class="form-group">
                <label for="cpfUsuario">CPF</label>
                <input type="text" class="form-control" name="cpfUsuario" required>
            </div>
            <div class="form-group">
                    <label for="senhaUsuario">Senha</label>
                    <input type="password" class="form-control" name="senhaUsuario" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Cadastrar" name="btnAdicionarUsuario">
            </div>
        </form>
    </div>
</div>