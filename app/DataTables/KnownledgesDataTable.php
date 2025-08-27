<?php

namespace App\DataTables;

use App\Models\Knownledge;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KnownledgesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Tenant> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($row){
                $editUrl = route('knownledges.edit', $row->id);
                $deleteUrl = route('knownledges.destroy', $row->id);
                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm(\'Bạn có chắc chắn muốn xoá?\')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['action']) // 👈 rất quan trọng
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Tenant>
     */
    public function query(Knownledge $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('knownledges')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'desc')
            ->selectStyleSingle()
            ->dom('Bfrtip')   // 👈 thêm dòng này
            ->buttons([
                // Custom nút Add'
                Button::raw([
                    'text' => '<i class="fas fa-plus"></i> Thêm văn bản',
                    'className' => 'btn btn-success',
                    'action' => 'function() { window.location.href = "/knownledges/create/text"; }'
                ]),
                Button::raw([
                    'text' => '<i class="fas fa-plus"></i> Thêm file',
                    'className' => 'btn btn-info',
                    'action' => 'function() { window.location.href = "/knownledges/create/file"; }'
                ]),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'knownledges_' . date('YmdHis');
    }
}
