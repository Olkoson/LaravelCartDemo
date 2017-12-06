<?php
namespace App\Library\Services;

use App\Library\Services\DiscountServiceInterface;

class DiscountService implements DiscountServiceInterface
{
    /**
     * @param $products
     *
     * @return float
     */
    public function calculateDiscountBogof($products)
    {
        $discountAmount = 0;
        $discounts = $this->getDiscountPrograms("bogof");

        foreach ($products as $product) {
            if (($product->quantity >= 2) &&
                in_array($product->product_id, array_column($discounts, 'product_id'))) { // search value in the array
                $discountAmount += $product->price;
            }
        }

        return number_format($discountAmount, 2);
    }

    /**
     * @param float $price
     *
     * @return float
     */
    public function calculateDiscountGreater($price)
    {
        $discountAmount = 0;
        $discounts = $this->getDiscountPrograms("greater_than");

        foreach ($discounts as $discount) {
            if ($price > $discount['price_value']) {
                $discountAmount = $price * $discount['discount'];
            }
        }

        return number_format($discountAmount, 2);
    }

    /**
     * @param integer $userId
     *
     * @return float
     */
    public function calculateDiscountLoyalty($userId, $price)
    {
        $discountAmount = 0;
        $discounts = $this->getDiscountPrograms("user_loyalty");

        foreach ($discounts as $discount) {
            if ($discount['user_id'] == $userId) {
                $discountAmount = $price * $discount['discount'];
                break;
            }
        }

        return number_format($discountAmount, 2);
    }

    /**
     * TODO move discounts to a database
     * @param string $type
     *
     * @return array
     */
    public function getDiscountPrograms($type = '')
    {
        //hardcoded values for a different type of deals, should be stored at the database
        //values for a bogof deals
        $discounts = [];
        $discounts['bogof'][0]['product_id'] = 1;
        $discounts['bogof'][1]['product_id'] = 2;

        //values for a deals when price greater than
        $discounts['greater_than'][0]['price_value'] = 20;
        $discounts['greater_than'][0]['discount'] = 0.1;

        //values for a user loyalty deals
        $discounts['user_loyalty'][0]['user_id'] = 1;
        $discounts['user_loyalty'][0]['discount'] = 0.02;
        $discounts['user_loyalty'][1]['user_id'] = 2;
        $discounts['user_loyalty'][1]['discount'] = 0.02;

        if ($type) {
            return $discounts[$type];
        } else {
            return [];
        }
    }
}