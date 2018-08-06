<?php

namespace Sth348962\Algorithms\MaximumSubarrayProblem;

class Result
{
    public $sum;

    /**
     * @var \Sth348962\Algorithms\MaximumSubarrayProblem\Subarray[]
     */
    public $subarrays;

    public function __construct(int $sum, array $subarrays)
    {
        $this->sum = $sum;
        $this->subarrays = $subarrays;
    }
}