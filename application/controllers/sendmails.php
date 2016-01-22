<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sendmails extends CI_Controller {
    /*
     * This mail for vericifation of the mail id
     */

    public function send_email  ($reciever_mail_id, $reciever_name, $subject_body, $mail_body) {
        $this->load->model('mailer');
        $response = $this->mailer->sendMail(array(
            'to' => array(
                'email' => $reciever_mail_id,
                'name' =>  $reciever_name
            ),
            'subject' => $subject_body,
            'body' => $mail_body
        ));
    }

}
