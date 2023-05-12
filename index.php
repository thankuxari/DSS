<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="avatar.png">
    <title>Ανοσοθεραπεία | Συστήματα Υποστήριξης Αποφάσεων </title>
</head>
<body>
    <main>
        <form method="post">
            Sex: <input type="number" name="sex" placeholder="Sex {1:Female 2:Male}" min="1" max="2">
            Age: <input type="number" name="age" placeholder="Age">
            Time: <input type="number" name="time" placeholder="Time">
            Number of Warts: <input type="number" name="warts" placeholder="Number of Warts">
            Type: <input type="number" name="type" placeholder="Type">
            Area: <input type="number" name="area" placeholder="Area">
            Induration diameter: <input type="number" name="induration" placeholder="Induration diameter">
            <input type="submit" name="submit">
        </form>
        <?php
        
            if(isset($_POST['submit']))
            {
                $value1 = $_POST['sex'];
                $value2 = $_POST['age'];
                $value3 = $_POST['time'];
                $value4 = $_POST['warts'];
                $value5 = $_POST['type'];
                $value6 = $_POST['area'];
                $value7 = $_POST['induration'];

                $fp = fopen('new-immunotherapy.arff','w');

                if($fp)
                {
                    $str = 
                    "@relation Immunotherapy
@attribute sex numeric
@attribute age numeric
@attribute Time numeric
@attribute Number_of_Warts numeric
@attribute Type numeric
@attribute Area numeric
@attribute induration_diameter numeric
@attribute Result_of_Treatment {0,1}
                    
@data \n".$value1.",".$value2.",".$value3.",".$value4.",".$value5.",".$value6.",".$value7.",?";
                    if(!fwrite($fp,$str)) die ("couldnt write to file.");
                }
                
                fclose($fp);
            }        
            
            $cmd = "java -classpath weka.jar weka.classifiers.bayes.NaiveBayes -T new-immunotherapy.arff -l test5.model -p 0 2>&1 > new.txt";
            
            exec($cmd,$output);
            $cmd2 = "tail -2 new.txt";
            exec($cmd2,$output2);
            echo "<h3>Results</h3>";
            for($i=0;$i<sizeof($output2);)
            {
                $words = explode(' ',$output2[$i]);
                $class = explode(':',$words[24]);
                switch($class[1])
                {
                    case 1:
                        echo "Η Ανασοθεραπεία θα είναι επιτυχής";
                        break;
                    case 0:
                        echo "Η Ανασοθεραπεία δεν θα είναι επιτυχής";
                        break;
                }
                break;
            }

            
            
        ?>
    </main>
</body>
</html>

