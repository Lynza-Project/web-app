<?php

use App\Models\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('themes', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class);
            $table->string('title');
            $table->string('primary');
            $table->string('font');
            $table->string('background_color')->nullable();
            $table->string('button_color')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
