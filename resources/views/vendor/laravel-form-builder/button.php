<?php if ($options['wrapper'] !== false) : ?>
    <div <?= $options['wrapperAttrs'] ?>>
    <?php endif; ?>

    <?php if (isset($options['attr']['icon']) && $options['attr']['icon']) : ?>
        <?= Html::decode(Form::button("<i class='mr-1.5 text-lg'></i>" . $options['label'], $options['attr'])) ?>
    <?php else : ?>
        <?= Form::button($options['label'], $options['attr']) ?>
    <?php endif; ?>

    <?php include helpBlockPath(); ?>

    <?php if ($options['wrapper'] !== false) : ?>
    </div>
<?php endif; ?>
