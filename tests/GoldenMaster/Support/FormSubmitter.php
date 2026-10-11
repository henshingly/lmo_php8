<?php

namespace Lmo\Tests\GoldenMaster\Support;

/**
 * Liest ein HTML-Formular wie ein Browser aus (Felder, Standardwerte, Auswahl, Haken)
 * und baut daraus die zu sendenden Feldpaare. Damit lassen sich Admin-Formulare ausfuellen
 * und abschicken, ohne jedes Feld einzeln nachzubauen; nur Abweichungen werden angegeben.
 *
 * Nicht nachgebildet: JavaScript (onclick/onChange), Datei-Uploads.
 */
final class FormSubmitter
{
    /**
     * @param string|null $mustContain Name eines Feldes, das das gesuchte Formular enthalten muss;
     *                                 null = erstes Formular mit einem Feld "save", sonst das erste
     * @param string|null $submit      Name des Absende-Knopfs, der mitgesendet wird (Browser tun das beim Klick)
     * @return array{method:string,fields:array<int,array{0:string,1:string}>,formCount:int}|null
     */
    public static function extract(string $html, ?string $mustContain = null, ?string $submit = null): ?array
    {
        $dom = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $xpath = new \DOMXPath($dom);

        $forms = $xpath->query('//form');
        $chosen = null;
        foreach ($forms as $form) {
            $probe = $mustContain ?? 'save';
            if ($xpath->query('.//*[@name="' . $probe . '"]', $form)->length > 0) {
                $chosen = $form;
                break;
            }
        }
        if ($chosen === null && $mustContain === null && $forms->length > 0) {
            $chosen = $forms->item(0);
        }
        if ($chosen === null) {
            return null;
        }

        /** @var \DOMElement $chosen */
        $fields = [];
        foreach ($xpath->query('.//input|.//select|.//textarea', $chosen) as $element) {
            /** @var \DOMElement $element */
            $name = $element->getAttribute('name');
            if ($name === '' || $element->hasAttribute('disabled')) {
                continue;
            }
            switch (strtolower($element->nodeName)) {
                case 'input':
                    $type = strtolower($element->getAttribute('type') ?: 'text');
                    if (in_array($type, ['checkbox', 'radio'], true)) {
                        if ($element->hasAttribute('checked')) {
                            $fields[] = [$name, $element->hasAttribute('value') ? $element->getAttribute('value') : 'on'];
                        }
                    } elseif ($type === 'submit') {
                        if ($submit !== null && $name === $submit) {
                            $fields[] = [$name, $element->getAttribute('value')];
                        }
                    } elseif (!in_array($type, ['button', 'reset', 'file', 'image'], true)) {
                        $fields[] = [$name, $element->getAttribute('value')];
                    }
                    break;
                case 'select':
                    $options = $xpath->query('.//option', $element);
                    $selected = [];
                    foreach ($options as $option) {
                        /** @var \DOMElement $option */
                        if ($option->hasAttribute('selected')) {
                            $selected[] = $option->hasAttribute('value') ? $option->getAttribute('value') : trim($option->textContent);
                        }
                    }
                    if (!$selected && !$element->hasAttribute('multiple') && $options->length > 0) {
                        /** @var \DOMElement $first */
                        $first = $options->item(0);
                        $selected[] = $first->hasAttribute('value') ? $first->getAttribute('value') : trim($first->textContent);
                    }
                    foreach ($selected as $value) {
                        $fields[] = [$name, $value];
                    }
                    break;
                case 'textarea':
                    $fields[] = [$name, $element->textContent];
                    break;
            }
        }

        return [
            'method' => strtolower($chosen->getAttribute('method') ?: 'get'),
            'fields' => $fields,
            'formCount' => $forms->length,
        ];
    }

    /**
     * Ersetzt oder ergaenzt Felder. Ein Array-Wert erzeugt mehrere Paare (z. B. name[]).
     *
     * @param array<int,array{0:string,1:string}> $fields
     * @param array<string,string|int|array<int,string|int>> $overrides
     * @return array<int,array{0:string,1:string}>
     */
    public static function override(array $fields, array $overrides): array
    {
        foreach ($overrides as $name => $value) {
            $fields = array_values(array_filter($fields, static fn ($pair) => $pair[0] !== (string)$name));
            foreach ((array)$value as $single) {
                $fields[] = [(string)$name, (string)$single];
            }
        }
        return $fields;
    }

    /** @param array<int,array{0:string,1:string}> $fields */
    public static function encode(array $fields): string
    {
        return implode('&', array_map(static fn ($p) => rawurlencode($p[0]) . '=' . rawurlencode($p[1]), $fields));
    }

    /** Lesbare Liste der gesendeten Felder fuer das Protokoll. @param array<int,array{0:string,1:string}> $fields */
    public static function describe(array $fields): string
    {
        $lines = [];
        foreach ($fields as [$name, $value]) {
            $value = str_replace(["\r", "\n"], ['\\r', '\\n'], $value);
            $lines[] = $name . '=' . (strlen($value) > 80 ? substr($value, 0, 80) . '...' : $value);
        }
        return implode("\n", $lines);
    }
}
