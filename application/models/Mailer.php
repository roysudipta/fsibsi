<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class Mailer extends CI_Model {

    protected $_mandrill = null;

    public function __construct() {
        parent::__construct();

        require APPPATH . '/third_party/mandrill/Mandrill.php';

        $this->_mandrill = new Mandrill('0PdovjdFdBzIA26S8bMM8g');
    }

    public function sendMail($params = array()) {
        if (empty($params['to']) || empty($params['subject']) || empty($params['body']))
        {
            return json_encode(array('success' => false, 'message' => 'INVALID ARGUMENTS SUPPLIED!'));
        }
        
        if (!isset($params['from']['email']) || empty($params['from']['email']))
        {
            $params['from'] = array(
                'email' => 'info@deltainc.net.in', 
                'name' => 'Delta Inc'
            );
        }
        
        if (!isset($params['replyTo']) || empty($params['replyTo']))
        {
            $params['replyTo'] = 'info@deltainc.net.in';
        }
        
        $message = array(
            'html' => $params['body'],
            'text' => strip_tags($params['body']),
            'subject' => $params['subject'],
            'from_email' => $params['from']['email'],
            'from_name' => $params['from']['name'],
            'to' => array(
                array(
                    'email' => $params['to']['email'],
                    'name' => $params['to']['name'],
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => $params['replyTo']),
            'track_opens' => isset($params['track_opens']) && $params['track_opens'] ? true : false,
            'track_clicks' => isset($params['track_clicks']) && $params['track_clicks'] ? true : false,
        );
        
        if (isset($params['cc']) && is_array($params['cc']))
        {
            foreach ($params['cc'] as $cc)
            {
                if (!empty($cc['email']) && !empty($cc['name']))
                {
                    $message['to'][] = array(
                        'email' => $cc['email'],
                        'name' => $cc['name'],
                        'type' => 'cc'
                    );
                }
            }
        }
        
        if (isset($params['bcc']) && is_array($params['bcc']))
        {
            foreach ($params['bcc'] as $bcc)
            {
                if (!empty($bcc['email']) && !empty($bcc['name']))
                {
                    $message['to'][] = array(
                        'email' => $bcc['email'],
                        'name' => $bcc['name'],
                        'type' => 'bcc'
                    );
                }
            }
        }
       
        $result = $this->_mandrill->messages->send($message);
        
        if (isset($params['debug']))
        {
            echo '<pre>';
            var_dump($result);
            echo '</pre>';
        }
        
        return $result;
    }

}
