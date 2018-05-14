<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Вход</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="User Profile Form A Responsive Widget,Login form widgets, Sign up Web forms , Login signup Responsive web form,Flat Pricing table,Flat Drop downs,Registration Forms,News letter Forms,Elements" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Meta tag Keywords -->
    <!-- css files -->
    <link href="/css/auth/style.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="/css/auth/font-awesome.css"> <!-- Font-Awesome-Icons-CSS -->
    <!-- //css files -->
    <!-- online-fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <!--//online-fonts -->
</head>
<body>
<div class="header">
    <h1>welcome to gistagram</h1>
</div>
<div class="w3-main">
    <div class="form-w3l">
        <div class="img">
            <img src="/images/auth/profile.jpg" alt="image">
            <h2>login here</h2>
        </div>
        <?php $form = ActiveForm::begin(); ?>
        <div class="w3l-user">
            <span><i class="fa fa-user-circle-o w3l-1" aria-hidden="true"></i></span>
            <?= $form->field($model, 'login')->textInput(['autofocus' => true, 'placeholder' => 'login'])->label(false) ?>
            <div class="clear"></div>
        </div>

        <div class="w3l-password">
            <span><i class="fa fa-lock w3l-2" aria-hidden="true"></i></span>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'password'])->label(false) ?>
            <div class="clear"></div>
        </div>
        <div class="w3l-btn">
            <input type="submit" name="button" value="sign up"/>
            <div class = 'clear'></div>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="w3l-user">
            <h4>not yet registered?</h4>
            <?= Html::a("Register", ['/auth/register']) ?> just now!
            <div class = 'clear'></div>
        </div>
    </div>
</div>



<footer>
    &copy; RIABOVA
</footer>
</body>
</html>