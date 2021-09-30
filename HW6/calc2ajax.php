<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<div style="display: flex;">
    <form action="#" method="post" style="display:flex">
        <input id="arg1" type="text" name="arg1" value="">
        <select name="operation" id="op_select">
            <option value="add">+</option>
            <option value="subtraction">-</option>
            <option value="multiply">*</option>
            <option value="division">/</option>
        </select>
        <input id="arg2" type="text" name="arg2" value="">
        <input type="submit" value="=" disabled>
        <input id="result" type="text" name="result"  readonly>
    </form>
    <button id="start">Посчитать</button>
</div>

<script>
    window.onload = function () {
        document.getElementById('start').onclick = function () {
            const arg1 = document.getElementById('arg1').value;
            const arg2 = document.getElementById('arg2').value;
            const operation = document.querySelector('#op_select').value;
            (async () => {
                const response = await fetch('post.php', {
                    method: 'POST',
                    headers: new Headers({
                        'Content-Type': 'application/json'
                    }),
                    body: JSON.stringify({
                        arg1: arg1,
                        arg2: arg2,
                        operation: operation
                    }), // body data type must match "Content-Type" header
                });
                const answer = await response.json();
                console.log(answer);
                document.getElementById('result').value = answer['result']
            })();
        }
    }
</script>
</body>
</html>