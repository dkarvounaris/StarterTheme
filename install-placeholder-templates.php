<?php

@ini_set('display_errors', 'on');

$modulesDirectory = realpath(implode(DIRECTORY_SEPARATOR, [
  __DIR__, '..', '..', 'modules'
]));

$modulesToInclude = [
    'socialsharing',
    'blocksocial',
    'blockfacebook',
    'sendtoafriend',
    'blockcms',
    'blockcmsinfo',
    'blockmyaccount',
    'blockmyaccountfooter',
    'blockcontact',
    'blockcontactinfos',
    'blockpaymentlogo',
    'productpaymentlogos',
    'blocknewsletter',
    'themeconfigurator',
    'blockbanner',
    'blockbestsellers',
    'blockspecials',
    'blocknewproducts',
    'blockviewed',
    'homefeatured',
    'blocklayered',
    'homeslider',
    'blockstore',
    'blockwishlist',
    'blockmanufacturer',
    'blocksupplier',
    'bankwire',
    'blocktags',
    'blockcart',
    'blockuserinfo',
    'blockcategories',
    'blockcurrencies',
    'blocklanguages',
    'blocksearch',
    'blocktopmenu',
    'cheque',
    'productcomments'
];

if ($modulesDirectory === false) {
    throw new Exception('Modules directory not found.');
}

foreach ($modulesToInclude as $moduleName) {
    $moduleDirectory = $modulesDirectory . DIRECTORY_SEPARATOR . $moduleName;
    foreach (
        new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($moduleDirectory)
        ) as $entry
    ) {
        if ($entry->getExtension() === 'tpl') {
            $relativeTemplatePath = substr(
                $entry->getRealPath(),
                strlen($modulesDirectory) + 1
            );

            $skeletonTemplateToCreate = implode(DIRECTORY_SEPARATOR, [
                __DIR__, 'modules', $relativeTemplatePath
            ]);

            $directoryToCreate = dirname($skeletonTemplateToCreate);

            echo sprintf("Installing placeholder template: %1\$s\n", $relativeTemplatePath);

            if (!is_dir($directoryToCreate)) {
                if (mkdir($directoryToCreate, 0755, true) === false) {
                    throw new Exception(
                        sprintf('Could not create directory `%1$s`.', $directoryToCreate)
                    );
                }
            }

            $placeHolder = '<!-- automatically generated by install-placeholder-templates.php --><span class="placeholder-template">' . $relativeTemplatePath . '</span>';

            if (file_put_contents($skeletonTemplateToCreate, $placeHolder) === false) {
                throw new Exception(
                    sprintf('Could not create file `%1$s`.', $skeletonTemplateToCreate)
                );
            }
        }
    }
}

echo "\nAll good, kthxbai.\n";
