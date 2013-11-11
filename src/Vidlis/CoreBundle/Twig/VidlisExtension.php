<?php

namespace Vidlis\CoreBundle\Twig;

class VidlisExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'makeClickable' => new \Twig_Filter_Method($this, 'makeClickable', array('is_safe' => array('html'))),
            'isFloat' => new \Twig_Filter_Method($this, 'isFloat'),
        );
    }

    public function makeClickable($text)
    {
        return preg_replace('@(?<![.*">])\b(?:(?:https?|ftp|file)://|[a-z]\.)[-A-Z0-9+&#/%=~_|$?!:,.]*[A-Z0-9+&#/%=~_|$]@i', '<a href="\0" target="_blank">\0</a>', $text);
    }

    public function isFloat($number)
    {
        return is_float($number);
    }

    public function getName()
    {
        return 'vidlis_extension';
    }
}