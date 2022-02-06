<?php

namespace App\Util;

use ChargeBee_Addon;
use ChargeBee_Environment;
use ChargeBee_Plan;


class ChargebeeUtil
{
    private $result;

    public function __construct()
    {
        ChargeBee_Environment::configure(config('chargebee.site'),config('chargebee.api_key'));
    }

    /**
     * Retrieve all Plans.
     * 
     * @param array $data
     * @return mixed object or array.
     */
    public function retrieveAllPlan(array $data):void
    {
        $this->result = ChargeBee_Plan::all($data);
    }

    /**
     * Retrieve all addons.
     * 
     * @param array $data
     * @return mixed object or array.
     */
    public function retrieveAllAddons(array $data):void
    {
        $this->result = ChargeBee_Addon::all($data);
    }

    /**
     * Get Resource Result.
     * 
     * @return mixed object or array.
     */
    public function getResult()
    {
        return $this->result;
    }

}