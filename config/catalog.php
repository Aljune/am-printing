<?php

return [
    'categories' => [
        ['id' => 'printing', 'label' => 'Printing documents', 'icon' => 'printing'],
        ['id' => 'photocopy', 'label' => 'Photocopy', 'icon' => 'photocopy'],
        ['id' => 'scan', 'label' => 'Scan', 'icon' => 'scan'],
        ['id' => 'rushid', 'label' => 'Rush ID', 'icon' => 'rushid'],
        ['id' => 'lamination', 'label' => 'Laminations', 'icon' => 'lamination'],
        ['id' => 'template', 'label' => 'Template design', 'icon' => 'template', 'subcategories' => [
            ['id' => 'birthday', 'label' => 'Birthday'],
            ['id' => 'anniversary', 'label' => 'Anniversary'],
            ['id' => 'wedding', 'label' => 'Wedding'],
            ['id' => 'christening', 'label' => 'Christening'],
        ]],
    ],
];