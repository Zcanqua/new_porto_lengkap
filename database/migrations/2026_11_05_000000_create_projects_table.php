<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title', 120);
            $table->string('category', 80);
            $table->text('description');
            $table->string('image');
            $table->string('image_alt', 180);
            $table->text('url');
            $table->json('technologies');
            $table->timestamps();
        });

        $legacyFile = storage_path('app/private/projects.json');

        if (! is_file($legacyFile)) {
            return;
        }

        $contents = file_get_contents($legacyFile);

        if ($contents === false) {
            throw new RuntimeException('Unable to read the legacy project data file.');
        }

        $projects = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);

        if (! is_array($projects) || ! array_is_list($projects)) {
            throw new RuntimeException('The legacy project data file must contain a JSON list.');
        }

        $timestamp = now();
        $records = array_map(static fn (array $project): array => [
            'id' => $project['id'],
            'title' => $project['title'],
            'category' => $project['category'],
            'description' => $project['description'],
            'image' => $project['image'],
            'image_alt' => $project['image_alt'],
            'url' => $project['url'],
            'technologies' => json_encode($project['technologies'], JSON_THROW_ON_ERROR),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ], $projects);

        if ($records !== []) {
            DB::table('projects')->insert($records);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
