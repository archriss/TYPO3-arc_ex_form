<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Arc Ex Form - Form extend capabilities',
    'description' => 'Extends the TYPO3 form with a receiver finisher, choose receiver email depending on a select field value.',
    'category' => 'misc',
    'author' => 'Christophe Monard',
    'author_email' => 'cmonard@archriss.com',
    'author_company' => 'Archriss',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '10.4.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'form' => '10.4.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
 
