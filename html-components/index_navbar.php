<script>
    var idUsuario = "<?php echo isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : ''; ?>";
</script>
<style>
    @media screen and (max-width: 1200px) {
        nav{height: 12vh;}
    }
</style>
<input type="checkbox" id="check">
<nav>
    <div class="logo">
        <a href="index.php">
            <img class="logo64" src="assets\logo\logo64h.svg" alt="logo do site">TCCERVO
        </a>
    </div>
    <ul class="nav-list">
        <li><a href="index.php">Início</a></li>
        <li id="publicar"><a href="postar-tcc.php">Publicar</a></li>
        <li id="entrar"><a href="login.php">Entrar</a></li>
        <li><a href="sobre.php">Sobre</a></li>
        <li class="dropdown">
            <div class="div"><i class="fa-solid fa-user fa-lg"></i> <i class="fa-solid fa-caret-down"></i></div>
            <ul class="dropdown-content">
            <li class="meuperfil"><a href="perfil.php?idBusc=<?php echo "$idUsuario" ?? ""?>">Meu perfil</a></li>
                <li class="meutcc"><a href="postar-tcc.php">Meu TCC</a></li>
                <li><a href="php/logout.php?logout_id=<?php echo $idUsuario;?>">Sair</a></li>
            </ul>
        </li>
    </ul>
    <label for="check" class="bar">
        <span class="fa fa-bars" id=bars></span>
        <span class="fa fa-times" id="times"></span>
    </label>    
</nav>
<script src="https://kit.fontawesome.com/cbdcf7d21d.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     $(document).ready(function(){
        $('#entrar').show();
        $('#publicar').hide();
        if(idUsuario != "")
        {
            $('#entrar').hide();
            $('#publicar').show();
        }
     })
</script>
     