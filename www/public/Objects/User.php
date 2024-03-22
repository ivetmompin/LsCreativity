<?php

namespace Ivet\Ac1\Objects;
class User
{
    public string $email;
    public string $password;

    private bool $loggedIn;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->loggedIn = true;
    }


}