<header class="col-12 d-flex flex-wrap align-items-center text-center sticky-top z-1">
  <?php
  if (isset($_SESSION["user"])) {
    $username = htmlspecialchars($_SESSION["user"]["nombre"] ?? "Usuario");

    $htmlsesion = <<<HTML
            <div class="col-4 p-3 d-flex flex-wrap align-items-center ">
                <i class="col-1 bi bi-person-circle mx-3" style="font-size: 30px"></i>
                <div class="me-3">
                    <strong>Bienvenido, {$username}</strong>
                </div>
                <button onclick="window.location.href = '../controller/cerrarSesion.php'" type="button" class="btn btn-primary">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-door-open-fill"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"
                        ></path>
                    </svg>
                    Logout
                </button>
            </div>
    HTML;
    echo $htmlsesion;
  } else {
    $htmlnosesion = <<<HTML
            <div class="col-4 p-3 d-flex flex-wrap align-items-center sticky-top z-1">
                <button onclick="window.location.href = 'login.php'" type="button" class="btn btn-primary m-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-door-open-fill"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"
                        ></path>
                    </svg>
                    Iniciar Sesión
                </button>
                <button onclick="window.location.href = 'registro.php'" type="button" class="btn btn-primary">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-door-open-fill"
                        viewBox="0 0 16 16"
                    >
                        <path
                            d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"
                        ></path>
                    </svg>
                    Registrarse
                </button>
            </div>
    HTML;
    echo $htmlnosesion;
  }
  ?>
  <div class="col-4 p-3 text-center">
    <form class="d-flex" role="search">
      <input
        class="form-control me-2"
        type="search"
        placeholder="Producto..."
        aria-label="Search" />
      <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>
  </div>
  <div class="col-4 p-3 text-center">
    <a href="detalles_carrito.php" type="button" class="btn btn-primary position-relative">
      <i class="bi bi-bag-fill"></i>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        <?php
        if (isset($_SESSION["carrito"])) {
          echo sizeof($_SESSION["carrito"]);
        } else {
          echo "0";
        }
        ?>
        <span class="visually-hidden">unread messages</span>
      </span>
    </a>
  </div>
</header>