<?php

namespace Vidlis\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VidlisUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
