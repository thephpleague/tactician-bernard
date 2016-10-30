<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Message;
use League\Tactician\Bernard\QueueCommand;
use Normalt\Normalizer\AggregateNormalizer;
use PhpSpec\ObjectBehavior;

class QueueCommandNormalizerSpec extends ObjectBehavior
{
    function let(AggregateNormalizer $aggregate)
    {
        $this->setAggregateNormalizer($aggregate);
    }

    function it_is_a_normalizer_and_denormailzer()
    {
        $this->shouldHaveType('Symfony\Component\Serializer\Normalizer\NormalizerInterface');
        $this->shouldHaveType('Symfony\Component\Serializer\Normalizer\DenormalizerInterface');
    }

    function it_normalizes_queue_command_and_delegates_message_to_aggregate(Message $message, AggregateNormalizer $aggregate)
    {
        $queueCommand = new QueueCommand($messageDouble = $message->getWrappedObject(), 'queue');

        $aggregate->normalize($message)->willReturn([
            'key' => 'value',
        ]);

        $this->normalize($queueCommand)->shouldReturn([
            'class' => get_class($messageDouble),
            'name' => 'queue',
            'data' => ['key' => 'value'],
        ]);
    }

    function it_denormalizes_queue_command_and_delegates_message_to_aggregate(Message $message, AggregateNormalizer $aggregate)
    {
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
