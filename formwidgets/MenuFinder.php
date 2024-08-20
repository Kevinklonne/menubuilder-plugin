<?php namespace KevinKlonne\MenuBuilder\FormWidgets;

use Backend\Classes\FormField;
use Backend\Classes\FormWidgetBase;
use Kevinklonne\MenuBuilder\Models\Menu;

/**
 * MenuFinder Form Widget
 *
 * @link https://docs.octobercms.com/3.x/extend/forms/form-widgets.html
 */
class MenuFinder extends FormWidgetBase
{
    protected $defaultAlias = 'menufinder';

    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('~/modules/backend/widgets/form/partials/_field_dropdown.htm');
    }

    public function prepareVars()
    {
        $this->vars['field'] = $this->makeFormField();
    }

    protected function makeFormField(): FormField
    {
        $field = clone $this->formField;
        $field->type = 'dropdown';
        $field->options = $this->getOptions();

        return $field;
    }

    protected function getOptions(): array
    {
        return Menu::all()
            ->mapWithKeys(function ($menu) {
                return [
                    $menu->code => $menu->name,
                ];
            })->toArray();
    }
}
