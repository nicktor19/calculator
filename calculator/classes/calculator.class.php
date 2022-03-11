<?php

/**
 * Nicholas Torres
 * 3/7/2022
 * Basic mathematics calculator using a class and methods.
 * @package 
 */
class Calculator
{
    //properties
    protected $first_num;
    protected $second_num;
    protected $operation;
    protected $save_result;

    //methods
    public function __construct()
    {
        //create the session:
        $this->createHistory();
        //post
        $this->calculatorPost();
        //form
        $this->calculatorForm();
    }

    /**
     * Creates history Session
     * @return void 
     */
    protected function createHistory()
    {
        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = []; //create  new session['history']
        }
    }

    /**
     * Will display results and help validate the operation.
     * @return void 
     */
    protected function calculatorPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['calculate'])) {
            $this->first_num = $this->validEntry($_POST['first_num']);
            $this->second_num = $this->validEntry($_POST['second_num']);
            $this->operation = $_POST['operator'];

            switch ($this->operation) {
                case "+":
                    $this->save_result = $this->first_num + $this->second_num;
                    return;
                case "-":
                    $this->save_result = $this->first_num - $this->second_num;
                    return;
                case "*":
                    $this->save_result = $this->first_num * $this->second_num;
                    return;
                case "/":
                    // if the user enters any number other than zero for the property $this->second_num:
                    // if so, continue the calculation
                    if ($this->second_num != 0) {
                        $this->save_result = $this->first_num / $this->second_num;
                        return;
                    // if the user enters a zero at the property $this->second_num:
                    // if so, the result should be a error, because you cannot divide by zero.
                    } elseif ($this->second_num == 0) {
                        $this->save_result = "You cannot divide by zero.";
                        return;
                    }
                case "^":
                    $this->save_result = $this->first_num ** $this->second_num;
                    return;
                case "%":
                    // if the user enters any number other than zero for the property $this->second_num:
                    // if so, continue the calculation
                    if ($this->second_num != 0) {
                        $this->save_result = $this->first_num % $this->second_num;
                        return;
                    // if the user enters a zero at the property $this->second_num:
                    // if so, the result should remain modulus of $this->first_num
                    } elseif ($this->second_num == 0) {
                        $this->save_result = $this->first_num;
                        return;
                    }
                default:
                    echo "The operator entered is invalid."; // error message
                    header("refresh:2; url=calculator.php"); // refresh page after 2 seconds
                    exit;
            }
        } else {
            return;
        }
    }

    /**
     * Display the form. 
     * @return void 
     */
    protected function calculatorForm()
    {
?>
        <form action="calculator.php" method="post">
            <?php echo ($_SERVER['REQUEST_METHOD'] == "POST") ? "<label>Total = <label>" : "" ?>
            <input type="number" name="first_num" value="<?= $this->total($this->save_result) ?>" placeholder="First Number">
            <select name="operator">
                <option value="+">+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
                <option value="^">^</option>
                <option value="%">%</option>
            </select>
            <input type="number" name="second_num" value="" placeholder="Second Number">
            <label>=</label>
            <input type="submit" name="calculate" value="Calculate">
        </form>
    <?php
        $this->addHistory();
    }

    protected function total($total)
    {
        echo ($_SERVER['REQUEST_METHOD'] == "POST") ? $total : "";
    }

    /**
     * will validate if number.
     * @param mixed $num 
     * @return int|float|string 
     */
    protected function validEntry($num)
    {
        if (isset($num) and is_numeric($num)) {
            return $num;
        } else {
            return 0;
        }
    }

    protected function addHistory()
    {
        //start a session that stores the history.
        if (isset($_POST['calculate'])) { // if button pressed or refreshed add
            $h = $this->first_num . " " . $this->operation . " " . $this->second_num . " = " . $this->save_result;
            array_push($_SESSION['history'], $h);
        }
        return;
    }

    /**
     * display all calculations sumitted or refreshed.
     * @param array $array 
     * @return void 
     */
    public function displayHistory()
    {
    ?>
        <fieldset>
            <legend>History:</legend>

            <?php
            if (isset($_POST['reset'])) {
                $this->resetHistory();
                exit;
            }
            $this->writeHistory();
            ?>
            <hr>
            <form auction="calculator.php" method="POST">
                <input type="submit" name="reset" value="Reset Calculator">
            </form>
        </fieldset>
    <?php  
    }

    /**
     * Writes the History stored in the Session.
     * @return void 
     */
    protected function writeHistory()
    {
        if (sizeof($_SESSION['history']) > 0) {
            for ($i = 0; $i < sizeof($_SESSION['history']); $i++) {
                echo $i + 1 . ") <b>" . $_SESSION['history'][$i] . "</b><br>";
            }
        } else {
            echo "There isn't any Calculation History available.";
        }
        return;
    }

    /**
     * DELETES the history.
     * @return void 
     */
    protected function resetHistory()
    {
        if (isset($_POST['reset']) and $_POST['reset'] == "Reset Calculator") {
            unset($cal);
            unset($_SESSION['history']);
            session_destroy();
            echo "History Deleted";
            header("refresh:2; url=calculator.php"); // refresh page after 2 seconds
        }
    }
}
