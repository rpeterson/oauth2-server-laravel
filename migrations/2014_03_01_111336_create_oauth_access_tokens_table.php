<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthAccessTokensTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_access_tokens', function (Blueprint $table) {
            $table->string('token', 40)->primary();
            $table->integer('session_id')->unsigned();
            $table->integer('expires');

            $table->timestamps();

            $table->unique(array('access_token', 'session_id'));
            $table->index('session_id');

            $table->foreign('session_id')
                  ->references('id')->on('oauth_sessions')
                  ->onDelete('cascade')
                  ->onUpdate('no action');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('oauth_access_tokens', function ($table) {
            $table->dropForeign('oauth_access_tokens_session_id_foreign');
        });
        Schema::drop('oauth_access_tokens');
	}

}