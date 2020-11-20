<?php

namespace TypiCMS\Modules\Projects\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Projects\Models\Project;

class Export implements WithColumnFormatting, ShouldAutoSize, FromCollection, WithHeadings, WithMapping
{
    protected $collection;

    public function __construct($request)
    {
        $this->collection = QueryBuilder::for(Project::class)
            ->selectFields($request->input('fields.projects'))
            ->allowedSorts(['status_translated', 'date', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->get();
    }

    public function map($model): array
    {
        return [
            Date::dateTimeToExcel($model->created_at),
            Date::dateTimeToExcel($model->updated_at),
            $model->status_translated,
            Date::dateTimeToExcel($model->date),
            $model->website,
            $model->title_translated,
            $model->summary_translated,
            $model->body_translated,
        ];
    }

    public function headings(): array
    {
        return [
            'Created at',
            'Updated at',
            'Published',
            'Date',
            'Website',
            'Title',
            'Summary',
            'Body',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
            'D' => NumberFormat::FORMAT_DATE_DMYSLASH,
        ];
    }

    public function collection()
    {
        return $this->collection;
    }
}
