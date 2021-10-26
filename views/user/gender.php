<?php !session_start() && session_start(); ?>
<?php $this->layout('_simpleTheme'); ?>

<?php $this->unshift('head') ?>
<title> <?= $this->e($title) ?> </title>
<link rel="stylesheet" href="assets/css/style.css">
<?php $this->end() ?>


<?php $this->unshift('mainContent') ?>
    <div class="category-gender">
        <h1><?= $category_name ?></h1>        
    </div>

        <p class="title-apresentation">Categorias Popular</p>
    <section class="popular-categories">
    </section>
<?php $this->end();?>