<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;



    function sendEmail($nome, $email, $cod)
    {
        require './lib/vendor/autoload.php';
        $mail = new PHPMailer(true);
        try 
        {
            // Configurações de servidor e host
            $mail->SMTPDebug = SMTP::DEBUG_OFF;      
            $mail->CharSet = "UTF-8";            
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'suporte.tccervo@gmail.com';                     
            $mail->Password   = 'trsd jttd idys njvq';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
            $mail->Port       = 465;

            // Remetente e destinatário
            $mail->setFrom('suporte.tccervo@gmail.com', 'TCCervo');
            $mail->addAddress($email, $nome);

            // Conteúdo
            $mail->isHTML(true);


            $codUsuarioRec = $_SESSION["codUsuarioRec"] ?? "";

            if($codUsuarioRec)
            {
                $mail->Subject = "Código de recuperação de senha - TCCervo";
                $mail->Body = "Olá, {$nome}. Seu código de recuperação de senha é: <b>{$cod}</b>";
            }
            else
            {
                $mail->Subject = "Código de verificação - TCCervo";
                $mail->Body = "Olá, {$nome}. Seu código de verificação é: <b>{$cod}</b>";
            }
            
            $mail->send();

            return true;

        }
        catch (Exception $e) 
        {
            echo "Erro: não foi possível enviar um email com o código de verificação.";
            return false;
        }
    }

    function sendEmailTccervo($nome, $email, $assunto, $mensagem)
    {
        require './php/lib/vendor/autoload.php';
        $mail = new PHPMailer(true);
        try 
        {
            // Configurações de servidor e host
            $mail->SMTPDebug = SMTP::DEBUG_OFF;      
            $mail->CharSet = "UTF-8";            
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'suporte.tccervo@gmail.com';                     
            $mail->Password   = 'trsd jttd idys njvq';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
            $mail->Port       = 465;

            // Remetente e destinatário
            $mail->setFrom($email, $nome);
            $mail->addAddress('suporte.tccervo@gmail.com', 'TCCervo');

            $mail->addCustomHeader('Reply-To', $email);

            // Conteúdo
            $mail->isHTML(true);



            $mail->Subject = $assunto;
            $mail->Body = $mensagem;
            
            $mail->send();

            return true;

        }
        catch (Exception $e) 
        {
            echo "Erro: não foi possível enviar um email";
            return false;
        }
    }

?>