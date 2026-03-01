<?php

namespace App\DataTables;

use App\Models\CustomField;
use App\Models\EProviderPayout;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class EProviderPayoutDataTable extends DataTable
{
    /**
     * custom fields columns
     * @var array
     */
    public static $customFields = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $columns = array_column($this->getColumns(), 'data');
        $dataTable = $dataTable
            ->editColumn('e_provider.name', function ($earning) {
                return getLinksColumnByRouteName([$earning->eProvider], "eProviders.edit", 'id', 'name');
            })
            ->editColumn('note', function ($eProviderPayout) {
                return getStripedHtmlColumn($eProviderPayout, 'note');
            })
            ->editColumn('paid_date', function ($eProviderPayout) {
                return getDateColumn($eProviderPayout, "paid_date");
            })
            ->editColumn('amount', function ($eProviderPayout) {
                return getPriceColumn($eProviderPayout, 'amount');
            })
            ->editColumn('full_name', function ($eProviderPayout) {
                return $eProviderPayout->full_name;
            })
            ->editColumn('bank_name', function ($eProviderPayout) {
                return $eProviderPayout->bank_name;
            })
            ->editColumn('account_number', function ($eProviderPayout) {
                return $eProviderPayout->account_number;
            })
            ->editColumn('iban', function ($eProviderPayout) {
                return $eProviderPayout->iban;
            })
            ->editColumn('sort_code', function ($eProviderPayout) {
                return $eProviderPayout->sort_code;
            })
            ->editColumn('paid', function ($eProviderPayout) {
                return getBooleanColumn($eProviderPayout, 'paid');
            })
            ->addColumn('action', 'e_provider_payouts.datatables_actions')
            ->rawColumns(array_merge($columns, ['action']));


        return $dataTable;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            [
                'data' => 'e_provider.name',
                'name' => 'eProvider.name',
                'title' => trans('lang.e_provider_payout_e_provider_id'),
            ],
            [
                'data' => 'method',
                'title' => trans('lang.e_provider_payout_method'),
            ],
            [
                'data' => 'amount',
                'title' => trans('lang.e_provider_payout_amount'),
            ],
            [
                'data' => 'paid_date',
                'name' => 'paidDate',
                'title' => trans('lang.e_provider_payout_paid_date'),
            ],
            [
                'data' => 'full_name',
                'title' => trans('lang.e_provider_payout_full_name'),
            ],
            [
                'data' => 'bank_name',
                'title' => trans('lang.e_provider_payout_bank_name'),
            ],
            [
                'data' => 'account_number',
                'title' => trans('lang.e_provider_payout_account_number'),
            ],
            [
                'data' => 'iban',
                'title' => trans('lang.e_provider_payout_iban'),
            ],
            [
                'data' => 'sort_code',
                'title' => trans('lang.e_provider_payout_sort_code'),
            ],
            [
                'data' => 'paid',
                'title' => trans('lang.e_provider_payout_paid'),
            ],
            [
                'data' => 'note',
                'title' => trans('lang.e_provider_payout_note'),
            ]
        ];

        $hasCustomField = in_array(EProviderPayout::class, setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFieldsCollection = CustomField::where('custom_field_model', EProviderPayout::class)->where('in_table', '=', true)->get();
            foreach ($customFieldsCollection as $key => $field) {
                array_splice($columns, $field->order - 1, 0, [[
                    'data' => 'custom_fields.' . $field->name . '.view',
                    'title' => trans('lang.e_provider_payout_' . $field->name),
                    'orderable' => false,
                    'searchable' => false,
                ]]);
            }
        }
        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param EProviderPayout $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EProviderPayout $model)
    {
        if (auth()->user()->hasRole('admin')) {
            return $model->newQuery()->with("eProvider")->select("$model->table.*");
        } else if (auth()->user()->hasRole('provider')) {
            return $model->newQuery()
                ->join("e_provider_users", "e_provider_users.e_provider_id", "=", "e_provider_payouts.e_provider_id")
                ->where('e_provider_users.user_id', auth()->id())
                ->with("eProvider")
                ->select("$model->table.*");
        } else {
            return $model->newQuery() ->with("eProvider")->select("$model->table.*");
        }
    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false, 'responsivePriority' => '100'])
            ->parameters(array_merge(
                config('datatables-buttons.parameters'), [
                    'language' => json_decode(
                        file_get_contents(base_path('resources/lang/' . app()->getLocale() . '/datatable.json')
                        ), true)
                ]
            ));
    }

    /**
     * Export PDF using DOMPDF
     * @return mixed
     */
    public function pdf()
    {
        $data = $this->getDataForPrint();
        $pdf = PDF::loadView($this->printPreview, compact('data'));
        return $pdf->download($this->filename() . '.pdf');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'e_provider_payoutsdatatable_' . time();
    }
}
