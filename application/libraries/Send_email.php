<?php
require_once(APPPATH . "third_party/PHPMailer/class.phpmailer.php");
require_once(APPPATH . "third_party/PHPMailer/class.smtp.php");
class Send_email extends PHPMailer
{
    public function __construct()
    {
        parent::__construct();
        $this->CI =&get_instance();
    }
    
    public function _Send($subject, $message, $from, $to) {
       
        $this->IsSMTP();
        $this->SMTPDebug = false;
        $this->SMTPAuth = true;
        $this->SMTPSecure = 'tls';
        $this->Host = "smtp.gmail.com";
        $this->Port = 587;
        $this->Username = "noreply.nextweb.vn@gmail.com";
        $this->Password = "qflsqcvygiokavxw";
        $this->CharSet = 'UTF-8';
        $this->MsgHTML($message);
        $this->Subject = $subject;
        $this->SetFrom($from, 'babyfood');
        $this->FromName = 'babyfood.com.vn';
        $this->AddReplyTo($from);
        $this->AddAddress($to);
        $this->AddAddress($from);
        $this->IsHTML(true);
        
        if($this->Send()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
} 
?>