<?php
namespace SleepingOwl\Framework\Configuration;

trait ManagesAuthOptions
{
    /**
     * @return array
     */
    public function guardProvider(): array
    {
        return $this->config->get('guard_provider');
    }
}
