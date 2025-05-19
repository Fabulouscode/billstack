<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subs_plan_feature', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subscription_plan_id');
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')->onDelete('cascade');
            $table->uuid('subscription_feature_id');
            $table->foreign('subscription_feature_id')->references('id')->on('subscription_features')->onDelete('cascade');
            $table->timestamps();
        });

        $plans = DB::table('subscription_plans')->pluck('id', 'slug');
        $features = DB::table('subscription_features')->pluck('id', 'slug');

        // Assign features to plans
        DB::table('subs_plan_feature')->insert([

            // Pro (Monthly) plan features
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_monthly'],
                'subscription_feature_id' => $features['custom_branding'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_monthly'],
                'subscription_feature_id' => $features['payment_link'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_monthly'],
                'subscription_feature_id' => $features['recurring_invoices'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_monthly'],
                'subscription_feature_id' => $features['invoice_tracking'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_monthly'],
                'subscription_feature_id' => $features['report_export'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Pro (Yearly) plan gets the same features
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_yearly'],
                'subscription_feature_id' => $features['custom_branding'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_yearly'],
                'subscription_feature_id' => $features['payment_link'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_yearly'],
                'subscription_feature_id' => $features['recurring_invoices'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_yearly'],
                'subscription_feature_id' => $features['invoice_tracking'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'subscription_plan_id' => $plans['pro_yearly'],
                'subscription_feature_id' => $features['report_export'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subs_plan_features');
    }
};
