<?php

return [
    'linkable_to_page' => true,
    'has_taxonomies' => true,
    'per_page' => 30,
    'order' => [
        'date' => 'desc',
    ],
    'sidebar' => [
        'icon' => '<i class="icon-grid-2x2"></i>',
        'weight' => 60,
    ],
    'permissions' => [
        'read projects' => 'Read',
        'create projects' => 'Create',
        'update projects' => 'Update',
        'delete projects' => 'Delete',
    ],
];
