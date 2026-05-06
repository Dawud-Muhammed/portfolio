<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('skills')) {
            return;
        }

        if (Schema::hasColumn('skills', 'proficiency')) {
            // proficiency already present, nothing to do
            return;
        }

        if (Schema::hasColumn('skills', 'level')) {
            Schema::table('skills', function (Blueprint $table): void {
                $table->enum('proficiency', ['beginner', 'intermediate', 'proficient'])->default('beginner')->after('name');
            });

            // Map existing numeric levels to qualitative proficiencies
            DB::table('skills')->update(["proficiency" => DB::raw("CASE
                WHEN level BETWEEN 0 AND 40 THEN 'beginner'
                WHEN level BETWEEN 41 AND 70 THEN 'intermediate'
                ELSE 'proficient'
            END")]);

            Schema::table('skills', function (Blueprint $table): void {
                $table->dropColumn('level');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('skills')) {
            return;
        }

        if (! Schema::hasColumn('skills', 'proficiency')) {
            return;
        }

        Schema::table('skills', function (Blueprint $table): void {
            $table->unsignedTinyInteger('level')->default(0)->after('name');
        });

        // Map qualitative proficiencies back to representative percentage values
        DB::table('skills')->update(["level" => DB::raw("CASE
            WHEN proficiency = 'beginner' THEN 30
            WHEN proficiency = 'intermediate' THEN 55
            WHEN proficiency = 'proficient' THEN 85
            ELSE 0
        END")]);

        Schema::table('skills', function (Blueprint $table): void {
            $table->dropColumn('proficiency');
        });
    }
};
