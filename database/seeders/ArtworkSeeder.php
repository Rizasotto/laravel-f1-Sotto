<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArtworkSeeder extends Seeder
{
    public function run()
    {
        // Get all artist users
        $artists = User::where('role', 'artist')->get();
        
        if ($artists->isEmpty()) {
            return;
        }

        // Placeholder image URLs
        $images = [
            'https://picsum.photos/seed/1/400/300',
            'https://picsum.photos/seed/2/400/300',
            'https://picsum.photos/seed/3/400/300',
            'https://picsum.photos/seed/4/400/300',
            'https://picsum.photos/seed/5/400/300',
            'https://picsum.photos/seed/6/400/300',
            'https://picsum.photos/seed/7/400/300',
            'https://picsum.photos/seed/8/400/300',
            'https://picsum.photos/seed/9/400/300',
            'https://picsum.photos/seed/10/400/300',
            'https://picsum.photos/seed/11/400/300',
            'https://picsum.photos/seed/12/400/300',
            'https://picsum.photos/seed/13/400/300',
            'https://picsum.photos/seed/14/400/300',
            'https://picsum.photos/seed/15/400/300',
        ];

        // Define artwork collections with category, price range, and details
        $artworks = [
            // Digital Art (₱1,500 - ₱3,500)
            ['title' => 'Neon Dreams - Digital Artwork', 'category' => 'Digital', 'price' => 2500, 'description' => 'A captivating digital piece exploring neon aesthetics and cyberpunk themes. Created with Photoshop and Procreate.', 'stock' => 1],
            ['title' => 'Ethereal Dimensions', 'category' => 'Digital', 'price' => 1800, 'description' => 'Abstract digital art combining geometric shapes with flowing patterns. High resolution ready for print.', 'stock' => 1],
            ['title' => '3D Character Development', 'category' => 'Digital', 'price' => 3500, 'description' => 'Professional 3D character model with detailed texturing and rigging. Perfect for game or animation projects.', 'stock' => 2],
            
            // Traditional Painting (₱2,000 - ₱5,000)
            ['title' => 'Sunset Over Manila Bay - Oil Painting', 'category' => 'Traditional', 'price' => 4500, 'description' => 'Original oil painting on canvas depicting a beautiful sunset. Dimensions: 60x80cm. Hand-painted by master artist.', 'stock' => 1],
            ['title' => 'Portrait Series: Youth', 'category' => 'Traditional', 'price' => 3500, 'description' => 'Expressive oil portrait showcasing youth and beauty. Part of our celebrated portrait series. 50x70cm canvas.', 'stock' => 1],
            ['title' => 'Watercolor Garden', 'category' => 'Traditional', 'price' => 2000, 'description' => 'Delicate watercolor work capturing blooming flowers in spring garden. Small format 30x40cm.', 'stock' => 3],
            
            // Photography (₱800 - ₱2,500)
            ['title' => 'Urban Architecture - Limited Edition', 'category' => 'Photo', 'price' => 2500, 'description' => 'Fine art photography print of modern architectural details. Limited to 50 copies. Premium quality matte finish.', 'stock' => 45],
            ['title' => 'Nature\'s Serenity - Forest Walk', 'category' => 'Photo', 'price' => 1200, 'description' => 'Landscape photography capturing misty forest at dawn. High resolution 4K print available.', 'stock' => 20],
            ['title' => 'Street Photography - Manila Life', 'category' => 'Photo', 'price' => 800, 'description' => 'Black and white street photography documenting everyday Filipino life. Documentary style.', 'stock' => 15],
            
            // Abstract Art (₱1,200 - ₱3,000)
            ['title' => 'Color Explosion - Abstract Canvas', 'category' => 'Abstract', 'price' => 3000, 'description' => 'Large abstract canvas with vibrant color combinations. Dimensions: 100x100cm. Acrylic on canvas.', 'stock' => 1],
            ['title' => 'Minimalist Geometry', 'category' => 'Abstract', 'price' => 1500, 'description' => 'Clean abstract design exploring geometric patterns and negative space. Perfect for modern interiors.', 'stock' => 2],
            
            // Sculpture (₱3,000 - ₱8,000)
            ['title' => 'Bronze Sculpture: Infinity', 'category' => 'Sculpture', 'price' => 6500, 'description' => 'Hand-cast bronze sculpture exploring concepts of infinity and motion. Height: 45cm. Numbered edition 5/20.', 'stock' => 1],
            ['title' => 'Wooden Figure Study', 'category' => 'Sculpture', 'price' => 4000, 'description' => 'Hand-carved wooden sculpture of human form. Sustainable hardwood. Height: 60cm.', 'stock' => 1],
        ];

        $statuses = ['active', 'active', 'active', 'active', 'inactive', 'inactive', 'deleted'];

        $index = 0;
        foreach ($images as $image) {
            $artwork = $artworks[$index % count($artworks)];
            
            Artwork::firstOrCreate(
                ['image_path' => $image],
                [
                    'title' => $artwork['title'],
                    'description' => $artwork['description'],
                    'price' => $artwork['price'],
                    'category' => $artwork['category'],
                    'user_id' => $artists->random()->id,
                    'status' => $statuses[$index % count($statuses)],
                    'views' => rand(50, 800),
                    'stock' => $artwork['stock'],
                ]
            );
            $index++;
        }
    }
}
