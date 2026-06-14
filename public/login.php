<?php
require_once "../modelos/GestionUsuarios.php";
session_start();

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["pass"]);
    $validatedEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($validatedEmail === false) {
        $message = <<<HTML
            <p style="color: red";>Email no valido</p>
        HTML;
    } else {
        $user = GestionUsuarios::verifyEmailAndPassword($validatedEmail, $password);
        if ($user) {
            $_SESSION["user"] = $user;
            header("Location: index.php");
            exit();
        } else {
            $message = <<<HTML
                <p style="color: red";>Email o contraseña incorrectos</p>
            HTML;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../styles.css" />
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <title>Registro</title>
</head>

<body class="fondo">
    <div class="position-relative vh-100">
        <div class="position-absolute top-50 start-50 translate-middle bg-crystal d-flex flex-wrap rounded-5 col-4 text-center justify-content-center ">
            <form action="" method="POST" class="d-flex flex-column gap-3">
                <div class="col-12 my-3">
                    <h1 class="text-white">Log In</h1>
                </div>
                <div class="col-12"><input class="border border-0 border-bottom bg-transparent border-info border-3" type="email" name="email" placeholder="Email..."></div>
                <div class="col-12"><input class="border border-0 border-bottom bg-transparent border-info border-3" type="password" name="pass" placeholder="Contraseña..."></div>
                <div class="col-12 text-center"><button class="btn btn-primary" type="submit">Iniciar Sesión</button></div>
                <div class="col-12 link-trans"><a class="text-white" href="index.php">Continuar sin Iniciar Sesión</a></div>
                <div class="col-12 my-3 link-trans"><a class="text-white" href="registro.php">¿Aún no tienes una cuenta? Registrate</a></div>
                <div class="col-12 text-light"><?= isset($message) ?  $message : ""  ?> </div>
            </form>
        </div>
    </div>

</body>

</html>