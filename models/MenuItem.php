<?php namespace Kevinklonne\MenuBuilder\Models;

use Model;

/**
 * Model
 */
class MenuItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\SimpleTree;
    use \October\Rain\Database\Traits\Sortable;

    /**
     * @var array dates to cast from the database.
     */
    protected $dates = ['deleted_at'];
    protected $jsonable = ['custom_options'];

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'kevinklonne_menubuilder_menu_items';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'label' => ['required'],
    ];

    public $belongsTo = [
        'menu' => \Kevinklonne\MenuBuilder\Models\Menu::class,
        'parent' => [MenuItem ::class, 'key' => 'parent_id'],
    ];

    public $hasMany = [
        'children' => [MenuItem ::class, 'key' => 'parent_id'],
    ];

}
