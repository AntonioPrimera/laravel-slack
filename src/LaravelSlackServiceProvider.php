<?php

namespace AntonioPrimera\Slack;

use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;

class LaravelSlackServiceProvider extends PackageServiceProvider
{
	
	public function configurePackage(Package $package): void
	{
		$package
			->name('antonioprimera/laravel-slack')
			->hasConfigFile('slack');
		
			//->hasViews()
			//->hasViewComponent('spatie', Alert::class)
			//->hasViewComposer('*', MyViewComposer::class)
			//->sharesDataWithAllViews('downloads', 3)
			//->hasTranslations()
			//->hasAssets()
			//->hasRoute('web')
			//->hasMigration('create_package_tables')
			//->hasCommand(YourCoolPackageCommand::class);
	}
}