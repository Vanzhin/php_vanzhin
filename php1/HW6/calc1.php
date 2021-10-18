<?php
include_once 'function.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$operation = $_POST['operation'];
$arg1 = (float) $_POST['arg1'];
$arg2 = (float) $_POST['arg2'];
$result = $operation($arg1, $arg2);
}
?>
<form action="" method="post">
    <input type="text" name="arg1" value="<?=$arg1?>">
    <select name="operation" id="">
        <option value="add" <?php if($operation == 'add') echo 'selected';?>>+</option>
        <option value="subtraction" <?php if($operation == 'subtraction') echo 'selected';?>>-</option>
        <option value="multiply" <?php if($operation == 'multiply') echo 'selected';?>>*</option>
        <option value="division" <?php if($operation == 'division') echo 'selected';?>>/</option>
    </select>
    <input type="text" name="arg2" value="<?=$arg2?>">
    <input type="submit" value="=">
    <input type="text" name="result" value="<?=$result?>" readonly>

</form>
