<?php


namespace ACME\Reels\DataGrids\Admin;

use ACME\Reels\Models\Reel; // We will use the Reel model directly


use Webkul\DataGrid\DataGrid;

class ReelDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        // This is the corrected way to build the query, using the Eloquent model.
        $queryBuilder = Reel::query()->select('id', 'title', 'sort_order', 'status');

        $this->setQueryBuilder($queryBuilder);
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => 'ID',
            'type'       => 'integer',
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => 'Title',
            'type'       => 'string',
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'sort_order',
            'label'      => 'Sort Order',
            'type'       => 'integer',
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => 'Status',
            'type'       => 'boolean',
            'sortable'   => true,
            'closure'    => fn ($row) => $row->status ? 'Active' : 'Inactive',
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'icon'   => 'icon-edit',
            'title'  => 'Edit Reel',
            'method' => 'GET',
            'url'    => fn ($row) => route('admin.reels.edit', $row->id),
        ]);

        $this->addAction([
            'icon'   => 'icon-delete',
            'title'  => 'Delete Reel',
            'method' => 'DELETE',
            'url'    => fn ($row) => route('admin.reels.destroy', $row->id),
        ]);
    }
}