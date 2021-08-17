<?php

namespace HelthjemSDK\Shared\Interfaces;

interface Configuration
{
    public function getUserName();
    public function getPassword();
    public function isProduction();
    public function getShopId();
    public function getTransportSolutionId();
}
