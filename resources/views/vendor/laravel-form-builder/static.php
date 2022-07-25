<?php if ($showLabel && $showField && !(isset($options['title']) && $options['title'])): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false && $options['label_show'] && $options['title']): ?>
    <?= $options['content'] ?>
<?php else: ?>
    <?= Html::decode(Form::label($options['content'], $options['label'])) ?>

<?php endif; ?>

<?php if ($showField): ?>
    <<?= $options['tag'] ?> <?= $options['elemAttrs'] ?>><?= e($options['value']) ?></<?= $options['tag'] ?>>

    <?php include helpBlockPath(); ?>

<?php endif; ?>


<?php if ($showLabel && $showField && (!(isset($options['title']) && $options['title']))): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
