<?php namespace KevinKlonne\MenuBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class MenuBuilderCreateMenuTable extends Migration
{
    public function up()
    {
        Schema::create('kevinklonne_menubuilder_menus', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('css_class')->nullable();
            $table->text('custom_options')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('kevinklonne_menubuilder_menus');
    }
}
