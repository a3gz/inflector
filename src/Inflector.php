<?php 
/**
 * Inflector
 *
 * @link      https://github.com/a3gz/inflector
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   http://www.roetal.com/license/mit (MIT License)
 */
namespace A3gZ\Inflector;

class Inflector 
{

    /**
     * Camelize a text formed by words separated by spaces and/or underscores
     * @param string $text The text to camelize
     * @return string The camelized string
     */
    public static function toCamel($text)
    {
        return str_replace(" ", "", ucwords(str_replace(array("_", "-"), " ", $text)));
    } // toCamel

    /**
     * Camelbacks a text formed by words separated by spaces and/or underscores
     * @param string $text The text to camelback
     * @return string The camelbacked string
     */
    public static function toCamelBack($text)
    {
        $camel = Inflector::toCamel($text);
        return strtolower(substr($camel, 0, 1)) . substr($camel, 1);
    } // toCamelBack
    
    /**
     * Converts a camelized word into underscore separated words
     * @param string $text The text to convert into underscore separated words
     * @return string The converted string
     */
    public static function camelToUnderscore($text)
    {
        $s = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $text));		
		if (substr($s, -1) == "_") $s = substr($s, 0, -1);
		
		return $s;
    }	// camelToUnderscore()

    /**
     * Converts an underscored text into human readable text
     * @param string $text The text to convert into humanized words
     * @return string The converted string
     */
    public static function underscoreToHuman($text)
    {
		return ucwords(str_replace("_", " ", $text));
    } // underscoreToHuman
	

    /**
     * Converts a camelized word into human readable text
     * @param string $text The text to convert 
     * @return string The converted string
     */
    public static function camelToHuman($text)
    {
		return Inflector::underscoreToHuman(Inflector::camelToUnderscore($text));
    }	// camelToHuman()
	
    /**
     * Converts a camelized word into dash separated words
     * @param string $text The text to convert into dash separated words
     * @return string The converted string
     */
    public static function dashify($text)
    {
        $s = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '-\\1', $text));		
		if (substr($s, -1) == "-") $s = substr($s, 0, -1);
		return $s;
    } // dashify()
	
	/***
	 * Converts a word into its plural form
	 */
	public static function pluralize($word)
	{
		if (has_filter("inflector_pluralize")) 
        {
			if ($newWord = apply_filter("inflector_pluralize", $word)) 
            {
				return $newWord;
			}
		}
		
		if (strtolower(substr($word, -1)) == "y") 
        {
			return substr($word, 0, -1) . "ies";
		} 
        elseif (strtolower(substr($word, -2)) == "ss") 
        {
			return $word . "es";
		} 
        else 
        {
			return $word . "s";
		}
	} // pluralize()
	
    /**
     * Converts a text into a slug
     * @param string $text The text to convert to slug
     * @return string The slug
     *
     * This function is a modified version of CakePHP's Inflector::slug() function.
     * CakePHP(tm) :    Rapid Development Framework (http://www.cakephp.org)
     * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
     *
     * Licensed under The MIT License
     */
    public static function slug($text, $separator = '-')
    {
		$map = array(
			"/à|á|å|â/" => "a",
			"/è|é|ê|\?|ë/" => "e",
			"/ì|í|î/" => "i",
			"/ò|ó|ô|ø/" => "o",
			"/ù|ú|u|û/" => "u",
			"/ç/" => "c",
			"/ñ/" => "n",
			"/ä|æ/" => "ae",
			"/ö/" => "oe",
			"/ü/" => "ue",
			"/Ä/" => "Ae",
			"/Ü/" => "Ue",
			"/Ö/" => "Oe",
			"/ß/" => "ss",
			"/[^\w\s]/" => " ",
			"/\\s+/" => $separator
		);
		return strtolower( preg_replace(array_keys($map), array_values($map), $text) );
    } // slug()
	
	/***
	 *
	 */
	public static function feedEncode($string, $trans='') {
		$trans = (is_array($trans)) ? $trans : get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
		foreach ($trans as $k=>$v)
        {
			$trans[$k]= "&#".ord($k).";";
        }
		return strtr($string, $trans);
	} // feedEncode()

} // Inflector

 // EOF 