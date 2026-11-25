<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\FittingType;
use Illuminate\Database\Seeder;

class FittingTypeSeeder extends Seeder
{
    public function run(): void
    {
        // CARCASE category
        $carcase = Category::create([
            'name'       => 'Carcase',
            'slug'       => 'carcase',
            'is_active'  => true,
            'sort_order' => 1,
        ]);

        $carcaseItems = [
            ['name' => 'Base Carcase', 'standard_time' => 25, 'unit' => 'per box'],
            ['name' => 'Tall Carcase', 'standard_time' => 30, 'unit' => 'per box'],
            ['name' => 'Wall Box', 'standard_time' => 35, 'unit' => 'per box'],
            ['name' => 'Loft Box', 'standard_time' => 30, 'unit' => 'per box'],
            ['name' => 'Loft Frame Work', 'standard_time' => 90, 'unit' => 'per 8ft'],
            ['name' => 'Breakfast Table', 'standard_time' => 120, 'unit' => 'per piece'],
            ['name' => 'Counter Top Multiwood', 'standard_time' => 20, 'unit' => 'per sheet'],
            ['name' => 'Hob Cutting', 'standard_time' => 15, 'unit' => 'per piece'],
            ['name' => 'Sink Cutting', 'standard_time' => 15, 'unit' => 'per piece'],
            ['name' => 'Shelf Fitting', 'standard_time' => 10, 'unit' => 'per piece'],
        ];

        foreach($carcaseItems as $item) {
            FittingType::create(array_merge(
                $item, ['category_id' => $carcase->id, 'is_active' => true]
            ));
        }

        // SHUTTER category
        $shutter = Category::create([
            'name'       => 'Shutter',
            'slug'       => 'shutter',
            'is_active'  => true,
            'sort_order' => 2,
        ]);

        $shutterItems = [
            ['name' => 'Base Shutter', 'standard_time' => 20, 'unit' => 'per piece'],
            ['name' => 'Tall Shutter', 'standard_time' => 45, 'unit' => 'per piece'],
            ['name' => 'Wall Shutter', 'standard_time' => 30, 'unit' => 'per piece'],
            ['name' => 'Loft Shutter', 'standard_time' => 40, 'unit' => 'per piece'],
            ['name' => 'Drawer Facia', 'standard_time' => 20, 'unit' => 'per piece'],
            ['name' => 'Dummy Fittings', 'standard_time' => 30, 'unit' => 'per piece'],
            ['name' => 'Built In Fridge Shutter', 'standard_time' => 180, 'unit' => 'per piece'],
            ['name' => 'Dishwasher Shutter', 'standard_time' => 40, 'unit' => 'per piece'],
            ['name' => 'Oven Fittings', 'standard_time' => 30, 'unit' => 'per piece'],
        ];

        foreach($shutterItems as $item) {
            FittingType::create(array_merge(
                $item, ['category_id' => $shutter->id, 'is_active' => true]
            ));
        }

        // ACCESSORIES category
        $accessories = Category::create([
            'name'       => 'Accessories',
            'slug'       => 'accessories',
            'is_active'  => true,
            'sort_order' => 3,
        ]);

        $accessoryItems = [
            ['name' => 'Tandam Box', 'standard_time' => 30, 'unit' => 'per piece'],
            ['name' => 'Inner Tandam Box', 'standard_time' => 30, 'unit' => 'per piece'],
            ['name' => 'Tall Unit', 'standard_time' => 90, 'unit' => 'per piece'],
            ['name' => 'Corner Unit', 'standard_time' => 60, 'unit' => 'per piece'],
            ['name' => 'Waste Boy', 'standard_time' => 30, 'unit' => 'per piece'],
            ['name' => 'Rolling Shutter', 'standard_time' => 60, 'unit' => 'per piece'],
            ['name' => 'GTPT', 'standard_time' => 30, 'unit' => 'per piece'],
            ['name' => 'Avantos', 'standard_time' => 45, 'unit' => 'per piece'],
            ['name' => 'Pocket Door System', 'standard_time' => 180, 'unit' => 'per piece'],
            ['name' => 'Skirting L Type', 'standard_time' => 120, 'unit' => 'per piece'],
            ['name' => 'Light Channel Fittings', 'standard_time' => 60, 'unit' => 'per piece'],
            ['name' => 'Cleaning Kitchen', 'standard_time' => 480, 'unit' => 'per kitchen'],
            ['name' => 'Cornish 8ft', 'standard_time' => 90, 'unit' => 'per 8ft'],
            ['name' => 'Glass Shelf', 'standard_time' => 10, 'unit' => 'per piece'],
            ['name' => 'Knob/Handle', 'standard_time' => 10, 'unit' => 'per piece'],
            ['name' => 'Push Open', 'standard_time' => 10, 'unit' => 'per piece'],
            ['name' => 'Cutlery', 'standard_time' => 10, 'unit' => 'per piece'],
            ['name' => 'Plate Tray', 'standard_time' => 15, 'unit' => 'per piece'],
            ['name' => 'Wicker Basket', 'standard_time' => 60, 'unit' => 'per piece'],
            ['name' => 'Covering', 'standard_time' => 60, 'unit' => 'per piece'],
        ];

        foreach($accessoryItems as $item) {
            FittingType::create(array_merge(
                $item, ['category_id' => $accessories->id, 'is_active' => true]
            ));
        }

        // WARDROBE category
        $wardrobe = Category::create([
            'name'       => 'Wardrobe',
            'slug'       => 'wardrobe',
            'is_active'  => true,
            'sort_order' => 4,
        ]);

        $wardrobeItems = [
            ['name' => 'Wardrobe Carcase', 'standard_time' => 180, 'unit' => 'per piece'],
            ['name' => 'Wardrobe Door', 'standard_time' => 60, 'unit' => 'per piece'],
            ['name' => 'Drawer', 'standard_time' => 30, 'unit' => 'per piece'],
            ['name' => 'Jewellery Tray', 'standard_time' => 45, 'unit' => 'per piece'],
            ['name' => 'Handle', 'standard_time' => 15, 'unit' => 'per piece'],
            ['name' => 'Knob', 'standard_time' => 15, 'unit' => 'per piece'],
            ['name' => 'Lighting', 'standard_time' => 480, 'unit' => 'per wardrobe'],
        ];

        foreach($wardrobeItems as $item) {
            FittingType::create(array_merge(
                $item, ['category_id' => $wardrobe->id, 'is_active' => true]
            ));
        }
    }
}