<?php

namespace App\Services;

class Recaptcha
{
  private $isEnabled;
  public function __construct()
  {
    $this->isEnabled = env('RECAPTCHA_ENABLE');
  }

  public function getValidationString()
  {
    if ($this->isEnabled) return 'required|captcha';
    return '';
  }
}

?>
