<?php
if ($options['wrapper'] !== false) : ?>
    <div <?= $options['wrapperAttrs'] ?>>
    <?php endif; ?>

    <?php if (isset($options['attr']['icon']) && $options['attr']['icon']) : ?>
        <?= Html::decode(Form::button("<i class='mr-1.5 text-lg add-icon'></i>" . trans(lcfirst($options['label'])), $options['attr'])) ?>
    <?php else : ?>
        <?= Form::button(trans("buttons.".lcfirst($options['label'])), $options['attr']) ?>
    <?php endif; ?>

    <?php include helpBlockPath(); ?>

    <?php if ($options['wrapper'] !== false) : ?>
    </div>
<?php endif; ?>
