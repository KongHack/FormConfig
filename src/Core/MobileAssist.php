<?php
namespace GCWorld\FormConfig\Core;

class MobileAssist
{
    /**
     * Parses the HTML into JS, Namespaces, and pure HTML.
     *
     * @param string $html
     *
     * @return array
     */
    public static function parseHTML(string $html)
    {
        $js               = [];
        $namespaces       = [];
        $matches          = [];
        $jqNamespaceRegex = "/\\$\(.*?\)\.on\('(.+?)'/";
        $scriptRegex      = '/<script.*?>([\s\S]*?)<\/script>/';

        \preg_match_all($jqNamespaceRegex, $html, $matches);
        for ($i = 0; $i < \count($matches[1]); ++$i) {
            $str = $matches[1][$i];
            $ns  = !\strpos($str, '.') ? $str : \strstr($str, '.', false);
            if (!\in_array($ns, $namespaces)) {
                $namespaces[] = $ns;
            }
        }

        \preg_match_all($scriptRegex, $html, $matches);
        for ($i = 0; $i < \count($matches[0]); ++$i) {
            $js[] = $matches[1][$i];
            $html = \str_replace($matches[0][$i], '', $html);
        }

        return [
            'js'         => $js,
            'namespaces' => $namespaces,
            'html'       => $html,
        ];
    }
}