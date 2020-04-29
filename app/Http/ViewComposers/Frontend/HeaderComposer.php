<?php

namespace App\Http\ViewComposers\Frontend;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ServiceCategoryRepository;
use Illuminate\View\View;
use Session;


class HeaderComposer
{
    /**
     * Create a new sidebar composer.
     *
     * @return void
     */
    protected $propertyCategory, $productCategory, $serviceCategory;

    public function __construct(CategoryRepository $propertyCategory, ProductCategoryRepository $productCategory,ServiceCategoryRepository $serviceCategory)
    {
            $this->propertyCategory = $propertyCategory;
            $this->productCategory = $productCategory;
            $this->serviceCategory = $serviceCategory;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $categories = $this->propertyCategory->where('is_active','1')->get();
        $productCategories = $this->productCategory->where('is_active','1')->orderBy('created_at','desc')->get();
        $servicecategories = $this->serviceCategory->where('is_active','1')->orderBy('created_at','desc')->get();
        $data = Session::get('cart');
//        dd( $data );
        $view->with('categories',$categories)
                ->with('productCategories',$productCategories)
                ->with('data',$data)
                ->with('servicecategories',$servicecategories);


    }
}
