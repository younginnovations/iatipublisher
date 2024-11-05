<?php use Illuminate\Support\Arr;

if ($showLabel && $showField): ?>

    <?php if (isset($options['options']['dynamic_wrapper'])): ?>
        <div
            class="<?= strtolower($options['label']) === "narrative" ? $options['options']['dynamic_wrapper']['class'] . ' narrative' : $options['options']['dynamic_wrapper']['class'] ?> ">
        <?php endif; ?>

        <?php if (!isset($options['options']['dynamic_wrapper']) && $options['wrapper']): ?>
            <div <?= $options['wrapperAttrs'] ?>>
            <?php endif; ?>

        <?php endif; ?>

        <?php if ($showLabel && $options['label'] !== false && $options['label_show'] && strtolower($options['label']) !== "narrative"): ?>
            <?php
            $label              = $options['options']['data']['label'] ?? $options['label'];
            $labelAnchor        = $label;
            $labelAnchor        = str_replace(' ', '_', str_replace('-', '_', $labelAnchor));
            $help_text          = !empty($options['options']['help_text'])
                                     ? getHelpTextDom($label, $options['options']['help_text'])
                                     : '';
            $hover_text         = !empty($options['options']['hover_text'])
                                     ? getHoverTextDom($label, $options['options']['hover_text'])
                                     : '';
            $helper_text        = !empty($options['options']['helper_text'])
                                     ? getHelperTextDom($options['options']['helper_text'])
                                     : '';
            $collapsable_button = Arr::get($options,'options.is_collapsable')
                                     ? getCollapsableButtonDom()
                                     : '';
            $label_indicator    = Arr::get($options,'options.label_indicator');

            $label = str_replace('_', ' ', $label);
            $label = str_replace('-', ' ', $label);
            $label = ucwords($label);
            $error = '';
            $errorSection = '';

            if(isset($options['options']['info_text']) && !empty($options['options']['info_text']))
            {
                $error = '<div class="text-danger-info">' . $options['options']['info_text'] . '</div>';
                $errorSection = '<section class="collection_error">' . $error . '</section>';
            }

            if(isset($options['options']['warning_info_text']) && !empty($options['options']['warning_info_text']))
            {
                $errorSection = '<div class="mt-2 flex items-center bg-eggshell pt-2 pr-4 pb-2 pl-4 text-xs rounded-md font-normal">
                                    <svg-vue icon="exclamation-warning" class="mr-2 w-2/100"></svg-vue>
                                    <div class="text-crimson-50">'.$options['options']['warning_info_text'].'</div>
                                </div>';
            }

            if ($showError && isset($errors) && $errors->hasBag($errorBag)) {
                foreach ($errors->getBag($errorBag)->get($nameKey) as $err) {
                    if(!empty($err))
                    {
                        $error = '<div class="text-danger-error">' . $err . '</div>';
                    }
                }
                $errorSection = '<section class="collection_error">' . $error . '</section>';
            }

            $collectionLabel = '
                <div class="w-full">
                    <div class="title-container w-full">
                        <div class="flex justify-between items-center w-full">
                            <div class="flex space-x-2 items-center" id="' . $labelAnchor . '">
                                <span class="pr-1">' . $label . '</span>'.
                                ($label_indicator === 'required_icon' ? '<span class="required-icon px-1">*</span>' : '') . '
                                ' . $help_text . '
                                ' . $hover_text .
                                ($label_indicator === 'optional_text' ? getOptionalTextDom() : '') . '
                            </div>
                            ' . $collapsable_button . '
                        </div>
                        ' . $errorSection . '
                    </div>
                    ' . $helper_text . '
                </div>';
            ?>


            <?php if (isset($options['options']['element_criteria']) && $options['options']['element_criteria'] === 'mandatory'): ?>
                <?= htmlspecialchars_decode(Form::customLabel($name, $collectionLabel, $options['label_attr'])) ?>
            <?php elseif (isset($options['options']['element_criteria']) && $options['options']['element_criteria'] === 'recommended'): ?>
                <?= htmlspecialchars_decode(Form::customLabel($name, $collectionLabel, $options['label_attr'])) ?>
            <?php else: ?>
                <?= htmlspecialchars_decode(Form::customLabel($name, $collectionLabel, $options['label_attr'])) ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($showField): ?>
            <?php foreach ((array) $options['children'] as $child): ?>
                <?= $child->render() ?>
            <?php endforeach; ?>

            <?php include helpBlockPath(); ?>
        <?php endif; ?>

        <?php if (strtolower($options['label']) === "narrative"): ?>
            <section class="collection_error">
                <?php include errorBlockPath(); ?>
            </section>
        <?php endif; ?>
        <?php if ($showLabel && $showField): ?>
            <?php if ($options['wrapper'] !== false): ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>
