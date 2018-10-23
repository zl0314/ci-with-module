<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

$config['default'] = [
    'upload_path'   => './uploads/default/' . date( 'Y/m/d/' ) . rand( 10000, 99999 ) . '/',
    'allowed_types' => 'gif|jpg|png|jpeg|PNG|JPG|JPEG|pdf|doc',
    'encrypt_name'  => true,
    'create_thumb'  => false,
    'max_size'      => ini_get( 'upload_max_filesize' ) * 1024,
];


/* 
/* End of file upload_config.php */
/* Location: ./application/config/upload_config.php */