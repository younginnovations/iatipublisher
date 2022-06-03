<?php if ($options['wrapper'] !== false) : ?>
    <div <?= $options['wrapperAttrs'] ?>>
<?php endif; ?>

    <?php if ( $name == 'add_to_collection' || $name== 'add_more' ): ?>
        <?= Form::button("<span class='mr-1'>".file_get_contents(resource_path('assets/images/svg/add-more.svg'))."</span>".$options['label'], $options['attr']) ?>
    <?php endif; ?>

    <?php if ( $name !== 'add_to_collection' ): ?>
        <?= Form::button($options['label'], $options['attr']) ?>
    <?php endif; ?>

    <?php include helpBlockPath(); ?>

<?php if ($options['wrapper'] !== false) : ?>
    </div>
<?php endif; ?>
