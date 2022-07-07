<?php if ($options['wrapper'] !== false) : ?>
    <div <?= $options['wrapperAttrs'] ?>>
    <?php endif; ?>

    <?php if (!$options['splitted']) : ?>
        <div class="flex items-center justify-end">
        <?php endif; ?>

        <?php foreach ($options['buttons'] as $button) : ?>
            <?php if ($button['attr']['type'] === 'anchor') : ?>
                <a href="<?= $button['attr']['href']??'' ?>" class="<?= $button['attr']['class']?>"><?php echo($button['label']);?></a>
            <?php else : ?>
                <?= Form::button($button['label'], $button['attr']) ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if (!$options['splitted']) : ?>
        </div>
    <?php endif; ?>


    <?php if ($options['wrapper'] !== false) : ?>
    </div>
<?php endif; ?>
