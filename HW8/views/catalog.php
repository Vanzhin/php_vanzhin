<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Каталог</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>

</head>

<body>
<?php include "views/menu.php";?>
<div id="main">
    <div class="post_title"><h2>Каталог</h2></div>
    <div class="gallery">
        <?php foreach($dataFromProducts as $item):?>
            <div class="gallery_item">
                <a rel="gallery" class="photo" href="product_item.php?id=<?=$item['id']?>"><img alt="<?=$item['title']?>" src="gallery_img/small/<?=$item['title']?>" width="150" height="100" /></a>
                <h3><?=$item['name']?></h3>
                <h4>Цена: <?=$item['price']?></h4>
                <h4>Понравилось: <span id="<?=$item['id']?>"><?=$item['likes']?></span> покупателям</h4>
                <span class="like" data-id="<?=$item['id']?>">Мне нравится</span>
                <form action="" method="POST">
                    <button type="submit" name="buy" value="<?=$item['id']?>"><?=$buyText?></button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    const buttons = document.querySelectorAll('.like');
    buttons.forEach((elem)=>{
        elem.addEventListener('click',() =>{
            const id = elem.getAttribute('data-id');
            (
                async () =>{
                    const response = await fetch("catalog.php?action=addlike&id=" + id);
                    const answer = await response.json();
                    document.getElementById(id).innerHTML = answer.likes;
                }
            )()
        })
    });
</script>
</body>
</html>
