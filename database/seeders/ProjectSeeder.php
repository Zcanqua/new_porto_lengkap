<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use RuntimeException;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
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

        foreach ($projects as $project) {
            Project::query()->firstOrCreate(
                ['id' => $project['id']],
                [
                    'title' => $project['title'],
                    'category' => $project['category'],
                    'description' => $project['description'],
                    'image' => $project['image'],
                    'image_alt' => $project['image_alt'],
                    'url' => $project['url'],
                    'technologies' => $project['technologies'],
                ],
            );
        }
    }
}
