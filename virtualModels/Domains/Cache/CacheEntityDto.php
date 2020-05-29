<?php

namespace app\virtualModels\Domains\Cache;

class CacheEntityDto
{
    private $cacheId;

    private $cacheClass;

    private $cacheData;

    public function __construct(
        $cacheId,
        $cacheClass,
        $cacheData
    ) {
        $this->cacheId = $cacheId;
        $this->cacheClass = $cacheClass;
        $this->cacheData = $cacheData;
    }

    /**
     * @return mixed
     */
    public function getCacheId()
    {
        return $this->cacheId;
    }

    /**
     * @param mixed $cacheId
     */
    public function setCacheId($cacheId)
    {
        $this->cacheId = $cacheId;
    }

    /**
     * @return mixed
     */
    public function getCacheClass()
    {
        return $this->cacheClass;
    }

    /**
     * @param mixed $cacheClass
     */
    public function setCacheClass($cacheClass)
    {
        $this->cacheClass = $cacheClass;
    }

    /**
     * @return mixed
     */
    public function getCacheData()
    {
        return $this->cacheData;
    }

    /**
     * @param mixed $cacheData
     */
    public function setCacheData($cacheData)
    {
        $this->cacheData = $cacheData;
    }
}