<?php

return [
    'modMeta' => [
        'file' => 'modmeta',
        'properties' => [
            'tpl' => [
                'type' => 'textfield',
                'value' => 'tpl.modMeta',
            ],
            'tplRss' => [
                'type' => 'textfield',
                'value' => 'tpl.modMeta.rss',
            ],
            'copyFrom' => [
                'type' => 'numberfield',
                'value' => '',
            ],
            'copyTill' => [
                'type' => 'numberfield',
                'value' => '',
            ],
            'copySeparator' => [
                'type' => 'textfield',
                'value' => ' - ',
            ],
            'rss' => [
                'type' => 'numberfield',
                'value' => '',
            ],
        ],
    ],
];