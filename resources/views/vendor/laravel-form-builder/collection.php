<?php if ($showLabel && $showField) : ?>
    <?php if (isset($options['options']['dynamic_wrapper'])) : ?>
        <div class="<?= strtolower($options['label']) === "narrative" ? $options['options']['dynamic_wrapper']['class'] . ' narrative' : $options['options']['dynamic_wrapper']['class'] ?> ">
        <?php endif; ?>
        <?php if (!isset($options['options']['dynamic_wrapper']) && $options['wrapper']) : ?>
            <div <?= $options['wrapperAttrs'] ?>>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($showLabel && $options['label'] !== false && $options['label_show'] && strtolower($options['label']) !== "narrative") : ?>
            <?php if (isset($options['options']['element_criteria']) && $options['options']['element_criteria'] === 'mandatory') : ?>
                <?= htmlspecialchars_decode(Form::customLabel($name, '<svg-vue icon="star" class="mr-2"></svg-vue>' . $options['label'], $options['label_attr'])) ?>
            <?php elseif (isset($options['options']['element_criteria']) && $options['options']['element_criteria'] === 'recommended') : ?>
                <?= htmlspecialchars_decode(Form::customLabel($name, '<svg-vue icon="moon" class="mr-2"></svg-vue>' . $options['label'], $options['label_attr'])) ?>
            <?php else : ?>
                <?= Form::customLabel($name,$options['label'], $options['label_attr']) ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($showField) : ?>
            <?php foreach ((array)$options['children'] as $child) : ?>
                <?= $child->render() ?>
            <?php endforeach; ?>

            <?php include helpBlockPath(); ?>

        <?php endif; ?>

        <?php include errorBlockPath(); ?>

        <?php if ($showLabel && $showField) : ?>
            <?php if ($options['wrapper'] !== false) : ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
