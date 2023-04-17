<?php

return [
    'linkable_to_page' => true,
    'has_taxonomies' => true,
    'per_page' => 30,
    'order' => [
        'date' => 'desc',
    ],
    'sidebar' => [
        'icon' => '<i class="bi bi-x-diamond"></i>',
        'weight' => 60,
    ],
    'permissions' => [
        'read projects' => 'Read',
        'create projects' => 'Create',
        'update projects' => 'Update',
        'delete projects' => 'Delete',
    ],
];
