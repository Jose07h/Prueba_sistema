<?php

include_once dirname(__FILE__) . '/' . 'phpgen_settings.php';
include_once dirname(__FILE__) . '/' . 'components/application.php';
include_once dirname(__FILE__) . '/' . 'components/security/permission_set.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_authentication/table_based_user_authentication.php';
include_once dirname(__FILE__) . '/' . 'components/security/grant_manager/table_based_user_grant_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/table_based_user_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_identity_storage/user_identity_session_storage.php';
include_once dirname(__FILE__) . '/' . 'components/security/recaptcha.php';
include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';



$dataSourceRecordPermissions = array('conciliacion_validacion' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'avance_luminarias_censadas' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'informes_municipio' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'cartografias_municipio' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'fichas_tecnicas_municipio' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'luminarias_maestra' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'semaforos_maestra' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'publicitarios_maestra' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'vias_primarias_maestra' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'vias_secundarias_maestra' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'comparativo_censo_luminarias' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'carga_por_municipio_luminarias' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'carga_por_municipio_semaforos' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'carga_por_colonia_luminarias_24hrs' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'carga_por_municipio_calle' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'carga_por_municipio_colonia' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'carga_por_municipio_tipo_luminarias' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'vias_primarias_carga_por_colonia' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true),
  'vias_secundarias_carga_por_colonia' => new DataSourceRecordPermission('user_id', false, false, false, true, true, true));

$tableCaptions = array('conciliacion_validacion' => 'Conciliacion',
'conciliacion_municipio' => 'Conciliacion Municipio',
'avance_luminarias_censadas' => 'Avance Luminarias Censadas',
'informes' => 'Informes',
'informes_municipio' => 'Informes Municipio',
'cartografias' => 'Cartografias',
'cartografias_municipio' => 'Cartografias Municipio',
'fichas_tecnicas' => 'Fichas Tecnicas',
'fichas_tecnicas_municipio' => 'Fichas Tecnicas Municipio',
'seguridad_rij' => 'Seguridad Rij',
'seguridad_rim' => 'Seguridad Rim',
'seguridad_supervision' => 'Seguridad Supervision',
'luminarias_maestra' => 'Luminarias Detalle',
'semaforos_maestra' => 'Semaforos Detalle',
'publicitarios_maestra' => 'Publicitarios Detalle',
'vias_primarias_maestra' => 'Vias Primarias Detalle',
'vias_secundarias_maestra' => 'Vias Secundarias Detalle',
'comparativo_censo_luminarias' => 'Comparativo Censo Luminarias',
'carga_por_municipio_luminarias' => 'Carga Por Municipio Luminarias',
'carga_por_municipio_semaforos' => 'Carga Por Municipio Semaforos',
'carga_por_colonia_luminarias_24hrs' => 'Carga Por Colonia Luminarias 24hrs',
'carga_por_municipio_calle' => 'Carga Por Municipio Calle',
'carga_por_municipio_colonia' => 'Carga Por Municipio Colonia',
'carga_por_municipio_tipo_luminarias' => 'Carga Por Municipio Tipo Luminarias',
'vias_primarias_carga_por_colonia' => 'Vias Primarias Carga Por Colonia',
'vias_secundarias_carga_por_colonia' => 'Vias Secundarias Carga Por Colonia');

$usersTableInfo = array(
    'TableName' => 'phpgen_users',
    'UserId' => 'user_id',
    'UserName' => 'user_name',
    'Password' => 'user_password',
    'Email' => '',
    'UserToken' => '',
    'UserStatus' => ''
);

function EncryptPassword($password, &$result)
{

}

function VerifyPassword($enteredPassword, $encryptedPassword, &$result)
{

}

function BeforeUserRegistration($userName, $email, $password, &$allowRegistration, &$errorMessage)
{

}    

function AfterUserRegistration($userName, $email)
{

}    

function PasswordResetRequest($userName, $email)
{

}

function PasswordResetComplete($userName, $email)
{

}

function VerifyPasswordStrength($password, &$result, &$passwordRuleMessage) 
{

}

function CreatePasswordHasher()
{
    $hasher = CreateHasher('');
    if ($hasher instanceof CustomStringHasher) {
        $hasher->OnEncryptPassword->AddListener('EncryptPassword');
        $hasher->OnVerifyPassword->AddListener('VerifyPassword');
    }
    return $hasher;
}

function CreateGrantManager() 
{
    global $tableCaptions;
    global $usersTableInfo;
    
    $userPermsTableInfo = array('TableName' => 'phpgen_user_perms', 'UserId' => 'user_id', 'PageName' => 'page_name', 'Grant' => 'perm_name');
    
    return new TableBasedUserGrantManager(MySqlIConnectionFactory::getInstance(), GetGlobalConnectionOptions(),
        $usersTableInfo, $userPermsTableInfo, $tableCaptions, false);
}

function CreateTableBasedUserManager() 
{
    global $usersTableInfo;

    $userManager = new TableBasedUserManager(MySqlIConnectionFactory::getInstance(), GetGlobalConnectionOptions(), 
        $usersTableInfo, CreatePasswordHasher(), false);
    $userManager->OnVerifyPasswordStrength->AddListener('VerifyPasswordStrength');

    return $userManager;
}

function GetReCaptcha($formId) 
{
    return null;
}

function SetUpUserAuthorization() 
{
    global $dataSourceRecordPermissions;

    $hasher = CreatePasswordHasher();

    $grantManager = CreateGrantManager();

    $userAuthentication = new TableBasedUserAuthentication(new UserIdentitySessionStorage(), false, $hasher, CreateTableBasedUserManager(), false, false, false);

    GetApplication()->SetUserAuthentication($userAuthentication);
    GetApplication()->SetUserGrantManager($grantManager);
    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}
