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
    
    
    
    class avancePage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Avance');
            $this->SetMenuLabel('Avance');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`avance`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_avance', true, true, true),
                    new StringField('municipio', true),
                    new IntegerField('user_id'),
                    new StringField('tarea', true),
                    new DateField('fecha_de_inicio', true),
                    new DateField('fecha_de_termino', true),
                    new IntegerField('porcentaje_completado_1_100', true)
                )
            );
            $this->dataset->AddLookupField('municipio', 'municipios', new StringField('nombre_municipio'), new StringField('nombre_municipio', false, false, false, false, 'municipio_nombre_municipio', 'municipio_nombre_municipio_municipios'), 'municipio_nombre_municipio_municipios');
            $this->dataset->AddLookupField('user_id', 'phpgen_users', new IntegerField('user_id'), new StringField('user_name', false, false, false, false, 'user_id_user_name', 'user_id_user_name_phpgen_users'), 'user_id_user_name_phpgen_users');
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
                new FilterColumn($this->dataset, 'id_avance', 'id_avance', 'Id Avance'),
                new FilterColumn($this->dataset, 'municipio', 'municipio_nombre_municipio', 'Municipio'),
                new FilterColumn($this->dataset, 'user_id', 'user_id_user_name', 'User Id'),
                new FilterColumn($this->dataset, 'tarea', 'tarea', 'Tarea'),
                new FilterColumn($this->dataset, 'fecha_de_inicio', 'fecha_de_inicio', 'Fecha De Inicio'),
                new FilterColumn($this->dataset, 'fecha_de_termino', 'fecha_de_termino', 'Fecha De Termino'),
                new FilterColumn($this->dataset, 'porcentaje_completado_1_100', 'porcentaje_completado_1_100', 'Porcentaje Completado 1 100')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_avance'])
                ->addColumn($columns['municipio'])
                ->addColumn($columns['user_id'])
                ->addColumn($columns['tarea'])
                ->addColumn($columns['fecha_de_inicio'])
                ->addColumn($columns['fecha_de_termino'])
                ->addColumn($columns['porcentaje_completado_1_100']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('municipio')
                ->setOptionsFor('user_id')
                ->setOptionsFor('tarea')
                ->setOptionsFor('fecha_de_inicio')
                ->setOptionsFor('fecha_de_termino');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_RIGHT);
            
            if ($this->GetSecurityInfo()->HasViewGrant()) {
            
                $operation = new AjaxOperation(OPERATION_VIEW,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetInlineGridViewHandler(), $grid, AjaxOperation::INLINE);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id_avance field
            //
            $column = new NumberViewColumn('id_avance', 'id_avance', 'Id Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nombre_municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio_nombre_municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('user_id', 'user_id_user_name', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tarea field
            //
            $column = new TextViewColumn('tarea', 'tarea', 'Tarea', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fecha_de_inicio field
            //
            $column = new DateTimeViewColumn('fecha_de_inicio', 'fecha_de_inicio', 'Fecha De Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fecha_de_termino field
            //
            $column = new DateTimeViewColumn('fecha_de_termino', 'fecha_de_termino', 'Fecha De Termino', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for porcentaje_completado_1_100 field
            //
            $column = new NumberViewColumn('porcentaje_completado_1_100', 'porcentaje_completado_1_100', 'Porcentaje Completado 1 100', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_avance field
            //
            $column = new NumberViewColumn('id_avance', 'id_avance', 'Id Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombre_municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio_nombre_municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('user_id', 'user_id_user_name', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tarea field
            //
            $column = new TextViewColumn('tarea', 'tarea', 'Tarea', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_de_inicio field
            //
            $column = new DateTimeViewColumn('fecha_de_inicio', 'fecha_de_inicio', 'Fecha De Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_de_termino field
            //
            $column = new DateTimeViewColumn('fecha_de_termino', 'fecha_de_termino', 'Fecha De Termino', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for porcentaje_completado_1_100 field
            //
            $column = new NumberViewColumn('porcentaje_completado_1_100', 'porcentaje_completado_1_100', 'Porcentaje Completado 1 100', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for municipio field
            //
            $editor = new DynamicCombobox('municipio_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`municipios`');
            $lookupDataset->addFields(
                array(
                    new StringField('nombre_municipio', true, true)
                )
            );
            $lookupDataset->setOrderByField('nombre_municipio', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Municipio', 'municipio', 'municipio_nombre_municipio', 'edit_avance_municipio_search', $editor, $this->dataset, $lookupDataset, 'nombre_municipio', 'nombre_municipio', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for user_id field
            //
            $editor = new DynamicCombobox('user_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('User Id', 'user_id', 'user_id_user_name', 'edit_avance_user_id_search', $editor, $this->dataset, $lookupDataset, 'user_id', 'user_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tarea field
            //
            $editor = new ComboBox('tarea_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('CENSO EN CAMPO TERMINADO', 'CENSO EN CAMPO TERMINADO');
            $editor->addChoice('CENSO CONCILIADO', 'CENSO CONCILIADO');
            $editColumn = new CustomEditColumn('Tarea', 'tarea', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_de_inicio field
            //
            $editor = new DateTimeEdit('fecha_de_inicio_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha De Inicio', 'fecha_de_inicio', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_de_termino field
            //
            $editor = new DateTimeEdit('fecha_de_termino_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha De Termino', 'fecha_de_termino', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for porcentaje_completado_1_100 field
            //
            $editor = new TextEdit('porcentaje_completado_1_100_edit');
            $editColumn = new CustomEditColumn('Porcentaje Completado 1 100', 'porcentaje_completado_1_100', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MaxValueValidator(100, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(0, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for municipio field
            //
            $editor = new DynamicCombobox('municipio_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`municipios`');
            $lookupDataset->addFields(
                array(
                    new StringField('nombre_municipio', true, true)
                )
            );
            $lookupDataset->setOrderByField('nombre_municipio', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Municipio', 'municipio', 'municipio_nombre_municipio', 'multi_edit_avance_municipio_search', $editor, $this->dataset, $lookupDataset, 'nombre_municipio', 'nombre_municipio', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for user_id field
            //
            $editor = new DynamicCombobox('user_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('User Id', 'user_id', 'user_id_user_name', 'multi_edit_avance_user_id_search', $editor, $this->dataset, $lookupDataset, 'user_id', 'user_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tarea field
            //
            $editor = new ComboBox('tarea_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('CENSO EN CAMPO TERMINADO', 'CENSO EN CAMPO TERMINADO');
            $editor->addChoice('CENSO CONCILIADO', 'CENSO CONCILIADO');
            $editColumn = new CustomEditColumn('Tarea', 'tarea', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_de_inicio field
            //
            $editor = new DateTimeEdit('fecha_de_inicio_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha De Inicio', 'fecha_de_inicio', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_de_termino field
            //
            $editor = new DateTimeEdit('fecha_de_termino_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha De Termino', 'fecha_de_termino', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for porcentaje_completado_1_100 field
            //
            $editor = new TextEdit('porcentaje_completado_1_100_edit');
            $editColumn = new CustomEditColumn('Porcentaje Completado 1 100', 'porcentaje_completado_1_100', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MaxValueValidator(100, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(0, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for municipio field
            //
            $editor = new DynamicCombobox('municipio_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`municipios`');
            $lookupDataset->addFields(
                array(
                    new StringField('nombre_municipio', true, true)
                )
            );
            $lookupDataset->setOrderByField('nombre_municipio', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Municipio', 'municipio', 'municipio_nombre_municipio', 'insert_avance_municipio_search', $editor, $this->dataset, $lookupDataset, 'nombre_municipio', 'nombre_municipio', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for user_id field
            //
            $editor = new DynamicCombobox('user_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $editColumn = new DynamicLookupEditColumn('User Id', 'user_id', 'user_id_user_name', 'insert_avance_user_id_search', $editor, $this->dataset, $lookupDataset, 'user_id', 'user_name', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tarea field
            //
            $editor = new ComboBox('tarea_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('CENSO EN CAMPO TERMINADO', 'CENSO EN CAMPO TERMINADO');
            $editor->addChoice('CENSO CONCILIADO', 'CENSO CONCILIADO');
            $editColumn = new CustomEditColumn('Tarea', 'tarea', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_de_inicio field
            //
            $editor = new DateTimeEdit('fecha_de_inicio_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha De Inicio', 'fecha_de_inicio', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_de_termino field
            //
            $editor = new DateTimeEdit('fecha_de_termino_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Fecha De Termino', 'fecha_de_termino', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for porcentaje_completado_1_100 field
            //
            $editor = new TextEdit('porcentaje_completado_1_100_edit');
            $editColumn = new CustomEditColumn('Porcentaje Completado 1 100', 'porcentaje_completado_1_100', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MaxValueValidator(100, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(0, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id_avance field
            //
            $column = new NumberViewColumn('id_avance', 'id_avance', 'Id Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombre_municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio_nombre_municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('user_id', 'user_id_user_name', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tarea field
            //
            $column = new TextViewColumn('tarea', 'tarea', 'Tarea', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_de_inicio field
            //
            $column = new DateTimeViewColumn('fecha_de_inicio', 'fecha_de_inicio', 'Fecha De Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_de_termino field
            //
            $column = new DateTimeViewColumn('fecha_de_termino', 'fecha_de_termino', 'Fecha De Termino', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for porcentaje_completado_1_100 field
            //
            $column = new NumberViewColumn('porcentaje_completado_1_100', 'porcentaje_completado_1_100', 'Porcentaje Completado 1 100', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_avance field
            //
            $column = new NumberViewColumn('id_avance', 'id_avance', 'Id Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nombre_municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio_nombre_municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('user_id', 'user_id_user_name', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for tarea field
            //
            $column = new TextViewColumn('tarea', 'tarea', 'Tarea', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_de_inicio field
            //
            $column = new DateTimeViewColumn('fecha_de_inicio', 'fecha_de_inicio', 'Fecha De Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_de_termino field
            //
            $column = new DateTimeViewColumn('fecha_de_termino', 'fecha_de_termino', 'Fecha De Termino', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for porcentaje_completado_1_100 field
            //
            $column = new NumberViewColumn('porcentaje_completado_1_100', 'porcentaje_completado_1_100', 'Porcentaje Completado 1 100', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for nombre_municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio_nombre_municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for user_name field
            //
            $column = new TextViewColumn('user_id', 'user_id_user_name', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tarea field
            //
            $column = new TextViewColumn('tarea', 'tarea', 'Tarea', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_de_inicio field
            //
            $column = new DateTimeViewColumn('fecha_de_inicio', 'fecha_de_inicio', 'Fecha De Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_de_termino field
            //
            $column = new DateTimeViewColumn('fecha_de_termino', 'fecha_de_termino', 'Fecha De Termino', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for porcentaje_completado_1_100 field
            //
            $column = new NumberViewColumn('porcentaje_completado_1_100', 'porcentaje_completado_1_100', 'Porcentaje Completado 1 100', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
        public function GetEnableInlineSingleRecordView() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
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
            $this->setExportListAvailable(array('excel'));
            $this->setExportSelectedRecordsAvailable(array('excel'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array());
            $this->setOpenExportedPdfInNewTab(false);
            $this->setShowFormErrorsOnTop(true);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`municipios`');
            $lookupDataset->addFields(
                array(
                    new StringField('nombre_municipio', true, true)
                )
            );
            $lookupDataset->setOrderByField('nombre_municipio', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_avance_municipio_search', 'nombre_municipio', 'nombre_municipio', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_avance_user_id_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`municipios`');
            $lookupDataset->addFields(
                array(
                    new StringField('nombre_municipio', true, true)
                )
            );
            $lookupDataset->setOrderByField('nombre_municipio', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_avance_municipio_search', 'nombre_municipio', 'nombre_municipio', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_avance_user_id_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`municipios`');
            $lookupDataset->addFields(
                array(
                    new StringField('nombre_municipio', true, true)
                )
            );
            $lookupDataset->setOrderByField('nombre_municipio', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_avance_municipio_search', 'nombre_municipio', 'nombre_municipio', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`phpgen_users`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('user_id', true, true, true),
                    new StringField('user_name', true),
                    new StringField('user_password', true),
                    new StringField('user_email', true),
                    new StringField('user_token'),
                    new IntegerField('user_status', true)
                )
            );
            $lookupDataset->setOrderByField('user_name', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_avance_user_id_search', 'user_id', 'user_name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
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
        $Page = new avancePage("avance", "avance.php", GetCurrentUserPermissionsForPage("avance"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("avance"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
