<?php


namespace Hcode;

use Rain\Tpl;

class Mailer{

    const USERNAME ="nemezio321@gmail.com";

    const PASSWORD= "nemezio1994";

    const NAME_FROM ="Hcode Store";

    private $mail;

    public function __construct($toAddress, $toName, $subject, $tplName,$data=array()){

        $config = array(
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email",
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"         => false // set to false to improve the speed
           );

        Tpl::configure( $config );

        $tpl = new Tpl;

        foreach($data as $key => $value){
            $tpl->assign($key, $value);
        }

        $html= $tpl->draw($tplName, true);

        // Crie uma nova instância do PHPMailer
        $this-> mail = new \PHPMailer ();

        // Diga ao PHPMailer para usar SMTP
        $this->mail-> isSMTP ();

        // Habilitar depuração de SMTP
        // SMTP :: DEBUG_OFF = off (para uso em produção)
        // SMTP :: DEBUG_CLIENT = mensagens do cliente
        // SMTP :: DEBUG_SERVER = mensagens do cliente e do servidor
        $this->mail-> SMTPDebug = 0;

        $this->mail->Debugoutput = 'html';

        // Defina o nome do host do servidor de e-mail
        $this->mail-> Host = 'smtp.gmail.com';
        // Use `$ mail-> Host = gethostbyname ('smtp.gmail.com');`
        // se sua rede não suportar SMTP sobre IPv6,
        // embora isso possa causar problemas com TLS

        // Defina o número da porta SMTP:
        // - 465 para SMTP com TLS implícito, também conhecido como RFC8314 SMTPS ou
        // - 587 para SMTP + STARTTLS
        $this->mail-> Porta = 587;

        // Defina o mecanismo de criptografia a ser usado:
        // - SMTPS (TLS implícito na porta 465) ou
        // - STARTTLS (TLS explícito na porta 587)
        $this->mail-> SMTPSecure = PHPMailer :: ENCRYPTION_SMTPS;

        // Se deve usar autenticação SMTP
        $this->mail-> SMTPAuth = true;

        // Nome de usuário a ser usado para autenticação SMTP - use endereço de e-mail completo para gmail
        $this->mail-> Username = Mailer::USERNAME;
        // Senha a ser usada para autenticação SMTP
        $this->mail-> Senha = Mailer::PASSWORD;

        // Defina de quem a mensagem deve ser enviada
        // Observe que com o gmail você só pode usar o endereço da sua conta (o mesmo que `Nome de usuário`)
        // ou aliases predefinidos que você configurou em sua conta.
        // Não use endereços enviados por usuários aqui
        $this->mail-> setFrom (Mailer::USERNAME, Mailer::NAME_FROM);

        // Defina um endereço de resposta alternativo
        // Este é um bom lugar para colocar endereços enviados por usuários
        //$this->mail-> addReplyTo ('replyto@example.com ',' Primeiro Último ');

        // Defina para quem a mensagem deve ser enviada
        $this->mail-> addAddress ($toAddress, $toName);

        // Defina a linha de assunto
        $this->mail-> Subject = $subject;

        // Ler o corpo de uma mensagem HTML de um arquivo externo, converter imagens referenciadas em incorporadas,
        // converter HTML em um corpo alternativo de texto simples básico
        $this->mail-> msgHTML ($html);

        // Substitua o corpo do texto simples por um criado manualmente
        $this->mail-> AltBody = 'Este é um corpo de mensagem de texto simples';



        // Anexe um arquivo de imagem
        //$this->mail-> addAttachment ('images / phpmailer_mini.png');

        // envie a mensagem, verifique se há erros
        /*if (!$this->mail-> send ()) {
            echo 'Mailer Error:'. $this->mail-> ErrorInfo;
        } else{
            echo 'Mensagem enviada!';
            // Seção 2: IMAP
            // Remova os comentários para salvar sua mensagem na pasta 'E-mails enviados'.
            #if (save_mail ($ mail)) {
            # echo "Mensagem salva!";
            #}
        }

        // Seção 2: IMAP
        // Os comandos IMAP requerem a extensão PHP IMAP, encontrada em: https://php.net/manual/en/imap.setup.php
        // Função a ser chamada que usa as funções PHP imap _ * () para salvar mensagens: https://php.net/manual/en/book.imap.php
        // Você pode usar imap_getmailboxes ($ imapStream, '/ imap / ssl', '*') para obter uma lista de pastas ou rótulos disponíveis, isso pode
        // seja útil se você estiver tentando fazer isso funcionar em um servidor IMAP que não é do Gmail.
        function save_mail($this->mail)
        {
            // Você pode mudar o 'Correio enviado' para qualquer outra pasta ou tag
            $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Enviar e-mail';

            // Diga ao seu servidor para abrir uma conexão IMAP usando o mesmo nome de usuário e senha que você usou para SMTP
            $imapStream = imap_open ($path, $this->mail-> Username, $this->mail-> Senha);

            $result = imap_append ($imapStream, $path, $this->mail->getSentMIMEMessage());
            imap_close ($imapStream);

            return $result;
        }*/



/*end class  */
    }

    public function send(){
        return $this->mail->send();
    }
}


?>