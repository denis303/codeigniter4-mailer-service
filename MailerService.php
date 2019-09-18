<?php

namespace denis303\codeigniter4;

use App\Models\User;
use App\Models\UserModel;

class MailerService
{

    public $fromName;

    public $fromEmail;

    public function getUserToEmail($user)
    {
        $model = new UserModel;

        return $model->getUserEmail($user);
    }

    public function getUserToName($user)
    {
        $model = new UserModel;

        return $model->getUserName($user);
    }

    public function sendToUser(User $user, string $subject, string $message, & $error = null)
    {
        $email = Services::email();

        $email->setFrom($this->fromEmail, $this->fromName);

        $email->initialize(['mailType' => 'html']);
        
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