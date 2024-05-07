<?php

use App\Enums\RoomStatus;
use App\Enums\RoomType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid()->default(Uuid::uuid4());
            $table->string('name');
            $table->longText('description');
            $table->tinyInteger('type')->unsigned()->default(RoomType::UNKNOWN);
            $table->tinyInteger('status')->unsigned()->default(RoomStatus::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
