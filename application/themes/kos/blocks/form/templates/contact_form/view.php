<?php
defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Block\Form\MiniSurvey;
use Concrete\Core\Support\Facade\Application;

$app = Application::getFacadeApplication();

$survey = $controller;
$miniSurvey = new MiniSurvey($b);
$miniSurvey->frontEndMode = true;

$bID = (int) $bID;
$qsID = (int) ($survey->questionSetId);
$formAction = $view->action('submit_form') . '#formblock' . $bID;

if (!function_exists('contactFormTemplateAddClass')) {
    function contactFormTemplateAddClass(DOMElement $element, string $className): void
    {
        $currentClasses = preg_split('/\s+/', trim((string) $element->getAttribute('class'))) ?: [];
        if (!in_array($className, $currentClasses, true)) {
            $currentClasses[] = $className;
            $element->setAttribute('class', trim(implode(' ', array_filter($currentClasses))));
        }
    }
}

if (!function_exists('contactFormTemplateInnerHtml')) {
    function contactFormTemplateInnerHtml(DOMNode $node): string
    {
        $html = '';
        foreach ($node->childNodes as $childNode) {
            $html .= $node->ownerDocument->saveHTML($childNode);
        }

        return $html;
    }
}

if (!function_exists('contactFormTemplateGuessAutocomplete')) {
    function contactFormTemplateGuessAutocomplete(array $question): string
    {
        $prompt = strtolower(trim((string) ($question['question'] ?? '')));
        $type = strtolower(trim((string) ($question['type'] ?? '')));

        if (strpos($prompt, 'email') !== false || $type === 'email') {
            return 'email';
        }

        if (strpos($prompt, 'full name') !== false || preg_match('/\bname\b/', $prompt)) {
            return 'name';
        }

        if (strpos($prompt, 'company') !== false || strpos($prompt, 'organization') !== false) {
            return 'organization';
        }

        if (strpos($prompt, 'telephone') !== false || strpos($prompt, 'phone') !== false || strpos($prompt, 'mobile') !== false) {
            return 'tel';
        }

        if (strpos($prompt, 'website') !== false || strpos($prompt, 'url') !== false) {
            return 'url';
        }

        return '';
    }
}

