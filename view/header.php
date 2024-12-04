<header class="bg-color p-3">
    <div class="container d-flex justify-content-between gap-2">
        <div>
            <img src="../img/planeadicto-logo.svg" class="img-fluid" alt="planeadicto logo" style="height: 65px">
        </div>

        <div class="d-flex gap-2 align-items-center">
            <div>
                <p class="text-white fw-bold mb-0">Hola, <?php echo ($_SESSION['userName']); ?> </p>
            </div>
            
            <div class="btn btn-secondary" id="logout">
                <a href="../controller/sessiondestroy_controller.php" class="text-white fw-bold">Cerrar sesión</a>
            </div>
        </div>

    </div>
</header>