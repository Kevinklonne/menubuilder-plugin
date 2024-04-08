<?php namespace Kevinklonne\MenuBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class MenuBuilderCreateMenuItemsTable extends Migration
{
    public function up()
    {
        Schema::create('kevinklonne_menubuilder_menu_items', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('menu_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('label');
            $table->string('url')->nullable();
            $table->boolean('is_hidden')->default(0);
            $table->boolean('is_external')->default(0);
            $table->string('css_class')->nullable();
            $table->string('code')->nullable();
            $table->string('custom_attributes')->nullable();
            $table->boolean('include_nested')->default(0);
            $table->boolean('replace_with_nested')->default(0);
            $table->text('custom_options')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('sort_order')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('kevinklonne_menubuilder_menu_items');
    }
}
