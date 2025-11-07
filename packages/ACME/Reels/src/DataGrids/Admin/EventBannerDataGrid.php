<?php

namespace ACME\Reels\DataGrids\Admin;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;
use Webkul\DataGrid\Enums\ColumnTypeEnum;

class EventBannerDataGrid extends DataGrid
{
    public function prepareQueryBuilder()
    {
        return DB::table('event_banners')
            ->select('id', 'title', 'path', 'status');
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index'    => 'id',
            'label'    => 'ID',
            'type'     => ColumnTypeEnum::INTEGER->value,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index'   => 'path',
            'label'   => 'Image',
            'type'    => ColumnTypeEnum::STRING->value,
            'closure' => function ($row) {
                return '<img src="' . \Illuminate\Support\Facades\Storage::url($row->path) . '" width="100" />';
            },
        ]);

        $this->addColumn([
            'index'    => 'title',
            'label'    => 'Title',
            'type'     => ColumnTypeEnum::STRING->value,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index'   => 'status',
            'label'   => 'Status',
            'type'    => ColumnTypeEnum::BOOLEAN->value,
            'sortable'=> true,
            'closure' => function ($row) {
                return $row->status
                    ? '<span class="label-active">Enabled</span>'
                    : '<span class="label-info">Disabled</span>';
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'index'  => 'delete',
            'title'  => 'Delete',
            'icon'   => 'icon-delete', // Use the correct admin icon class
            'method' => 'DELETE',
              'url'    => function ($row) {
            // Use the new, correct, and unique route name
            return route('admin.event_banners.destroy', $row->id);
        },
            'confirm_text' => 'Are you sure you want to delete this banner?', // Optional confirmation
        ]);
    }
}
