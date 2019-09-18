# CodeIgniter 4 Mailer Service

## Configuration file (App\Config\Mailer.php)

```
<?php

namespace Config;

class Mailer extends \CodeIgniter\Config\BaseConfig;
{

    public $fromEmail;

    public $fromName;

}
```

## Mailer service config (App\Config\Services.php)

```
public static function mailer($getShared = true)
{
    if ($getShared)
    {
        return static::getSharedInstance('mailer');
    }

    $mailerConfig = config(Mailer::class);

    return new \denis303\codeigniter4\MailerService($mailerConfig->fromEmail, $mailerConfig->fromName);
}
```

## Usage

```
$user = \App\Models\UserModel::find(1);

$mailer = service('mailer');

$is_send = $mailer->sendToUser($user, 'subject text', 'message text', $error);

if (!$is_send)
{
    throw new Exception($error);
}
```