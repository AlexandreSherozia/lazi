<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 27/05/2019
 * Time: 11:15
 */

namespace App\Service\Twig;


use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{
    public const NB_OF_CHARACTERS = 20;

    /**
     * @return array|\Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig_Filter('shorten_text', [$this, 'textFilter']),
        ];
    }

    public function textFilter(string $text)
    {
        $string = strip_tags($text);

        if (\strlen($string) > self::NB_OF_CHARACTERS) {

            $stringCut = substr($string, 0, self::NB_OF_CHARACTERS);

            $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '[. . .]';
        }

        # On retourne l'accroche
        return $string;
    }
}