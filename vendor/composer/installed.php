<?php return array(
    'root' => array(
        'name' => '__root__',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => NULL,
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'chillerlan/php-qrcode' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => 'f15b0afe9d4128bf734c3bf1bcffae72bf7b3e53',
            'type' => 'library',
            'install_path' => __DIR__ . '/../chillerlan/php-qrcode',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'chillerlan/php-settings-container' => array(
            'pretty_version' => '2.1.4',
            'version' => '2.1.4.0',
            'reference' => '1beb7df3c14346d4344b0b2e12f6f9a74feabd4a',
            'type' => 'library',
            'install_path' => __DIR__ . '/../chillerlan/php-settings-container',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
