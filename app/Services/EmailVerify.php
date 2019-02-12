<?php

namespace App\Services;

class EmailVerify
{
    private $isEnabled;
    public function __construct()
    {
        $this->isEnabled = env('EMAIL_VERIF_ENABLE');
    }

    public function getDate()
    {
        if ($this->isEnabled) return \Carbon\Carbon::now();
        return null;
    }
}

?>
