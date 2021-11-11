<?php
require_once "textblock.php";
require_once "profanity_spell_check.php";

$clean = new NoProfanity(); //var is new class

if (isset($_POST['btnSubmit'])) { //is button clicked?

    $textblock = $_POST['string_pass'];
    // $censored = $clean->ProfanitySeeker($textblock);
    $statistics = $clean->profanityIndicator($textblock);
    $censored = $clean->ProfanitySeeker($textblock);
    $UppercaseMyText = $clean->Uppercaser($textblock);
} else {
    $statistics = $clean->profanityIndicator($textblock);
    $censored = $clean->ProfanitySeeker($textblock);
    $UppercaseMyText = $clean->Uppercaser($textblock);
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
      <h1>Profanity eraser and Caps Corrector</h1>
      <p>
          This is a php code function to check any given random text for profanies,
          and replace said profane words for positive words.<br>
          This might alter the implied result of a sentence, since the "positive"
          words are not matched to any bad words.<br>
      </p>

<h2>How does it work?</h2>
<ol>
    <li>Copy and paste your text in the field below.*</li>
    <li>Click "Check" or press enter.</li>
    <li>See the result.</li>
</ol>
<h5>* = It comes with a default text block</h5>


      <!-- textblock halen we hier -->
    <form class="" action="#" method="post">
        <input type="text" name="string_pass">
        <input type="submit" name="btnSubmit" value="Check">
    </form>


    <h1> <!-- Profanity Indicator -->
        This text has <?php echo $statistics[0]["profanityLevel"];?> profanity.
</h1>
<h2>
    Here follows a preview of your text, capped at 1000 characters. 
    <br>But we used a little mouthwash to clean this text if it had profanity in it.
</h2>

<!-- gewassen text -->
<p>
<?php echo substr($UppercaseMyText, 0, 1000) . " ... </i>";?> 
</p>

<!-- hier volgen statistieken -->
<h2>Statistics</h2>
<ul>
    <li>There are <?php echo $statistics[2]["totalWords"];?> words in this text</li>
    <li>There is <?php echo $statistics[3]["percentagedProfanity"];?>% profanity in this text</li>
    <li>That means this text had <?php echo $statistics[0]["profanityLevel"];?> profanity</li>
    <li>There are <?php echo $statistics[1]["totalProfanities"];?> profanities replaced in this text</li>
    <li>There are <?php echo $statistics[5]["Uppercaser"] ?> lowercases corrected to Uppercases</li>
    <li>Enjoy reading a cleaned text</li> 
</ul>

<!-- hier volgt de blacklist -->
<h2>Blacklisted Words &#9760</h2>
<p>The following list of profanity was cleansed:</p>

<ol>
<?php 

$j = count($statistics[4]["blacklist"]);
$statistics[4]["blacklist"] = array_reverse(
    $statistics[4]["blacklist"], false
);
for ($i = 0; $i < $j; $i++) :
    foreach ($statistics[4]["blacklist"][$i] as $profanity => $counter) : ?>
    
      <li><?php echo $profanity . ", " . $counter . " times.";?></li>
        <?php 
    endforeach; 
endfor;?>
    </ol>

<pre>
    <?php //echo var_dump($statistics); ?>
</pre>


<hr>
<!-- hier volgt de huiswerkopdracht -->
<h1>Schrijf een programma met de volgende functionaliteiten:</h1>
<p>

<ol>
<li><del>Grove woorden uit willekeurige teksten vervangen voor willekeurige (random) aardige woorden.</del></li>
<li><del>Zinnen automatisch corrigeert op hoofdletters.</del></li>
<li><del>Tonen van de de gecorrigeerde tekst.</del></li>
<li><del>De tekst die getoond wordt mag niet langer zijn dan een voorgedefinieerd aantal tekens en worden afgebroken met "..."</del></li>
<li><del>Tonen van de grofheid van de tekst met een indicator.</del></li>
<li>Tonen van statistieken: 
<ul>    
<li><del>1. Aantal woorden, </del></li>
<li><del>2. Aantal vervangen woorden,</del> </li>
<li><del>3. Aantal gecorrigeerde hoofdletters.</del> </li>
<li><del>4. Percentage vervangen woorden.</del> </li>
<li><del>5. Het aantal keer dat een grof woord voorkomt.</del></li>
</ul>
</ol>
Zorg voor herbruikbaarheid van de code door functies te maken die een enkele taakuitvoeren.<br>
<del>Maak gebruik van het require statement om jouw functies binnen te halen.<br></del>
Maak zoveel mogelijk gebruik van ingebouwde php functies (zie php.net) om je doel te bereiken.<br>
Test de output van jouw programma op de correcte werking door de functies verschillende teksten en parameters mee te geven.<br>
</p>
<hr>

<!-- gewassen text -->
<h2>Here is your complete washed text:</h2>
<p>
<?php echo $UppercaseMyText;?> 
</p>

</body>
</html>