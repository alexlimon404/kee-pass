<?php

namespace App\Actions\File;

use App\Actions\Action;
use App\Models\File;
use App\Models\Group;
use App\Models\Note;

class ImportCSVAction extends Action
{
    public function __construct(private File $file, private string $file_name)
    {
    }

    public function handle(): void
    {
        $path = storage_path() . "/app/public/{$this->file_name}";

        if (($handle = fopen($path, 'r')) !== false) {
            $headers = fgetcsv($handle, 1000, ',');

            $data = [];

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $data[] = array_combine($headers, $row);
            }

            $this->save($data);

            fclose($handle);
        }
    }

    private function save(array $records): void
    {
        foreach ($records as $record) {
            Note::create([
                'group_id' => $this->createGroup($record['Group'])->id,
                'user_id' => $this->file->user_id,
                'file_id' => $this->file->id,
                'title' => $record['Title'],
                'username' => $record['Username'],
                'password' => $record['Password'],
                'url' => $record['URL'],
                'description' => $record['Notes'],
                'last_edit_at' => $record['Last Modified'],
                'created_at_from_export' => $record['Created'],
            ]);
        }
    }

    private function createGroup(string $group_path): Group
    {
        $groups = explode('/', $group_path);

        $ids = null;
        foreach ($groups as $group_name) {

            $group = Group::firstOrCreate([
                'name' => $group_name,
                'parent_id' => $ids ? end($ids) : null,
            ], [
                'user_id' => $this->file->user_id,
            ]);

            $ids[] = $group->id;
        }

        return $group;
    }
}
