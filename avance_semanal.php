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
    
    
    
    class avance_semanalPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Avance censadas semanal');
            $this->SetMenuLabel('Avance censadas semanal');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`avance_semanal`');
            $this->dataset->addFields(
                array(
                    new IntegerField('numero_semana_del_anio', true, true),
                    new DateField('fecha_inicio_semana_programada', true, true),
                    new DateField('fecha_final_semana_programada', true, true),
                    new IntegerField('eventos_programados', true, true),
                    new StringField('fecha_inicial_realizadas', false, true),
                    new StringField('fecha_final_realizadas', false, true),
                    new IntegerField('eventos_realizados', false, true),
                    new IntegerField('eventos_avance_vs_programa', false, true),
                    new IntegerField('porcentaje_de_avance', false, true)
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(100);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'numero_semana_del_anio', 'numero_semana_del_anio', 'Numero Semana Del Anio'),
                new FilterColumn($this->dataset, 'fecha_inicio_semana_programada', 'fecha_inicio_semana_programada', 'Fecha Inicio Semana Programada'),
                new FilterColumn($this->dataset, 'fecha_final_semana_programada', 'fecha_final_semana_programada', 'Fecha Final Semana Programada'),
                new FilterColumn($this->dataset, 'eventos_programados', 'eventos_programados', 'Eventos Programados'),
                new FilterColumn($this->dataset, 'fecha_inicial_realizadas', 'fecha_inicial_realizadas', 'Fecha Inicial Realizadas'),
                new FilterColumn($this->dataset, 'fecha_final_realizadas', 'fecha_final_realizadas', 'Fecha Final Realizadas'),
                new FilterColumn($this->dataset, 'eventos_realizados', 'eventos_realizados', 'Eventos Realizados'),
                new FilterColumn($this->dataset, 'eventos_avance_vs_programa', 'eventos_avance_vs_programa', 'Eventos Avance Vs Programa'),
                new FilterColumn($this->dataset, 'porcentaje_de_avance', 'porcentaje_de_avance', 'Porcentaje De Avance')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['numero_semana_del_anio'])
                ->addColumn($columns['fecha_inicio_semana_programada'])
                ->addColumn($columns['fecha_final_semana_programada'])
                ->addColumn($columns['eventos_programados'])
                ->addColumn($columns['fecha_inicial_realizadas'])
                ->addColumn($columns['fecha_final_realizadas'])
                ->addColumn($columns['eventos_realizados'])
                ->addColumn($columns['eventos_avance_vs_programa'])
                ->addColumn($columns['porcentaje_de_avance']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('numero_semana_del_anio')
                ->setOptionsFor('fecha_inicio_semana_programada')
                ->setOptionsFor('fecha_final_semana_programada')
                ->setOptionsFor('fecha_inicial_realizadas')
                ->setOptionsFor('fecha_final_realizadas');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
    
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for numero_semana_del_anio field
            //
            $column = new NumberViewColumn('numero_semana_del_anio', 'numero_semana_del_anio', 'Numero Semana Del Anio', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fecha_inicio_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_inicio_semana_programada', 'fecha_inicio_semana_programada', 'Fecha Inicio Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fecha_final_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_final_semana_programada', 'fecha_final_semana_programada', 'Fecha Final Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for eventos_programados field
            //
            $column = new NumberViewColumn('eventos_programados', 'eventos_programados', 'Eventos Programados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fecha_inicial_realizadas field
            //
            $column = new TextViewColumn('fecha_inicial_realizadas', 'fecha_inicial_realizadas', 'Fecha Inicial Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fecha_final_realizadas field
            //
            $column = new TextViewColumn('fecha_final_realizadas', 'fecha_final_realizadas', 'Fecha Final Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for eventos_realizados field
            //
            $column = new NumberViewColumn('eventos_realizados', 'eventos_realizados', 'Eventos Realizados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for eventos_avance_vs_programa field
            //
            $column = new NumberViewColumn('eventos_avance_vs_programa', 'eventos_avance_vs_programa', 'Eventos Avance Vs Programa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for porcentaje_de_avance field
            //
            $column = new NumberViewColumn('porcentaje_de_avance', 'porcentaje_de_avance', 'Porcentaje De Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
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
            // View column for numero_semana_del_anio field
            //
            $column = new NumberViewColumn('numero_semana_del_anio', 'numero_semana_del_anio', 'Numero Semana Del Anio', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_inicio_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_inicio_semana_programada', 'fecha_inicio_semana_programada', 'Fecha Inicio Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_final_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_final_semana_programada', 'fecha_final_semana_programada', 'Fecha Final Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for eventos_programados field
            //
            $column = new NumberViewColumn('eventos_programados', 'eventos_programados', 'Eventos Programados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_inicial_realizadas field
            //
            $column = new TextViewColumn('fecha_inicial_realizadas', 'fecha_inicial_realizadas', 'Fecha Inicial Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_final_realizadas field
            //
            $column = new TextViewColumn('fecha_final_realizadas', 'fecha_final_realizadas', 'Fecha Final Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for eventos_realizados field
            //
            $column = new NumberViewColumn('eventos_realizados', 'eventos_realizados', 'Eventos Realizados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for eventos_avance_vs_programa field
            //
            $column = new NumberViewColumn('eventos_avance_vs_programa', 'eventos_avance_vs_programa', 'Eventos Avance Vs Programa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for porcentaje_de_avance field
            //
            $column = new NumberViewColumn('porcentaje_de_avance', 'porcentaje_de_avance', 'Porcentaje De Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for numero_semana_del_anio field
            //
            $editor = new TextEdit('numero_semana_del_anio_edit');
            $editColumn = new CustomEditColumn('Numero Semana Del Anio', 'numero_semana_del_anio', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_inicio_semana_programada field
            //
            $editor = new DateTimeEdit('fecha_inicio_semana_programada_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha Inicio Semana Programada', 'fecha_inicio_semana_programada', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_final_semana_programada field
            //
            $editor = new DateTimeEdit('fecha_final_semana_programada_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha Final Semana Programada', 'fecha_final_semana_programada', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for eventos_programados field
            //
            $editor = new TextEdit('eventos_programados_edit');
            $editColumn = new CustomEditColumn('Eventos Programados', 'eventos_programados', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_inicial_realizadas field
            //
            $editor = new TextEdit('fecha_inicial_realizadas_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Fecha Inicial Realizadas', 'fecha_inicial_realizadas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_final_realizadas field
            //
            $editor = new TextEdit('fecha_final_realizadas_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Fecha Final Realizadas', 'fecha_final_realizadas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for eventos_realizados field
            //
            $editor = new TextEdit('eventos_realizados_edit');
            $editColumn = new CustomEditColumn('Eventos Realizados', 'eventos_realizados', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for eventos_avance_vs_programa field
            //
            $editor = new TextEdit('eventos_avance_vs_programa_edit');
            $editColumn = new CustomEditColumn('Eventos Avance Vs Programa', 'eventos_avance_vs_programa', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for porcentaje_de_avance field
            //
            $editor = new TextEdit('porcentaje_de_avance_edit');
            $editColumn = new CustomEditColumn('Porcentaje De Avance', 'porcentaje_de_avance', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for numero_semana_del_anio field
            //
            $editor = new TextEdit('numero_semana_del_anio_edit');
            $editColumn = new CustomEditColumn('Numero Semana Del Anio', 'numero_semana_del_anio', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_inicio_semana_programada field
            //
            $editor = new DateTimeEdit('fecha_inicio_semana_programada_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha Inicio Semana Programada', 'fecha_inicio_semana_programada', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_final_semana_programada field
            //
            $editor = new DateTimeEdit('fecha_final_semana_programada_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha Final Semana Programada', 'fecha_final_semana_programada', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for eventos_programados field
            //
            $editor = new TextEdit('eventos_programados_edit');
            $editColumn = new CustomEditColumn('Eventos Programados', 'eventos_programados', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_inicial_realizadas field
            //
            $editor = new TextEdit('fecha_inicial_realizadas_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Fecha Inicial Realizadas', 'fecha_inicial_realizadas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_final_realizadas field
            //
            $editor = new TextEdit('fecha_final_realizadas_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Fecha Final Realizadas', 'fecha_final_realizadas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for eventos_realizados field
            //
            $editor = new TextEdit('eventos_realizados_edit');
            $editColumn = new CustomEditColumn('Eventos Realizados', 'eventos_realizados', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for eventos_avance_vs_programa field
            //
            $editor = new TextEdit('eventos_avance_vs_programa_edit');
            $editColumn = new CustomEditColumn('Eventos Avance Vs Programa', 'eventos_avance_vs_programa', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for porcentaje_de_avance field
            //
            $editor = new TextEdit('porcentaje_de_avance_edit');
            $editColumn = new CustomEditColumn('Porcentaje De Avance', 'porcentaje_de_avance', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for numero_semana_del_anio field
            //
            $editor = new TextEdit('numero_semana_del_anio_edit');
            $editColumn = new CustomEditColumn('Numero Semana Del Anio', 'numero_semana_del_anio', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_inicio_semana_programada field
            //
            $editor = new DateTimeEdit('fecha_inicio_semana_programada_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha Inicio Semana Programada', 'fecha_inicio_semana_programada', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_final_semana_programada field
            //
            $editor = new DateTimeEdit('fecha_final_semana_programada_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha Final Semana Programada', 'fecha_final_semana_programada', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for eventos_programados field
            //
            $editor = new TextEdit('eventos_programados_edit');
            $editColumn = new CustomEditColumn('Eventos Programados', 'eventos_programados', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_inicial_realizadas field
            //
            $editor = new TextEdit('fecha_inicial_realizadas_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Fecha Inicial Realizadas', 'fecha_inicial_realizadas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_final_realizadas field
            //
            $editor = new TextEdit('fecha_final_realizadas_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Fecha Final Realizadas', 'fecha_final_realizadas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for eventos_realizados field
            //
            $editor = new TextEdit('eventos_realizados_edit');
            $editColumn = new CustomEditColumn('Eventos Realizados', 'eventos_realizados', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for eventos_avance_vs_programa field
            //
            $editor = new TextEdit('eventos_avance_vs_programa_edit');
            $editColumn = new CustomEditColumn('Eventos Avance Vs Programa', 'eventos_avance_vs_programa', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for porcentaje_de_avance field
            //
            $editor = new TextEdit('porcentaje_de_avance_edit');
            $editColumn = new CustomEditColumn('Porcentaje De Avance', 'porcentaje_de_avance', $editor, $this->dataset);
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
            // View column for numero_semana_del_anio field
            //
            $column = new NumberViewColumn('numero_semana_del_anio', 'numero_semana_del_anio', 'Numero Semana Del Anio', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_inicio_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_inicio_semana_programada', 'fecha_inicio_semana_programada', 'Fecha Inicio Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_final_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_final_semana_programada', 'fecha_final_semana_programada', 'Fecha Final Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for eventos_programados field
            //
            $column = new NumberViewColumn('eventos_programados', 'eventos_programados', 'Eventos Programados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_inicial_realizadas field
            //
            $column = new TextViewColumn('fecha_inicial_realizadas', 'fecha_inicial_realizadas', 'Fecha Inicial Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_final_realizadas field
            //
            $column = new TextViewColumn('fecha_final_realizadas', 'fecha_final_realizadas', 'Fecha Final Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for eventos_realizados field
            //
            $column = new NumberViewColumn('eventos_realizados', 'eventos_realizados', 'Eventos Realizados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for eventos_avance_vs_programa field
            //
            $column = new NumberViewColumn('eventos_avance_vs_programa', 'eventos_avance_vs_programa', 'Eventos Avance Vs Programa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for porcentaje_de_avance field
            //
            $column = new NumberViewColumn('porcentaje_de_avance', 'porcentaje_de_avance', 'Porcentaje De Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for numero_semana_del_anio field
            //
            $column = new NumberViewColumn('numero_semana_del_anio', 'numero_semana_del_anio', 'Numero Semana Del Anio', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_inicio_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_inicio_semana_programada', 'fecha_inicio_semana_programada', 'Fecha Inicio Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_final_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_final_semana_programada', 'fecha_final_semana_programada', 'Fecha Final Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for eventos_programados field
            //
            $column = new NumberViewColumn('eventos_programados', 'eventos_programados', 'Eventos Programados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_inicial_realizadas field
            //
            $column = new TextViewColumn('fecha_inicial_realizadas', 'fecha_inicial_realizadas', 'Fecha Inicial Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_final_realizadas field
            //
            $column = new TextViewColumn('fecha_final_realizadas', 'fecha_final_realizadas', 'Fecha Final Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for eventos_realizados field
            //
            $column = new NumberViewColumn('eventos_realizados', 'eventos_realizados', 'Eventos Realizados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for eventos_avance_vs_programa field
            //
            $column = new NumberViewColumn('eventos_avance_vs_programa', 'eventos_avance_vs_programa', 'Eventos Avance Vs Programa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for porcentaje_de_avance field
            //
            $column = new NumberViewColumn('porcentaje_de_avance', 'porcentaje_de_avance', 'Porcentaje De Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for numero_semana_del_anio field
            //
            $column = new NumberViewColumn('numero_semana_del_anio', 'numero_semana_del_anio', 'Numero Semana Del Anio', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_inicio_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_inicio_semana_programada', 'fecha_inicio_semana_programada', 'Fecha Inicio Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_final_semana_programada field
            //
            $column = new DateTimeViewColumn('fecha_final_semana_programada', 'fecha_final_semana_programada', 'Fecha Final Semana Programada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for eventos_programados field
            //
            $column = new NumberViewColumn('eventos_programados', 'eventos_programados', 'Eventos Programados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_inicial_realizadas field
            //
            $column = new TextViewColumn('fecha_inicial_realizadas', 'fecha_inicial_realizadas', 'Fecha Inicial Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_final_realizadas field
            //
            $column = new TextViewColumn('fecha_final_realizadas', 'fecha_final_realizadas', 'Fecha Final Realizadas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for eventos_realizados field
            //
            $column = new NumberViewColumn('eventos_realizados', 'eventos_realizados', 'Eventos Realizados', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for eventos_avance_vs_programa field
            //
            $column = new NumberViewColumn('eventos_avance_vs_programa', 'eventos_avance_vs_programa', 'Eventos Avance Vs Programa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for porcentaje_de_avance field
            //
            $column = new NumberViewColumn('porcentaje_de_avance', 'porcentaje_de_avance', 'Porcentaje De Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
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
            $defaultSortedColumns = array();
            $defaultSortedColumns[] = new SortColumn('numero_semana_del_anio', 'ASC');
            $result->setDefaultOrdering($defaultSortedColumns);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->SetShowUpdateLink(false);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
            $result->setIncludeAllFieldsForMultiEditByDefault(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            $result->setReloadPageAfterAjaxOperation(true);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
    
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
            $this->AddOperationsColumns($result);
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(false);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(false);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(false);
            $this->setAllowPrintSelectedRecords(false);
            $this->setOpenPrintFormInNewTab(false);
            $this->setExportListAvailable(array('pdf', 'excel'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array());
            $this->setOpenExportedPdfInNewTab(false);
            $this->setShowFormErrorsOnTop(true);
    
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
        $Page = new avance_semanalPage("avance_semanal", "avance_semanal.php", GetCurrentUserPermissionsForPage("avance_semanal"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("avance_semanal"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
