<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_features', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        DB::table('subscription_features')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Custom Branding',
                'slug' => 'custom_branding',
                'description' => 'Use your own logo and brand colors.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Payment Integration',
                'slug' => 'payment_link',
                'description' => 'Generate and share payment links with invoices.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Recurring Invoices',
                'slug' => 'recurring_invoices',
                'description' => 'Automatically send invoices on a recurring schedule.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Invoice Tracking',
                'slug' => 'invoice_tracking',
                'description' => 'Track sent, paid, and overdue invoices.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Export Reports',
                'slug' => 'report_export',
                'description' => 'Download invoice and expense reports in Excel or PDF.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_features');
    }
};
