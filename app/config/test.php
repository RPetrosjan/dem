{
"name": "symfony/framework-standard-edition",
"license": "MIT",
"type": "project",
"description": "The \"Symfony Standard Edition\" distribution",
"autoload": {
"psr-4": {
"AppBundle\\": "src/AppBundle"
},
"classmap": [ "app/AppKernel.php", "app/AppCache.php" ]
},
"autoload-dev": {
"psr-4": { "Tests\\": "tests/" },
"files": [ "vendor/symfony/symfony/src/Symfony/Component/VarDumper/Resources/functions/dump.php" ]
},
"require": {
"php": ">=5.5.9",
"doctrine/doctrine-bundle": "^1.6",
"doctrine/orm": "^2.5",
"incenteev/composer-parameter-handler": "^2.0",
"sensio/distribution-bundle": "^5.0.19",
"sensio/framework-extra-bundle": "^5.0.0",
"symfony/monolog-bundle": "^3.1.0",
"symfony/polyfill-apcu": "^1.0",
"symfony/swiftmailer-bundle": "^2.6.4",
"symfony/symfony": "3.4.*",
"twig/twig": "^1.0||^2.0"
},
"require-dev": {
"sensio/generator-bundle": "^3.0",
"symfony/phpunit-bridge": "^3.0"
},
"scripts": {
"symfony-scripts": [
"Incenteev\\ParameterHandler\\ScriptHandler::buildParameters",
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::buildBootstrap",
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets",
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installRequirementsFile",
"Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::prepareDeploymentTarget"
],
"post-install-cmd": [
"@symfony-scripts"
],
"post-update-cmd": [
"@symfony-scripts"
]
},
"config": {
"platform": {
"php": "5.6"
},
"sort-packages": true
},
"extra": {
"symfony-app-dir": "app",
"symfony-bin-dir": "bin",
"symfony-var-dir": "var",
"symfony-web-dir": "web",
"symfony-tests-dir": "tests",
"symfony-assets-install": "relative",
"incenteev-parameters": {
"file": "app/config/parameters.yml"
},
"branch-alias": {
"dev-master": "3.4-dev"
}
}
}
