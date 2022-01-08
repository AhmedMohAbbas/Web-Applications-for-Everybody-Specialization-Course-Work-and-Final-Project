<h1>Hello to my first php</h1>
<p>
    <?php
        echo "Hi There <br>";
        $x = 6 * 7;
        echo "The answer is ".$x." As expected <br>";
        echo 15 . 20;
    ?>
</p>
<p>
    <?php
        $stuff = array("Hi","There");
        echo $stuff[0],"<br>";
        $otherStuff = array('name' => "chuck", "Course" => "PHP" );
        echo $otherStuff["name"]."<br>";
        echo "<pre> <br>";
        print_r($otherStuff);
        echo "<br> </pre> <br>";
        $otherStuff["price"] = 125;
        echo "<pre> <br>";
        var_dump($otherStuff);
        echo "<br> </pre> <br>";
        foreach ($otherStuff as $y => $z) {
            echo "key is: ".$y.", Value = ".$z.'<br>';
        }
        foreach ($stuff as $y => $z) { // OR you can just loop through it normally using for(i; i<sfs ;i++)
            echo "Position ".$y.", Value = ".$z.'<br>';
        }
        echo $stuff[2] ?? "Nothing !!!<br>";
        echo $stuff[1] ?? "Nothing !!!<br>";
        $xaxstuff = array('course' => 'PHP-Intro', 'topic' => 'Arrays');
        echo isset($xaxstuff['section']);
        echo shuffle($stuff)."<br>";
        ////////////////////////////////////
        function greet(){
            print "Hello";
        }
        greet();
    ?>
</p>

<p>So...</p>
