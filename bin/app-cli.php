<?php
require_once dirname(__DIR__) . '/src/bootstrap.php';

use App\Models\Foo;

// $foo = new Foo($db_connection);
// $foo->first_name = 'marko';
// $foo->last_name = 'jovic';
// $foo->save();

// $bar = new Foo($db_connection);
// $bar->first_name = 'srdjan';
// $bar->save();

$mjau = (new Foo($db_connection))->all();

foreach ($mjau as $khm) {
	var_dump($khm->id, $khm->first_name, $khm->last_name);
}
// $mjau->delete();
