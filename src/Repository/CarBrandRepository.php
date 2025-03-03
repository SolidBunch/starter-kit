<?php

namespace StarterKit\Repository;

defined('ABSPATH') || exit;

/**
 * Repository for Car brands directory objects
 *
 * @package    Starter Kit
 */
class CarBrandRepository
{
    /**
     * Get Car Brands array
     *
     * @return array
     */
    public static function getCarBrands(): array
    {
        return [
            'acura' => __('Acura', 'starter-kit'),
            'alfa_romeo' => __('Alfa Romeo', 'starter-kit'),
            'aston_martin' => __('Aston Martin', 'starter-kit'),
            'audi' => __('Audi', 'starter-kit'),
            'bentley' => __('Bentley', 'starter-kit'),
            'bmw' => __('BMW', 'starter-kit'),
            'buick' => __('Buick', 'starter-kit'),
            'cadillac' => __('Cadillac', 'starter-kit'),
            'chevrolet' => __('Chevrolet', 'starter-kit'),
            'chrysler' => __('Chrysler', 'starter-kit'),
            'dodge' => __('Dodge', 'starter-kit'),
            'ferrari' => __('Ferrari', 'starter-kit'),
            'fiat' => __('Fiat', 'starter-kit'),
            'ford' => __('Ford', 'starter-kit'),
            'genesis' => __('Genesis', 'starter-kit'),
            'gmc' => __('GMC', 'starter-kit'),
            'honda' => __('Honda', 'starter-kit'),
            'hyundai' => __('Hyundai', 'starter-kit'),
            'infiniti' => __('Infiniti', 'starter-kit'),
            'jaguar' => __('Jaguar', 'starter-kit'),
            'jeep' => __('Jeep', 'starter-kit'),
            'kia' => __('Kia', 'starter-kit'),
            'lamborghini' => __('Lamborghini', 'starter-kit'),
            'land_rover' => __('Land Rover', 'starter-kit'),
            'lexus' => __('Lexus', 'starter-kit'),
            'lincoln' => __('Lincoln', 'starter-kit'),
            'maserati' => __('Maserati', 'starter-kit'),
            'mazda' => __('Mazda', 'starter-kit'),
            'mclaren' => __('McLaren', 'starter-kit'),
            'mercedes_benz' => __('Mercedes-Benz', 'starter-kit'),
            'mini' => __('MINI', 'starter-kit'),
            'mitsubishi' => __('Mitsubishi', 'starter-kit'),
            'nissan' => __('Nissan', 'starter-kit'),
            'porsche' => __('Porsche', 'starter-kit'),
            'ram' => __('RAM', 'starter-kit'),
            'rolls_royce' => __('Rolls-Royce', 'starter-kit'),
            'subaru' => __('Subaru', 'starter-kit'),
            'tesla' => __('Tesla', 'starter-kit'),
            'toyota' => __('Toyota', 'starter-kit'),
            'volkswagen' => __('Volkswagen', 'starter-kit'),
            'volvo' => __('Volvo', 'starter-kit'),
        ];
    }
}
