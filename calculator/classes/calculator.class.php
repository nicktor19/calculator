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
        //post
        $this->calculatorPost();
        //form
        $this->calculatorForm();
    }

    /**
     * Will display results and help validate the operation.
     * @return void 
     */
    protected function calculatorPost() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
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
                    $this->save_result = $this->first_num / $this->second_num;
                    return;
                case "^":
                    $this->save_result = $this->first_num ** $this->second_num;
                    return;
                case "%":
                    $this->save_result = $this->first_num % $this->second_num;
                    return;
                default:
                    echo "The operator entered is invalid.";
                    return;
            }
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
}