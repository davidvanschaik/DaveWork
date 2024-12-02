<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

use Src\Http\Request;
use Src\Http\Controllers\Controller;

class <?= $name; ?> extends Controller

{
    public function index(Request $request)
    {
        //
    }
}