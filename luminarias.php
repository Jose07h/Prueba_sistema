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
    
    
    
    class luminariasPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Conciliacion por luminaria');
            $this->SetMenuLabel('Conciliacion por luminaria');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`luminarias`');
            $this->dataset->addFields(
                array(
                    new StringField('id', true, true),
                    new DateTimeField('fecha'),
                    new StringField('hora'),
                    new StringField('operador'),
                    new StringField('coordenadas'),
                    new StringField('estado_poste'),
                    new StringField('tipo_carcaza'),
                    new StringField('horas_uso'),
                    new IntegerField('numero_de_lamparas'),
                    new StringField('municipio'),
                    new StringField('colonia'),
                    new StringField('calle'),
                    new StringField('tipo_de_calle'),
                    new StringField('via'),
                    new StringField('numero_de_medidor'),
                    new StringField('carga_aceptada'),
                    new StringField('tipo_poste'),
                    new StringField('estado_luminaria'),
                    new StringField('observaciones'),
                    new StringField('tipo_de_luminaria'),
                    new StringField('fotografia'),
                    new StringField('fotografia_2'),
                    new IntegerField('conciliada'),
                    new IntegerField('user_id')
                )
            );
            $this->dataset->AddLookupField('tipo_de_luminaria', 'tipos_luminarias', new StringField('tipo_de_luminaria'), new IntegerField('watts', false, false, false, false, 'tipo_de_luminaria_watts', 'tipo_de_luminaria_watts_tipos_luminarias'), 'tipo_de_luminaria_watts_tipos_luminarias');
            if (!$this->GetSecurityInfo()->HasAdminGrant()) {
                $this->dataset->setRlsPolicy(new RlsPolicy('user_id', GetApplication()->GetCurrentUserId()));
            }
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
                new FilterColumn($this->dataset, 'conciliada', 'conciliada', 'Conciliada'),
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'fecha', 'fecha', 'Fecha'),
                new FilterColumn($this->dataset, 'hora', 'hora', 'Hora'),
                new FilterColumn($this->dataset, 'operador', 'operador', 'Operador'),
                new FilterColumn($this->dataset, 'coordenadas', 'coordenadas', 'Coordenadas'),
                new FilterColumn($this->dataset, 'estado_poste', 'estado_poste', 'Estado Poste'),
                new FilterColumn($this->dataset, 'tipo_carcaza', 'tipo_carcaza', 'Tipo Carcaza'),
                new FilterColumn($this->dataset, 'horas_uso', 'horas_uso', 'Horas Uso'),
                new FilterColumn($this->dataset, 'numero_de_lamparas', 'numero_de_lamparas', 'Numero De Lamparas'),
                new FilterColumn($this->dataset, 'municipio', 'municipio', 'Municipio'),
                new FilterColumn($this->dataset, 'colonia', 'colonia', 'Colonia'),
                new FilterColumn($this->dataset, 'calle', 'calle', 'Calle'),
                new FilterColumn($this->dataset, 'tipo_de_calle', 'tipo_de_calle', 'Tipo De Calle'),
                new FilterColumn($this->dataset, 'via', 'via', 'Via'),
                new FilterColumn($this->dataset, 'numero_de_medidor', 'numero_de_medidor', 'Numero De Medidor'),
                new FilterColumn($this->dataset, 'carga_aceptada', 'carga_aceptada', 'Carga Aceptada'),
                new FilterColumn($this->dataset, 'tipo_poste', 'tipo_poste', 'Tipo Poste'),
                new FilterColumn($this->dataset, 'estado_luminaria', 'estado_luminaria', 'Estado Luminaria'),
                new FilterColumn($this->dataset, 'observaciones', 'observaciones', 'Observaciones'),
                new FilterColumn($this->dataset, 'tipo_de_luminaria', 'tipo_de_luminaria_watts', 'Tipo De Luminaria'),
                new FilterColumn($this->dataset, 'fotografia', 'fotografia', 'Fotografia'),
                new FilterColumn($this->dataset, 'fotografia_2', 'fotografia_2', 'Fotografia 2'),
                new FilterColumn($this->dataset, 'user_id', 'user_id', 'User Id')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['conciliada'])
                ->addColumn($columns['id'])
                ->addColumn($columns['fecha'])
                ->addColumn($columns['hora'])
                ->addColumn($columns['operador'])
                ->addColumn($columns['coordenadas'])
                ->addColumn($columns['estado_poste'])
                ->addColumn($columns['tipo_carcaza'])
                ->addColumn($columns['horas_uso'])
                ->addColumn($columns['numero_de_lamparas'])
                ->addColumn($columns['municipio'])
                ->addColumn($columns['colonia'])
                ->addColumn($columns['calle'])
                ->addColumn($columns['tipo_de_calle'])
                ->addColumn($columns['via'])
                ->addColumn($columns['numero_de_medidor'])
                ->addColumn($columns['carga_aceptada'])
                ->addColumn($columns['tipo_poste'])
                ->addColumn($columns['estado_luminaria'])
                ->addColumn($columns['observaciones'])
                ->addColumn($columns['tipo_de_luminaria'])
                ->addColumn($columns['fotografia'])
                ->addColumn($columns['fotografia_2'])
                ->addColumn($columns['user_id']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('conciliada')
                ->setOptionsFor('fecha')
                ->setOptionsFor('estado_poste')
                ->setOptionsFor('tipo_carcaza')
                ->setOptionsFor('horas_uso')
                ->setOptionsFor('municipio')
                ->setOptionsFor('colonia')
                ->setOptionsFor('tipo_de_calle')
                ->setOptionsFor('via')
                ->setOptionsFor('carga_aceptada')
                ->setOptionsFor('tipo_poste')
                ->setOptionsFor('estado_luminaria')
                ->setOptionsFor('tipo_de_luminaria');
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
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid, AjaxOperation::INLINE);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for conciliada field
            //
            $column = new CheckboxViewColumn('conciliada', 'conciliada', 'Conciliada', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('center');
            $column->setDisplayValues('<input type="checkbox" onclick="return false;" checked="checked">', '<input type="checkbox" onclick="return false;">');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fecha field
            //
            $column = new DateTimeViewColumn('fecha', 'fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for hora field
            //
            $column = new TextViewColumn('hora', 'hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for operador field
            //
            $column = new TextViewColumn('operador', 'operador', 'Operador', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for coordenadas field
            //
            $column = new TextViewColumn('coordenadas', 'coordenadas', 'Coordenadas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for estado_poste field
            //
            $column = new TextViewColumn('estado_poste', 'estado_poste', 'Estado Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tipo_carcaza field
            //
            $column = new TextViewColumn('tipo_carcaza', 'tipo_carcaza', 'Tipo Carcaza', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for horas_uso field
            //
            $column = new TextViewColumn('horas_uso', 'horas_uso', 'Horas Uso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for numero_de_lamparas field
            //
            $column = new NumberViewColumn('numero_de_lamparas', 'numero_de_lamparas', 'Numero De Lamparas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for colonia field
            //
            $column = new TextViewColumn('colonia', 'colonia', 'Colonia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for calle field
            //
            $column = new TextViewColumn('calle', 'calle', 'Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tipo_de_calle field
            //
            $column = new TextViewColumn('tipo_de_calle', 'tipo_de_calle', 'Tipo De Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for via field
            //
            $column = new TextViewColumn('via', 'via', 'Via', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for numero_de_medidor field
            //
            $column = new TextViewColumn('numero_de_medidor', 'numero_de_medidor', 'Numero De Medidor', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for carga_aceptada field
            //
            $column = new TextViewColumn('carga_aceptada', 'carga_aceptada', 'Carga Aceptada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tipo_poste field
            //
            $column = new TextViewColumn('tipo_poste', 'tipo_poste', 'Tipo Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for estado_luminaria field
            //
            $column = new TextViewColumn('estado_luminaria', 'estado_luminaria', 'Estado Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('tipo_de_luminaria', 'tipo_de_luminaria_watts', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fotografia_2 field
            //
            $column = new TextViewColumn('fotografia_2', 'fotografia_2', 'Fotografia 2', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for user_id field
            //
            $column = new NumberViewColumn('user_id', 'user_id', 'User Id', $this->dataset);
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
            // View column for conciliada field
            //
            $column = new CheckboxViewColumn('conciliada', 'conciliada', 'Conciliada', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<input type="checkbox" onclick="return false;" checked="checked">', '<input type="checkbox" onclick="return false;">');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha field
            //
            $column = new DateTimeViewColumn('fecha', 'fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for hora field
            //
            $column = new TextViewColumn('hora', 'hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for operador field
            //
            $column = new TextViewColumn('operador', 'operador', 'Operador', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for coordenadas field
            //
            $column = new TextViewColumn('coordenadas', 'coordenadas', 'Coordenadas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for estado_poste field
            //
            $column = new TextViewColumn('estado_poste', 'estado_poste', 'Estado Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipo_carcaza field
            //
            $column = new TextViewColumn('tipo_carcaza', 'tipo_carcaza', 'Tipo Carcaza', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for horas_uso field
            //
            $column = new TextViewColumn('horas_uso', 'horas_uso', 'Horas Uso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for numero_de_lamparas field
            //
            $column = new NumberViewColumn('numero_de_lamparas', 'numero_de_lamparas', 'Numero De Lamparas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for colonia field
            //
            $column = new TextViewColumn('colonia', 'colonia', 'Colonia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for calle field
            //
            $column = new TextViewColumn('calle', 'calle', 'Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipo_de_calle field
            //
            $column = new TextViewColumn('tipo_de_calle', 'tipo_de_calle', 'Tipo De Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for via field
            //
            $column = new TextViewColumn('via', 'via', 'Via', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for numero_de_medidor field
            //
            $column = new TextViewColumn('numero_de_medidor', 'numero_de_medidor', 'Numero De Medidor', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for carga_aceptada field
            //
            $column = new TextViewColumn('carga_aceptada', 'carga_aceptada', 'Carga Aceptada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipo_poste field
            //
            $column = new TextViewColumn('tipo_poste', 'tipo_poste', 'Tipo Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for estado_luminaria field
            //
            $column = new TextViewColumn('estado_luminaria', 'estado_luminaria', 'Estado Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('tipo_de_luminaria', 'tipo_de_luminaria_watts', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fotografia_2 field
            //
            $column = new TextViewColumn('fotografia_2', 'fotografia_2', 'Fotografia 2', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for user_id field
            //
            $column = new NumberViewColumn('user_id', 'user_id', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for conciliada field
            //
            $editor = new CheckBox('conciliada_edit');
            $editColumn = new CustomEditColumn('Conciliada', 'conciliada', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha field
            //
            $editor = new DateTimeEdit('fecha_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Fecha', 'fecha', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hora field
            //
            $editor = new TextEdit('hora_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Hora', 'hora', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for operador field
            //
            $editor = new TextEdit('operador_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Operador', 'operador', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for coordenadas field
            //
            $editor = new TextEdit('coordenadas_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Coordenadas', 'coordenadas', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for estado_poste field
            //
            $editor = new TextEdit('estado_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Poste', 'estado_poste', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_carcaza field
            //
            $editor = new TextEdit('tipo_carcaza_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Carcaza', 'tipo_carcaza', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for horas_uso field
            //
            $editor = new TextEdit('horas_uso_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Horas Uso', 'horas_uso', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for numero_de_lamparas field
            //
            $editor = new TextEdit('numero_de_lamparas_edit');
            $editColumn = new CustomEditColumn('Numero De Lamparas', 'numero_de_lamparas', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for municipio field
            //
            $editor = new TextEdit('municipio_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Municipio', 'municipio', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for colonia field
            //
            $editor = new TextEdit('colonia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Colonia', 'colonia', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for calle field
            //
            $editor = new TextEdit('calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Calle', 'calle', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_de_calle field
            //
            $editor = new TextEdit('tipo_de_calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo De Calle', 'tipo_de_calle', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for via field
            //
            $editor = new TextEdit('via_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Via', 'via', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for numero_de_medidor field
            //
            $editor = new TextEdit('numero_de_medidor_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Numero De Medidor', 'numero_de_medidor', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for carga_aceptada field
            //
            $editor = new TextEdit('carga_aceptada_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Carga Aceptada', 'carga_aceptada', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_poste field
            //
            $editor = new TextEdit('tipo_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Poste', 'tipo_poste', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for estado_luminaria field
            //
            $editor = new TextEdit('estado_luminaria_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Luminaria', 'estado_luminaria', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for observaciones field
            //
            $editor = new TextEdit('observaciones_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Observaciones', 'observaciones', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_de_luminaria field
            //
            $editor = new DynamicCombobox('tipo_de_luminaria_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_luminarias`');
            $lookupDataset->addFields(
                array(
                    new StringField('tipo_de_luminaria', true, true),
                    new IntegerField('watts'),
                    new StringField('balastro'),
                    new IntegerField('porcbal'),
                    new StringField('grupo_reporte'),
                    new StringField('tipo_balastro')
                )
            );
            $lookupDataset->setOrderByField('watts', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Tipo De Luminaria', 'tipo_de_luminaria', 'tipo_de_luminaria_watts', 'edit_luminarias_tipo_de_luminaria_search', $editor, $this->dataset, $lookupDataset, 'tipo_de_luminaria', 'watts', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fotografia field
            //
            $editor = new TextEdit('fotografia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia', 'fotografia', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fotografia_2 field
            //
            $editor = new TextEdit('fotografia_2_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia 2', 'fotografia_2', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for user_id field
            //
            $editor = new TextEdit('user_id_edit');
            $editColumn = new CustomEditColumn('User Id', 'user_id', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for conciliada field
            //
            $editor = new CheckBox('conciliada_edit');
            $editColumn = new CustomEditColumn('Conciliada', 'conciliada', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha field
            //
            $editor = new DateTimeEdit('fecha_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Fecha', 'fecha', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for hora field
            //
            $editor = new TextEdit('hora_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Hora', 'hora', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for operador field
            //
            $editor = new TextEdit('operador_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Operador', 'operador', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for coordenadas field
            //
            $editor = new TextEdit('coordenadas_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Coordenadas', 'coordenadas', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for estado_poste field
            //
            $editor = new TextEdit('estado_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Poste', 'estado_poste', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_carcaza field
            //
            $editor = new TextEdit('tipo_carcaza_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Carcaza', 'tipo_carcaza', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for horas_uso field
            //
            $editor = new TextEdit('horas_uso_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Horas Uso', 'horas_uso', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for numero_de_lamparas field
            //
            $editor = new TextEdit('numero_de_lamparas_edit');
            $editColumn = new CustomEditColumn('Numero De Lamparas', 'numero_de_lamparas', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for municipio field
            //
            $editor = new TextEdit('municipio_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Municipio', 'municipio', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for colonia field
            //
            $editor = new TextEdit('colonia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Colonia', 'colonia', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for calle field
            //
            $editor = new TextEdit('calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Calle', 'calle', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_de_calle field
            //
            $editor = new TextEdit('tipo_de_calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo De Calle', 'tipo_de_calle', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for via field
            //
            $editor = new TextEdit('via_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Via', 'via', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for numero_de_medidor field
            //
            $editor = new TextEdit('numero_de_medidor_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Numero De Medidor', 'numero_de_medidor', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for carga_aceptada field
            //
            $editor = new TextEdit('carga_aceptada_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Carga Aceptada', 'carga_aceptada', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_poste field
            //
            $editor = new TextEdit('tipo_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Poste', 'tipo_poste', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for estado_luminaria field
            //
            $editor = new TextEdit('estado_luminaria_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Luminaria', 'estado_luminaria', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for observaciones field
            //
            $editor = new TextEdit('observaciones_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Observaciones', 'observaciones', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_de_luminaria field
            //
            $editor = new DynamicCombobox('tipo_de_luminaria_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_luminarias`');
            $lookupDataset->addFields(
                array(
                    new StringField('tipo_de_luminaria', true, true),
                    new IntegerField('watts'),
                    new StringField('balastro'),
                    new IntegerField('porcbal'),
                    new StringField('grupo_reporte'),
                    new StringField('tipo_balastro')
                )
            );
            $lookupDataset->setOrderByField('watts', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Tipo De Luminaria', 'tipo_de_luminaria', 'tipo_de_luminaria_watts', 'multi_edit_luminarias_tipo_de_luminaria_search', $editor, $this->dataset, $lookupDataset, 'tipo_de_luminaria', 'watts', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fotografia field
            //
            $editor = new TextEdit('fotografia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia', 'fotografia', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fotografia_2 field
            //
            $editor = new TextEdit('fotografia_2_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia 2', 'fotografia_2', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for user_id field
            //
            $editor = new TextEdit('user_id_edit');
            $editColumn = new CustomEditColumn('User Id', 'user_id', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for conciliada field
            //
            $editor = new CheckBox('conciliada_edit');
            $editColumn = new CustomEditColumn('Conciliada', 'conciliada', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id field
            //
            $editor = new TextEdit('id_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Id', 'id', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha field
            //
            $editor = new DateTimeEdit('fecha_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Fecha', 'fecha', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hora field
            //
            $editor = new TextEdit('hora_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Hora', 'hora', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for operador field
            //
            $editor = new TextEdit('operador_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Operador', 'operador', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for coordenadas field
            //
            $editor = new TextEdit('coordenadas_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Coordenadas', 'coordenadas', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for estado_poste field
            //
            $editor = new TextEdit('estado_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Poste', 'estado_poste', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_carcaza field
            //
            $editor = new TextEdit('tipo_carcaza_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Carcaza', 'tipo_carcaza', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for horas_uso field
            //
            $editor = new TextEdit('horas_uso_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Horas Uso', 'horas_uso', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for numero_de_lamparas field
            //
            $editor = new TextEdit('numero_de_lamparas_edit');
            $editColumn = new CustomEditColumn('Numero De Lamparas', 'numero_de_lamparas', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for municipio field
            //
            $editor = new TextEdit('municipio_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Municipio', 'municipio', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for colonia field
            //
            $editor = new TextEdit('colonia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Colonia', 'colonia', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for calle field
            //
            $editor = new TextEdit('calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Calle', 'calle', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_de_calle field
            //
            $editor = new TextEdit('tipo_de_calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo De Calle', 'tipo_de_calle', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for via field
            //
            $editor = new TextEdit('via_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Via', 'via', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for numero_de_medidor field
            //
            $editor = new TextEdit('numero_de_medidor_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Numero De Medidor', 'numero_de_medidor', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for carga_aceptada field
            //
            $editor = new TextEdit('carga_aceptada_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Carga Aceptada', 'carga_aceptada', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_poste field
            //
            $editor = new TextEdit('tipo_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Poste', 'tipo_poste', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for estado_luminaria field
            //
            $editor = new TextEdit('estado_luminaria_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Luminaria', 'estado_luminaria', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for observaciones field
            //
            $editor = new TextEdit('observaciones_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Observaciones', 'observaciones', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_de_luminaria field
            //
            $editor = new DynamicCombobox('tipo_de_luminaria_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_luminarias`');
            $lookupDataset->addFields(
                array(
                    new StringField('tipo_de_luminaria', true, true),
                    new IntegerField('watts'),
                    new StringField('balastro'),
                    new IntegerField('porcbal'),
                    new StringField('grupo_reporte'),
                    new StringField('tipo_balastro')
                )
            );
            $lookupDataset->setOrderByField('watts', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Tipo De Luminaria', 'tipo_de_luminaria', 'tipo_de_luminaria_watts', 'insert_luminarias_tipo_de_luminaria_search', $editor, $this->dataset, $lookupDataset, 'tipo_de_luminaria', 'watts', '');
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fotografia field
            //
            $editor = new TextEdit('fotografia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia', 'fotografia', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fotografia_2 field
            //
            $editor = new TextEdit('fotografia_2_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia 2', 'fotografia_2', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for user_id field
            //
            $editor = new TextEdit('user_id_edit');
            $editColumn = new CustomEditColumn('User Id', 'user_id', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
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
            // View column for conciliada field
            //
            $column = new CheckboxViewColumn('conciliada', 'conciliada', 'Conciliada', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('center');
            $column->setDisplayValues('<input type="checkbox" onclick="return false;" checked="checked">', '<input type="checkbox" onclick="return false;">');
            $grid->AddPrintColumn($column);
            
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha field
            //
            $column = new DateTimeViewColumn('fecha', 'fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for hora field
            //
            $column = new TextViewColumn('hora', 'hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for operador field
            //
            $column = new TextViewColumn('operador', 'operador', 'Operador', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for coordenadas field
            //
            $column = new TextViewColumn('coordenadas', 'coordenadas', 'Coordenadas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for estado_poste field
            //
            $column = new TextViewColumn('estado_poste', 'estado_poste', 'Estado Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipo_carcaza field
            //
            $column = new TextViewColumn('tipo_carcaza', 'tipo_carcaza', 'Tipo Carcaza', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for horas_uso field
            //
            $column = new TextViewColumn('horas_uso', 'horas_uso', 'Horas Uso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for numero_de_lamparas field
            //
            $column = new NumberViewColumn('numero_de_lamparas', 'numero_de_lamparas', 'Numero De Lamparas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for colonia field
            //
            $column = new TextViewColumn('colonia', 'colonia', 'Colonia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for calle field
            //
            $column = new TextViewColumn('calle', 'calle', 'Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipo_de_calle field
            //
            $column = new TextViewColumn('tipo_de_calle', 'tipo_de_calle', 'Tipo De Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for via field
            //
            $column = new TextViewColumn('via', 'via', 'Via', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for numero_de_medidor field
            //
            $column = new TextViewColumn('numero_de_medidor', 'numero_de_medidor', 'Numero De Medidor', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for carga_aceptada field
            //
            $column = new TextViewColumn('carga_aceptada', 'carga_aceptada', 'Carga Aceptada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipo_poste field
            //
            $column = new TextViewColumn('tipo_poste', 'tipo_poste', 'Tipo Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for estado_luminaria field
            //
            $column = new TextViewColumn('estado_luminaria', 'estado_luminaria', 'Estado Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('tipo_de_luminaria', 'tipo_de_luminaria_watts', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fotografia_2 field
            //
            $column = new TextViewColumn('fotografia_2', 'fotografia_2', 'Fotografia 2', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for user_id field
            //
            $column = new NumberViewColumn('user_id', 'user_id', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for conciliada field
            //
            $column = new CheckboxViewColumn('conciliada', 'conciliada', 'Conciliada', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('center');
            $column->setDisplayValues('<input type="checkbox" onclick="return false;" checked="checked">', '<input type="checkbox" onclick="return false;">');
            $grid->AddExportColumn($column);
            
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha field
            //
            $column = new DateTimeViewColumn('fecha', 'fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for hora field
            //
            $column = new TextViewColumn('hora', 'hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for operador field
            //
            $column = new TextViewColumn('operador', 'operador', 'Operador', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for coordenadas field
            //
            $column = new TextViewColumn('coordenadas', 'coordenadas', 'Coordenadas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for estado_poste field
            //
            $column = new TextViewColumn('estado_poste', 'estado_poste', 'Estado Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for tipo_carcaza field
            //
            $column = new TextViewColumn('tipo_carcaza', 'tipo_carcaza', 'Tipo Carcaza', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for horas_uso field
            //
            $column = new TextViewColumn('horas_uso', 'horas_uso', 'Horas Uso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for numero_de_lamparas field
            //
            $column = new NumberViewColumn('numero_de_lamparas', 'numero_de_lamparas', 'Numero De Lamparas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for colonia field
            //
            $column = new TextViewColumn('colonia', 'colonia', 'Colonia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for calle field
            //
            $column = new TextViewColumn('calle', 'calle', 'Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for tipo_de_calle field
            //
            $column = new TextViewColumn('tipo_de_calle', 'tipo_de_calle', 'Tipo De Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for via field
            //
            $column = new TextViewColumn('via', 'via', 'Via', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for numero_de_medidor field
            //
            $column = new TextViewColumn('numero_de_medidor', 'numero_de_medidor', 'Numero De Medidor', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for carga_aceptada field
            //
            $column = new TextViewColumn('carga_aceptada', 'carga_aceptada', 'Carga Aceptada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for tipo_poste field
            //
            $column = new TextViewColumn('tipo_poste', 'tipo_poste', 'Tipo Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for estado_luminaria field
            //
            $column = new TextViewColumn('estado_luminaria', 'estado_luminaria', 'Estado Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('tipo_de_luminaria', 'tipo_de_luminaria_watts', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for fotografia_2 field
            //
            $column = new TextViewColumn('fotografia_2', 'fotografia_2', 'Fotografia 2', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for user_id field
            //
            $column = new NumberViewColumn('user_id', 'user_id', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for conciliada field
            //
            $column = new CheckboxViewColumn('conciliada', 'conciliada', 'Conciliada', $this->dataset);
            $column->SetOrderable(true);
            $column->setAlign('center');
            $column->setDisplayValues('<input type="checkbox" onclick="return false;" checked="checked">', '<input type="checkbox" onclick="return false;">');
            $grid->AddCompareColumn($column);
            
            //
            // View column for id field
            //
            $column = new TextViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha field
            //
            $column = new DateTimeViewColumn('fecha', 'fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for hora field
            //
            $column = new TextViewColumn('hora', 'hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for operador field
            //
            $column = new TextViewColumn('operador', 'operador', 'Operador', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for coordenadas field
            //
            $column = new TextViewColumn('coordenadas', 'coordenadas', 'Coordenadas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for estado_poste field
            //
            $column = new TextViewColumn('estado_poste', 'estado_poste', 'Estado Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipo_carcaza field
            //
            $column = new TextViewColumn('tipo_carcaza', 'tipo_carcaza', 'Tipo Carcaza', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for horas_uso field
            //
            $column = new TextViewColumn('horas_uso', 'horas_uso', 'Horas Uso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for numero_de_lamparas field
            //
            $column = new NumberViewColumn('numero_de_lamparas', 'numero_de_lamparas', 'Numero De Lamparas', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for colonia field
            //
            $column = new TextViewColumn('colonia', 'colonia', 'Colonia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for calle field
            //
            $column = new TextViewColumn('calle', 'calle', 'Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipo_de_calle field
            //
            $column = new TextViewColumn('tipo_de_calle', 'tipo_de_calle', 'Tipo De Calle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for via field
            //
            $column = new TextViewColumn('via', 'via', 'Via', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for numero_de_medidor field
            //
            $column = new TextViewColumn('numero_de_medidor', 'numero_de_medidor', 'Numero De Medidor', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for carga_aceptada field
            //
            $column = new TextViewColumn('carga_aceptada', 'carga_aceptada', 'Carga Aceptada', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipo_poste field
            //
            $column = new TextViewColumn('tipo_poste', 'tipo_poste', 'Tipo Poste', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for estado_luminaria field
            //
            $column = new TextViewColumn('estado_luminaria', 'estado_luminaria', 'Estado Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('tipo_de_luminaria', 'tipo_de_luminaria_watts', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fotografia_2 field
            //
            $column = new TextViewColumn('fotografia_2', 'fotografia_2', 'Fotografia 2', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for user_id field
            //
            $column = new NumberViewColumn('user_id', 'user_id', 'User Id', $this->dataset);
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
            $defaultSortedColumns[] = new SortColumn('municipio', 'ASC');
            $defaultSortedColumns[] = new SortColumn('operador', 'ASC');
            $defaultSortedColumns[] = new SortColumn('fecha', 'ASC');
            $defaultSortedColumns[] = new SortColumn('hora', 'ASC');
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
                '`tipos_luminarias`');
            $lookupDataset->addFields(
                array(
                    new StringField('tipo_de_luminaria', true, true),
                    new IntegerField('watts'),
                    new StringField('balastro'),
                    new IntegerField('porcbal'),
                    new StringField('grupo_reporte'),
                    new StringField('tipo_balastro')
                )
            );
            $lookupDataset->setOrderByField('watts', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_luminarias_tipo_de_luminaria_search', 'tipo_de_luminaria', 'watts', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_luminarias`');
            $lookupDataset->addFields(
                array(
                    new StringField('tipo_de_luminaria', true, true),
                    new IntegerField('watts'),
                    new StringField('balastro'),
                    new IntegerField('porcbal'),
                    new StringField('grupo_reporte'),
                    new StringField('tipo_balastro')
                )
            );
            $lookupDataset->setOrderByField('watts', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_luminarias_tipo_de_luminaria_search', 'tipo_de_luminaria', 'watts', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_luminarias`');
            $lookupDataset->addFields(
                array(
                    new StringField('tipo_de_luminaria', true, true),
                    new IntegerField('watts'),
                    new StringField('balastro'),
                    new IntegerField('porcbal'),
                    new StringField('grupo_reporte'),
                    new StringField('tipo_balastro')
                )
            );
            $lookupDataset->setOrderByField('watts', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_luminarias_tipo_de_luminaria_search', 'tipo_de_luminaria', 'watts', null, 20);
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
        $Page = new luminariasPage("luminarias", "luminarias.php", GetCurrentUserPermissionsForPage("luminarias"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("luminarias"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
