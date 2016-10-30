<?php

namespace spec\League\Tactician\Bernard;

use Bernard\Message;
use Bernard\Message\DefaultMessage;
use League\Tactician\Bernard\QueueCommand;
use Normalt\Normalizer\AggregateNormalizer;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class QueueCommandNormalizerSpec extends ObjectBehavior
{
    function let(AggregateNormalizer $aggregate)
    {
        $this->setAggregateNormalizer($aggregate);
    }

    function it_is_a_normalizer_and_denormailzer()
    {
        $this->shouldImplement(NormalizerInterface::class);
        $this->shouldImplement(DenormalizerInterface::class);
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

        $this->supportsNormalization($queueCommand)->shouldReturn(true);
    }

    function it_denormalizes_queue_command_and_delegates_message_to_aggregate(Message $message, AggregateNormalizer $aggregate)
    {
        $aggregate->denormalize(['key' => 'value'], DefaultMessage::class, null)->willReturn($message);

        $normalized = [
            'class' => DefaultMessage::class,
            'name' => 'queue',
            'data' => ['key' => 'value'],
        ];

        $queueCommand = $this->denormalize($normalized, QueueCommand::class);
        $queueCommand->shouldHaveType(QueueCommand::class);
        $queueCommand->getCommand()->shouldReturn($message);
        $queueCommand->getName()->shouldReturn('queue');

        $this->supportsDenormalization($normalized, QueueCommand::class)->shouldReturn(true);
    }
}
