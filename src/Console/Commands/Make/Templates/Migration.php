<?= "<?php\n" ?> <?php $class = ucfirst(substr($name, 11, -6)); ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Src\Abstracts\Migration;

return new class extends Migration
{
    public function run(Builder $schema): void
    {
        $schema->create('<?= strtolower($class) . 's' ?>', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('<?= strtolower($class) . 's' ?>');
    }
};