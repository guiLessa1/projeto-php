<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
if (isset($this->dados['form'])) {
    $valorForm = $this->dados['form'];
}

if (isset($this->dados['form'][0])) {
    $valorForm = $this->dados['form'][0];
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar a Senha do Usuário</h2>
            </div>
            <?php
            if (!empty($valorForm)) {
                extract($valorForm);
                ?>
                <div class="p-2">
                    <span class="d-none d-lg-block">
                        <a href="<?php echo URLADM; ?>list-users/index" class="btn btn-outline-info btn-sm">Listar</a>
                        <a href="<?php echo URLADM . 'view-users/index/' . $id; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
                        <a href="<?php echo URLADM . 'edit-users/index/' . $id; ?>" class="btn btn-outline-warning btn-sm">Editar</a>
                        <a href="<?php echo URLADM . 'delete-users/index/' . $id; ?>" class="btn btn-outline-danger btn-sm" data-confirm="Excluir">Apagar</a> 
                    </span>
                    <div class="dropdown d-block d-lg-none">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                            <a class="dropdown-item" href="<?php echo URLADM; ?>list-users/index">Listar</a>
                            <a class="dropdown-item" href="<?php echo URLADM . 'view-users/index/' . $id; ?>">Visualizar</a>
                            <a class="dropdown-item" href="<?php echo URLADM . 'edit-users/index/' . $id; ?>">Editar</a>
                            <a class="dropdown-item" href="<?php echo URLADM . 'delete-users/index/' . $id; ?>" data-confirm="Excluir">Apagar</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr class="hr-title">

        <span class="msg"></span>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form id="update_password" method="POST" action="">
            <input name="id" type="hidden" id="id" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-group">
                <label for="password"><span class="text-danger">*</span> Senha:</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Digite a senha"  value="<?php
                if (isset($valorForm['password'])) {
                    echo $valorForm['password'];
                }
                ?>" onkeyup="passwordStrength()" required autofocus>
            </div>
            
            <span id="msgViewStrength"></span>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input name="EditUserPass" type="submit" class="btn btn-outline-warning btn-sm" value="Salvar"> 

        </form>
    </div>
</div>

