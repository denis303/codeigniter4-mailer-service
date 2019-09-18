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

    public function getUserToEmail($user)
    {
        $class = static::USER_MODEL;

        $model = new $class;

        return $model->getUserEmail($user);
    }

    public function getUserToName($user)
    {
        $class = static::USER_MODEL;

        $model = new $class;
        
        return $model->getUserName($user);
    }

    public function sendToUser($user, string $subject, string $message, & $error = null)
    {
        $email = Services::email();

        $email->initialize(['mailType' => 'html']);

        $email->setFrom($this->fromEmail, $this->fromName);
        
        $email->setTo($this->getUserToEmail($user), $this->getUserToName($user));

        $email->setSubject($subject);

        $email->setMessage($message);

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
    
}