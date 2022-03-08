<?php 
    ob_start();
    session_start();
    // auto loader:
    require_once("includes/auto_classloader.inc.php");

    ?>
    <fieldset>
        <legend>Basic Calculator:</legend>
    <?php

    $cal = new Calculator;
?>
</fieldset>
<?php
    $cal->displayHistory();
    ob_end_flush();