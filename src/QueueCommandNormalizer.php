<?php

namespace League\Tactician\Bernard;

use Assert\Assertion;
use Bernard\Normalizer\AbstractAggregateNormalizerAware;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class QueueCommandNormalizer extends AbstractAggregateNormalizerAware implements NormalizerInterface, DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'class' => get_class($object->getCommand()),
            'name' => $object->getName(),
            'data' => $this->aggregate->normalize($object->getCommand()),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof QueueCommand;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        Assertion::choicesNotEmpty($data, ['class', 'name', 'data']);

        Assertion::classExists($data['class']);

        $object = new QueueCommand($this->aggregate->denormalize($data['data'], $data['class']), $data['name']);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === QueueCommand::class;
    }
}
