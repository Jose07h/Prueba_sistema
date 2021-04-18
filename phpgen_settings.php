<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/mail/mailer.php';
include_once dirname(__FILE__) . '/' . 'components/mail/phpmailer_based_mailer.php';
require_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('America/Tegucigalpa');

function GetGlobalConnectionOptions()
{
    return
        array(
          'server' => '23.111.148.170',
          'port' => '3306',
          'username' => 'emihermx',
          'password' => '3m1h3rmx2020',
          'database' => 'emihermx_toluca2021_v2',
          'client_encoding' => 'utf8'
        );
}

function HasAdminPage()
{
    return true;
}

function HasHomePage()
{
    return false;
}

function GetHomeURL()
{
    return 'index.php';
}

function GetHomePageBanner()
{
    return '';
}

function GetPageGroups()
{
    $result = array();
    $result[] = array('caption' => 'Municipios', 'description' => '');
    $result[] = array('caption' => 'Programado vs Real', 'description' => '');
    $result[] = array('caption' => 'Cargas KW', 'description' => '');
    $result[] = array('caption' => 'Conciliacion', 'description' => '');
    $result[] = array('caption' => 'Documentos', 'description' => '');
    $result[] = array('caption' => 'Seguridad', 'description' => '');
    $result[] = array('caption' => 'Reportes Anexo 2', 'description' => '');
    $result[] = array('caption' => 'Mapas y Cartografias', 'description' => '');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Avance censadas semanal', 'short_caption' => 'Avance censadas semanal', 'filename' => 'avance_semanal.php', 'name' => 'avance_semanal', 'group_name' => 'Programado vs Real', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Avance conciliacion', 'short_caption' => 'Avance conciliacion', 'filename' => 'conciliadas_por_municipio.php', 'name' => 'conciliadas_por_municipio', 'group_name' => 'Conciliacion', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Programa Semanal', 'short_caption' => 'Programa Semanal', 'filename' => 'programa_semanal.php', 'name' => 'programa_semanal', 'group_name' => 'Programado vs Real', 'add_separator' => false, 'description' => '');
    //$result[] = array('caption' => 'Conciliacion por colonia', 'short_caption' => 'Conciliacion por colonia', 'filename' => 'conciliacion_validacion.php', 'name' => 'conciliacion_validacion', 'group_name' => 'Conciliacion', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Conciliacion por luminaria', 'short_caption' => 'Conciliacion por luminaria', 'filename' => 'luminarias.php', 'name' => 'luminarias', 'group_name' => 'Conciliacion', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Conciliacion Municipio por colonia', 'short_caption' => 'Conciliacion Municipio por colonia', 'filename' => 'conciliacion_municipio.php', 'name' => 'conciliacion_municipio', 'group_name' => 'Conciliacion', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Informes', 'short_caption' => 'Informes', 'filename' => 'informes.php', 'name' => 'informes', 'group_name' => 'Documentos', 'add_separator' => false, 'description' => '');
    //$result[] = array('caption' => 'Informes Municipio', 'short_caption' => 'Informes Municipio', 'filename' => 'informes_municipio.php', 'name' => 'informes_municipio', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Cartografias', 'short_caption' => 'Cartografias', 'filename' => 'cartografias.php', 'name' => 'cartografias', 'group_name' => 'Mapas y Cartografias', 'add_separator' => false, 'description' => '');
    //$result[] = array('caption' => 'Cartografias Municipio', 'short_caption' => 'Cartografias Municipio', 'filename' => 'cartografias_municipio.php', 'name' => 'cartografias_municipio', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Fichas Tecnicas', 'short_caption' => 'Fichas Tecnicas', 'filename' => 'fichas_tecnicas.php', 'name' => 'fichas_tecnicas', 'group_name' => 'Documentos', 'add_separator' => false, 'description' => '');
    //$result[] = array('caption' => 'Fichas Tecnicas Municipio', 'short_caption' => 'Fichas Tecnicas Municipio', 'filename' => 'fichas_tecnicas_municipio.php', 'name' => 'fichas_tecnicas_municipio', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Seguridad Rij', 'short_caption' => 'Seguridad Rij', 'filename' => 'seguridad_rij.php', 'name' => 'seguridad_rij', 'group_name' => 'Seguridad', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Seguridad Rim', 'short_caption' => 'Seguridad Rim', 'filename' => 'seguridad_rim.php', 'name' => 'seguridad_rim', 'group_name' => 'Seguridad', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Seguridad Supervision', 'short_caption' => 'Seguridad Supervision', 'filename' => 'seguridad_supervision.php', 'name' => 'seguridad_supervision', 'group_name' => 'Seguridad', 'add_separator' => false, 'description' => '');
    //$result[] = array('caption' => 'Luminarias Detalle', 'short_caption' => 'Luminarias Detalle', 'filename' => 'luminarias_maestra.php', 'name' => 'luminarias_maestra', 'group_name' => 'Detalle Y Mapas', 'add_separator' => false, 'description' => '');
    //$result[] = array('caption' => 'Semaforos Detalle', 'short_caption' => 'Semaforos Detalle', 'filename' => 'semaforos_maestra.php', 'name' => 'semaforos_maestra', 'group_name' => 'Detalle Y Mapas', 'add_separator' => false, 'description' => '');
    //$result[] = array('caption' => 'Publicitarios Detalle', 'short_caption' => 'Publicitarios Detalle', 'filename' => 'publicitarios_maestra.php', 'name' => 'publicitarios_maestra', 'group_name' => 'Detalle Y Mapas', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Vias Primarias Detalle', 'short_caption' => 'Vias Primarias Detalle', 'filename' => 'vias_primarias_maestra.php', 'name' => 'vias_primarias_maestra', 'group_name' => 'Mapas y Cartografias', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Vias Secundarias Detalle', 'short_caption' => 'Vias SecundariasDetalle', 'filename' => 'vias_secundarias_maestra.php', 'name' => 'vias_secundarias_maestra', 'group_name' => 'Mapas y Cartografias', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Comparativo Censo Luminarias', 'short_caption' => 'Comparativo Censo Luminarias', 'filename' => 'comparativo_censo_luminarias.php', 'name' => 'comparativo_censo_luminarias', 'group_name' => 'Reportes Anexo 2', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Carga Por Municipio Luminarias', 'short_caption' => 'Carga Por Municipio Luminarias', 'filename' => 'carga_por_municipio_luminarias.php', 'name' => 'carga_por_municipio_luminarias', 'group_name' => 'Reportes Anexo 2', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Carga Por Municipio Semaforos', 'short_caption' => 'Carga Por Municipio Semaforos', 'filename' => 'carga_por_municipio_semaforos.php', 'name' => 'carga_por_municipio_semaforos', 'group_name' => 'Reportes Anexo 2', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Carga Por Colonia Luminarias 24hrs', 'short_caption' => 'Carga Por Colonia Luminarias 24hrs', 'filename' => 'carga_por_colonia_luminarias_24hrs.php', 'name' => 'carga_por_colonia_luminarias_24hrs', 'group_name' => 'Reportes Anexo 2', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Carga Por Municipio Calle', 'short_caption' => 'Carga Por Municipio Calle', 'filename' => 'carga_por_municipio_calle.php', 'name' => 'carga_por_municipio_calle', 'group_name' => 'Reportes Anexo 2', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Carga Por Municipio Colonia', 'short_caption' => 'Carga Por Municipio Colonia', 'filename' => 'carga_por_municipio_colonia.php', 'name' => 'carga_por_municipio_colonia', 'group_name' => 'Reportes Anexo 2', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Carga Por Municipio Tipo Luminarias', 'short_caption' => 'Carga Por Municipio Tipo Luminarias', 'filename' => 'carga_por_municipio_tipo_luminarias.php', 'name' => 'carga_por_municipio_tipo_luminarias', 'group_name' => 'Reportes Anexo 2', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Vias Primarias Carga Por Colonia', 'short_caption' => 'Vias Primarias Carga Por Colonia', 'filename' => 'vias_primarias_carga_por_colonia.php', 'name' => 'vias_primarias_carga_por_colonia', 'group_name' => 'Cargas KW', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Vias Secundarias Carga Por Colonia', 'short_caption' => 'Vias Secundarias Carga Por Colonia', 'filename' => 'vias_secundarias_carga_por_colonia.php', 'name' => 'vias_secundarias_carga_por_colonia', 'group_name' => 'Cargas KW', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Municipios', 'short_caption' => 'Municipios', 'filename' => 'municipios.php', 'name' => 'municipios', 'group_name' => 'Municipios', 'add_separator' => false, 'description' => '');
    return $result;
}

