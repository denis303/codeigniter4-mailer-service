<?php

namespace denis303\codeigniter4;

use Config\Services;
use App\Models\UserModel;

class MailerService
{

    const USER_MODEL = UserModel::class;

    protected $fromName;

    protected $fromEmail;

    public function __construct($fromEmail, $fromName)
    {
        $this->fromEmail = $fromEmail;

        $this->fromName = $fromName;
    }

    public function getUserEmail($user)
    {
        $class = static::USER_MODEL;

        $model = new $class;

        return $model->getUserEmail($user);
    }

    public function getUserName($user)
    {
        $class = static::USER_MODEL;

        $model = new $class;
        
        return $model->getUserName($user);
    }

    protected function _send(object $email, array $options = [], &$error = null)
    {
        $return = $email->send();

        if (!$return)
        {
            if (CI_DEBUG)
            {
                $error = $email->printDebugger([]); 
            }
            else
            {
                $error = 'There was an error sending your message.';
            }
        }

        return $return;
    }

    public function sendToUser($user, string $subject, string $message, array $options = [], &$error = null)
    {
        $email = Services::email();

        $email->initialize(['mailType' => 'html']);

        $email->setFrom($this->fromEmail, $this->fromName);
        
        $email->setTo($this->getUserEmail($user), $this->getUserName($user));

        $email->setSubject($subject);

        $email->setMessage($message);

        return $this->_send($email, $options, $error);
    }
    
}