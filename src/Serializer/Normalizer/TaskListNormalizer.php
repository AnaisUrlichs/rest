<?php

namespace App\Serializer\Normalizer;

use App\Entity\TaskList;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TaskListNormalizer implements NormalizerInterface {

    /**
     * @var Packages
     */
    private $packages;
    /**
     * @var ObjectNormalizer
     */
    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer, Packages $packages){
        $this->packages = $packages;
        $this->objectNormalizer = $objectNormalizer;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $object->setbackgroundPath(
            $this->packages->getUrl($object->getBackgroundPath(), 'backgrounds')
        );

        /**
         * Set context before you normalize your stuff
         */
        $context['ignored_attributes'] = ['user'];

        $data = $this->objectNormalizer->normalize($object, $format, $context);

        /** return the object after modification */
        return $data;
    }

    public function supportsNormalization($data, $format = null)
    {
       return $data instanceof TaskList;
    }
}