function GetPagesHeader()
{
    return
        '<span class="navbar-brand">
    <span>
        <img src="emiher.png" style="height: 36px; margin-top: -10px;">
    </span>
</span>
<span class="navbar-brand">    
    <span class="hidden-xs"><strong>Censo de Alumbrado Zona Toluca 2021</strong></span>
</span>';
}

function GetPagesFooter()
{
    return
        '<footer class="footer-distributed">

			<div class="footer-left">

				<p class="footer-company-name">EMIHER CONSTRUCCIONES E INSTALACIONES &copy; 2021</p>
			</div>

			<div class="footer-center">

				<div>
					<i class="fa fa-map-marker"></i>
					<p><span>Emiliano Zapata 101 Col. La Constitución Totoltepec</span>Toluca, Edo. Mex.</p>
				</div>

				<div>
					<i class="fa fa-phone"></i>
					<p> Tel. +01 7225700633</p>
				</div>

				<div>
					<i class="fa fa-envelope"></i>
					<p><a href="mailto:support@company.com">contacto@emiher.com</a></p>
				</div>

			</div>

			<div class="footer-right">

				<p class="footer-company-about">

					
				</p>

				<div class="footer-icons">

					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="#"><i class="fa fa-linkedin"></i></a>
					<a href="#"><i class="fa fa-github"></i></a>

				</div>

			</div>

		</footer>';
}

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(true);
    $page->setShowNavigation(false);
    $page->OnGetCustomExportOptions->AddListener('Global_OnGetCustomExportOptions');
    $page->getDataset()->OnGetFieldValue->AddListener('Global_OnGetFieldValue');
    $page->getDataset()->OnGetFieldValue->AddListener('OnGetFieldValue', $page);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
    $grid->AfterUpdateRecord->AddListener('Global_AfterUpdateHandler');
    $grid->AfterDeleteRecord->AddListener('Global_AfterDeleteHandler');
    $grid->AfterInsertRecord->AddListener('Global_AfterInsertHandler');
}

