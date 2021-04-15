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
    
    
    
    class semaforos_maestraPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Semaforos Detalle');
            $this->SetMenuLabel('Semaforos Detalle');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`semaforos_maestra`');
            $this->dataset->addFields(
                array(
                    new StringField('id_lum', true),
                    new StringField('fecha_captura', false, true),
                    new StringField('hora'),
                    new StringField('latitude'),
                    new StringField('longitude'),
                    new StringField('estado_poste'),
                    new StringField('tipo_carcaza'),
                    new StringField('horas_uso'),
                    new IntegerField('numero_de_lamparas', false, true),
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
                    new IntegerField('watts', false, true),
                    new IntegerField('porcentaje_perdida', false, true),
                    new StringField('tipo_balastro'),
                    new IntegerField('subtotal_kw', false, true),
                    new IntegerField('perdida_kw', false, true),
                    new IntegerField('carga_kw', false, true),
                    new IntegerField('cpd', false, true),
                    new IntegerField('user_id', false, true),
                    new StringField('fotografia'),
                    new StringField('fotografia_2')
                )
            );
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
                new FilterColumn($this->dataset, 'id_lum', 'id_lum', 'Id Lum'),
                new FilterColumn($this->dataset, 'fecha_captura', 'fecha_captura', 'Fecha Captura'),
                new FilterColumn($this->dataset, 'hora', 'hora', 'Hora'),
                new FilterColumn($this->dataset, 'latitude', 'latitude', 'Latitude'),
                new FilterColumn($this->dataset, 'longitude', 'longitude', 'Longitude'),
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
                new FilterColumn($this->dataset, 'tipo_de_luminaria', 'tipo_de_luminaria', 'Tipo De Luminaria'),
                new FilterColumn($this->dataset, 'watts', 'watts', 'Watts'),
                new FilterColumn($this->dataset, 'porcentaje_perdida', 'porcentaje_perdida', 'Porcentaje Perdida'),
                new FilterColumn($this->dataset, 'tipo_balastro', 'tipo_balastro', 'Tipo Balastro'),
                new FilterColumn($this->dataset, 'subtotal_kw', 'subtotal_kw', 'Subtotal Kw'),
                new FilterColumn($this->dataset, 'perdida_kw', 'perdida_kw', 'Perdida Kw'),
                new FilterColumn($this->dataset, 'carga_kw', 'carga_kw', 'Carga Kw'),
                new FilterColumn($this->dataset, 'cpd', 'cpd', 'Cpd'),
                new FilterColumn($this->dataset, 'user_id', 'user_id', 'User Id'),
                new FilterColumn($this->dataset, 'fotografia', 'fotografia', 'Fotografia'),
                new FilterColumn($this->dataset, 'fotografia_2', 'fotografia_2', 'Fotografia 2')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_lum'])
                ->addColumn($columns['fecha_captura'])
                ->addColumn($columns['hora'])
                ->addColumn($columns['latitude'])
                ->addColumn($columns['longitude'])
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
                ->addColumn($columns['watts'])
                ->addColumn($columns['porcentaje_perdida'])
                ->addColumn($columns['tipo_balastro'])
                ->addColumn($columns['subtotal_kw'])
                ->addColumn($columns['perdida_kw'])
                ->addColumn($columns['carga_kw'])
                ->addColumn($columns['cpd'])
                ->addColumn($columns['user_id'])
                ->addColumn($columns['fotografia'])
                ->addColumn($columns['fotografia_2']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
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
                ->setOptionsFor('tipo_de_luminaria')
                ->setOptionsFor('watts')
                ->setOptionsFor('tipo_balastro');
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
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id_lum field
            //
            $column = new TextViewColumn('id_lum', 'id_lum', 'Id Lum', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for fecha_captura field
            //
            $column = new TextViewColumn('fecha_captura', 'fecha_captura', 'Fecha Captura', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for latitude field
            //
            $column = new TextViewColumn('latitude', 'latitude', 'Latitude', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for longitude field
            //
            $column = new TextViewColumn('longitude', 'longitude', 'Longitude', $this->dataset);
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
            // View column for tipo_de_luminaria field
            //
            $column = new TextViewColumn('tipo_de_luminaria', 'tipo_de_luminaria', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('watts', 'watts', 'Watts', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for porcentaje_perdida field
            //
            $column = new NumberViewColumn('porcentaje_perdida', 'porcentaje_perdida', 'Porcentaje Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tipo_balastro field
            //
            $column = new TextViewColumn('tipo_balastro', 'tipo_balastro', 'Tipo Balastro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for subtotal_kw field
            //
            $column = new NumberViewColumn('subtotal_kw', 'subtotal_kw', 'Subtotal Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for perdida_kw field
            //
            $column = new NumberViewColumn('perdida_kw', 'perdida_kw', 'Perdida Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for carga_kw field
            //
            $column = new NumberViewColumn('carga_kw', 'carga_kw', 'Carga Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for cpd field
            //
            $column = new NumberViewColumn('cpd', 'cpd', 'Cpd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
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
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%fotografia%');
            $column->setTarget('_blank');
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
            $column->setHrefTemplate('%fotografia_2%');
            $column->setTarget('_blank');
            $column->SetMaxLength(100);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_lum field
            //
            $column = new TextViewColumn('id_lum', 'id_lum', 'Id Lum', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_captura field
            //
            $column = new TextViewColumn('fecha_captura', 'fecha_captura', 'Fecha Captura', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for hora field
            //
            $column = new TextViewColumn('hora', 'hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for latitude field
            //
            $column = new TextViewColumn('latitude', 'latitude', 'Latitude', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for longitude field
            //
            $column = new TextViewColumn('longitude', 'longitude', 'Longitude', $this->dataset);
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
            // View column for tipo_de_luminaria field
            //
            $column = new TextViewColumn('tipo_de_luminaria', 'tipo_de_luminaria', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('watts', 'watts', 'Watts', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for porcentaje_perdida field
            //
            $column = new NumberViewColumn('porcentaje_perdida', 'porcentaje_perdida', 'Porcentaje Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipo_balastro field
            //
            $column = new TextViewColumn('tipo_balastro', 'tipo_balastro', 'Tipo Balastro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for subtotal_kw field
            //
            $column = new NumberViewColumn('subtotal_kw', 'subtotal_kw', 'Subtotal Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for perdida_kw field
            //
            $column = new NumberViewColumn('perdida_kw', 'perdida_kw', 'Perdida Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for carga_kw field
            //
            $column = new NumberViewColumn('carga_kw', 'carga_kw', 'Carga Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cpd field
            //
            $column = new NumberViewColumn('cpd', 'cpd', 'Cpd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
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
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%fotografia%');
            $column->setTarget('_blank');
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fotografia_2 field
            //
            $column = new TextViewColumn('fotografia_2', 'fotografia_2', 'Fotografia 2', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%fotografia_2%');
            $column->setTarget('_blank');
            $column->SetMaxLength(100);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_lum field
            //
            $editor = new TextEdit('id_lum_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Id Lum', 'id_lum', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_captura field
            //
            $editor = new TextEdit('fecha_captura_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Fecha Captura', 'fecha_captura', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for hora field
            //
            $editor = new TextEdit('hora_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Hora', 'hora', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for latitude field
            //
            $editor = new TextEdit('latitude_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Latitude', 'latitude', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for longitude field
            //
            $editor = new TextEdit('longitude_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Longitude', 'longitude', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for estado_poste field
            //
            $editor = new TextEdit('estado_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Poste', 'estado_poste', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_carcaza field
            //
            $editor = new TextEdit('tipo_carcaza_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Carcaza', 'tipo_carcaza', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for horas_uso field
            //
            $editor = new TextEdit('horas_uso_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Horas Uso', 'horas_uso', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for numero_de_lamparas field
            //
            $editor = new TextEdit('numero_de_lamparas_edit');
            $editColumn = new CustomEditColumn('Numero De Lamparas', 'numero_de_lamparas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for municipio field
            //
            $editor = new TextEdit('municipio_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Municipio', 'municipio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for colonia field
            //
            $editor = new TextEdit('colonia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Colonia', 'colonia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for calle field
            //
            $editor = new TextEdit('calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Calle', 'calle', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_de_calle field
            //
            $editor = new TextEdit('tipo_de_calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo De Calle', 'tipo_de_calle', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for via field
            //
            $editor = new TextEdit('via_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Via', 'via', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for numero_de_medidor field
            //
            $editor = new TextEdit('numero_de_medidor_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Numero De Medidor', 'numero_de_medidor', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for carga_aceptada field
            //
            $editor = new TextEdit('carga_aceptada_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Carga Aceptada', 'carga_aceptada', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_poste field
            //
            $editor = new TextEdit('tipo_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Poste', 'tipo_poste', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for estado_luminaria field
            //
            $editor = new TextEdit('estado_luminaria_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Luminaria', 'estado_luminaria', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for observaciones field
            //
            $editor = new TextEdit('observaciones_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Observaciones', 'observaciones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_de_luminaria field
            //
            $editor = new TextEdit('tipo_de_luminaria_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo De Luminaria', 'tipo_de_luminaria', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for watts field
            //
            $editor = new TextEdit('watts_edit');
            $editColumn = new CustomEditColumn('Watts', 'watts', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for porcentaje_perdida field
            //
            $editor = new TextEdit('porcentaje_perdida_edit');
            $editColumn = new CustomEditColumn('Porcentaje Perdida', 'porcentaje_perdida', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_balastro field
            //
            $editor = new TextEdit('tipo_balastro_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Balastro', 'tipo_balastro', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for subtotal_kw field
            //
            $editor = new TextEdit('subtotal_kw_edit');
            $editColumn = new CustomEditColumn('Subtotal Kw', 'subtotal_kw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for perdida_kw field
            //
            $editor = new TextEdit('perdida_kw_edit');
            $editColumn = new CustomEditColumn('Perdida Kw', 'perdida_kw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for carga_kw field
            //
            $editor = new TextEdit('carga_kw_edit');
            $editColumn = new CustomEditColumn('Carga Kw', 'carga_kw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cpd field
            //
            $editor = new TextEdit('cpd_edit');
            $editColumn = new CustomEditColumn('Cpd', 'cpd', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for user_id field
            //
            $editor = new TextEdit('user_id_edit');
            $editColumn = new CustomEditColumn('User Id', 'user_id', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fotografia field
            //
            $editor = new TextEdit('fotografia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia', 'fotografia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fotografia_2 field
            //
            $editor = new TextEdit('fotografia_2_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia 2', 'fotografia_2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_lum field
            //
            $editor = new TextEdit('id_lum_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Id Lum', 'id_lum', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_captura field
            //
            $editor = new TextEdit('fecha_captura_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Fecha Captura', 'fecha_captura', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for hora field
            //
            $editor = new TextEdit('hora_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Hora', 'hora', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for latitude field
            //
            $editor = new TextEdit('latitude_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Latitude', 'latitude', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for longitude field
            //
            $editor = new TextEdit('longitude_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Longitude', 'longitude', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for estado_poste field
            //
            $editor = new TextEdit('estado_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Poste', 'estado_poste', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_carcaza field
            //
            $editor = new TextEdit('tipo_carcaza_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Carcaza', 'tipo_carcaza', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for horas_uso field
            //
            $editor = new TextEdit('horas_uso_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Horas Uso', 'horas_uso', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for numero_de_lamparas field
            //
            $editor = new TextEdit('numero_de_lamparas_edit');
            $editColumn = new CustomEditColumn('Numero De Lamparas', 'numero_de_lamparas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for municipio field
            //
            $editor = new TextEdit('municipio_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Municipio', 'municipio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for colonia field
            //
            $editor = new TextEdit('colonia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Colonia', 'colonia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for calle field
            //
            $editor = new TextEdit('calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Calle', 'calle', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_de_calle field
            //
            $editor = new TextEdit('tipo_de_calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo De Calle', 'tipo_de_calle', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for via field
            //
            $editor = new TextEdit('via_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Via', 'via', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for numero_de_medidor field
            //
            $editor = new TextEdit('numero_de_medidor_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Numero De Medidor', 'numero_de_medidor', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for carga_aceptada field
            //
            $editor = new TextEdit('carga_aceptada_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Carga Aceptada', 'carga_aceptada', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_poste field
            //
            $editor = new TextEdit('tipo_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Poste', 'tipo_poste', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for estado_luminaria field
            //
            $editor = new TextEdit('estado_luminaria_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Luminaria', 'estado_luminaria', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for observaciones field
            //
            $editor = new TextEdit('observaciones_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Observaciones', 'observaciones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_de_luminaria field
            //
            $editor = new TextEdit('tipo_de_luminaria_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo De Luminaria', 'tipo_de_luminaria', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for watts field
            //
            $editor = new TextEdit('watts_edit');
            $editColumn = new CustomEditColumn('Watts', 'watts', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for porcentaje_perdida field
            //
            $editor = new TextEdit('porcentaje_perdida_edit');
            $editColumn = new CustomEditColumn('Porcentaje Perdida', 'porcentaje_perdida', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_balastro field
            //
            $editor = new TextEdit('tipo_balastro_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Balastro', 'tipo_balastro', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for subtotal_kw field
            //
            $editor = new TextEdit('subtotal_kw_edit');
            $editColumn = new CustomEditColumn('Subtotal Kw', 'subtotal_kw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for perdida_kw field
            //
            $editor = new TextEdit('perdida_kw_edit');
            $editColumn = new CustomEditColumn('Perdida Kw', 'perdida_kw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for carga_kw field
            //
            $editor = new TextEdit('carga_kw_edit');
            $editColumn = new CustomEditColumn('Carga Kw', 'carga_kw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cpd field
            //
            $editor = new TextEdit('cpd_edit');
            $editColumn = new CustomEditColumn('Cpd', 'cpd', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for user_id field
            //
            $editor = new TextEdit('user_id_edit');
            $editColumn = new CustomEditColumn('User Id', 'user_id', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fotografia field
            //
            $editor = new TextEdit('fotografia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia', 'fotografia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fotografia_2 field
            //
            $editor = new TextEdit('fotografia_2_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia 2', 'fotografia_2', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_lum field
            //
            $editor = new TextEdit('id_lum_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Id Lum', 'id_lum', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_captura field
            //
            $editor = new TextEdit('fecha_captura_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Fecha Captura', 'fecha_captura', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for hora field
            //
            $editor = new TextEdit('hora_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Hora', 'hora', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for latitude field
            //
            $editor = new TextEdit('latitude_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Latitude', 'latitude', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for longitude field
            //
            $editor = new TextEdit('longitude_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Longitude', 'longitude', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for estado_poste field
            //
            $editor = new TextEdit('estado_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Poste', 'estado_poste', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_carcaza field
            //
            $editor = new TextEdit('tipo_carcaza_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Carcaza', 'tipo_carcaza', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for horas_uso field
            //
            $editor = new TextEdit('horas_uso_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Horas Uso', 'horas_uso', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for numero_de_lamparas field
            //
            $editor = new TextEdit('numero_de_lamparas_edit');
            $editColumn = new CustomEditColumn('Numero De Lamparas', 'numero_de_lamparas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for municipio field
            //
            $editor = new TextEdit('municipio_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Municipio', 'municipio', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for colonia field
            //
            $editor = new TextEdit('colonia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Colonia', 'colonia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for calle field
            //
            $editor = new TextEdit('calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Calle', 'calle', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_de_calle field
            //
            $editor = new TextEdit('tipo_de_calle_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo De Calle', 'tipo_de_calle', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for via field
            //
            $editor = new TextEdit('via_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Via', 'via', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for numero_de_medidor field
            //
            $editor = new TextEdit('numero_de_medidor_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Numero De Medidor', 'numero_de_medidor', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for carga_aceptada field
            //
            $editor = new TextEdit('carga_aceptada_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Carga Aceptada', 'carga_aceptada', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_poste field
            //
            $editor = new TextEdit('tipo_poste_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Poste', 'tipo_poste', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for estado_luminaria field
            //
            $editor = new TextEdit('estado_luminaria_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Estado Luminaria', 'estado_luminaria', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for observaciones field
            //
            $editor = new TextEdit('observaciones_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Observaciones', 'observaciones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_de_luminaria field
            //
            $editor = new TextEdit('tipo_de_luminaria_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo De Luminaria', 'tipo_de_luminaria', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for watts field
            //
            $editor = new TextEdit('watts_edit');
            $editColumn = new CustomEditColumn('Watts', 'watts', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for porcentaje_perdida field
            //
            $editor = new TextEdit('porcentaje_perdida_edit');
            $editColumn = new CustomEditColumn('Porcentaje Perdida', 'porcentaje_perdida', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_balastro field
            //
            $editor = new TextEdit('tipo_balastro_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Tipo Balastro', 'tipo_balastro', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for subtotal_kw field
            //
            $editor = new TextEdit('subtotal_kw_edit');
            $editColumn = new CustomEditColumn('Subtotal Kw', 'subtotal_kw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for perdida_kw field
            //
            $editor = new TextEdit('perdida_kw_edit');
            $editColumn = new CustomEditColumn('Perdida Kw', 'perdida_kw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for carga_kw field
            //
            $editor = new TextEdit('carga_kw_edit');
            $editColumn = new CustomEditColumn('Carga Kw', 'carga_kw', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cpd field
            //
            $editor = new TextEdit('cpd_edit');
            $editColumn = new CustomEditColumn('Cpd', 'cpd', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for user_id field
            //
            $editor = new TextEdit('user_id_edit');
            $editColumn = new CustomEditColumn('User Id', 'user_id', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fotografia field
            //
            $editor = new TextEdit('fotografia_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia', 'fotografia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fotografia_2 field
            //
            $editor = new TextEdit('fotografia_2_edit');
            $editor->SetMaxLength(255);
            $editColumn = new CustomEditColumn('Fotografia 2', 'fotografia_2', $editor, $this->dataset);
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
            // View column for id_lum field
            //
            $column = new TextViewColumn('id_lum', 'id_lum', 'Id Lum', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_captura field
            //
            $column = new TextViewColumn('fecha_captura', 'fecha_captura', 'Fecha Captura', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for hora field
            //
            $column = new TextViewColumn('hora', 'hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for latitude field
            //
            $column = new TextViewColumn('latitude', 'latitude', 'Latitude', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for longitude field
            //
            $column = new TextViewColumn('longitude', 'longitude', 'Longitude', $this->dataset);
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
            // View column for tipo_de_luminaria field
            //
            $column = new TextViewColumn('tipo_de_luminaria', 'tipo_de_luminaria', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('watts', 'watts', 'Watts', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for porcentaje_perdida field
            //
            $column = new NumberViewColumn('porcentaje_perdida', 'porcentaje_perdida', 'Porcentaje Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipo_balastro field
            //
            $column = new TextViewColumn('tipo_balastro', 'tipo_balastro', 'Tipo Balastro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for subtotal_kw field
            //
            $column = new NumberViewColumn('subtotal_kw', 'subtotal_kw', 'Subtotal Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for perdida_kw field
            //
            $column = new NumberViewColumn('perdida_kw', 'perdida_kw', 'Perdida Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for carga_kw field
            //
            $column = new NumberViewColumn('carga_kw', 'carga_kw', 'Carga Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cpd field
            //
            $column = new NumberViewColumn('cpd', 'cpd', 'Cpd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
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
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%fotografia%');
            $column->setTarget('_blank');
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fotografia_2 field
            //
            $column = new TextViewColumn('fotografia_2', 'fotografia_2', 'Fotografia 2', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%fotografia_2%');
            $column->setTarget('_blank');
            $column->SetMaxLength(100);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_lum field
            //
            $column = new TextViewColumn('id_lum', 'id_lum', 'Id Lum', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_captura field
            //
            $column = new TextViewColumn('fecha_captura', 'fecha_captura', 'Fecha Captura', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for hora field
            //
            $column = new TextViewColumn('hora', 'hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for latitude field
            //
            $column = new TextViewColumn('latitude', 'latitude', 'Latitude', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for longitude field
            //
            $column = new TextViewColumn('longitude', 'longitude', 'Longitude', $this->dataset);
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
            // View column for tipo_de_luminaria field
            //
            $column = new TextViewColumn('tipo_de_luminaria', 'tipo_de_luminaria', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('watts', 'watts', 'Watts', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for porcentaje_perdida field
            //
            $column = new NumberViewColumn('porcentaje_perdida', 'porcentaje_perdida', 'Porcentaje Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for tipo_balastro field
            //
            $column = new TextViewColumn('tipo_balastro', 'tipo_balastro', 'Tipo Balastro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for subtotal_kw field
            //
            $column = new NumberViewColumn('subtotal_kw', 'subtotal_kw', 'Subtotal Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for perdida_kw field
            //
            $column = new NumberViewColumn('perdida_kw', 'perdida_kw', 'Perdida Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for carga_kw field
            //
            $column = new NumberViewColumn('carga_kw', 'carga_kw', 'Carga Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for cpd field
            //
            $column = new NumberViewColumn('cpd', 'cpd', 'Cpd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
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
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%fotografia%');
            $column->setTarget('_blank');
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
            
            //
            // View column for fotografia_2 field
            //
            $column = new TextViewColumn('fotografia_2', 'fotografia_2', 'Fotografia 2', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%fotografia_2%');
            $column->setTarget('_blank');
            $column->SetMaxLength(100);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id_lum field
            //
            $column = new TextViewColumn('id_lum', 'id_lum', 'Id Lum', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_captura field
            //
            $column = new TextViewColumn('fecha_captura', 'fecha_captura', 'Fecha Captura', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for hora field
            //
            $column = new TextViewColumn('hora', 'hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for latitude field
            //
            $column = new TextViewColumn('latitude', 'latitude', 'Latitude', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for longitude field
            //
            $column = new TextViewColumn('longitude', 'longitude', 'Longitude', $this->dataset);
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
            // View column for tipo_de_luminaria field
            //
            $column = new TextViewColumn('tipo_de_luminaria', 'tipo_de_luminaria', 'Tipo De Luminaria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for watts field
            //
            $column = new NumberViewColumn('watts', 'watts', 'Watts', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for porcentaje_perdida field
            //
            $column = new NumberViewColumn('porcentaje_perdida', 'porcentaje_perdida', 'Porcentaje Perdida', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipo_balastro field
            //
            $column = new TextViewColumn('tipo_balastro', 'tipo_balastro', 'Tipo Balastro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for subtotal_kw field
            //
            $column = new NumberViewColumn('subtotal_kw', 'subtotal_kw', 'Subtotal Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for perdida_kw field
            //
            $column = new NumberViewColumn('perdida_kw', 'perdida_kw', 'Perdida Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for carga_kw field
            //
            $column = new NumberViewColumn('carga_kw', 'carga_kw', 'Carga Kw', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for cpd field
            //
            $column = new NumberViewColumn('cpd', 'cpd', 'Cpd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
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
            
            //
            // View column for fotografia field
            //
            $column = new TextViewColumn('fotografia', 'fotografia', 'Fotografia', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%fotografia%');
            $column->setTarget('_blank');
            $column->SetMaxLength(100);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fotografia_2 field
            //
            $column = new TextViewColumn('fotografia_2', 'fotografia_2', 'Fotografia 2', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('%fotografia_2%');
            $column->setTarget('_blank');
            $column->SetMaxLength(100);
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
            $this->setExportListAvailable(array('excel', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('excel', 'xml', 'csv'));
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
        $Page = new semaforos_maestraPage("semaforos_maestra", "semaforos_maestra.php", GetCurrentUserPermissionsForPage("semaforos_maestra"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("semaforos_maestra"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
