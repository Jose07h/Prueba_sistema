<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class comparativo_censo_luminariasPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Comparativo Censo Luminarias');
            $this->SetMenuLabel('Comparativo Censo Luminarias');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`comparativo_censo_luminarias`');
            $this->dataset->addFields(
                array(
                    new StringField('municipio'),
                    new IntegerField('total_luminarias_2021', false, true),
                    new IntegerField('subtotal_kw_2021', false, true),
                    new IntegerField('perdida_kw_2021', false, true),
                    new IntegerField('carga_kw_2021', false, true),
                    new IntegerField('cpd_2021', false, true),
                    new IntegerField('total_luminarias_2019', false, true),
                    new IntegerField('subtotal_kw_2019', false, true),
                    new IntegerField('perdida_kw_2019', false, true),
                    new IntegerField('carga_kw_2019', false, true),
                    new IntegerField('cpd_2019', false, true),
                    new IntegerField('diferencia_numero_luminarias', false, true),
                    new IntegerField('diferencia_subtotal', false, true),
                    new IntegerField('diferencia perdida', false, true),
                    new IntegerField('diferencia_carga_total', false, true),
                    new IntegerField('user_id', false, true)
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
            $chart = new Chart('Chart01', Chart::TYPE_COLUMN, $this->dataset);
            $chart->setTitle('');
            $chart->setHeight(300);
            $chart->setDomainColumn('municipio', 'municipio', 'string');
            $chart->addDataColumn('total_luminarias_2021', 'Luminarias 2021', 'int');
            $chart->addDataColumn('total_luminarias_2019', 'Luminarias 2019', 'float');
            $chart->addDataColumn('carga_kw_2021', 'Kw 2021', 'float');
            $chart->addDataColumn('carga_kw_2019', 'Kw 2019', 'float');
            $this->addChart($chart, 0, ChartPosition::BEFORE_GRID, 12);
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'municipio', 'municipio', 'Municipio'),
                new FilterColumn($this->dataset, 'total_luminarias_2021', 'total_luminarias_2021', 'Total Luminarias 2021'),
                new FilterColumn($this->dataset, 'subtotal_kw_2021', 'subtotal_kw_2021', 'Subtotal Kw 2021'),
                new FilterColumn($this->dataset, 'perdida_kw_2021', 'perdida_kw_2021', 'Perdida Kw 2021'),
                new FilterColumn($this->dataset, 'carga_kw_2021', 'carga_kw_2021', 'Carga Kw 2021'),
                new FilterColumn($this->dataset, 'cpd_2021', 'cpd_2021', 'Cpd 2021'),
                new FilterColumn($this->dataset, 'total_luminarias_2019', 'total_luminarias_2019', 'Total Luminarias 2019'),
                new FilterColumn($this->dataset, 'subtotal_kw_2019', 'subtotal_kw_2019', 'Subtotal Kw 2019'),
                new FilterColumn($this->dataset, 'perdida_kw_2019', 'perdida_kw_2019', 'Perdida Kw 2019'),
                new FilterColumn($this->dataset, 'carga_kw_2019', 'carga_kw_2019', 'Carga Kw 2019'),
                new FilterColumn($this->dataset, 'cpd_2019', 'cpd_2019', 'Cpd 2019'),
                new FilterColumn($this->dataset, 'diferencia_numero_luminarias', 'diferencia_numero_luminarias', 'Diferencia Numero Luminarias'),
                new FilterColumn($this->dataset, 'diferencia_subtotal', 'diferencia_subtotal', 'Diferencia Subtotal'),
                new FilterColumn($this->dataset, 'diferencia perdida', 'diferencia perdida', 'Diferencia Perdida'),
                new FilterColumn($this->dataset, 'diferencia_carga_total', 'diferencia_carga_total', 'Diferencia Carga Total'),
                new FilterColumn($this->dataset, 'user_id', 'user_id', 'User Id')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['municipio'])
                ->addColumn($columns['total_luminarias_2021'])
                ->addColumn($columns['subtotal_kw_2021'])
                ->addColumn($columns['perdida_kw_2021'])
                ->addColumn($columns['carga_kw_2021'])
                ->addColumn($columns['cpd_2021'])
                ->addColumn($columns['total_luminarias_2019'])
                ->addColumn($columns['subtotal_kw_2019'])
                ->addColumn($columns['perdida_kw_2019'])
                ->addColumn($columns['carga_kw_2019'])
                ->addColumn($columns['cpd_2019'])
                ->addColumn($columns['diferencia_numero_luminarias'])
                ->addColumn($columns['diferencia_subtotal'])
                ->addColumn($columns['diferencia perdida'])
                ->addColumn($columns['diferencia_carga_total']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('municipio');
            
            $filterBuilder->addColumn(
                $columns['municipio'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('total_luminarias_2021_edit');
            
            $filterBuilder->addColumn(
                $columns['total_luminarias_2021'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('subtotal_kw_2021_edit');
            
            $filterBuilder->addColumn(
                $columns['subtotal_kw_2021'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('perdida_kw_2021_edit');
            
            $filterBuilder->addColumn(
                $columns['perdida_kw_2021'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('carga_kw_2021_edit');
            
            $filterBuilder->addColumn(
                $columns['carga_kw_2021'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cpd_2021_edit');
            
            $filterBuilder->addColumn(
                $columns['cpd_2021'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('total_luminarias_2019_edit');
            
            $filterBuilder->addColumn(
                $columns['total_luminarias_2019'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('subtotal_kw_2019_edit');
            
            $filterBuilder->addColumn(
                $columns['subtotal_kw_2019'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('perdida_kw_2019_edit');
            
            $filterBuilder->addColumn(
                $columns['perdida_kw_2019'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('carga_kw_2019_edit');
            
            $filterBuilder->addColumn(
                $columns['carga_kw_2019'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('cpd_2019_edit');
            
            $filterBuilder->addColumn(
                $columns['cpd_2019'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('diferencia_numero_luminarias_edit');
            
            $filterBuilder->addColumn(
                $columns['diferencia_numero_luminarias'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('diferencia_subtotal_edit');
            
            $filterBuilder->addColumn(
                $columns['diferencia_subtotal'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('diferencia_perdida_edit');
            
            $filterBuilder->addColumn(
                $columns['diferencia perdida'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('diferencia_carga_total_edit');
            
            $filterBuilder->addColumn(
                $columns['diferencia_carga_total'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
    
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for total_luminarias_2021 field
            //
            $column = new NumberViewColumn('total_luminarias_2021', 'total_luminarias_2021', 'Total Luminarias 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for subtotal_kw_2021 field
            //
            $column = new NumberViewColumn('subtotal_kw_2021', 'subtotal_kw_2021', 'Subtotal Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for perdida_kw_2021 field
            //
            $column = new NumberViewColumn('perdida_kw_2021', 'perdida_kw_2021', 'Perdida Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for carga_kw_2021 field
            //
            $column = new NumberViewColumn('carga_kw_2021', 'carga_kw_2021', 'Carga Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for cpd_2021 field
            //
            $column = new NumberViewColumn('cpd_2021', 'cpd_2021', 'Cpd 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for total_luminarias_2019 field
            //
            $column = new NumberViewColumn('total_luminarias_2019', 'total_luminarias_2019', 'Total Luminarias 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for subtotal_kw_2019 field
            //
            $column = new NumberViewColumn('subtotal_kw_2019', 'subtotal_kw_2019', 'Subtotal Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for perdida_kw_2019 field
            //
            $column = new NumberViewColumn('perdida_kw_2019', 'perdida_kw_2019', 'Perdida Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for carga_kw_2019 field
            //
            $column = new NumberViewColumn('carga_kw_2019', 'carga_kw_2019', 'Carga Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for cpd_2019 field
            //
            $column = new NumberViewColumn('cpd_2019', 'cpd_2019', 'Cpd 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diferencia_numero_luminarias field
            //
            $column = new NumberViewColumn('diferencia_numero_luminarias', 'diferencia_numero_luminarias', 'Diferencia Numero Luminarias', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diferencia_subtotal field
            //
            $column = new NumberViewColumn('diferencia_subtotal', 'diferencia_subtotal', 'Diferencia Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diferencia perdida field
            //
            $column = new NumberViewColumn('diferencia perdida', 'diferencia perdida', 'Diferencia Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for diferencia_carga_total field
            //
            $column = new NumberViewColumn('diferencia_carga_total', 'diferencia_carga_total', 'Diferencia Carga Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for total_luminarias_2021 field
            //
            $column = new NumberViewColumn('total_luminarias_2021', 'total_luminarias_2021', 'Total Luminarias 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for subtotal_kw_2021 field
            //
            $column = new NumberViewColumn('subtotal_kw_2021', 'subtotal_kw_2021', 'Subtotal Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for perdida_kw_2021 field
            //
            $column = new NumberViewColumn('perdida_kw_2021', 'perdida_kw_2021', 'Perdida Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for carga_kw_2021 field
            //
            $column = new NumberViewColumn('carga_kw_2021', 'carga_kw_2021', 'Carga Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cpd_2021 field
            //
            $column = new NumberViewColumn('cpd_2021', 'cpd_2021', 'Cpd 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for total_luminarias_2019 field
            //
            $column = new NumberViewColumn('total_luminarias_2019', 'total_luminarias_2019', 'Total Luminarias 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for subtotal_kw_2019 field
            //
            $column = new NumberViewColumn('subtotal_kw_2019', 'subtotal_kw_2019', 'Subtotal Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for perdida_kw_2019 field
            //
            $column = new NumberViewColumn('perdida_kw_2019', 'perdida_kw_2019', 'Perdida Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for carga_kw_2019 field
            //
            $column = new NumberViewColumn('carga_kw_2019', 'carga_kw_2019', 'Carga Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cpd_2019 field
            //
            $column = new NumberViewColumn('cpd_2019', 'cpd_2019', 'Cpd 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diferencia_numero_luminarias field
            //
            $column = new NumberViewColumn('diferencia_numero_luminarias', 'diferencia_numero_luminarias', 'Diferencia Numero Luminarias', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diferencia_subtotal field
            //
            $column = new NumberViewColumn('diferencia_subtotal', 'diferencia_subtotal', 'Diferencia Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diferencia perdida field
            //
            $column = new NumberViewColumn('diferencia perdida', 'diferencia perdida', 'Diferencia Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for diferencia_carga_total field
            //
            $column = new NumberViewColumn('diferencia_carga_total', 'diferencia_carga_total', 'Diferencia Carga Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for municipio field
            //
            $editor = new TextAreaEdit('municipio_edit', 50, 8);
            $editColumn = new CustomEditColumn('Municipio', 'municipio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for total_luminarias_2021 field
            //
            $editor = new TextEdit('total_luminarias_2021_edit');
            $editColumn = new CustomEditColumn('Total Luminarias 2021', 'total_luminarias_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for subtotal_kw_2021 field
            //
            $editor = new TextEdit('subtotal_kw_2021_edit');
            $editColumn = new CustomEditColumn('Subtotal Kw 2021', 'subtotal_kw_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for perdida_kw_2021 field
            //
            $editor = new TextEdit('perdida_kw_2021_edit');
            $editColumn = new CustomEditColumn('Perdida Kw 2021', 'perdida_kw_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for carga_kw_2021 field
            //
            $editor = new TextEdit('carga_kw_2021_edit');
            $editColumn = new CustomEditColumn('Carga Kw 2021', 'carga_kw_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cpd_2021 field
            //
            $editor = new TextEdit('cpd_2021_edit');
            $editColumn = new CustomEditColumn('Cpd 2021', 'cpd_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for total_luminarias_2019 field
            //
            $editor = new TextEdit('total_luminarias_2019_edit');
            $editColumn = new CustomEditColumn('Total Luminarias 2019', 'total_luminarias_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for subtotal_kw_2019 field
            //
            $editor = new TextEdit('subtotal_kw_2019_edit');
            $editColumn = new CustomEditColumn('Subtotal Kw 2019', 'subtotal_kw_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for perdida_kw_2019 field
            //
            $editor = new TextEdit('perdida_kw_2019_edit');
            $editColumn = new CustomEditColumn('Perdida Kw 2019', 'perdida_kw_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for carga_kw_2019 field
            //
            $editor = new TextEdit('carga_kw_2019_edit');
            $editColumn = new CustomEditColumn('Carga Kw 2019', 'carga_kw_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cpd_2019 field
            //
            $editor = new TextEdit('cpd_2019_edit');
            $editColumn = new CustomEditColumn('Cpd 2019', 'cpd_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diferencia_numero_luminarias field
            //
            $editor = new TextEdit('diferencia_numero_luminarias_edit');
            $editColumn = new CustomEditColumn('Diferencia Numero Luminarias', 'diferencia_numero_luminarias', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diferencia_subtotal field
            //
            $editor = new TextEdit('diferencia_subtotal_edit');
            $editColumn = new CustomEditColumn('Diferencia Subtotal', 'diferencia_subtotal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diferencia perdida field
            //
            $editor = new TextEdit('diferencia_perdida_edit');
            $editColumn = new CustomEditColumn('Diferencia Perdida', 'diferencia perdida', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for diferencia_carga_total field
            //
            $editor = new TextEdit('diferencia_carga_total_edit');
            $editColumn = new CustomEditColumn('Diferencia Carga Total', 'diferencia_carga_total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for municipio field
            //
            $editor = new TextAreaEdit('municipio_edit', 50, 8);
            $editColumn = new CustomEditColumn('Municipio', 'municipio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for total_luminarias_2021 field
            //
            $editor = new TextEdit('total_luminarias_2021_edit');
            $editColumn = new CustomEditColumn('Total Luminarias 2021', 'total_luminarias_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for subtotal_kw_2021 field
            //
            $editor = new TextEdit('subtotal_kw_2021_edit');
            $editColumn = new CustomEditColumn('Subtotal Kw 2021', 'subtotal_kw_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for perdida_kw_2021 field
            //
            $editor = new TextEdit('perdida_kw_2021_edit');
            $editColumn = new CustomEditColumn('Perdida Kw 2021', 'perdida_kw_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for carga_kw_2021 field
            //
            $editor = new TextEdit('carga_kw_2021_edit');
            $editColumn = new CustomEditColumn('Carga Kw 2021', 'carga_kw_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cpd_2021 field
            //
            $editor = new TextEdit('cpd_2021_edit');
            $editColumn = new CustomEditColumn('Cpd 2021', 'cpd_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for total_luminarias_2019 field
            //
            $editor = new TextEdit('total_luminarias_2019_edit');
            $editColumn = new CustomEditColumn('Total Luminarias 2019', 'total_luminarias_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for subtotal_kw_2019 field
            //
            $editor = new TextEdit('subtotal_kw_2019_edit');
            $editColumn = new CustomEditColumn('Subtotal Kw 2019', 'subtotal_kw_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for perdida_kw_2019 field
            //
            $editor = new TextEdit('perdida_kw_2019_edit');
            $editColumn = new CustomEditColumn('Perdida Kw 2019', 'perdida_kw_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for carga_kw_2019 field
            //
            $editor = new TextEdit('carga_kw_2019_edit');
            $editColumn = new CustomEditColumn('Carga Kw 2019', 'carga_kw_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cpd_2019 field
            //
            $editor = new TextEdit('cpd_2019_edit');
            $editColumn = new CustomEditColumn('Cpd 2019', 'cpd_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for diferencia_numero_luminarias field
            //
            $editor = new TextEdit('diferencia_numero_luminarias_edit');
            $editColumn = new CustomEditColumn('Diferencia Numero Luminarias', 'diferencia_numero_luminarias', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for diferencia_subtotal field
            //
            $editor = new TextEdit('diferencia_subtotal_edit');
            $editColumn = new CustomEditColumn('Diferencia Subtotal', 'diferencia_subtotal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for diferencia perdida field
            //
            $editor = new TextEdit('diferencia_perdida_edit');
            $editColumn = new CustomEditColumn('Diferencia Perdida', 'diferencia perdida', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for diferencia_carga_total field
            //
            $editor = new TextEdit('diferencia_carga_total_edit');
            $editColumn = new CustomEditColumn('Diferencia Carga Total', 'diferencia_carga_total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for municipio field
            //
            $editor = new TextAreaEdit('municipio_edit', 50, 8);
            $editColumn = new CustomEditColumn('Municipio', 'municipio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for total_luminarias_2021 field
            //
            $editor = new TextEdit('total_luminarias_2021_edit');
            $editColumn = new CustomEditColumn('Total Luminarias 2021', 'total_luminarias_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for subtotal_kw_2021 field
            //
            $editor = new TextEdit('subtotal_kw_2021_edit');
            $editColumn = new CustomEditColumn('Subtotal Kw 2021', 'subtotal_kw_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for perdida_kw_2021 field
            //
            $editor = new TextEdit('perdida_kw_2021_edit');
            $editColumn = new CustomEditColumn('Perdida Kw 2021', 'perdida_kw_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for carga_kw_2021 field
            //
            $editor = new TextEdit('carga_kw_2021_edit');
            $editColumn = new CustomEditColumn('Carga Kw 2021', 'carga_kw_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cpd_2021 field
            //
            $editor = new TextEdit('cpd_2021_edit');
            $editColumn = new CustomEditColumn('Cpd 2021', 'cpd_2021', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for total_luminarias_2019 field
            //
            $editor = new TextEdit('total_luminarias_2019_edit');
            $editColumn = new CustomEditColumn('Total Luminarias 2019', 'total_luminarias_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for subtotal_kw_2019 field
            //
            $editor = new TextEdit('subtotal_kw_2019_edit');
            $editColumn = new CustomEditColumn('Subtotal Kw 2019', 'subtotal_kw_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for perdida_kw_2019 field
            //
            $editor = new TextEdit('perdida_kw_2019_edit');
            $editColumn = new CustomEditColumn('Perdida Kw 2019', 'perdida_kw_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for carga_kw_2019 field
            //
            $editor = new TextEdit('carga_kw_2019_edit');
            $editColumn = new CustomEditColumn('Carga Kw 2019', 'carga_kw_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cpd_2019 field
            //
            $editor = new TextEdit('cpd_2019_edit');
            $editColumn = new CustomEditColumn('Cpd 2019', 'cpd_2019', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diferencia_numero_luminarias field
            //
            $editor = new TextEdit('diferencia_numero_luminarias_edit');
            $editColumn = new CustomEditColumn('Diferencia Numero Luminarias', 'diferencia_numero_luminarias', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diferencia_subtotal field
            //
            $editor = new TextEdit('diferencia_subtotal_edit');
            $editColumn = new CustomEditColumn('Diferencia Subtotal', 'diferencia_subtotal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diferencia perdida field
            //
            $editor = new TextEdit('diferencia_perdida_edit');
            $editColumn = new CustomEditColumn('Diferencia Perdida', 'diferencia perdida', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for diferencia_carga_total field
            //
            $editor = new TextEdit('diferencia_carga_total_edit');
            $editColumn = new CustomEditColumn('Diferencia Carga Total', 'diferencia_carga_total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for total_luminarias_2021 field
            //
            $column = new NumberViewColumn('total_luminarias_2021', 'total_luminarias_2021', 'Total Luminarias 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for subtotal_kw_2021 field
            //
            $column = new NumberViewColumn('subtotal_kw_2021', 'subtotal_kw_2021', 'Subtotal Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for perdida_kw_2021 field
            //
            $column = new NumberViewColumn('perdida_kw_2021', 'perdida_kw_2021', 'Perdida Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for carga_kw_2021 field
            //
            $column = new NumberViewColumn('carga_kw_2021', 'carga_kw_2021', 'Carga Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cpd_2021 field
            //
            $column = new NumberViewColumn('cpd_2021', 'cpd_2021', 'Cpd 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for total_luminarias_2019 field
            //
            $column = new NumberViewColumn('total_luminarias_2019', 'total_luminarias_2019', 'Total Luminarias 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for subtotal_kw_2019 field
            //
            $column = new NumberViewColumn('subtotal_kw_2019', 'subtotal_kw_2019', 'Subtotal Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for perdida_kw_2019 field
            //
            $column = new NumberViewColumn('perdida_kw_2019', 'perdida_kw_2019', 'Perdida Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for carga_kw_2019 field
            //
            $column = new NumberViewColumn('carga_kw_2019', 'carga_kw_2019', 'Carga Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cpd_2019 field
            //
            $column = new NumberViewColumn('cpd_2019', 'cpd_2019', 'Cpd 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for diferencia_numero_luminarias field
            //
            $column = new NumberViewColumn('diferencia_numero_luminarias', 'diferencia_numero_luminarias', 'Diferencia Numero Luminarias', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for diferencia_subtotal field
            //
            $column = new NumberViewColumn('diferencia_subtotal', 'diferencia_subtotal', 'Diferencia Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for diferencia perdida field
            //
            $column = new NumberViewColumn('diferencia perdida', 'diferencia perdida', 'Diferencia Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for diferencia_carga_total field
            //
            $column = new NumberViewColumn('diferencia_carga_total', 'diferencia_carga_total', 'Diferencia Carga Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for total_luminarias_2021 field
            //
            $column = new NumberViewColumn('total_luminarias_2021', 'total_luminarias_2021', 'Total Luminarias 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for subtotal_kw_2021 field
            //
            $column = new NumberViewColumn('subtotal_kw_2021', 'subtotal_kw_2021', 'Subtotal Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for perdida_kw_2021 field
            //
            $column = new NumberViewColumn('perdida_kw_2021', 'perdida_kw_2021', 'Perdida Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for carga_kw_2021 field
            //
            $column = new NumberViewColumn('carga_kw_2021', 'carga_kw_2021', 'Carga Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for cpd_2021 field
            //
            $column = new NumberViewColumn('cpd_2021', 'cpd_2021', 'Cpd 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for total_luminarias_2019 field
            //
            $column = new NumberViewColumn('total_luminarias_2019', 'total_luminarias_2019', 'Total Luminarias 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for subtotal_kw_2019 field
            //
            $column = new NumberViewColumn('subtotal_kw_2019', 'subtotal_kw_2019', 'Subtotal Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for perdida_kw_2019 field
            //
            $column = new NumberViewColumn('perdida_kw_2019', 'perdida_kw_2019', 'Perdida Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for carga_kw_2019 field
            //
            $column = new NumberViewColumn('carga_kw_2019', 'carga_kw_2019', 'Carga Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for cpd_2019 field
            //
            $column = new NumberViewColumn('cpd_2019', 'cpd_2019', 'Cpd 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for diferencia_numero_luminarias field
            //
            $column = new NumberViewColumn('diferencia_numero_luminarias', 'diferencia_numero_luminarias', 'Diferencia Numero Luminarias', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for diferencia_subtotal field
            //
            $column = new NumberViewColumn('diferencia_subtotal', 'diferencia_subtotal', 'Diferencia Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for diferencia perdida field
            //
            $column = new NumberViewColumn('diferencia perdida', 'diferencia perdida', 'Diferencia Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for diferencia_carga_total field
            //
            $column = new NumberViewColumn('diferencia_carga_total', 'diferencia_carga_total', 'Diferencia Carga Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for total_luminarias_2021 field
            //
            $column = new NumberViewColumn('total_luminarias_2021', 'total_luminarias_2021', 'Total Luminarias 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for subtotal_kw_2021 field
            //
            $column = new NumberViewColumn('subtotal_kw_2021', 'subtotal_kw_2021', 'Subtotal Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for perdida_kw_2021 field
            //
            $column = new NumberViewColumn('perdida_kw_2021', 'perdida_kw_2021', 'Perdida Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for carga_kw_2021 field
            //
            $column = new NumberViewColumn('carga_kw_2021', 'carga_kw_2021', 'Carga Kw 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cpd_2021 field
            //
            $column = new NumberViewColumn('cpd_2021', 'cpd_2021', 'Cpd 2021', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for total_luminarias_2019 field
            //
            $column = new NumberViewColumn('total_luminarias_2019', 'total_luminarias_2019', 'Total Luminarias 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for subtotal_kw_2019 field
            //
            $column = new NumberViewColumn('subtotal_kw_2019', 'subtotal_kw_2019', 'Subtotal Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for perdida_kw_2019 field
            //
            $column = new NumberViewColumn('perdida_kw_2019', 'perdida_kw_2019', 'Perdida Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for carga_kw_2019 field
            //
            $column = new NumberViewColumn('carga_kw_2019', 'carga_kw_2019', 'Carga Kw 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cpd_2019 field
            //
            $column = new NumberViewColumn('cpd_2019', 'cpd_2019', 'Cpd 2019', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for diferencia_numero_luminarias field
            //
            $column = new NumberViewColumn('diferencia_numero_luminarias', 'diferencia_numero_luminarias', 'Diferencia Numero Luminarias', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for diferencia_subtotal field
            //
            $column = new NumberViewColumn('diferencia_subtotal', 'diferencia_subtotal', 'Diferencia Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for diferencia perdida field
            //
            $column = new NumberViewColumn('diferencia perdida', 'diferencia perdida', 'Diferencia Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for diferencia_carga_total field
            //
            $column = new NumberViewColumn('diferencia_carga_total', 'diferencia_carga_total', 'Diferencia Carga Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->setAllowSortingByClick(false);
            $result->setAllowSortingByDialog(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(false);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(false);
            $this->setAllowPrintSelectedRecords(false);
            $this->setOpenPrintFormInNewTab(false);
            $this->setExportListAvailable(array('pdf'));
            $this->setExportSelectedRecordsAvailable(array('pdf'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new comparativo_censo_luminariasPage("comparativo_censo_luminarias", "comparativo_censo_luminarias.php", GetCurrentUserPermissionsForPage("comparativo_censo_luminarias"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("comparativo_censo_luminarias"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
