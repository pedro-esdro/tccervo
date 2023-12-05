<script>
    var idUsuario = "<?php echo isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : ''; ?>";
</script>
<input type="checkbox" id="check">
<nav>
    <div class="logo">
        <a href="index.php"><img class="logo64" src="assets\logo\logo64h.svg" alt="logo do site">TCCERVO</a>
    </div>
    <div class="search-box">
        <input type="search" name="search" id="buscatxt" placeholder="Busque aqui">
        <span  id="busca"class="fa fa-search"></span>
        <a class="adv-search" href="filtros.php">Busca avançada</a>   
    </div>
    <ul class="nav-list">
        <li class="adv-search"><a href="#">Busca avançada</a></li>
        <li><a href="index.php">Início</a></li>
        <li id="publicar"><a href="postar-tcc.php">Publicar</a></li>
        <li id="entrar"><a href="login.php">Entrar</a></li>
        <li><a href="sobre.php">Sobre</a></li>
        <li class="dropdown">
            <div class="div"><i class="fa-solid fa-user fa-lg"></i> <i class="fa-solid fa-caret-down"></i></div>
            <ul class="dropdown-content">
            <li><a class="meuperfil" href="perfil.php?idBusc=<?php echo "$idUsuario" ?? ""?>">Meu perfil</a></li>
                <li><a class="meutcc" href="postar-tcc.php">Meu TCC</a></li>
                <li><a href="php/logout.php?logout_id=<?php echo $idUsuario;?>">Sair</a></li>
            </ul>
        </li>
    </ul>
    <label for="check" class="bar">
        <span class="fa fa-bars" id=bars></span>
        <span class="fa fa-times" id="times"></span>
    </label>
</nav>
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
        $('#busca').click(function() {
                var termoBusca = $('#buscatxt').val();
                if (termoBusca !== '') {
                    window.location.href = 'buscar.php?busca=' + encodeURIComponent(termoBusca);
                }
        });
     })
</script>