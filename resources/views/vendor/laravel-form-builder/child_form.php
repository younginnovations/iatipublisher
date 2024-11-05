<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<!-- <?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?> -->

<?php if ($showField): ?>
    <!-- <div class ="form-field-group flex flex-wrap p-6" > -->
    <?php foreach ((array)$options['children'] as $child): ?>
        <?php if( ! in_array( $child->getRealName(), (array)$options['exclude']) ) { ?>
            <?= $child->render() ?>
        <?php } ?>
    <?php endforeach; ?>
    <!-- </div> -->

    <?php include helpBlockPath(); ?>

<?php endif; ?>

<?php include errorBlockPath(); ?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>
