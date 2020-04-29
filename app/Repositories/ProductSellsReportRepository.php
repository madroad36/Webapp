<?php
/**
 * Created by PhpStorm.
 * User: Amit Shrestha <amitshrestha221@gmail.com> <https://amitstha.com.np>
 * Date: 10/31/18
 * Time: 3:36 PM
 */

namespace App\Repositories;




use App\Models\ProductSellReport;

class ProductSellsReportRepository extends  BaseRepository
{
    public function __construct(ProductSellReport $productsellReport)
    {
        $this->model = $productsellReport;
    }
}