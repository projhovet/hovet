<div class="container">
    <div class="cadastro_body">
        <form class="form_cad astro" action="index.php?menuop=inserir_usuario" method="post">
            <div class="form-group">
                <h3>Cadastro de Usuário</h3>
            </div>
            <div class="form-group">
                <label for="nomeUsuario">Nome Completo</label>
                <input type="text" class="form-control" name="nomeUsuario">
            </div>
            <div class="form-group">
                <label for="mailUsuario">E-mail</label>
                <input type="email" class="form-control" name="mailUsuario">
            </div>
            <div class="form-group">
                <label for="tipoUsuario">Tipo de usuário</label>
                <input type="text" class="form-control" name="tipoUsuario">
            </div>
            <div class="form-group">
                <label for="cpfUsuario">CPF</label>
                <input type="text" class="form-control" name="cpfUsuario">
            </div>
            <!--<div class="form-group">
                    <label for="senhaUsuario">Senha</label>
                    <input type="password" class="form-control" name="senhaUsuario">
                </div>-->
            <div class="form-group">
                <input type="submit" value="Cadastrar" name="btnAdicionarUsuario">
            </div>
        </form>
    </div>
</div>