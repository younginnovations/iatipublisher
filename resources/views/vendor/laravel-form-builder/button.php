<?php if ($options['wrapper'] !== false) : ?>
<div <?= $options['wrapperAttrs'] ?>>
    <?php endif; ?>

    <?php if (isset($options['attr']['icon']) && $options['attr']['icon']): ?>
        <?= Form::button("<span class='mr-1.5 text-lg'>" . file_get_contents(resource_path('assets/images/svg/add-more.svg')) . "</span>" . $options['label'], $options['attr']) ?>
    <?php else : ?>
        <?= Form::button($options['label'], $options['attr']) ?>
    <?php endif; ?>

    <?php include helpBlockPath(); ?>

    <?php if ($options['wrapper'] !== false) : ?>
</div>
<?php endif; ?>
