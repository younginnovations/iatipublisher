<?php if ($showLabel && $showField): ?>

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
                    <div class="left-0 help__text w-72">
                        <p class="text-bluecoral mb-2 italic">IATI standard reference</p>
                        <span class="font-bold text-bluecoral">' . $label . '</span>
                        <p>' . $options['options']['hover_text'] . '</p>
                    </div>
                </div>' : '';
            $label = strtolower(str_replace(' ', '-', $options['label']));
            $error = '';
            $errorSection = '';



            if(isset($options['options']['info_text']) && !empty($options['options']['info_text']))
            {
                $error = '<div class="text-danger-error">' . $options['options']['info_text'] . '</div>';
                $errorSection = '<section class="collection_error">' . $error . '</section>';
            }


            if(isset($options['options']['warning_info_text']) && !empty($options['options']['warning_info_text']))
            {
                $errorSection = '<div class="mt-2 flex items-center bg-eggshell pt-2 pr-4 pb-2 pl-4 text-xs rounded-md font-normal">
                                    <svg
                                        class="elements-svg"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 18 18"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M8.99935 4.79533C8.77834 4.79533 8.56638 4.88313 8.4101 5.03941C8.25382 5.19569 8.16602 5.40765 8.16602 5.62866V8.962C8.16602 9.18301 8.25382 9.39497 8.4101 9.55125C8.56638 9.70753 8.77834 9.79533 8.99935 9.79533C9.22037 9.79533 9.43233 9.70753 9.58861 9.55125C9.74489 9.39497 9.83269 9.18301 9.83269 8.962V5.62866C9.83269 5.40765 9.74489 5.19569 9.58861 5.03941C9.43233 4.88313 9.22037 4.79533 8.99935 4.79533ZM9.76602 11.9787C9.74778 11.9256 9.72256 11.8751 9.69102 11.8287L9.59102 11.7037C9.47383 11.588 9.32502 11.5097 9.16336 11.4786C9.00171 11.4474 8.83444 11.4648 8.68269 11.5287C8.5817 11.5709 8.48869 11.6301 8.40769 11.7037C8.33045 11.7815 8.26935 11.8739 8.22788 11.9754C8.18641 12.0769 8.16539 12.1857 8.16602 12.2953C8.16734 12.4042 8.18999 12.5118 8.23269 12.612C8.27011 12.7154 8.32982 12.8093 8.40759 12.8871C8.48536 12.9649 8.57927 13.0246 8.68269 13.062C8.78244 13.1061 8.89029 13.1289 8.99935 13.1289C9.10841 13.1289 9.21627 13.1061 9.31602 13.062C9.41943 13.0246 9.51335 12.9649 9.59111 12.8871C9.66888 12.8093 9.72859 12.7154 9.76602 12.612C9.80872 12.5118 9.83137 12.4042 9.83269 12.2953C9.83678 12.2398 9.83678 12.1841 9.83269 12.1287C9.81834 12.0755 9.79585 12.0249 9.76602 11.9787ZM8.99935 0.628662C7.35118 0.628662 5.74001 1.1174 4.3696 2.03308C2.99919 2.94876 1.93109 4.25025 1.30036 5.77297C0.669626 7.29568 0.504599 8.97124 0.826142 10.5877C1.14769 12.2043 1.94136 13.6891 3.1068 14.8546C4.27223 16.02 5.75709 16.8137 7.3736 17.1352C8.99011 17.4568 10.6657 17.2917 12.1884 16.661C13.7111 16.0303 15.0126 14.9622 15.9283 13.5917C16.8439 12.2213 17.3327 10.6102 17.3327 8.962C17.3327 7.86765 17.1171 6.78401 16.6983 5.77297C16.2796 4.76192 15.6657 3.84326 14.8919 3.06944C14.1181 2.29562 13.1994 1.68179 12.1884 1.263C11.1773 0.84421 10.0937 0.628662 8.99935 0.628662ZM8.99935 15.6287C7.68081 15.6287 6.39188 15.2377 5.29555 14.5051C4.19922 13.7726 3.34474 12.7314 2.84016 11.5132C2.33557 10.295 2.20355 8.9546 2.46078 7.66139C2.71802 6.36819 3.35296 5.1803 4.28531 4.24795C5.21766 3.3156 6.40554 2.68066 7.69875 2.42343C8.99196 2.16619 10.3324 2.29821 11.5506 2.8028C12.7687 3.30738 13.8099 4.16187 14.5425 5.25819C15.275 6.35452 15.666 7.64345 15.666 8.962C15.666 10.7301 14.9636 12.4258 13.7134 13.676C12.4632 14.9263 10.7675 15.6287 8.99935 15.6287Z"
                                            fill="#F4B784"
                                        />
                                    </svg>
                                    <div>'.$options['options']['warning_info_text'].'</div>
                                </div>';
            }

            if ($showError && isset($errors) && $errors->hasBag($errorBag)) {
                foreach ($errors->getBag($errorBag)->get($nameKey) as $err) {
                    if($err !== "")
                    {
                        $error .= '<div class="text-danger-error">' . $err . '</div>';
                    }
                }
                $errorSection = '<section class="collection_error">' . $error . '</section>';
            }


            $collectionLabel = '<div class="title-container w-full" > <div class="flex justify-between items-center w-full" >' .
                $label .
                '<div class="flex items-center">' .
                $help_text . $hover_text .
                '</div>' .
                '</div>' . $errorSection. '</div>';
            ?>

            <?php if (isset($options['options']['element_criteria']) && $options['options']['element_criteria'] === 'mandatory'): ?>
                <?= htmlspecialchars_decode(Form::customLabel($name, '<svg-vue icon="core" class="mr-2"></svg-vue>' . $collectionLabel, $options['label_attr'])) ?>
            <?php elseif (isset($options['options']['element_criteria']) && $options['options']['element_criteria'] === 'recommended'): ?>
                <?= htmlspecialchars_decode(Form::customLabel($name, '<svg-vue icon="core" class="mr-2"></svg-vue>' . $collectionLabel, $options['label_attr'])) ?>
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
            <section class="collection_error ml-2">
                <?php include errorBlockPath(); ?>
            </section>
        <?php endif; ?>
        <?php if ($showLabel && $showField): ?>
            <?php if ($options['wrapper'] !== false): ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>
