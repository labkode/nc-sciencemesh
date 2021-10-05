<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\ScienceMesh\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
        ['name' => 'reva#Authenticate', 'url' => '/~{userId}/api/storage/Authenticate', 'verb' => 'POST'],
        ['name' => 'reva#AddGrant', 'url' => '/~{userId}/api/storage/AddGrant', 'verb' => 'POST'],
        ['name' => 'reva#CreateDir', 'url' => '/~{userId}/api/storage/CreateDir', 'verb' => 'POST'],
        ['name' => 'reva#CreateHome', 'url' => '/~{userId}/api/storage/CreateHome', 'verb' => 'POST'],
        ['name' => 'reva#CreateReference', 'url' => '/~{userId}/api/storage/CreateReference', 'verb' => 'POST'],
        ['name' => 'reva#Delete', 'url' => '/~{userId}/api/storage/Delete', 'verb' => 'POST'],
        ['name' => 'reva#EmptyRecycle', 'url' => '/~{userId}/api/storage/EmptyRecycle', 'verb' => 'POST'],
        ['name' => 'reva#GetMD', 'url' => '/~{userId}/api/storage/GetMD', 'verb' => 'POST'],
        ['name' => 'reva#GetPathByID', 'url' => '/~{userId}/api/storage/GetPathByID', 'verb' => 'POST'],
        ['name' => 'reva#InitiateUpload', 'url' => '/~{userId}/api/storage/InitiateUpload', 'verb' => 'POST'],
        ['name' => 'reva#ListFolder', 'url' => '/~{userId}/api/storage/ListFolder', 'verb' => 'POST'],
        ['name' => 'reva#ListGrants', 'url' => '/~{userId}/api/storage/ListGrants', 'verb' => 'POST'],
        ['name' => 'reva#ListRecycle', 'url' => '/~{userId}/api/storage/ListRecycle', 'verb' => 'POST'],
        ['name' => 'reva#ListRevisions', 'url' => '/~{userId}/api/storage/ListRevisions', 'verb' => 'POST'],
        ['name' => 'reva#Move', 'url' => '/~{userId}/api/storage/Move', 'verb' => 'POST'],
        ['name' => 'reva#RemoveGrant', 'url' => '/~{userId}/api/storage/RemoveGrant', 'verb' => 'POST'],
        ['name' => 'reva#RestoreRecycleItem', 'url' => '/~{userId}/api/storage/RestoreRecycleItem', 'verb' => 'POST'],
        ['name' => 'reva#RestoreRevision', 'url' => '/~{userId}/api/storage/RestoreRevision', 'verb' => 'POST'],
        ['name' => 'reva#SetArbitraryMetadata', 'url' => '/~{userId}/api/storage/SetArbitraryMetadata', 'verb' => 'POST'],
        ['name' => 'reva#UnsetArbitraryMetadata', 'url' => '/~{userId}/api/storage/UnsetArbitraryMetadata', 'verb' => 'POST'],
        ['name' => 'reva#UpdateGrant', 'url' => '/~{userId}/api/storage/UpdateGrant', 'verb' => 'POST'],
        ['name' => 'reva#Upload', 'url' => '/~{userId}/api/storage/Upload/{path}', 'verb' => 'PUT'],
        ['name' => 'reva#Share', 'url' => '/~{userId}/api/share/Share', 'verb' => 'POST'],
        ['name' => 'reva#GetShare', 'url' => '/~{userId}/api/share/GetShare', 'verb' => 'POST'],
        ['name' => 'reva#UnShare', 'url' => '/~{userId}/api/share/UnShare', 'verb' => 'POST'],
        ['name' => 'reva#UpdateShare', 'url' => '/~{userId}/api/share/UpdateShare', 'verb' => 'POST'],
        ['name' => 'reva#ListShares', 'url' => '/~{userId}/api/share/ListShares', 'verb' => 'POST'],
        ['name' => 'reva#ListreceivedShares', 'url' => '/~{userId}/api/share/ListReceivedShares', 'verb' => 'POST'],
        ['name' => 'reva#GetReceivedShare', 'url' => '/~{userId}/api/share/GetReceivedShare', 'verb' => 'POST'],
        ['name' => 'reva#UpdateReceivedShare', 'url' => '/~{userId}/api/share/UpdateReceivedShare', 'verb' => 'POST'],
        
/*        
        ['name' => 'storage#createHome', 'url' => '/~{userId}/CreateHome', 'verb' => 'POST'],
        ['name' => 'storage#listFolder', 'url' => '/~{userId}/ListFolder', 'verb' => 'POST'],
        ['name' => 'storage#initiateUpload', 'url' => '/~{userId}/InitiateUpload', 'verb' => 'POST'],
        ['name' => 'storage#upload', 'url' => '/~{userId}/Upload', 'verb' => 'POST'],
        ['name' => 'storage#handleUpload', 'url' => '/~{userId}/Upload/{path}', 'verb' => 'PUT'],
        ['name' => 'storage#getMD', 'url' => '/~{userId}/GetMD', 'verb' => 'POST'],
*/

        ['name' => 'storage#handleGet', 'url' => '/~{userId}/files/{path}', 'verb' => 'GET', 'requirements' => array('path' => '.+')],
        ['name' => 'storage#handlePost', 'url' => '/~{userId}/files/{path}', 'verb' => 'POST', 'requirements' => array('path' => '.+')],
        ['name' => 'storage#handlePut', 'url' => '/~{userId}/files/{path}', 'verb' => 'PUT', 'requirements' => array('path' => '.+')],
        ['name' => 'storage#handleDelete', 'url' => '/~{userId}/files/{path}', 'verb' => 'DELETE', 'requirements' => array('path' => '.+')],
        ['name' => 'storage#handleHead', 'url' => '/~{userId}/files/{path}', 'verb' => 'HEAD', 'requirements' => array('path' => '.+')],

        ['name' => 'app#appLauncher', 'url' => '/', 'verb' => 'GET'],
    ]
];
