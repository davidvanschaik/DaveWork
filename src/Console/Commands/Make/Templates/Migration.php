<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Interfaces\Migration;

class <?= $className ?> implements Migration
{
    public function run(Builder $schema): void
    {
        $schema->create('<?= strtolower(str_replace('Migration', '', $className)) ?>', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('<?= strtolower(str_replace('Migration', '', $className)) ?>');
    }
}