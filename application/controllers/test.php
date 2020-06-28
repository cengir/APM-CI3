 <?php defined('BASEPATH') OR exit('No direct script access allowed');  
 class Email extends CI_Controller {  
  public function send()  
  {  
   $config = Array(  
    'protocol' => 'smtp',  
    'smtp_host' => 'ssl://smtp.googlemail.com',  
    'smtp_port' => 465,  
    'smtp_user' => 'email_kamu@gmail.com',   
    'smtp_pass' => 'password_email_kamu',   
    'mailtype' => 'html',   
    'charset' => 'iso-8859-1'  
   );  
   $this->load->library('email', $config);  
   $this->email->set_newline("\r\n");  
   $this->email->from('recodeku@gmail.com', 'Admin Re:Code');   
   $this->email->to('email_kamu@gmail.com');   
   $this->email->subject('Percobaan email');   
   $this->email->message('Ini adalah email percobaan untuk Tutorial CodeIgniter: Mengirim Email via Gmail SMTP menggunakan Email Library CodeIgniter @ recodeku.blogspot.com');  
   if (!$this->email->send()) {  
    show_error($this->email->print_debugger());   
   }else{  
    echo 'Success to send email';   
   }  
  }  
 }  