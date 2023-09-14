<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require './lib/vendor/autoload.php';

    function getCodRec(){
        if ($_SESSION["codUsuarioRec"] == false)
            return false;
        else
            return true;
    }
    

    function sendEmail($nome, $email, $cod)
    {
        $mail = new PHPMailer(true);
        try 
        {
            // Configurações de servidor e host
            $mail->SMTPDebug = SMTP::DEBUG_OFF;      
            $mail->CharSet = "UTF-8";            
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'pehen092@gmail.com';                     
            $mail->Password   = 'gage wqxs xyix ccxi';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
            $mail->Port       = 465;

            // Remetente e destinatário
            $mail->setFrom('pehen092@gmail.com', 'TCCervo');
            $mail->addAddress($email, $nome);

            // Conteúdo
            $mail->isHTML(true);
            if(getCodRec())
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

?>