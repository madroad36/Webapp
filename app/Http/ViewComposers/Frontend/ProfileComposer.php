<?php

namespace App\Http\ViewComposers\Frontend;


use App\Repositories\AminitiesRepository;
use App\Repositories\BrokerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductCategoryRepository;

use App\Repositories\ServiceCategoryRepository;
use App\Repositories\SubcategoryRepository;
use App\Repositories\TechnicianRepository;
use App\Repositories\VendorRepository;
use Illuminate\View\View;
use Auth;


class ProfileComposer
{
    /**
     * Create a new sidebar composer.
     *
     * @return void
     */
    protected  $productCategory, $propertyCategory, $aminites,$propertySubcategory,$serviceCategory,$broker,$vendor,$technician;

    public function __construct(ProductCategoryRepository $productCategory,
                                CategoryRepository $propertyCategory,
                                AminitiesRepository $aminites,
                                SubcategoryRepository $propertySubcategory,
                                ServiceCategoryRepository $serviceCategory,
                                BrokerRepository $broker,
                                VendorRepository $vendor,
                                TechnicianRepository $technician)
    {
        $this->productCategory = $productCategory;
        $this->propertyCategory = $propertyCategory;
        $this->propertySubcategory= $propertySubcategory;
        $this->aminites = $aminites;
        $this->serviceCategory = $serviceCategory;
        $this->broker = $broker;
        $this->vendor = $vendor;
        $this->technician = $technician;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {

        $aminites = $this->aminites->where('is_active', '1')->get();
        $propertySubcategories = $this->propertySubcategory->where('is_active','1')->orderBy('created_at','desc')->get();
        $propertyCategories = $this->propertyCategory->where('is_active','1')->orderBy('created_at','desc')->get();
        $productCategories = $this->productCategory->where('is_active','1')->orderBy('created_at','desc')->get();
        $serviceCategories = $this->serviceCategory->where('is_active','1')->orderBy('name')->get();

        $broker = $this->broker->where('broker_id',Auth::user()->id)->first();


        $vendor = $this->vendor->where('vendor_id',Auth::user()->id)->first();
        $technician = $this->technician->where('technician_id',Auth::user()->id)->first();
        $view->with('productCategories',$productCategories)
            ->with('propertyCategories', $propertyCategories)
            ->with('propertySubcategories',$propertySubcategories)
            ->with('aminites',$aminites)
            ->with('broker',$broker)
            ->with('vendor',$vendor)
            ->with('technician',$technician)
        ->with('serviceCategories',$serviceCategories);


    }
}
