<?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
<?php endif; ?>

    <?php if ( !$options['splitted'] ): ?>
        <div class="flex items-center justify-end">
    <?php endif; ?>

        <?php foreach($options['buttons'] as $button): ?>
            <?= Form::button($button['label'], $button['attr']) ?>
        <?php endforeach; ?>

    <?php if ( !$options['splitted'] ): ?>
        </div>
    <?php endif; ?>


<?php if ($options['wrapper'] !== false): ?>
    </div>
<?php endif; ?>
