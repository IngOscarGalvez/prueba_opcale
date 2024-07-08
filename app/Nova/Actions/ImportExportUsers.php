<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportExportUsers extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        if ($fields->export_import == 'import') {
            return $this->import($fields->file);
        } else {
            return $this->export($fields->field_mapping);
        }
    }

    /**
     * Import users from the uploaded file.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return \Laravel\Nova\Actions\ActionResponse
     */
    protected function import($file)
    {
        (new FastExcel)->import($file, function ($line) {
            \App\Models\User::create([
                'name' => $line['Name'],
                'email' => $line['Email'],
                // Añade más campos según sea necesario
            ]);
        });

        return Action::message('Users imported successfully!');
    }

    /**
     * Export users to a file.
     *
     * @param  array  $fieldMapping
     * @return \Laravel\Nova\Actions\Action
     */
    protected function export($fieldMapping)
    {
        $users = \App\Models\User::all();

        $data = $users->map(function ($user) use ($fieldMapping) {
            $mappedData = [];
            foreach ($fieldMapping as $field => $column) {
                $mappedData[$column] = $user->$field;
            }
            return $mappedData;
        });

        $filePath = storage_path('app/public/users_export.xlsx');
        (new FastExcel($data))->export($filePath);

        return Action::download($filePath, 'users_export.xlsx');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Export/Import', 'export_import')
                ->options([
                    'export' => 'Export',
                    'import' => 'Import',
                ])
                ->rules('required'),

            File::make('File')
                ->help('Upload file for import')
                ->rules('required_if:export_import,import')
                ->disk('public'),

            KeyValue::make('Field Mapping', 'field_mapping')
                ->help('Map the fields for export. Key is user attribute, value is the column name in the file.')
                ->rules('required_if:export_import,export')
        ];
    }
}


