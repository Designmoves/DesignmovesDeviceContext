<?php
$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->filter(function (SplFileInfo $file) {
        $excludedFile = 'test' . DIRECTORY_SEPARATOR . 'Bootstrap.php';
        if (strpos((string) $file, $excludedFile)) {
            return false;
        }
    })
    ->in(__DIR__);

return Symfony\CS\Config\Config::create()
    ->fixers(array(
        /**
         * [contrib] Align equals symbols in consecutive lines.
         */
        'align_equals',
        /**
         * [PSR-2] Opening braces for classes, interfaces, traits and methods must go on the next line,
         * and closing braces must go on the next line after the body. Opening braces for control structures
         * must go on the same line, and closing braces must go on the next line after the body.
         */
        'braces',
        /**
         * [contrib] Concatenation should be used with at least one whitespace around.
         */
        'concat_with_spaces',
        /**
         * [PSR-2] The keyword elseif should be used instead of else if so that all control keywords looks
         * like single words.
         */
        'elseif',
        /**
         * [PSR-1] PHP code MUST use only UTF-8 without BOM (remove BOM).
         */
        'encoding',
        /**
         * [PSR-2] A file must always end with an empty line feed.
         */
        'eof_ending',
        /**
         * [PSR-2] When making a method or function call, there MUST NOT be a space between the method or
         * function name and the opening parenthesis.
         */
        'function_call_space',
        /**
         * [PSR-2] Spaces should be properly placed in a function declaration
         */
        'function_declaration',
        /**
         * [PSR-2] Code must use 4 spaces for indenting, not tabs.
         */
        'indentation',
        /**
         * [PSR-2] There MUST be one blank line after the namespace declaration.
         */
        'line_after_namespace',
        /**
         * [PSR-2] All PHP files must use the Unix LF (linefeed) line ending.
         */
        'linefeed',
        /**
         * [PSR-2] The PHP constants true, false, and null MUST be in lower case.
         */
        'lowercase_constants',
        /**
         * [PSR-2] PHP keywords MUST be in lower case.
         */
        'lowercase_keywords',
        /**
         * [PSR-2] In method arguments and method call, there MUST NOT be a space before each comma and
         * there MUST be one space after each comma.
         */
        'method_argument_space',
        /**
         * [PSR-2] There MUST be one use keyword per declaration.
         */
        'multiple_use',
        /**
         * [contrib] Ordering use statements.
         */
        'ordered_use',
        /**
         * [PSR-2] There MUST NOT be a space after the opening parenthesis. There MUST NOT be a space
         * before the closing parenthesis.
         */
        'parenthesis',
        /**
         * [PSR-2] The closing ?> tag MUST be omitted from files containing only PHP.
         */
        'php_closing_tag',
        /**
         * [all] All items of the @param phpdoc tags must be aligned vertically.
         */
        'phpdoc_params',
        /**
         * [PSR-0] Classes must be in a path that matches their namespace, be at least one namespace deep,
         * and the class name should match the file name.
         */
        'psr0',
        /**
         * [all] An empty line feed should precede a return statement.
         */
        'return',
        /**
         * [PSR-1] PHP code must use the long <?php ?> tags or the short-echo <?= ?> tags; it must not use
         * the other tag variations.
         */
        'short_tag',
        /**
         * [PSR-2] Each namespace use MUST go on its own line and there MUST be one blank line after the use statements block.
         */
        'single_line_after_imports',
        /**
         * [PSR-2] Remove trailing whitespace at the end of non-blank lines.
         */
        'trailing_spaces',
        /**
         * [all] Unused use statements must be removed.
         */
        'unused_use',
        /**
         * [PSR-2] Visibility MUST be declared on all properties and methods; abstract and final MUST be
         * declared before the visibility; static MUST be declared after the visibility.
         */
        'visibility',
    ))
    ->finder($finder);
