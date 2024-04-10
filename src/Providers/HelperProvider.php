<?php
/** @noinspection PhpIllegalPsrClassPathInspection */
/*
 * Copyright © 2023. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace MPhpMaster\LaravelDevHelpers\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextualizedDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;

/**
 * Class HelperProvider
 *
 * @package MPhpMaster\LaravelDevHelpers\Providers
 */
class HelperProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @param Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Builder::defaultStringLength(191);
        // Schema::defaultStringLength(191);

	    $cloner = new VarCloner();
	    $cloner->addCasters([]);

	    $format = $_SERVER['VAR_DUMPER_FORMAT'] ?? 'html';
	    switch(true) {
		    case 'html' === $format:
			    ($dumper = new HtmlDumper());
			    break;
		    case 'cli' === $format:
			    $dumper = new CliDumper();
			    break;
		    default:
			    $dumper = \in_array(\PHP_SAPI, [ 'cli', 'phpdbg', 'embed' ], true) ? new CliDumper() : new HtmlDumper();
	    }

	    if(!$dumper instanceof ServerDumper) {
		    $dumper = new ContextualizedDumper($dumper, [ new SourceContextProvider() ]);
	    }

	    $handler = function($var, ?string $label = null) use ($cloner, $dumper) {
		    $s = (new SourceContextProvider(null, null, null))->getContext();
		    $s['file'] = ltrim(Str::after($s['file'], base_path()), '/');
		    echo <<<EOF
<input style='color:darkgrey;width:100%;border:0' type='text' value='{$s['file']}:{$s['line']}' onclick='this.select()'>
EOF;
		    $var = $cloner->cloneVar($var);


		    if(null !== $label) {
			    $var = $var->withContext([ 'label' => $label ]);
		    }

		    /** @var \Symfony\Component\VarDumper\Cloner\Data $var */
		    $dumper->dump($var);
	    };
	    \Symfony\Component\VarDumper\VarDumper::setHandler($handler);

		/**
         * Helpers
         */
        require_once __DIR__ . '/../Helpers/FCheckers.php';
        require_once __DIR__ . '/../Helpers/FDebug.php';
        require_once __DIR__ . '/../Helpers/FGetters.php';
        require_once __DIR__ . '/../Helpers/FHelpers.php';
        require_once __DIR__ . '/../Helpers/FTools.php';
    }

    /**
     *
     */
    public function registerMacros()
    {

    }

    /**
     * @return array
     */
    public function provides()
    {
        return [];
    }

    public function register()
    {
        // $this->registerMacros();
    }
}
