<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class <?= $name ?> extends Model
{
    /** @use HasFactory<\Database\Factories\HalloFactory> */
    use HasFactory;
}
