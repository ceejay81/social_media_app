<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'video')) {
                $table->string('video')->nullable()->after('image');
            }
            if (!Schema::hasColumn('posts', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasIndex('posts', 'posts_user_id_index')) {
                $table->index('user_id');
            }
        });

        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('post_id');
                $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            }
            if (!Schema::hasColumn('comments', 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasIndex('comments', 'comments_post_id_user_id_index')) {
                $table->index(['post_id', 'user_id']);
            }
        });

        Schema::table('reactions', function (Blueprint $table) {
            if (!Schema::hasIndex('reactions', 'reactions_post_id_user_id_index')) {
                $table->index(['post_id', 'user_id']);
            }
        });

        // If you decide to merge Likes into Reactions, uncomment the following line:
        // Schema::dropIfExists('likes');
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'video')) {
                $table->dropColumn('video');
            }
            $table->dropSoftDeletes();
            $table->dropIndex(['user_id']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
            $table->dropSoftDeletes();
            $table->dropIndex(['post_id', 'user_id']);
        });

        Schema::table('reactions', function (Blueprint $table) {
            if (Schema::hasIndex('reactions', 'reactions_post_id_user_id_index')) {
                $table->dropIndex(['post_id', 'user_id']);
            }
        });

        // If you dropped the Likes table in the up method, uncomment the following lines:
        // Schema::create('likes', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('user_id');
        //     $table->unsignedBigInteger('post_id');
        //     $table->timestamps();
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        // });
    }
};