<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->bigInteger('telephone');
			$table->tinyInteger('jingdian');
			$table->tinyInteger('shangjia');
			$table->tinyInteger('is_verify')->default(0);
			$table->tinyInteger('is_del')->default(0);
			$table->timestamp('travel_at');
			$table->text('ticket');
			$table->text('info');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}

}
