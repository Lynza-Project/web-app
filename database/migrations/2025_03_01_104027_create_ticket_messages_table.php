<?php

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ticket_messages', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ticket::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Organization::class);
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_messages');
    }
};