if (!function_exists('contactFormTemplateIsFullWidth')) {
    function contactFormTemplateIsFullWidth(array $question): bool
    {
        $prompt = strtolower(trim((string) ($question['question'] ?? '')));
        $type = strtolower(trim((string) ($question['type'] ?? '')));
        $fullWidthTypes = ['textarea', 'select', 'radio', 'radios', 'checkbox', 'checkboxlist', 'file'];
        $fullWidthKeywords = ['service', 'services', 'budget', 'description', 'message', 'detail', 'brief', 'upload', 'file', 'attach', 'agree', 'terms', 'privacy'];

        if (in_array($type, $fullWidthTypes, true)) {
            return true;
        }

        foreach ($fullWidthKeywords as $keyword) {
            if (strpos($prompt, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('contactFormTemplateUsesContactServiceChips')) {
    function contactFormTemplateUsesContactServiceChips(array $question): bool
    {
        return strtolower(trim((string) ($question['type'] ?? ''))) === 'checkboxlist';
    }
}

if (!function_exists('contactFormTemplateNormalizeOptionText')) {
    function contactFormTemplateNormalizeOptionText(string $text): string
    {
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace("\xc2\xa0", ' ', $text);
        $text = preg_replace('/[[:space:]]+/u', ' ', trim($text));
        $text = preg_replace('/\s*([\/_-])\s*/u', '$1', $text);

        if (function_exists('mb_strtolower')) {
            return mb_strtolower((string) $text, 'UTF-8');
        }

        return strtolower((string) $text);
    }
}

if (!function_exists('contactFormTemplateExtractOptionLabelText')) {
    function contactFormTemplateExtractOptionLabelText(DOMElement $label, ?DOMElement $optionInput = null): string
    {
        $text = '';

        foreach ($label->childNodes as $childNode) {
            if ($optionInput && $childNode->isSameNode($optionInput)) {
                continue;
            }

            $text .= $childNode->textContent;
        }

        return trim((string) preg_replace('/\s+/u', ' ', $text));
    }
}

if (!function_exists('contactFormTemplateFindChoiceInput')) {
    function contactFormTemplateFindChoiceInput(DOMDocument $document, DOMElement $label): ?DOMElement
    {
        foreach ($label->getElementsByTagName('input') as $candidate) {
            if (
                $candidate instanceof DOMElement
                && in_array(strtolower((string) $candidate->getAttribute('type')), ['checkbox', 'radio'], true)
            ) {
                return $candidate;
            }
        }

        $forId = trim((string) $label->getAttribute('for'));
        if ($forId === '') {
            return null;
        }

        foreach ($document->getElementsByTagName('input') as $candidate) {
            if (
                $candidate instanceof DOMElement
                && $candidate->getAttribute('id') === $forId
                && in_array(strtolower((string) $candidate->getAttribute('type')), ['checkbox', 'radio'], true)
            ) {
                return $candidate;
            }
        }

        return null;
    }
}

if (!function_exists('contactFormTemplateResolveOptionKey')) {
    function contactFormTemplateResolveOptionKey(string ...$candidates): string
    {
        $aliases = [
            'games' => ['games', 'game'],
            '2d' => ['2d', '2-d', 'two d'],
            '3d' => ['3d', '3-d', 'three d'],
            'ai cinematic' => ['ai cinematic', 'ai-cinematic', 'cinematic ai'],
            'roblox' => ['roblox'],
            'other' => ['other', 'others'],
        ];

        $normalizedCandidates = [];
        foreach ($candidates as $candidate) {
            $normalizedCandidate = contactFormTemplateNormalizeOptionText($candidate);
            if ($normalizedCandidate !== '') {
                $normalizedCandidates[] = $normalizedCandidate;
            }
        }

        foreach ($normalizedCandidates as $candidate) {
            foreach ($aliases as $key => $variants) {
                if (in_array($candidate, $variants, true)) {
                    return $key;
                }
            }
        }

        foreach ($normalizedCandidates as $candidate) {
            foreach ($aliases as $key => $variants) {
                foreach ($variants as $variant) {
                    if ($variant !== '' && strpos($candidate, $variant) !== false) {
                        return $key;
                    }
                }
            }
        }

        return '';
    }
}

if (!function_exists('contactFormTemplateOptionIconMarkup')) {
    function contactFormTemplateOptionIconMarkup(string $optionKey): string
    {
        switch ($optionKey) {
            case 'games':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" focusable="false" aria-hidden="true"><path d="M4.2 5.2h7.6a2 2 0 0 1 1.92 2.56l-.63 2.2a1.55 1.55 0 0 1-2.6.73L9.3 9.52H6.7L5.45 10.7a1.55 1.55 0 0 1-2.6-.73l-.63-2.2A2 2 0 0 1 4.2 5.2Z"/><path d="M5.8 7.1v2M4.8 8.1h2M10.8 7.4h.01M12 8.6h.01"/></svg>';
            case '2d':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" focusable="false" aria-hidden="true"><rect x="2.5" y="2.5" width="11" height="11" rx="2.5"/><path d="M5 11.2 11.5 4.8M8.1 4.8h3.4v3.4"/></svg>';
            case '3d':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" focusable="false" aria-hidden="true"><path d="M8 2.75 13.25 8 8 13.25 2.75 8 8 2.75Z"/><path d="M8 5.2 10.8 8 8 10.8 5.2 8 8 5.2Z"/></svg>';
            case 'ai cinematic':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" focusable="false" aria-hidden="true"><circle cx="8" cy="8" r="5.25"/><path d="M8 5.1v2.2l1.9 1.1M5.1 8h.01M10.9 8h.01M8 10.9h.01"/></svg>';
            case 'roblox':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" focusable="false" aria-hidden="true"><path d="M4.4 2.8 13 4.7 11.1 13.2 2.6 11.4 4.4 2.8Z"/><path d="m7 6.3 2.2.5-.5 2.2-2.2-.5.5-2.2Z"/></svg>';
            case 'other':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" focusable="false" aria-hidden="true"><path d="M4 4.2h3.1v3.1H4zM8.9 4.2H12v3.1H8.9zM4 8.9h3.1V12H4zM8.9 8.9H12V12H8.9z"/></svg>';
            default:
                return '';
        }
    }
}

if (!function_exists('contactFormTemplateCreateOptionIcon')) {
    function contactFormTemplateCreateOptionIcon(DOMDocument $document, DOMElement $label, ?DOMElement $optionInput = null): ?DOMElement
    {
        $optionText = contactFormTemplateExtractOptionLabelText($label, $optionInput);
        $optionValue = $optionInput ? (string) $optionInput->getAttribute('value') : '';
        $optionKey = contactFormTemplateResolveOptionKey($optionText, $optionValue);
        if ($optionKey === '') {
            return null;
        }

        $icon = $document->createElement('span');
        contactFormTemplateAddClass($icon, 'contact-form-template__option-icon');
        $icon->setAttribute('aria-hidden', 'true');

        if ($optionKey === '3d') {
            contactFormTemplateAddClass($icon, 'contact-form-template__option-icon--diamond');

            return $icon;
        }

        $iconMarkup = contactFormTemplateOptionIconMarkup($optionKey);
        if ($iconMarkup === '') {
            return null;
        }

        if ($optionKey === 'other') {
            contactFormTemplateAddClass($icon, 'contact-form-template__option-icon--filled');
        }

        $iconDocument = new DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true);
        $loadSucceeded = $iconDocument->loadXML($iconMarkup);
        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        if (!$loadSucceeded || !$iconDocument->documentElement) {
            return null;
        }

        $icon->appendChild($document->importNode($iconDocument->documentElement, true));

        return $icon;
    }
}

if (!function_exists('contactFormTemplateDecorateInput')) {
    function contactFormTemplateDecorateInput(string $inputHtml, array $question): string
    {
        if (trim($inputHtml) === '' || !class_exists('DOMDocument')) {
            return $inputHtml;
        }

        $wrappedHtml = '<div class="contact-form-template__control-wrap">' . $inputHtml . '</div>';
        $document = new DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true);
        $loadSucceeded = $document->loadHTML('<?xml encoding="utf-8" ?>' . $wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        if (!$loadSucceeded) {
            return $inputHtml;
        }

        $autocomplete = contactFormTemplateGuessAutocomplete($question);
        $isRequired = !empty($question['required']);
        $useServiceChips = contactFormTemplateUsesContactServiceChips($question);
        $controlWrap = $document->documentElement;

        foreach ($document->getElementsByTagName('*') as $node) {
            if (!$node instanceof DOMElement) {
                continue;
            }

            $tagName = strtolower($node->tagName);
            if (!in_array($tagName, ['input', 'select', 'textarea', 'label', 'div', 'span', 'ul', 'ol', 'li'], true)) {
                continue;
            }

            if ($tagName === 'input') {
                $inputType = strtolower((string) $node->getAttribute('type'));

                if (in_array($inputType, ['checkbox', 'radio'], true)) {
                    contactFormTemplateAddClass($node, 'contact-form-template__option-input');
                } elseif ($inputType === 'hidden') {
                    continue;
                } elseif ($inputType === 'file') {
                    contactFormTemplateAddClass($node, 'contact-form-template__input');
                    contactFormTemplateAddClass($node, 'contact-form-template__input--file');
                } else {
                    contactFormTemplateAddClass($node, 'contact-form-template__input');
                    if ($autocomplete !== '' && !$node->hasAttribute('autocomplete')) {
                        $node->setAttribute('autocomplete', $autocomplete);
                    }
                    if ($isRequired) {
                        $node->setAttribute('aria-required', 'true');
                    }
                }
            } elseif ($tagName === 'select') {
                contactFormTemplateAddClass($node, 'contact-form-template__input');
                contactFormTemplateAddClass($node, 'contact-form-template__select');
                if ($isRequired) {
                    $node->setAttribute('aria-required', 'true');
                }
            } elseif ($tagName === 'textarea') {
                contactFormTemplateAddClass($node, 'contact-form-template__input');
                contactFormTemplateAddClass($node, 'contact-form-template__textarea');
                if ($isRequired) {
                    $node->setAttribute('aria-required', 'true');
                }
            } elseif ($tagName === 'label') {
                $optionInput = contactFormTemplateFindChoiceInput($document, $node);

                if ($optionInput) {
                    if (!$optionInput->parentNode || !$optionInput->parentNode->isSameNode($node)) {
                        $node->insertBefore($optionInput, $node->firstChild);
                    }

                    if ($node->hasAttribute('for')) {
                        $node->removeAttribute('for');
                    }

                    contactFormTemplateAddClass($optionInput, 'contact-form-template__option-input');

                    contactFormTemplateAddClass($node, 'contact-form-template__option');
                    if ($useServiceChips && strtolower((string) $optionInput->getAttribute('type')) === 'checkbox') {
                        contactFormTemplateAddClass($node, 'contact-form-template__option--service');
                    }
                    $optionText = contactFormTemplateExtractOptionLabelText($node, $optionInput);
                    $node->setAttribute('data-option-label', $optionText);
                    $node->setAttribute(
                        'data-option-key',
                        contactFormTemplateResolveOptionKey($optionText, (string) $optionInput->getAttribute('value'))
                    );

                    $textSpan = $document->createElement('span');
                    contactFormTemplateAddClass($textSpan, 'contact-form-template__option-text');

                    $labelSpan = $document->createElement('span');
                    contactFormTemplateAddClass($labelSpan, 'contact-form-template__option-label');

                    $children = [];
                    foreach ($node->childNodes as $childNode) {
                        $children[] = $childNode;
                    }

                    foreach ($children as $childNode) {
                        if ($childNode->isSameNode($optionInput)) {
                            continue;
                        }
                        $labelSpan->appendChild($childNode);
                    }

                    $icon = contactFormTemplateCreateOptionIcon($document, $node, $optionInput);
                    if ($icon) {
                        $textSpan->appendChild($icon);
                    }

                    $textSpan->appendChild($labelSpan);
                    $node->appendChild($textSpan);
                }
            } else {
                $className = trim((string) $node->getAttribute('class'));
                if ($className !== '') {
                    if (preg_match('/\b(?:radio|checkbox)\b/', $className)) {
                        contactFormTemplateAddClass($node, 'contact-form-template__option-item');
                    }
                    if (preg_match('/\b(?:radio-list|checkbox-list)\b/', $className)) {
                        contactFormTemplateAddClass($node, 'contact-form-template__options');
                    }
                }
            }
        }

        if ($useServiceChips) {
            contactFormTemplateAddClass($controlWrap, 'contact-form-template__options--services');

            $divNodes = [];
            foreach ($document->getElementsByTagName('div') as $divNode) {
                if ($divNode instanceof DOMElement) {
                    $divNodes[] = $divNode;
                }
            }

            foreach ($divNodes as $divNode) {
                $className = trim((string) $divNode->getAttribute('class'));
                if (
                    $className === ''
                    || !preg_match('/\b(?:checkbox|checkbox-list)\b/', $className)
                    || !$divNode->parentNode
                ) {
                    continue;
                }

                while ($divNode->firstChild) {
                    $divNode->parentNode->insertBefore($divNode->firstChild, $divNode);
                }

                $divNode->parentNode->removeChild($divNode);
            }
        }

        $hasOptionClass = false;
        foreach ($document->getElementsByTagName('label') as $label) {
            if ($label instanceof DOMElement && strpos(' ' . $label->getAttribute('class') . ' ', ' contact-form-template__option ') !== false) {
                $hasOptionClass = true;
                break;
            }
        }

        if ($hasOptionClass) {
            contactFormTemplateAddClass($controlWrap, 'contact-form-template__options');
        }

        return contactFormTemplateInnerHtml($controlWrap);
    }
}

$questionsRS = $miniSurvey->loadQuestions($qsID, $bID);
$questions = [];
while ($questionRow = $questionsRS->fetch()) {
    $question = $questionRow;
    $question['input'] = $miniSurvey->loadInputType($questionRow, false);

    if ($questionRow['inputType'] === 'text') {
        $question['type'] = 'textarea';
    } elseif ($questionRow['inputType'] === 'field') {
        $question['type'] = 'text';
    } else {
        $question['type'] = $questionRow['inputType'];
    }

    $question['labelFor'] = 'for="Question' . $questionRow['msqID'] . '"';

    if ($question['type'] === 'textarea') {
        $question['input'] = str_replace('style="width:95%"', '', $question['input']);
    }

    $question['decoratedInput'] = contactFormTemplateDecorateInput($question['input'], $question);
    $question['fullWidth'] = contactFormTemplateIsFullWidth($question);
    $questions[] = $question;
}

$success = (\Request::request('surveySuccess') && \Request::request('qsid') == $qsID);
$thanksMsg = $survey->thankyouMsg;

$errorHeader = $formResponse ?? null;
$errors = isset($errors) && is_array($errors) ? $errors : [];
if (isset($invalidIP) && $invalidIP) {
    $errors[] = $invalidIP;
}

$surveyBlockInfo = $miniSurvey->getMiniSurveyBlockInfoByQuestionId($qsID, $bID);
$captcha = $surveyBlockInfo['displayCaptcha'] ? $app->make('helper/validation/captcha') : false;

$headingId = 'contact-form-title-' . $bID;
$introId = 'contact-form-intro-' . $bID;
?>

<div id="formblock<?php echo $bID; ?>" class="ccm-block-type-form contact-form-template">
    <form
        enctype="multipart/form-data"
        class="contact-form-template__form miniSurveyView"
        id="miniSurveyView<?php echo $bID; ?>"
        method="post"
        action="<?php echo $formAction; ?>"
        aria-labelledby="<?php echo $headingId; ?>"
        aria-describedby="<?php echo $introId; ?>"
    >
        <?php echo Core::make('token')->output('form_block_submit_qs_' . $qsID); ?>

        <?php if ($success) { ?>
            <div class="contact-form-template__message contact-form-template__message--success" role="status" aria-live="polite">
                <?php echo h($thanksMsg); ?>
            </div>
        <?php } elseif ($errors) { ?>
            <div class="contact-form-template__message contact-form-template__message--error" role="alert" aria-live="assertive">
                <?php if ($errorHeader) { ?>
                    <p class="contact-form-template__message-title"><?php echo h($errorHeader); ?></p>
                <?php } ?>
                <ul class="contact-form-template__message-list">
                    <?php foreach ($errors as $error) { ?>
                        <li><?php echo h($error); ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <div class="contact-form-template__fields">
            <?php foreach ($questions as $question) { ?>
                <?php
                $questionType = strtolower((string) $question['type']);
                $isChoiceGroup = in_array($questionType, ['radio', 'radios', 'checkbox', 'checkboxlist'], true);
                $isServiceCheckboxList = $questionType === 'checkboxlist';
                $fieldClasses = [
                    'contact-form-template__field',
                    'contact-form-template__field--' . preg_replace('/[^a-z0-9]+/', '-', $questionType),
                ];

                if ($question['fullWidth']) {
                    $fieldClasses[] = 'contact-form-template__field--full';
                }

                if (isset($errorDetails[$question['msqID']])) {
                    $fieldClasses[] = 'contact-form-template__field--error';
                }

                if ($isServiceCheckboxList) {
                    $fieldClasses[] = 'contact-form-template__field--services';
                }
                ?>

                <?php if ($isChoiceGroup) { ?>
                    <fieldset class="<?php echo h(implode(' ', $fieldClasses)); ?>">
                        <legend class="contact-form-template__label">
                            <?php echo h($question['question']); ?>
                            <?php if (!empty($question['required'])) { ?>
                                <span class="contact-form-template__required"><?php echo h(t('Required')); ?></span>
                            <?php } ?>
                        </legend>
                        <?php echo $question['decoratedInput']; ?>
                    </fieldset>
                <?php } else { ?>
                    <div class="<?php echo h(implode(' ', $fieldClasses)); ?>">
                        <label class="contact-form-template__label" <?php echo $question['labelFor']; ?>>
                            <?php echo h($question['question']); ?>
                            <?php if (!empty($question['required'])) { ?>
                                <span class="contact-form-template__required"><?php echo h(t('Required')); ?></span>
                            <?php } ?>
                        </label>
                        <?php echo $question['decoratedInput']; ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <?php if ($captcha) { ?>
                <fieldset class="contact-form-template__field contact-form-template__field--full contact-form-template__field--captcha">
                    <?php
                    $captchaLabel = $captcha->label();
                    if (!empty($captchaLabel)) {
                        ?>
                        <legend class="contact-form-template__label"><?php echo h($captchaLabel); ?></legend>
                        <?php
                    }
                    ?>
                    <div class="contact-form-template__captcha-art"><?php $captcha->display(); ?></div>
                    <div class="contact-form-template__captcha-input"><?php $captcha->showInput(); ?></div>
                </fieldset>
            <?php } ?>
        </div>

        <div class="contact-form-template__actions">
            <button type="submit" name="Submit" value="<?php echo h(t($survey->submitText)); ?>" class="contact-form-template__submit">
                <svg class="contact-form-template__submit-cap" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                    <path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5" />
                </svg>
                <span class="contact-form-template__submit-label"><?php echo h(t($survey->submitText)); ?></span>
                <svg class="contact-form-template__submit-cap" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                    <path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5" />
                </svg>
            </button>
        </div>

        <input name="qsID" type="hidden" value="<?php echo $qsID; ?>" />
        <input name="pURI" type="hidden" value="<?php echo h($pURI ?? ''); ?>" />
    </form>
</div>
