<?php

/**
 * Tristan Arts
 * Huiswerk Opdracht 2 Back-End Development 
 *  Profanity Filter & Caps checker & Corrector
 */

class NoProfanity
{
    /**
     * Function using a text file as its dictionary. 
     * Instead of putting the words into an array 
     *  you can add the words in the text file separating each word with a new line
     * SWAP contents of blacklist.txt for language support.
     * provide your own list of bad words or add them to blacklist.txt
     * 
     * @return array of words
     **/
    function Get_a_load_of_this() //function reads file 1300 profanities
    {
        $profanity = file('blacklist.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 
        //this php function Reads entire file into an array
        return $profanity; //result is an array
        /*
        $profanity only exists if function is called
        */
    }


    /**
     * Dictionary of positivities
     * Same effect as Get_a_load_of_this()
     * 
     * @return array of words
     */
    function Mouthwash()// function reads file 2006 positivities
    {
        $modesty = file('whitelist.txt', FILE_IGNORE_NEW_LINES| FILE_SKIP_EMPTY_LINES);
        return $modesty;
    }





    /**
     * Search and assign statistics, return as array of statistics
     * 
     * @param string $textblock = $_POST['string_pass']
     * 
     * @return array of int's and value's
     */
    function ProfanityIndicator($textblock) //pure text als string
    {
        $profanity = $this-> Get_a_load_of_this(); 
        $profanity = array_reverse($profanity, false); 
        $profanity_count = count($profanity); // INT 1300
        $howManyWordsInText = str_word_count($textblock); //100% of text
        $percentageProfanes = 0;
        $total_profanes_in_text = 0;
        $blacklist = [];
        
        for ($i = 0; $i < $profanity_count; $i++) { //get statistics
            if (strpos(strtolower($textblock), " " . $profanity[$i])) { 
                $profanes_in_text = substr_count(
                    strtolower($textblock), 
                    " " . $profanity[$i]
                ); //return INT    

                $total_profanes_in_text += $profanes_in_text; //total
                $percentageProfanes 
                    = ($total_profanes_in_text * 100) 
                    / $howManyWordsInText; // x% of 100%
                if (!array_key_exists($profanity[$i], $blacklist)) { 
                    $blacklist[] = [$profanity[$i] => $profanes_in_text]; 
                    // <-- # $i dat een grof woord voorkomt (Tonen van statistieken).                                     
                } 
            }
        }
        

        //--set profanity indicator
        $profanityLevelList = [
        0 => "no",
        1 => "a little",
        2 => "mediocore",
        3 => "heavy",
        4 => "an obscene large amount of",
        ];

        
        if ($percentageProfanes == 0) { // 0 is clean
            $profanityLevel = 0;
        } else if ($percentageProfanes <= 1) { //greater then 0 == profanity found
            $profanityLevel = 1;
        } else if ($percentageProfanes <= 5) { // up to 5%
            $profanityLevel = 2;
        } else if ($percentageProfanes <= 10) { // up to 10 %
            $profanityLevel = 3;
        } else {
            $profanityLevel = 4; // >10% == over 9000 
        }


        // uppercase correction counter
        $Uppercase_Before = preg_match_all("/[A-Z]/", $textblock, $Uppercase_Before);
        $cap = true;
        $corrected = '';
        $strlen = strlen($textblock);
        for ($i = 0; $i < $strlen; $i++) {
            $letter = substr($textblock, $i, 1);
            if ($letter == "." 
                || $letter == "!" 
                || $letter == "?") {
                $cap = true;
            } elseif ($letter != " " && $cap == true) {
                $letter = strtoupper($letter);
                $cap = false;
            } 
            $corrected .= $letter;
        }
        $Uppercase_After = preg_match_all("/[A-Z]/", $corrected, $Uppercase_After);
        $capsConversion = $Uppercase_After - $Uppercase_Before;

        // pass all data into array
        $statistics = [
        ['profanityLevel' => $profanityLevelList[$profanityLevel]], //profanity level
        ['totalProfanities' => $total_profanes_in_text], // profanes total
        ['totalWords' => $howManyWordsInText], // text length
        ['percentagedProfanity' => number_format($percentageProfanes, 1)], // % 
        ['blacklist' => $blacklist],
        ['Uppercaser' => $capsConversion], // number of lowercase to uppercase    
        ];

        //return all data as array
        //because a function can pass only one return
        return $statistics;
    } 
    

    
    /**
     * Search profane words from array[profanity] in text
     * search BAD word, replace with NICE word, in THIS text
     * 
     * @param string $textblock = $_POST['string_pass']
     * 
     * @return string with profanities replaced
     */
    function ProfanitySeeker($textblock) //pure text als string
    {
        $profanity = $this-> Get_a_load_of_this(); 
        $profanity = array_reverse($profanity, false); 
        //we flip the alphabetical order to find [whore] before w[hore], 
        //also all ASS+somthing becomes ***something if not reversed
        $modesty = $this-> Mouthwash(); 


        $profanity_count = count($profanity); // INT
        for ($i = 0; $i < $profanity_count; $i++) {
            if (strpos(strtolower($textblock), " " . $profanity[$i])) { 
                //IF in String["haystack"], find Needle[$i] "a profanity"
                // walk trough array Profanity, check vs lowercased string
                //strtolower = string zonder hoofdletters, want hoofdlettergevoelig
                //strpos = position of the first occurrence of needle in the string.

                $clean_textblock = str_ireplace(
                    $profanity[$i], str_repeat('*', 1), $textblock
                ); 
                //replace profanity with *

                $modest_textblock = str_ireplace(
                    '*', "<i>" . str_repeat(
                        $modesty[mt_rand(1, 2005)]
                        . "</i>", 1
                    ), $clean_textblock
                ); //replace * with modest[random]

                $textblock = $modest_textblock; 
                //replace OLD string with NEW string where curse is censored
            } 
        }
            return $textblock; //untouched IF !profanity
    } 

    // if strpos($textblock, $punctuationMark . $letter) {



    /**
     * Sentence case php
     *
     * Met dank aan Klaas_m
     * https://stackoverflow.com/questions/8238314/php-sentence-case-function
     */
    function UpperCaser($textblock)     
    {
        $textblock = $this-> ProfanitySeeker($textblock);
        
        $cap = true;
        $corrected = '';

        for ($i = 0; $i < strlen($textblock); $i++) {
            $letter = substr($textblock, $i, 1);
            if ($letter == "." || $letter == "!" || $letter == "?") {
                $cap = true;
            } elseif ($letter != " " && $cap == true) {
                $letter = strtoupper($letter);
                $cap = false;
            } 
            $corrected .= $letter;
        }
        $textblock = $corrected;
        return $textblock;
    }
} //end class