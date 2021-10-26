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
  <div id="comments">

    <p class="titleComents">Comentarios</p>

    <div class="commentsContent">
        <?php if($comments !== []):?>
            <?php foreach($comments as $comment):?>
                <div class="commentItem">
                    <div class="headerComment">
                        <p><?= $comment['username']?> <a href="<?= BASE_URL . "/produto" . "/" . $comment['id_product'] . "/" . strtolower(str_replace("/", "-", str_replace(" ", "-", $comment['nome']))); ?>">Produto: #<?=$comment['id_product']?></a></p>
                    </div>
                    <div class="contextComment">
                        <svg class="ui-pdp-icon ui-pdp-questions__questions-list__answer-container__icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                            <path fill="#000" fill-opacity=".25" fill-rule="evenodd" d="M0 0h1v11h11v1H0z"></path>
                        </svg>
                        <div class="commentText"><?= $comment['comment']?></div>
                    </div>
                    <?php if($comment['answer'] !== ""): ?>
                    <div class="answerComment">
                        <svg class="ui-pdp-icon ui-pdp-questions__questions-list__answer-container__icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                            <path fill="#000" fill-opacity=".25" fill-rule="evenodd" d="M0 0h1v11h11v1H0z"></path>
                        </svg>
                        <div>
                        
                            <p>Resposta da administração</p>
                            <p><?= $comment['answer']?></p>
                            
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="actions">
                        <?php if($comment['answer'] !== ""): ?>
                            <i class="fas fa-edit" title="Editar resposta" data-edit="edit" data-id="<?=$comment['id_column']?>" data-answer="<?= $comment['answer']?>"></i>
                        <?php endif; ?>
                        <?php if($comment['answer'] == ""): ?>
                            <i class="fas fa-reply" title="Responder" data-aswer="answer" id="<?= $comment['id_column'] ?>"></i>
                        <?php endif; ?>
                        <i class="fas fa-trash-restore-alt" title="Remover pergunta" data-remove="remove" data-id="<?= $comment['id_column']  ?>"></i>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>

  </div>
<?php $this->end();?>
<?php $this->unshift('scrs');?>
    <script src="./../assets/js/CommentController.js"></script>
<?php $this->end();?>