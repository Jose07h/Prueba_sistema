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
    
    
    
    class informesPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Informes');
            $this->SetMenuLabel('Informes');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`informes`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_informe', true, true, true),
                    new StringField('municipio', true),
                    new StringField('tipo_informe', true),
                    new StringField('documento_1', true),
                    new StringField('documento_2')
                )
            );
            $this->dataset->AddLookupField('municipio', 'municipios', new StringField('nombre_municipio'), new StringField('nombre_municipio', false, false, false, false, 'municipio_nombre_municipio', 'municipio_nombre_municipio_municipios'), 'municipio_nombre_municipio_municipios');
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
                new FilterColumn($this->dataset, 'id_informe', 'id_informe', 'Id Informe'),
                new FilterColumn($this->dataset, 'municipio', 'municipio_nombre_municipio', 'Municipio'),
                new FilterColumn($this->dataset, 'tipo_informe', 'tipo_informe', 'Tipo Informe'),
                new FilterColumn($this->dataset, 'documento_1', 'documento_1', 'Documento 1'),
                new FilterColumn($this->dataset, 'documento_2', 'documento_2', 'Documento 2')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_informe'])
                ->addColumn($columns['municipio'])
                ->addColumn($columns['tipo_informe'])
                ->addColumn($columns['documento_1'])
                ->addColumn($columns['documento_2']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('municipio');
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
            // View column for id_informe field
            //
            $column = new NumberViewColumn('id_informe', 'id_informe', 'Id Informe', $this->dataset);
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
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for tipo_informe field
            //
            $column = new TextViewColumn('tipo_informe', 'tipo_informe', 'Tipo Informe', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for documento_1 field
            //
            $column = new DownloadExternalDataColumn('documento_1', 'documento_1', 'Documento 1', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for documento_2 field
            //
            $column = new DownloadExternalDataColumn('documento_2', 'documento_2', 'Documento 2', $this->dataset, '');
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_informe field
            //
            $column = new NumberViewColumn('id_informe', 'id_informe', 'Id Informe', $this->dataset);
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
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipo_informe field
            //
            $column = new TextViewColumn('tipo_informe', 'tipo_informe', 'Tipo Informe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for documento_1 field
            //
            $column = new DownloadExternalDataColumn('documento_1', 'documento_1', 'Documento 1', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for documento_2 field
            //
            $column = new DownloadExternalDataColumn('documento_2', 'documento_2', 'Documento 2', $this->dataset, '');
            $column->SetOrderable(true);
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
            $editColumn = new DynamicLookupEditColumn('Municipio', 'municipio', 'municipio_nombre_municipio', 'edit_informes_municipio_search', $editor, $this->dataset, $lookupDataset, 'nombre_municipio', 'nombre_municipio', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipo_informe field
            //
            $editor = new TextEdit('tipo_informe_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Tipo Informe', 'tipo_informe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for documento_1 field
            //
            $editor = new ImageUploader('documento_1_edit');
            $editor->SetShowImage(false);
            $editColumn = new UploadFileToFolderColumn('Documento 1', 'documento_1', $editor, $this->dataset, false, false, 'documentos', '%original_file_name%', $this->OnFileUpload, false);
            $editColumn->SetReplaceUploadedFileIfExist(false);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for documento_2 field
            //
            $editor = new ImageUploader('documento_2_edit');
            $editor->SetShowImage(false);
            $editColumn = new UploadFileToFolderColumn('Documento 2', 'documento_2', $editor, $this->dataset, false, false, 'documentos', '%original_file_name%', $this->OnFileUpload, false);
            $editColumn->SetReplaceUploadedFileIfExist(false);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Municipio', 'municipio', 'municipio_nombre_municipio', 'multi_edit_informes_municipio_search', $editor, $this->dataset, $lookupDataset, 'nombre_municipio', 'nombre_municipio', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipo_informe field
            //
            $editor = new TextEdit('tipo_informe_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Tipo Informe', 'tipo_informe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for documento_1 field
            //
            $editor = new ImageUploader('documento_1_edit');
            $editor->SetShowImage(false);
            $editColumn = new UploadFileToFolderColumn('Documento 1', 'documento_1', $editor, $this->dataset, false, false, 'documentos', '%original_file_name%', $this->OnFileUpload, false);
            $editColumn->SetReplaceUploadedFileIfExist(false);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for documento_2 field
            //
            $editor = new ImageUploader('documento_2_edit');
            $editor->SetShowImage(false);
            $editColumn = new UploadFileToFolderColumn('Documento 2', 'documento_2', $editor, $this->dataset, false, false, 'documentos', '%original_file_name%', $this->OnFileUpload, false);
            $editColumn->SetReplaceUploadedFileIfExist(false);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Municipio', 'municipio', 'municipio_nombre_municipio', 'insert_informes_municipio_search', $editor, $this->dataset, $lookupDataset, 'nombre_municipio', 'nombre_municipio', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipo_informe field
            //
            $editor = new TextEdit('tipo_informe_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Tipo Informe', 'tipo_informe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for documento_1 field
            //
            $editor = new ImageUploader('documento_1_edit');
            $editor->SetShowImage(false);
            $editColumn = new UploadFileToFolderColumn('Documento 1', 'documento_1', $editor, $this->dataset, false, false, 'documentos', '%original_file_name%', $this->OnFileUpload, false);
            $editColumn->SetReplaceUploadedFileIfExist(false);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for documento_2 field
            //
            $editor = new ImageUploader('documento_2_edit');
            $editor->SetShowImage(false);
            $editColumn = new UploadFileToFolderColumn('Documento 2', 'documento_2', $editor, $this->dataset, false, false, 'documentos', '%original_file_name%', $this->OnFileUpload, false);
            $editColumn->SetReplaceUploadedFileIfExist(false);
            $editColumn->SetAllowSetToNull(true);
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
            // View column for id_informe field
            //
            $column = new NumberViewColumn('id_informe', 'id_informe', 'Id Informe', $this->dataset);
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
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipo_informe field
            //
            $column = new TextViewColumn('tipo_informe', 'tipo_informe', 'Tipo Informe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for documento_1 field
            //
            $column = new DownloadExternalDataColumn('documento_1', 'documento_1', 'Documento 1', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for documento_2 field
            //
            $column = new DownloadExternalDataColumn('documento_2', 'documento_2', 'Documento 2', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_informe field
            //
            $column = new NumberViewColumn('id_informe', 'id_informe', 'Id Informe', $this->dataset);
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
            $grid->AddExportColumn($column);
            
            //
            // View column for tipo_informe field
            //
            $column = new TextViewColumn('tipo_informe', 'tipo_informe', 'Tipo Informe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for documento_1 field
            //
            $column = new DownloadExternalDataColumn('documento_1', 'documento_1', 'Documento 1', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for documento_2 field
            //
            $column = new DownloadExternalDataColumn('documento_2', 'documento_2', 'Documento 2', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for nombre_municipio field
            //
            $column = new TextViewColumn('municipio', 'municipio_nombre_municipio', 'Municipio', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipo_informe field
            //
            $column = new TextViewColumn('tipo_informe', 'tipo_informe', 'Tipo Informe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for documento_1 field
            //
            $column = new DownloadExternalDataColumn('documento_1', 'documento_1', 'Documento 1', $this->dataset, '');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for documento_2 field
            //
            $column = new DownloadExternalDataColumn('documento_2', 'documento_2', 'Documento 2', $this->dataset, '');
            $column->SetOrderable(true);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_informes_municipio_search', 'nombre_municipio', 'nombre_municipio', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_informes_municipio_search', 'nombre_municipio', 'nombre_municipio', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_informes_municipio_search', 'nombre_municipio', 'nombre_municipio', null, 20);
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
        $Page = new informesPage("informes", "informes.php", GetCurrentUserPermissionsForPage("informes"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("informes"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
