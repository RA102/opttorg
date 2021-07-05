<?php

class LoadPriceByEmail
{
    protected $email = '{mail.santehopttorg.kz:143/novalidate-cert}';
    protected $login = 'admin@santehopttorg.kz';
    protected $password = '3C1t5F3s';

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     *
     * {imap.server.ru:993/imap/ssl}INBOX
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function openImap()
    {
        try {
            $connect = imap_open($this->email, $this->login, $this->password);
        } catch (Exception $e) {
            return imap_errors();
        }
        return $connect;
    }

    public function fetchLetters($imap, $flag = 'NEW')
    {
        return imap_search($imap, $flag);
    }

    public function getLetterToId($imap, $id): array
    {
        $letter['header'] = imap_header($imap, $id);
        $letter['body'] = imap_body($imap, $id);

        return $letter;
    }

    public function fetchStructureLetters($imap, $messageNum)
    {
        return imap_fetchstructure($imap, $messageNum);
    }

    public function closeConnection($imap): bool
    {
        return imap_close($imap);
    }

    public function recursiveSearch($structure)
    {
        $encoding = '';

        if ($structure->subtype == 'HTML' || $structure->type == 0) {
            if ($structure->parameters[0]->attribute == 'charset') {
                $charset = $structure->parameters[0]->value;
            }
            return [
                'encoding' => $structure->encoding,
                'charset' => strtolower($charset),
                'subtype' => $structure->subtype
            ];
        } else {
            if (isset($structure->parts[0])) {
                return $this->recursiveSearch($structure->parts[0]);
            } else {
                if ($structure->parameters[0]->attribute == 'charset') {
                    $charset = $structure->parameters[0]->value;
                }
                return [
                    'encoding' => $structure->encoding,
                    'charset' => strtolower($charset),
                    'subtype' => $structure->subtype
                ];
            }
        }
    }

    public function getImapTitle($str){

        $mime = imap_mime_header_decode($str);

        $title = "";
        $encoding = mb_detect_encoding($mime->text);
        foreach($mime as $key => $m){
            if(!$this->checkUtf8($m->charset)) {
                $title .= $this->convertToUtf8($encoding, $m->text);
            } else {
                $title .= $m->text;
            }

        }
        return $title;
    }


    public function checkUtf8($charset)
    {

        if(strtolower($charset) != "utf-8") {

            return false;
        }

        return true;
    }

    public function convertToUtf8($in_charset, $str)
    {
        return iconv(strtolower($in_charset), "utf-8", $str);
    }


    function structureEncoding($encoding, $msg_body){

        switch((int)$encoding){

            case 4:
                $body = imap_qprint($msg_body);
                break;

            case 3:
                $body = imap_base64($msg_body);
                break;

            case 2:
                $body = imap_binary($msg_body);
                break;

            case 1:
                $body = imap_8bit($msg_body);
                break;

            case 0:
                $body = $msg_body;
                break;

            default:
                $body = "";
                break;
        }

        return $body;
    }

}