<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 12.04.2018
 * Time: 00:27
 */

namespace AppBundle\Entity;


class jsmin
{

    function getNextKeyElement($javascript){
        $elements = array();
        $keyMarkers = array('\'', '"', '//', '/*');
        foreach ($keyMarkers as $marker){
            $elements[$marker] = strpos($javascript, $marker);
        }
//regex to detect all regex
        $regex = "/[\k(](\/[\k\S]+\/)/";
        preg_match($regex, $javascript, $matches, PREG_OFFSET_CAPTURE, 1);
        if (count($matches) > 0){
            $elements[$matches[1][0]] = $matches[1][1];
        }
        $elements = array_filter($elements, function($k){return $k !== false;});
        if (count($elements) == 0){return false;}
        $min = min($elements);
        return array($min, array_keys($elements, $min)[0]);
    }

    function getNonEscapedQuoteIndex($string, $char, $start = 0){
        if (preg_match('/(\\\\*)(' . preg_quote($char) . ')/', $string, $match, PREG_OFFSET_CAPTURE, $start)){
            if ($match[2][1] == 54){
            }
            if (!isset($match[1][0]) || strlen($match[1][0]) % 2 == 0){
                return $match[2][1];
            } else{
                return getNonEscapedQuoteIndex($string, $char, $match[2][1] + 1);
            }
        }
        return -1;
    }

    function minifyJavascriptCode($javascript){
        $blocks = array('for', 'while', 'if', 'else');
        $javascript = preg_replace('/([-\+])\s+\+([^\s;]*)/', '$1 (+$2)', $javascript);
// remove new line in statements
        $javascript = preg_replace('/\s+\|\|\s+/', ' || ', $javascript);
        $javascript = preg_replace('/\s+\&\&\s+/', ' && ', $javascript);
        $javascript = preg_replace('/\s*([=+-\/\*:?])\s*/', '$1 ', $javascript);
// handle missing brackets {}
        foreach ($blocks as $block){
            $javascript = preg_replace('/(\s*\b' . $block . '\b[^{\n]*)\n([^{\n]+)\n/i', '$1{$2}', $javascript);
        }
// handle spaces
        $javascript = preg_replace(array("/\s*\n\s*/", "/\h+/"), array("\n", " "), $javascript);
// \h+ horizontal white space
        $javascript = preg_replace(array('/([^a-z0-9\_])\h+/i', '/\h+([^a-z0-9\$\_])/i'), '$1', $javascript);
        $javascript = preg_replace('/\n?([[;{(\.+-\/\*:?&|])\n?/', '$1', $javascript);
        $javascript = preg_replace('/\n?([})\]])/', '$1', $javascript);
        $javascript = str_replace("\nelse", "else", $javascript);
        $javascript = preg_replace("/([^}])\n/", "$1;", $javascript);
        $javascript = preg_replace("/;?\n/", ";", $javascript);
        return $javascript;
    }

    function minifyJavascript($javascript){
        $buffer = '';
        while (list($idx_start, $keyElement) = $this->getNextKeyElement($javascript)){
            switch ($keyElement){
                case '//':
                    $idx_start = strpos($javascript, '//');
                    $idx_end = strpos($javascript, "\n", $idx_start);
                    if ($idx_end !== false){
                        $javascript = substr($javascript, 0, $idx_start) . substr($javascript, $idx_end);
                    } else{
                        $javascript = substr($javascript, 0, $idx_start);
                    }
                    break;
                case '/*':
                    $idx_start = strpos($javascript, '/*');
                    $idx_end = strpos($javascript, '*/', $idx_start)+2;
                    $javascript = substr($javascript, 0, $idx_start) . substr($javascript, $idx_end);
                    break;
                default: // must be handle like string case
                    $idx_start = $this->getNonEscapedQuoteIndex($javascript, $keyElement);
                    if (strlen($keyElement) == 1){
// quote!  Either ' or "
                        if (substr($javascript, $idx_start, 1) == '\''){
                            $idx_end = $this->getNonEscapedQuoteIndex($javascript, '\'', $idx_start+1)+1;
                        } else{
                            $idx_end = $this->getNonEscapedQuoteIndex($javascript, '"', $idx_start+1) +1;
                        }
                    } else{
// regex!
                        $idx_end = $idx_start + strlen($keyElement);
                    }
                    $buffer .= $this->minifyJavascriptCode(substr($javascript, 0, $idx_start));
                    $quote = substr($javascript, $idx_start, ($idx_end-$idx_start));
                    $quote = str_replace("\\\n", ' ', $quote);
                    $buffer .= $quote;
                    $javascript = substr($javascript, $idx_end);
            }
        }
        $buffer .= $this->minifyJavascriptCode($javascript);
        return $buffer;
    }
}
