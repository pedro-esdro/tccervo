<?php
    session_start();
    // Trazendo a conexão com o banco de dados
    include_once './db.php'; 
    include_once './mail.php';

    // Recebendo os dados do formulário de cadastro
    $nome = $_POST['nome'];
    $curso = $_POST['curso'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    $csenha = md5($_POST['csenha']);
    $cargo = 'usuario';
    $statusVerificacao = '0';

    // Id de cada curso do select
    $idCursos = array(
        "Informática para Internet" => 1,
        "Administração" => 2,
        "Contabilidade" => 3,
        "Recursos Humanos" => 4,
        "Enfermagem" => 5,
        "Desenvolvimento de Sistemas" => 6,
        "Segurança do Trabalho" => 7
    );

    // Verificando se todos os campos do formulário foram preenchidos
    if (!empty($nome) && !empty($email) && !empty($curso) && !empty($senha) && !empty($csenha))
    {
        // Atribuindo o id do curso;
        $idCurso = $idCursos[$curso];

        // Validando o email
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            // Verificando se o email já existe
            $sqlCheckEmail = mysqli_query($conexao, "SELECT emailUsuario FROM tbUsuario WHERE emailUsuario = '{$email}'");
            if(mysqli_num_rows($sqlCheckEmail) > 0)
            {
                echo "$email - Esse email já existe em nosso sistema.";

            }
            // Se o email não existir no sistema, verifica se a confirmação de senha corresponde com a senha inserida
            else
            {
                if (strlen($_POST['senha']) >= 8)
                {
                    if ($senha == $csenha)
                    {
                        // Criando id de usuário e código de verificação
                        $idUsuario = rand(1000000, 9999999);
                        $codUsuario = mt_rand(1111, 9999);

                        //Inserção dos dados
                        $sqlInsert = mysqli_query($conexao, "INSERT INTO tbUsuario(idUsuario, nomeUsuario, emailUsuario,  senhaUsuario, codUsuario, verificacaoUsuario, cargoUsuario) VALUES({$idUsuario}, '{$nome}', '{$email}', '{$senha}', '{$codUsuario}', '{$statusVerificacao}', '{$cargo}');");

                        $sqlInsertCurso = mysqli_query($conexao, "INSERT INTO tbUsuario_tbCurso(idCurso, idUsuario) VALUES ({$idCurso}, {$idUsuario});");

                        // Se obtiver sucesso, busca o registro e envia o email de verificação
                        if($sqlInsert && $sqlInsertCurso)
                        {
                            $sqlSelectByEmail = mysqli_query($conexao, "SELECT * FROM tbUsuario WHERE emailUsuario = '{$email}';");
                            if(mysqli_num_rows($sqlSelectByEmail) > 0)
                            {
                                $row = mysqli_fetch_assoc($sqlSelectByEmail);
                                $_SESSION['idUsuario'] = $row['idUsuario'];
                                $_SESSION['emailUsuario'] = $row['emailUsuario'];
                                $_SESSION['codUsuario'] = $row['codUsuario'];

                                // Enviando email de confirmação. Método sendEmail construido no arquivo mail.php

                                if ($codUsuario)
                                {
                                    if(sendEmail($nome, $email, $codUsuario))
                                    {
                                        echo "success";
                                    }
                                    else
                                    {
                                        echo "Problema no envio do email!";
                                    }
                                }
                                else
                                {
                                    echo "Problema ao enviar o código. Tente novamente";
                                }


                            }
                        }
                        else
                        {
                            echo "Alguma coisa deu errado!";
                        }
                    }
                    else
                    {
                        echo "As senhas inseridas não estão iguais.";
                    }
                }
                else {
                    echo "A senha deve conter 8 ou mais caracteres";
                }
            }
        }
        else
        {
            echo "$email - Esse email não é válido.";
        }
    }
    else
    {
        echo "É necessário preencher todas as informações";
    }
?>