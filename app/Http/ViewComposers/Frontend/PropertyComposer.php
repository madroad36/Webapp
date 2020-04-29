<?php

namespace App\Http\ViewComposers\Frontend;


use App\Repositories\AminitiesRepository;


use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PlaceRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\SubcategoryRepository;
use Illuminate\View\View;


class PropertyComposer
{
    /**
     * Create a new sidebar composer.
     *
     * @return void
     */
    protected  $propertyCategory, $property, $aminites,$propertySubcategory,$location,$address;

    public function __construct(PropertyRepository $property,
                                CategoryRepository $propertyCategory,
                                AminitiesRepository $aminites,
                                SubcategoryRepository $propertySubcategory,
                                LocationRepository $location,
                                PlaceRepository $address
    )
    {
        $this->property = $property;
        $this->propertyCategory = $propertyCategory;
        $this->propertySubcategory= $propertySubcategory;
        $this->aminites = $aminites;
        $this->location = $location;
        $this->address= $address;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {

        $locations = $this->location->orderBy('created_at','desc')->get();
        $address = $this->address->orderBy('created_at','desc')->get();
        $aminites = $this->aminites->where('is_active', '1')->get();
        $propertySubcategories = $this->propertySubcategory->where('is_active','1')->orderBy('created_at','desc')->get();

        $propertyCategories = $this->propertyCategory->where('is_active','1')->orderBy('created_at','desc')->get();

        $view->with('propertyCategories', $propertyCategories)
            ->with('propertySubcategories',$propertySubcategories)
            ->with('aminites',$aminites)
            ->with('locations',$locations)
            ->with('address',$address);


    }
}
