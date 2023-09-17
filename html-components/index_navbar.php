<input type="checkbox" id="check">
<nav>
    <div class="icon">
        <a href="index.php">
            <img class="logo64" src="assets\logo\logo64h.svg" alt="logo do site">
            <img class="logo48" src="assets\logo\logo48h.svg" alt="logo do site">
            TCCERVO
        </a>
    </div>
    <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="login.php">Entrar</a></li>
        <li><a href="sobre.php">Sobre</a></li>
        <li class="dropdown">
            <a><i class="fa-solid fa-user fa-lg"></i></a>
            <ul class="dropdown-menu">
                <li><a href="perfil.php">Meu perfil</a></li>
                <li><a href="">Meu TCC</a></li>
                <li><a href="php/logout.php?logout_id=<?php echo $idUsuario;?>">Sair</a></li>
            </ul>
        </li>
    </ul>
    <label for="check" class="bar">
        <span class="fa fa-bars" id=bars></span>
        <span class="fa fa-times" id="times"></span>
    </label>
</nav>