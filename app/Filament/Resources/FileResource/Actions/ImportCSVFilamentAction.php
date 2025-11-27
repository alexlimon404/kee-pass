<?php

namespace App\Filament\Resources\FileResource\Actions;

use Closure;
use App\Models\File;
use Filament\Actions\Action;
use App\Actions\File\ImportCSVAction;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Concerns\CanCustomizeProcess;

class ImportCSVFilamentAction extends Action
{
    use CanCustomizeProcess;

    protected ?Closure $mutateRecordDataUsing = null;

    public static function getDefaultName(): ?string
    {
        return 'import_csv';
    }

    protected function setUp(): void
    {
        parent::setUp();

        // $this->disabled(! auth()->user()->can('update', $this->record));

        $this->successNotificationTitle('Import CSV');

        $this->icon('heroicon-m-currency-dollar');

        $this->schema([
            FileUpload::make('attachment'),
        ]);

        $this->action(function (): void {
            $this->process(function (array $data, File $file) {
                ImportCSVAction::run($file, $data['attachment']);
            });

            $this->success();
        });
    }

    public function mutateRecordDataUsing(?Closure $callback): static
    {
        $this->mutateRecordDataUsing = $callback;

        return $this;
    }
}
