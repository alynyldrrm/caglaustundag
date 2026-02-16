<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('key');
            $table->longText('text');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
        Schema::create('cities', function (Blueprint $table) {
            $table->integer('id');
            $table->text('name');
        });
        Schema::create('towns', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('city_id');
            $table->text('name');
        });
        Schema::create('website_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('seo_title')->nullable();
            $table->longText('seo_keywords')->nullable();
            $table->longText('seo_description')->nullable();
            $table->longText('facebook')->nullable();
            $table->longText('twitter')->nullable();
            $table->longText('instagram')->nullable();
            $table->longText('youtube')->nullable();
            $table->longText('gplus')->nullable();
            $table->longText('linkedin')->nullable();
            $table->longText('pinterest')->nullable();
            $table->longText('emails')->nullable();
            $table->timestamps();
        });
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->integer('type_id');
            $table->integer('brother_id');
            $table->longText('name')->nullable();
            $table->longText('city')->nullable();
            $table->longText('town')->nullable();
            $table->longText('phone')->nullable();
            $table->longText('email')->nullable();
            $table->longText('address')->nullable();
            $table->longText('iframe_code')->nullable();
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->integer('brother_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->longText('name');
            $table->longText('description')->nullable();
            $table->longText('imagePath')->nullable();
            $table->longText('filePath')->nullable();
            $table->longText('url')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->longText('permalink')->nullable();
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model', 255)->default('App\\\Models\\\Value');
            $table->longText('single_name');
            $table->longText('multiple_name');
            $table->longText('permalink');
            $table->longText('rendered_view')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id');
            $table->longText('key');
            $table->longText('name');
            $table->longText('type');
            $table->longText('attr')->nullable();
            $table->longText('values')->nullable();
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
        Schema::create('values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->integer('brother_id');
            $table->integer('type_id');
            $table->longText('name')->nullable();
            $table->longText('permalink')->nullable();
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
        Schema::create('value_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('field_id');
            $table->string('valueModel', 255)->default('App\\\Models\\\Value');
            $table->integer('model_id');
            $table->longText('value')->nullable();
            $table->timestamps();
        });
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->integer('value_detail_id')->nullable();
            $table->longText('original_name');
            $table->longText('extension');
            $table->longText('size');
            $table->longText('path');
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
        Schema::create('menu_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id');
            $table->integer('value_id');
            $table->integer('type_id');
            $table->timestamps();
        });
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->integer('brother_id');
            $table->integer('type_id');
            $table->longText('name');
            $table->longText('questions')->nullable();
            $table->longText('success_message')->nullable();
            $table->longText('error_message')->nullable();
            $table->longText('permalink');
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
        Schema::create('form_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id');
            $table->longText('answer');
            $table->longText('ip')->nullable();
            $table->boolean('checked')->default(false);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('towns');
        Schema::dropIfExists('website_settings');
        Schema::dropIfExists('contact_settings');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('types');
        Schema::dropIfExists('fields');
        Schema::dropIfExists('values');
        Schema::dropIfExists('value_details');
        Schema::dropIfExists('files');
        Schema::dropIfExists('menu_values');
        Schema::dropIfExists('forms');
        Schema::dropIfExists('form_answers');
    }
};
