<?php

declare(strict_types=1);

return [
    'linkable_to_page' => true,
    'has_taxonomies' => true,
    'per_page' => 30,
    'order' => [
        'date' => 'desc',
    ],
    'sidebar' => [
        'icon' => '<i class="icon-shapes"></i>',
        'weight' => 60,
    ],
    'permissions' => [
        'read projects' => 'Read',
        'create projects' => 'Create',
        'update projects' => 'Update',
        'delete projects' => 'Delete',
    ],
];
