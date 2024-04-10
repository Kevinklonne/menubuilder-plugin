<?php namespace KevinKlonne\MenuBuilder\Models;

use Model;

/**
 * Model
 */
class Menu extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\SimpleTree;

    /**
     * @var array dates to cast from the database.
     */
    protected $dates = ['deleted_at'];
    protected $jsonable = ['custom_options'];
    protected $cloneable_relations = ['items'];

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'kevinklonne_menubuilder_menus';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'name' => ['required'],
        'code' => ['unique'],
    ];

    public $hasMany = [
        'items' => [
            \KevinKlonne\MenuBuilder\Models\MenuItem::class,
            'replicate' => true,
        ],
    ];

    public function afterDelete()
    {
        $this->items->each->delete();
    }

}
