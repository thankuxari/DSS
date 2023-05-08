<?php
    
    $cmd = "java -classpath weka.jar weka.classifiers.bayes.NaiveBayes -T new-immunotherapy.arff -l test4.model -p 0 2>&1";

    exec($cmd,$output);

    echo "<h3>Results...</h3>";
    for($i=0;$i<sizeof($output);$i++)
    {
        trim($output[$i]);
        echo($output[$i])."<br>";
    }
?>
