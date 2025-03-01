<?php

use App\Models\LostAndFoundCategory;
use App\Models\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lost_and_founds', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organization::class);
            $table->string('title');
            $table->text('description');
            $table->foreignIdFor(LostAndFoundCategory::class);
            $table->date('date_lost');
            $table->string('location');
            $table->enum('status', ['lost', 'found', 'claimed']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lost_and_founds');
    }
};
