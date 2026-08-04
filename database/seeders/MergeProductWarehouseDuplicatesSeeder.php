<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MergeProductWarehouseDuplicatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        try {
            // Find duplicate warehouse-product combinations
            $duplicates = DB::table('product_warehouse')
                ->select('product_id', 'warehouse_id', 'variant_id', 'product_batch_id', DB::raw('COUNT(*) as count'))
                ->groupBy('product_id', 'warehouse_id', 'variant_id', 'product_batch_id')
                ->having('count', '>', 1)
                ->get();

            $totalMerged = 0;
            foreach ($duplicates as $dup) {
                // Get all rows in the duplicate group
                $rows = DB::table('product_warehouse')
                    ->where('product_id', $dup->product_id)
                    ->where('warehouse_id', $dup->warehouse_id)
                    ->where('variant_id', $dup->variant_id)
                    ->where('product_batch_id', $dup->product_batch_id)
                    ->orderBy('id', 'asc')
                    ->get();
                    
                $firstRow = $rows->first();
                $totalQty = $rows->sum('qty');
                
                // Update the first row with combined quantity
                DB::table('product_warehouse')
                    ->where('id', $firstRow->id)
                    ->update(['qty' => $totalQty]);
                    
                // Delete the remaining duplicate rows
                $deleteIds = $rows->slice(1)->pluck('id')->toArray();
                DB::table('product_warehouse')
                    ->whereIn('id', $deleteIds)
                    ->delete();
                    
                $totalMerged += count($deleteIds);
            }
            
            DB::commit();
            $this->command->info("Successfully merged product_warehouse duplicates! Deleted $totalMerged duplicate rows.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Error occurred while merging duplicates: " . $e->getMessage());
        }
    }
}
