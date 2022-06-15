<?php /** @noinspection DuplicatedCode */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::dropIfExists('user_invites');
        Schema::create('user_invites', static function (Blueprint $table) {
            $table->id();
            $table->string('created_by_user_identifier')->nullable();
            $table->string('used_by_user_identifier')->nullable();
            $table->string('created_by_name')->nullable();
            $table->string('used_by_name')->nullable();
            $table->uuid('code');
            $table->boolean('is_used')->default(false);
            $table->dateTime('valid_until')->nullable();
            $table->timestamps();

            $table->index(['code']);
            $table->index(['created_by_user_id', 'valid_until']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('user_invites');
        Schema::create('user_invites', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('used_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->uuid('code');
            $table->boolean('is_used')->default(false);
            $table->dateTime('valid_until')->nullable();
            $table->timestamps();

            $table->index(['code']);
            $table->index(['created_by_user_id', 'valid_until']);
        });
    }
};
