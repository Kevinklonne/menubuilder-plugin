<?php return [
    'plugin' => [
        'name' => 'Menu Bouwer',
        'description' => 'Plugin voor gemakkelijke menu management',
        'label' => 'Menu Bouwer',
        'sublabel' => 'Menus',
    ],
    'menu' => [
        'name' => 'Naam',
        'code' => 'Code',
        'description' => 'Omschrijving',
        'css' => 'CSS class',
        'is_active' => 'Is actief',
        'created' => 'Aangemaakt op',
        'updated' => 'Aangepast op',
        'copy_noun' => 'Kopie',
        'copy_verb' => 'Kopie',
        'menu_items' => 'Menu items',
        'actions' => 'Acties',
        'duplicate_confirm' => 'Weet je zeker dat je dit menu wilt dupliceren?',
        'duplicate_success' => 'Menu succesvol gedupliceerd.',
    ],
    'menuitem' => [
        'label' => 'Label',
        'url' => 'URL',
        'parent' => 'Bovenliggende item',
        'noparent' => '-- Geen bovenliggend item --',
        'external' => 'Externe link',
        'hidden' => 'Verborgen',
        'css' => 'CSS class',
        'code' => 'Code',
        'code_comment' => 'Unieke code om met een API te gebruiken',
        'attributes' => 'Attributen',
        'attributes_comment' => 'HTML attributen',
        'include_nested' => 'Inclusief onderliggende paginas',
        'replace_nested' => 'Vervang dit item door de onderliggende paginas',
    ],
    'permission' => [
        'tab' => 'Menu Bouwer',
        'label' => 'Beheer menus',
    ],
    'render_menu' => [
        'name' => 'Toon Menu',
        'description' => 'Toon een menu',
        'menu' => 'Menu',
        'menu_description' => 'Kies een menu',
    ]
];