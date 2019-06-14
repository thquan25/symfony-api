<?php

namespace App\Util;

use Symfony\Component\Serializer\SerializerInterface;

class SerializeUtil
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function normalize($target, $maxDepth = 1)
    {
        if (empty($target)) {
            return [];
        }

        return $target;
    }
}
