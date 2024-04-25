<?php
include('../verificar-autenticidade.php');
include('../conexao_pdo.php');

if (empty($_GET["ref"])) {
    $pk_servico = "";
    $servico = "";
    $cpf = "";
    $nome = "";
    $data_os = "";
    $data_inicio = "";
    $data_fim = "";
} else {
    $pk_servico = base64_decode(trim($_GET["ref"]));

    $sql = "
    SELECT * FROM servicos
    WHERE pk_servico = :pk_servico
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pk_servico', $pk_servico);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $dado = $stmt->fetch(PDO::FETCH_OBJ);
        $servico = $dado->SERVICO;
        $cpf = $dado->CPF;
        $nome = $dado->NOME;
        $data_os = $dado->DATA_OS;
        $data_inicio = $dado->DATA_INICIO;
        $data_fim = $dado->DATA_FIM;
    } else {
        $_SESSION["tipo"] = 'error';
        $_SESSION["title"] = 'OPS!';
        $_SESSION["msg"] = 'Registro não encontrado';

        header("location: ./");
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ordem de Serviço | Serviços</title>

    <!-- Seus links de estilo aqui -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../dist/plugins/fontawesome-free/css/all.min.css">
    <!-- Boostrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../dist/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- iCheck -->
    <link rel="stylesheet" href="../dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../dist/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../dist/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("../nav.php") ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("../aside.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content mt-3">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col">
                            <form method="post" action="salvar.php">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Lista de O.S</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="pk_servico" class="form-label">Cód</label>
                                                <input readonly type="text" name="pk_ordem_servico" id="pk_servico" class="form-control" value="<?php echo $pk_ordem_servico ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <label for="cpf" class="form-label">CPF</label>
                                                <input required type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $cpf ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="nome" class="form-label">Nome</label>
                                                <input required type="text" name="nome" id="nome" class="form-control" value="<?php echo $nome ?>">
                                            </div>
                                            <div class="col">
                                                <label for="data_os" class="form-label">Data da OS</label>
                                                <input required type="date" name="data_os" id="data_os" class="form-control" value="<?php echo $data_os ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col">
                                                <label for="data_inicio" class="form-label">Data de Início</label>
                                                <input required type="date" name="data_inicio" id="data_inicio" class="form-control" value="<?php echo $data_inicio ?>">
                                            </div>
                                            <div class="col">
                                                <label for="data_fim" class="form-label">Data de Término</label>
                                                <input required type="date" name="data_fim" id="data_fim" class="form-control" value="<?php echo $data_fim ?>">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Título
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>servicos</th>
                                                                    <th>valor</th>
                                                                    <th>opções</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input required type="text" name="servico" id="nome" class="form-control" value=""</td>
                                                                    <td><input required type="text" name="valor" id="nome" class="form-control" value=""</td>
                                                                    <td><input required type="text" name="opções" id="nome" class="form-control" value=""</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer text-end">
                                        <a href="./" class="btn btn-outline-danger">
                                            Voltar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.card -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Footer -->
        <?php include("./footer.php"); ?>
        <!-- /. Footer -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Seus scripts aqui -->
    
</body>

</html>