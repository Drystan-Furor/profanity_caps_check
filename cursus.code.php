<?php

/**
 * Tristan Arts
 * Huiswerk Opdracht 2 Back-End Development 
 *  Profanity Filter & Caps checker 
 */


str_word_count($textblock); //0 = amount of words, 1 =words are array, 2 = array (key => word)

//first count my text
$howManyWordsInText = str_word_count($textblock);

//also an array of the text with key => each_word
$textAsArray = str_word_count($textblock, 2);



    /**
     * A function using a text file as its dictionary. so instead of putting the badwords into an array 
     *  you can add the words in the text file separating each word with a new line
     **/
function Get_a_load_of_this()
{
    $profanity = file('blacklist.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); //php function Reads entire file into an array
    return $profanity; //result is an array
}

    /**
     * Now a function for nice, positive words, opposite of profanity, for str_replace
     */
function Mouthwash()// repalce profanity with these positive words later on
{
    $modesty = file('whitelist.txt', FILE_IGNORE_NEW_LINES| FILE_SKIP_EMPTY_LINES);
    return $modesty;
}
// so, we have 2 files as dictionaries now.
// presumably this cleanes my text:
$textblockCleaned = str_replace($profanity, $modesty, $textblock);
echo $textblockCleaned;

foreach ($textAsArray as $wordForWord) {
      //Replace the characters "world" in the string "Hello world!" with "Peter":
    
    // search BAD word, replace with NICE word, in THIS text
}