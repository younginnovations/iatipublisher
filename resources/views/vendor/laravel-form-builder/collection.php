<?php if ($showLabel && $showField) : ?>
    <?php if (isset($options['options']['dynamic_wrapper'])) : ?>
        <div class="<?= strtolower($options['label']) === "narrative" ? $options['options']['dynamic_wrapper']['class'] . ' narrative' : $options['options']['dynamic_wrapper']['class'] ?> ">
        <?php endif; ?>
        <?php if (!isset($options['options']['dynamic_wrapper']) && $options['wrapper']) : ?>
            <div <?= $options['wrapperAttrs'] ?>>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($showLabel && $options['label'] !== false && $options['label_show'] && strtolower($options['label']) !== "narrative") : ?>
            <?php
            $label = $options['options']['data']['label'] ?? $options['label'];
            $help_text = $options['options']['help_text'] !== '' ? '<div>
                            <p class="help-button text-xs text-n-40 hover:text-spring-50 font-normal ml-1.5 cursor-pointer inline-block">Help</p>
                            <div class="help-button-content hidden">
                                <p class="font-bold text-bluecoral">
                                    ' . $label . '
                                </p>
                                <div class="space-y-1.5">
                                ' . $options['options']['help_text'] . '
                                </div>
                            </div>
                        </div>' : '';
            $hover_text = $options['options']['hover_text'] !== '' ? '<div class="help ml-1.5 font-normal"><svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 14" class="text-sm">
                        <path d="M7.385 4.667a1.1 1.1 0 0 0-.518.128c-.16.085-.295.209-.39.362l-.004.006-.003.007a.346.346 0 0 1-.093.105.438.438 0 0 1-.455.033.37.37 0 0 1-.113-.093.313.313 0 0 1-.06-.117.287.287 0 0 1-.005-.124l-.329-.058.329.058a.305.305 0 0 1 .049-.12l.004-.005.004-.006a1.75 1.75 0 0 1 .663-.615 1.92 1.92 0 0 1 2.092.176c.324.256.537.605.607.985.07.378-.005.77-.215 1.105-.211.337-.546.6-.952.737l-.227.076v.36a.31.31 0 0 1-.104.227.414.414 0 0 1-.28.106c-.11 0-.21-.04-.281-.106A.31.31 0 0 1 7 7.667V7a.31.31 0 0 1 .104-.227.414.414 0 0 1 .28-.106c.272 0 .536-.1.735-.285a.977.977 0 0 0 .317-.715.977.977 0 0 0-.317-.716 1.08 1.08 0 0 0-.734-.284Zm0 0V5v-.333Zm-.369 4.906.012-.021.009-.023a.16.16 0 0 1 .02-.037.736.736 0 0 1 .05-.06.391.391 0 0 1 .122-.074.433.433 0 0 1 .311 0l.12-.31-.12.31a.39.39 0 0 1 .127.079c.034.032.06.07.077.108a.3.3 0 0 1 .025.12v.015a.29.29 0 0 1-.02.118.263.263 0 0 1-.067.098l.227.244-.227-.244a.321.321 0 0 1-.116.068l-.01.003-.01.005a.386.386 0 0 1-.293 0l-.01-.005-.01-.003a.321.321 0 0 1-.117-.068l-.227.244.227-.244a.263.263 0 0 1-.067-.097l-.006-.015-.007-.015a.193.193 0 0 1-.022-.093V9.64a.51.51 0 0 1-.002-.057.078.078 0 0 1 .004-.01ZM3.572 1.74A7.245 7.245 0 0 1 7.385.667c.902 0 1.795.165 2.627.485.833.32 1.588.789 2.222 1.378a6.323 6.323 0 0 1 1.48 2.055c.341.766.517 1.587.517 2.415a6 6 0 0 1-1.147 3.51 6.76 6.76 0 0 1-3.072 2.338 7.362 7.362 0 0 1-3.968.363 7.033 7.033 0 0 1-3.51-1.741A6.201 6.201 0 0 1 .67 8.23a5.892 5.892 0 0 1 .387-3.645A6.467 6.467 0 0 1 3.572 1.74Zm.446 9.978a6.39 6.39 0 0 0 3.367.949c1.604 0 3.146-.592 4.288-1.652C12.815 9.955 13.46 8.511 13.46 7a5.4 5.4 0 0 0-1.03-3.158 6.007 6.007 0 0 0-2.729-2.08 6.488 6.488 0 0 0-3.498-.32 6.226 6.226 0 0 0-3.108 1.542 5.56 5.56 0 0 0-1.67 2.906 5.314 5.314 0 0 0 .348 3.287 5.773 5.773 0 0 0 2.244 2.54Z" fill="#68797E" stroke="#68797E" stroke-width=".667"></path>
                    </svg>
                    <div class="right-0 help__text w-72">
                        <p class="text-bluecoral mb-2 italic">IATI standard reference</p>
                        <span class="font-bold text-bluecoral">' . $label . '</span>
                        <p>' . $options['options']['hover_text'] . '</p>
                    </div>
                </div>' : '';
            $label = strtolower(str_replace(' ', '-', $options['label']));
            ?>
            <?php if (isset($options['options']['element_criteria']) && $options['options']['element_criteria'] === 'mandatory') : ?>
                <?= htmlspecialchars_decode(Form::customLabel($name,  '<svg-vue icon="star" class="mr-2"></svg-vue>' . $label . $help_text . $hover_text, $options['label_attr'])) ?>
            <?php elseif (isset($options['options']['element_criteria']) && $options['options']['element_criteria'] === 'recommended') : ?>
                <?= htmlspecialchars_decode(Form::customLabel($name, '<svg-vue icon="moon" class="mr-2"></svg-vue>' . $label . $help_text . $hover_text, $options['label_attr'])) ?>
            <?php else : ?>
                <?= htmlspecialchars_decode(Form::customLabel($name, $label . $help_text . $hover_text, $options['label_attr'])) ?>
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
