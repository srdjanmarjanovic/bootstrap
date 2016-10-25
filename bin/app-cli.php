<?php
require_once dirname(__DIR__) . '/src/bootstrap.php';

use App\Models\Foo;

// $foo = new Foo($db_connection);
// $foo->first_name = 'marko';
// $foo->last_name = 'jovic';
// $foo->save();

// $foo->first_name = 'srdjan';
// $foo->save();

$mjau = (new Foo($db_connection))->find(9);
// $foo->delete();
