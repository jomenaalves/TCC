<?php !session_start() && session_start(); ?>

<?php $this->layout('../_adminTheme'); ?>

<?php $this->unshift('head') ?>
    <title> <?= $this->e($title) ?> </title>
    <link rel="stylesheet" href="./../assets/css/style.css">
    <style>
        body{
            background-color: #F2F7FF;
        }
    </style>
<?php $this->end() ?>

<?php  $this->unshift('mainContent');?>

    atualizar produtos
<?php $this->end();?>
<?php $this->unshift('scrs');?>
    <script src="assets/js/AdminController.js"></script>
<?php $this->end();?>