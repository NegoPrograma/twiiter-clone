<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twiiter Clone</title>
    <link rel="stylesheet" href="assets/css/template.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="/assets/js/main.js"></script>
</head>

<body>
    <div class="top">
        <div class="topfull">
            <div class="topleft">TWIITER</div>
            <div class="topright"><?php echo $viewData['name'] ?> - <a href="login/logout">Sair</a> </div>
            <div style="clear:both"></div>
        </div>
    </div>
    <div class="container">
        <?php $this->loadView($viewName, $viewData); ?>
    </div>

    <footer></footer>
</body>

</html>