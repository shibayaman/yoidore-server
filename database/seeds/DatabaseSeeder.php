<?php

use App\Category;
use App\User;
use App\Parameter;
use App\Review;
use App\ReviewDetail;
use App\Sake;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $others = factory(User::class, 1)->create();
        $me = factory(User::class, 1)->create([
            'username' => 'shiba',
            'password' => Hash::make('shiba')
        ]);
        $users = $others->concat($me);

        $categories = factory(Category::class, 2)->create();

        $sakes = new EloquentCollection();
        foreach ($categories as $category) {
            $newSakes = factory(Sake::class, 2)->create(['category_id' => $category]);
            $sakes = $sakes->concat($newSakes);
        }

        $parameters = $this->createRelatedObjects(Parameter::class, $users, $categories, 3);

        $reviews = $this->createRelatedObjects(Review::class, $users, $sakes);

        $this->createRelatedObjects(ReviewDetail::class, $reviews, $parameters);
    }

    private function createRelatedObjects($class, $parents, $children, $amount = 1)
    {
        $objects = new EloquentCollection();

        foreach ($parents as $parent) {
            foreach ($children as $child) {
                $newObjects = factory($class, $amount)->create([
                    $this->getForeignName($parent) => $parent->id,
                    $this->getForeignName($child) => $child->id,
                ]);
                $objects = $objects->concat($newObjects);
            }
        }

        return $objects;
    }

    private function getForeignName($model)
    {
        $fullClassName = get_class($model);

        if (strpos($fullClassName, '\\')) {
            $className = substr($fullClassName, strrpos($fullClassName, '\\') + 1);
        }

        return strtolower($className) . '_id';
    }
}