function GetAnsiEncoding() { return 'windows-1252'; }

function Global_AddEnvironmentVariablesHandler(&$variables)
{

}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{

}

function Global_OnGetCustomExportOptions($page, $exportType, $rowData, &$options)
{

}

function Global_OnGetFieldValue($fieldName, &$value, $tableName)
{

}

function Global_GetCustomPageList(CommonPage $page, PageList $pageList)
{

}

function Global_BeforeInsertHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeUpdateHandler($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeDeleteHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_AfterInsertHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterUpdateHandler($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterDeleteHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function GetDefaultDateFormat()
{
    return 'd-m-Y';
}

function GetFirstDayOfWeek()
{
    return 1;
}

function GetPageListType()
{
    return PageList::TYPE_SIDEBAR;
}

function GetNullLabel()
{
    return null;
}

function UseMinifiedJS()
{
    return true;
}

function GetOfflineMode()
{
    return false;
}

function GetInactivityTimeout()
{
    return 0;
}

function GetMailer()
{
    $mailerOptions = new MailerOptions(MailerType::Sendmail, '', '');
    
    return PHPMailerBasedMailer::getInstance($mailerOptions);
}

function sendMailMessage($recipients, $messageSubject, $messageBody, $attachments = '', $cc = '', $bcc = '')
{
    GetMailer()->send($recipients, $messageSubject, $messageBody, $attachments, $cc, $bcc);
}

function createConnection()
{
    $connectionOptions = GetGlobalConnectionOptions();
    $connectionOptions['client_encoding'] = 'utf8';

    $connectionFactory = MySqlIConnectionFactory::getInstance();
    return $connectionFactory->CreateConnection($connectionOptions);
}

/**
 * @param string $pageName
 * @return IPermissionSet
 */
function GetCurrentUserPermissionsForPage($pageName) 
{
    return GetApplication()->GetCurrentUserPermissionSet($pageName);
}
