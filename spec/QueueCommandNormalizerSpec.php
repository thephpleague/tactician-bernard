<?php

namespace spec\League\Tactician\Bernard;

use League\Tactician\Bernard\QueueCommand;
use PhpSpec\ObjectBehavior;

class QueueCommandNormalizerSpec extends ObjectBehavior
{
    /**
     * @param Normalt\Normalizer\AggregateNormalizer $aggregate
     */
    function let($aggregate)
    {
    }

    function it_is_a_normalizer_and_denormailzer()
    {
        $this->shouldHaveType('Symfony\Component\Serializer\Normalizer\NormalizerInterface');
        $this->shouldHaveType('Symfony\Component\Serializer\Normalizer\DenormalizerInterface');
    }

    /**
     * @param Bernard\Message                        $message
     * @param Normalt\Normalizer\AggregateNormalizer $aggregate
     */
    function it_normalizes_queue_command_and_delegates_message_to_aggregate($message, $aggregate)
    {
        $queueCommand = new QueueCommand($messageDouble = $message->getWrappedObject(), 'queue');

        $aggregate->normalize($message)->willReturn([
            'key' => 'value',
        ]);

        $this->setAggregateNormalizer($aggregate);

        $this->normalize($queueCommand)->shouldReturn([
            'class' => get_class($messageDouble),
            'name' => 'queue',
            'data' => ['key' => 'value'],
        ]);
    }

    /**
     * @param Bernard\Message $message
     */
    function it_denormalizes_queue_command_and_delegates_message_to_aggregate($message, $aggregate)
    {
        $this->setAggregateNormalizer($aggregate);

        $aggregate->denormalize(['key' => 'value'], 'Bernard\Message\DefaultMessage', null)->willReturn($message);

        $normalized = [
            'class' => 'Bernard\Message\DefaultMessage',
            'name' => 'queue',
            'data' => ['key' => 'value'],
        ];

        $queueCommand = $this->denormalize($normalized, 'League\Tactician\Bernard\QueueCommand');
        $queueCommand->shouldHaveType('League\Tactician\Bernard\QueueCommand');
        $queueCommand->getCommand()->shouldReturn($message);
        $queueCommand->getName()->shouldReturn('queue');
    }
}
