<?php if ($options['wrapper'] !== false) : ?>
    <div <?= $options['wrapperAttrs'] ?>>
    <?php endif; ?>

        <?= Form::button("<span class='mr-1'>".file_get_contents(resource_path('assets/images/svg/add-more.svg'))."</span>".$options['label'], $options['attr']) ?>

        <?php include helpBlockPath(); ?>

        <?php if ($options['wrapper'] !== false) : ?>
        </div>
    <?php endif; ?>
