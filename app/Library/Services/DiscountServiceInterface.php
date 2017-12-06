<?php
namespace App\Library\Services;

Interface DiscountServiceInterface
{
    public function calculateDiscountBogof($products);

    public function calculateDiscountGreater($price);

    public function calculateDiscountLoyalty($userId, $price);

    public function getDiscountPrograms($type);

}