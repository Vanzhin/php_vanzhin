<?php
include_once 'function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$operation = $_POST['operation'];
$arg1 = (float) $_POST['arg1'];
$arg2 = (float) $_POST['arg2'];
$result = $operation($arg1, $arg2);
}
?>
<form action="" method="post" style="display:flex">
    <input type="text" name="arg1" value="<?=$arg1?>">
    <div class="buttons" style="display:flex;">
        <button name="operation" value="add">+</button>
        <button name="operation" value="subtraction">-</button>
        <button name="operation" value="multiply">*</button>
        <button name="operation" value="division">/</button>
    </div>

    <input type="text" name="arg2" value="<?=$arg2?>">
    <input type="submit" value="=" disabled>
    <input type="text" name="result" value="<?=$result?>" readonly>

</form>
