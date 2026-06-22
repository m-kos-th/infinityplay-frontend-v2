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

if (!function_exists('contactFormTemplateAddClasses')) {
    function contactFormTemplateAddClasses(DOMElement $element, array $classNames): void
    {
        foreach ($classNames as $className) {
            if ($className !== '') {
                contactFormTemplateAddClass($element, $className);
            }
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

if (!function_exists('contactFormTemplateExtractPlainText')) {
    function contactFormTemplateExtractPlainText(string $value): string
    {
        $value = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = str_replace("\xc2\xa0", ' ', $value);

        return trim((string) preg_replace('/\s+/u', ' ', $value));
    }
}

if (!function_exists('contactFormTemplateSlugify')) {
    function contactFormTemplateSlugify(string $value): string
    {
        $value = contactFormTemplateNormalizeOptionText($value);
        $value = preg_replace('/[^a-z0-9]+/', '-', $value);

        return trim((string) $value, '-');
    }
}

if (!function_exists('contactFormTemplateTextContainsKeyword')) {
    function contactFormTemplateTextContainsKeyword(string $haystack, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if ($keyword !== '' && strpos($haystack, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('contactFormTemplateHasClassToken')) {
    function contactFormTemplateHasClassToken(string $className, array $tokens): bool
    {
        $classTokens = preg_split('/\s+/', trim($className)) ?: [];
        $classTokens = array_map('strtolower', array_filter($classTokens, 'strlen'));

        foreach ($tokens as $token) {
            if (in_array(strtolower($token), $classTokens, true)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('contactFormTemplateUsesAgreementCheckbox')) {
    function contactFormTemplateUsesAgreementCheckbox(array $question): bool
    {
        $type = strtolower(trim((string) ($question['type'] ?? '')));
        if (!in_array($type, ['checkbox', 'checkboxlist', 'radio', 'radios'], true)) {
            return false;
        }

        $inputHtml = (string) ($question['input'] ?? '');
        if ($inputHtml === '') {
            return false;
        }

        $choiceCount = preg_match_all('/<input\b[^>]*\btype\s*=\s*(?:"(?:checkbox|radio)"|\'(?:checkbox|radio)\'|checkbox|radio)\b/i', $inputHtml, $choiceMatches);
        if (!$choiceCount) {
            return false;
        }

        if ((int) $choiceCount !== 1) {
            return false;
        }

        $haystack = contactFormTemplateNormalizeOptionText(
            trim((string) (($question['question'] ?? '') . ' ' . contactFormTemplateExtractPlainText($inputHtml)))
        );
        $keywords = ['agree', 'agreement', 'consent', 'privacy', 'policy', 'terms'];

        foreach ($keywords as $keyword) {
            if (strpos($haystack, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('contactFormTemplateResolveFieldKey')) {
    function contactFormTemplateResolveFieldKey(array $question): string
    {
        if (!empty($question['agreementCheckbox']) || contactFormTemplateUsesAgreementCheckbox($question)) {
            return 'agreement';
        }

        $prompt = contactFormTemplateNormalizeOptionText((string) ($question['question'] ?? ''));
        $inputText = contactFormTemplateNormalizeOptionText(contactFormTemplateExtractPlainText((string) ($question['input'] ?? '')));
        $haystack = trim($prompt . ' ' . $inputText);
        $autocomplete = contactFormTemplateGuessAutocomplete($question);
        $type = strtolower(trim((string) ($question['type'] ?? '')));

        if ($autocomplete === 'email') {
            return 'email';
        }

        if ($autocomplete === 'name') {
            if (contactFormTemplateTextContainsKeyword($haystack, ['full name'])) {
                return 'full-name';
            }

            if (contactFormTemplateTextContainsKeyword($haystack, ['first name', 'given name'])) {
                return 'first-name';
            }

            if (contactFormTemplateTextContainsKeyword($haystack, ['last name', 'surname', 'family name'])) {
                return 'last-name';
            }

            return 'name';
        }

        if ($autocomplete === 'organization') {
            return 'company-name';
        }

        if ($autocomplete === 'tel') {
            return 'telephone';
        }

        if ($autocomplete === 'url') {
            return 'website';
        }

        $aliases = [
            'agreement' => ['agree', 'agreement', 'consent', 'privacy', 'policy', 'terms'],
            'services' => ['service', 'services'],
            'budget' => ['budget', 'price range', 'estimated budget', 'cost'],
            'description' => ['description', 'message', 'project detail', 'project details', 'brief', 'overview', 'tell us about', 'project summary'],
            'attachment' => ['upload', 'file', 'attach', 'attachment'],
            'company-name' => ['company', 'organization', 'organisation', 'studio', 'business'],
            'email' => ['email', 'e-mail'],
            'telephone' => ['telephone', 'phone', 'mobile', 'tel', 'whatsapp'],
            'website' => ['website', 'url', 'portfolio', 'site'],
            'timeline' => ['timeline', 'deadline', 'schedule'],
            'country' => ['country', 'location', 'region'],
        ];

        foreach ($aliases as $fieldKey => $keywords) {
            if (contactFormTemplateTextContainsKeyword($haystack, $keywords)) {
                return $fieldKey;
            }
        }

        if ($type === 'textarea') {
            return 'description';
        }

        $promptSlug = contactFormTemplateSlugify((string) ($question['question'] ?? ''));
        if ($promptSlug !== '') {
            return $promptSlug;
        }

        $typeSlug = contactFormTemplateSlugify($type);
        if ($typeSlug !== '') {
            return $typeSlug;
        }

        return 'question';
    }
}

if (!function_exists('contactFormTemplateShouldRenderAgreementPrompt')) {
    function contactFormTemplateShouldRenderAgreementPrompt(array $question): bool
    {
        $questionText = trim((string) ($question['question'] ?? ''));
        if ($questionText === '') {
            return false;
        }

        $optionText = contactFormTemplateExtractPlainText((string) ($question['input'] ?? ''));
        if ($optionText === '') {
            return true;
        }

        $normalizedQuestionText = contactFormTemplateNormalizeOptionText($questionText);
        $normalizedOptionText = contactFormTemplateNormalizeOptionText($optionText);

        if ($normalizedQuestionText === $normalizedOptionText) {
            return false;
        }

        return strpos($normalizedOptionText, $normalizedQuestionText) === false;
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
        contactFormTemplateAddClasses($icon, [
            'contact-form-template__option-icon',
            'contact__chip-icon',
        ]);
        $icon->setAttribute('aria-hidden', 'true');

        if ($optionKey === '3d') {
            contactFormTemplateAddClasses($icon, [
                'contact-form-template__option-icon--diamond',
                'contact__chip-icon--diamond',
            ]);

            return $icon;
        }

        $iconMarkup = contactFormTemplateOptionIconMarkup($optionKey);
        if ($iconMarkup === '') {
            return null;
        }

        if ($optionKey === 'other') {
            contactFormTemplateAddClasses($icon, [
                'contact-form-template__option-icon--filled',
                'contact__chip-icon--filled',
            ]);
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

        $fieldKey = trim((string) ($question['fieldKey'] ?? ''));
        $autocomplete = contactFormTemplateGuessAutocomplete($question);
        $isRequired = !empty($question['required']);
        $useAgreementCheckbox = $fieldKey === 'agreement' || contactFormTemplateUsesAgreementCheckbox($question);
        $useServiceChips = contactFormTemplateUsesContactServiceChips($question) && !$useAgreementCheckbox;
        $controlWrap = $document->documentElement;

        if ($fieldKey !== '') {
            contactFormTemplateAddClass($controlWrap, 'contact-form-template__control-wrap--' . $fieldKey);
            $controlWrap->setAttribute('data-field-key', $fieldKey);
        }

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
                    if ($isRequired) {
                        $node->setAttribute('aria-required', 'true');
                    }
                    if ($useAgreementCheckbox) {
                        contactFormTemplateAddClass($node, 'contact__agree-input');
                    } elseif ($useServiceChips && $inputType === 'checkbox') {
                        contactFormTemplateAddClass($node, 'contact__chip-input');
                    }
                } elseif ($inputType === 'hidden') {
                    continue;
                } elseif ($inputType === 'file') {
                    contactFormTemplateAddClasses($node, [
                        'contact-form-template__input',
                        'contact-form-template__input--file',
                        'contact__input',
                    ]);
                } else {
                    contactFormTemplateAddClasses($node, [
                        'contact-form-template__input',
                        'contact__input',
                    ]);
                    if ($autocomplete !== '' && !$node->hasAttribute('autocomplete')) {
                        $node->setAttribute('autocomplete', $autocomplete);
                    }
                    if ($isRequired) {
                        $node->setAttribute('aria-required', 'true');
                    }
                }
            } elseif ($tagName === 'select') {
                contactFormTemplateAddClasses($node, [
                    'contact-form-template__input',
                    'contact-form-template__select',
                    'contact__input',
                    'contact__select',
                ]);
                if ($isRequired) {
                    $node->setAttribute('aria-required', 'true');
                }
            } elseif ($tagName === 'textarea') {
                contactFormTemplateAddClasses($node, [
                    'contact-form-template__input',
                    'contact-form-template__textarea',
                    'contact__input',
                    'contact__textarea',
                ]);
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
                    $optionInputType = strtolower((string) $optionInput->getAttribute('type'));
                    if ($isRequired) {
                        $optionInput->setAttribute('aria-required', 'true');
                    }
                    if ($useAgreementCheckbox && in_array($optionInputType, ['checkbox', 'radio'], true)) {
                        contactFormTemplateAddClass($optionInput, 'contact__agree-input');
                    } elseif ($useServiceChips && $optionInputType === 'checkbox') {
                        contactFormTemplateAddClass($optionInput, 'contact__chip-input');
                    }

                    contactFormTemplateAddClass($node, 'contact-form-template__option');
                    if ($useAgreementCheckbox && in_array($optionInputType, ['checkbox', 'radio'], true)) {
                        contactFormTemplateAddClasses($node, [
                            'contact-form-template__option--agreement',
                            'contact__agree',
                        ]);
                    } elseif ($useServiceChips && $optionInputType === 'checkbox') {
                        contactFormTemplateAddClasses($node, [
                            'contact-form-template__option--service',
                            'contact__chip',
                        ]);
                    }
                    $optionText = contactFormTemplateExtractOptionLabelText($node, $optionInput);
                    $node->setAttribute('data-option-label', $optionText);
                    $node->setAttribute(
                        'data-option-key',
                        contactFormTemplateResolveOptionKey($optionText, (string) $optionInput->getAttribute('value'))
                    );

                    $textSpan = $document->createElement('span');
                    contactFormTemplateAddClass($textSpan, 'contact-form-template__option-text');
                    if ($useServiceChips && $optionInputType === 'checkbox') {
                        contactFormTemplateAddClass($textSpan, 'contact__chip-ui');
                    }

                    $labelSpan = $document->createElement('span');
                    contactFormTemplateAddClass($labelSpan, 'contact-form-template__option-label');
                    if ($useAgreementCheckbox && in_array($optionInputType, ['checkbox', 'radio'], true)) {
                        contactFormTemplateAddClass($labelSpan, 'contact-form-template__option-label--agreement');
                    } elseif ($useServiceChips && $optionInputType === 'checkbox') {
                        contactFormTemplateAddClass($labelSpan, 'contact__chip-text');
                    }

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

                    if ($useAgreementCheckbox && in_array($optionInputType, ['checkbox', 'radio'], true)) {
                        $agreeBox = $document->createElement('span');
                        contactFormTemplateAddClass($agreeBox, 'contact__agree-box');
                        $agreeBox->setAttribute('aria-hidden', 'true');
                        $node->appendChild($agreeBox);
                        $node->appendChild($labelSpan);
                    } else {
                        $icon = contactFormTemplateCreateOptionIcon($document, $node, $optionInput);
                        if ($icon) {
                            $textSpan->appendChild($icon);
                        }

                        $textSpan->appendChild($labelSpan);
                        $node->appendChild($textSpan);
                    }
                }
            } else {
                $className = trim((string) $node->getAttribute('class'));
                if ($className !== '') {
                    if (preg_match('/\b(?:radio|checkbox)\b/', $className)) {
                        contactFormTemplateAddClass($node, 'contact-form-template__option-item');
                    }
                    if (contactFormTemplateHasClassToken($className, ['radioList', 'radio-list', 'checkboxList', 'checkbox-list'])) {
                        contactFormTemplateAddClass($node, 'contact-form-template__options');
                    }
                }
            }
        }

        if ($useAgreementCheckbox || $useServiceChips) {
            if ($useAgreementCheckbox) {
                contactFormTemplateAddClass($controlWrap, 'contact-form-template__options--agreement');
            }

            if ($useServiceChips) {
                contactFormTemplateAddClasses($controlWrap, [
                    'contact-form-template__options--services',
                    'contact__services',
                ]);
            }

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
                    || !contactFormTemplateHasClassToken($className, ['checkboxList', 'checkbox-list', 'checkbox', 'radioList', 'radio-list', 'radio', 'form-check'])
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

    $question['fieldKey'] = contactFormTemplateResolveFieldKey($question);
    $question['agreementCheckbox'] = $question['fieldKey'] === 'agreement' || contactFormTemplateUsesAgreementCheckbox($question);
    $question['showAgreementPrompt'] = $question['agreementCheckbox'] ? contactFormTemplateShouldRenderAgreementPrompt($question) : false;
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

        <div class="contact-form-template__fields contact__fields">
            <?php foreach ($questions as $question) { ?>
                <?php
                $questionType = strtolower((string) $question['type']);
                $isAgreementCheckbox = !empty($question['agreementCheckbox']) || trim((string) ($question['fieldKey'] ?? '')) === 'agreement';
                $isChoiceGroup = in_array($questionType, ['radio', 'radios', 'checkbox', 'checkboxlist'], true);
                $isServiceCheckboxList = $questionType === 'checkboxlist' && !$isAgreementCheckbox;
                $fieldKey = trim((string) ($question['fieldKey'] ?? ''));
                $fieldClasses = [
                    'contact-form-template__field',
                    'contact__field',
                    'contact-form-template__field--' . preg_replace('/[^a-z0-9]+/', '-', $questionType),
                ];

                if ($fieldKey !== '') {
                    $fieldClasses[] = 'contact-form-template__field--' . $fieldKey;
                }

                $labelClasses = [
                    'contact-form-template__label',
                    'contact__label',
                ];

                if ($fieldKey !== '') {
                    $labelClasses[] = 'contact-form-template__label--' . $fieldKey;
                }

                if ($question['fullWidth']) {
                    $fieldClasses[] = 'contact-form-template__field--full';
                }

                if (isset($errorDetails[$question['msqID']])) {
                    $fieldClasses[] = 'contact-form-template__field--error';
                }

                if ($isAgreementCheckbox) {
                    $fieldClasses[] = 'contact-form-template__field--agreement';
                }

                if ($isServiceCheckboxList) {
                    $fieldClasses[] = 'contact-form-template__field--services';
                    $fieldClasses[] = 'contact__services';
                }
                ?>

                <?php if ($isAgreementCheckbox) { ?>
                    <fieldset class="<?php echo h(implode(' ', $fieldClasses)); ?>"<?php if ($fieldKey !== '') { ?> data-field-key="<?php echo h($fieldKey); ?>"<?php } ?>>
                        <?php if (!empty($question['showAgreementPrompt'])) { ?>
                            <legend class="<?php echo h(implode(' ', $labelClasses)); ?>">
                                <?php echo h($question['question']); ?>
                                <?php if (!empty($question['required'])) { ?>
                                    <span class="contact-form-template__required"><?php echo h(t('Required')); ?></span>
                                <?php } ?>
                            </legend>
                        <?php } ?>
                        <?php echo $question['decoratedInput']; ?>
                    </fieldset>
                <?php } elseif ($isChoiceGroup) { ?>
                    <fieldset class="<?php echo h(implode(' ', $fieldClasses)); ?>"<?php if ($fieldKey !== '') { ?> data-field-key="<?php echo h($fieldKey); ?>"<?php } ?>>
                        <legend class="<?php echo h(implode(' ', $labelClasses)); ?>">
                            <?php echo h($question['question']); ?>
                            <?php if (!empty($question['required'])) { ?>
                                <span class="contact-form-template__required"><?php echo h(t('Required')); ?></span>
                            <?php } ?>
                        </legend>
                        <?php echo $question['decoratedInput']; ?>
                    </fieldset>
                <?php } else { ?>
                    <div class="<?php echo h(implode(' ', $fieldClasses)); ?>"<?php if ($fieldKey !== '') { ?> data-field-key="<?php echo h($fieldKey); ?>"<?php } ?>>
                        <label class="<?php echo h(implode(' ', $labelClasses)); ?>" <?php echo $question['labelFor']; ?>>
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
            <button type="submit" name="Submit" value="<?php echo h(t($survey->submitText)); ?>" class="contact-form-template__submit contact__submit">
                <svg class="contact-form-template__submit-cap contact__submit-cap" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                    <path d="M0 9.65686C0 8.59599 0.421427 7.57857 1.17157 6.82843L6.82843 1.17157C7.57857 0.421426 8.59599 0 9.65685 0L17 0V38H9.65685C8.59599 38 7.57857 37.5786 6.82843 36.8284L1.17157 31.1716C0.421426 30.4214 0 29.404 0 28.3431V9.65686Z" fill="#ECEAE5" />
                </svg>
                <span class="contact-form-template__submit-label contact__submit-label"><?php echo h(t($survey->submitText)); ?></span>
                <svg class="contact-form-template__submit-cap contact__submit-cap" width="17" height="38" viewBox="0 0 17 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                    <path d="M17 9.65686C17 8.59599 16.5786 7.57857 15.8284 6.82843L10.1716 1.17157C9.42143 0.421426 8.40401 0 7.34315 0L0 0V38H7.34315C8.40401 38 9.42143 37.5786 10.1716 36.8284L15.8284 31.1716C16.5786 30.4214 17 29.404 17 28.3431V9.65686Z" fill="#ECEAE5" />
                </svg>
            </button>
        </div>

        <input name="qsID" type="hidden" value="<?php echo $qsID; ?>" />
        <input name="pURI" type="hidden" value="<?php echo h($pURI ?? ''); ?>" />
    </form>
</div>
